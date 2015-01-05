<?php

/**
 * Abstract class to provide basic functionalities to wiki importers.
 * Based on the work done on http://dev.tikiwiki.org/MediaWiki+to+TikiWiki+converter  
 * 
 * @author Rodrigo Sampaio Primo <rodrigo@utopia.org.br>
 * @package tikiimporter
 */

require_once('tikiimporter.php');

/**
 * Abstract class to provide basic functionalities to wiki importers.
 * Based on the work done on http://dev.tikiwiki.org/MediaWiki+to+TikiWiki+converter
 * 
 * Child classes must implement the functions validateInput(), parseData()
 *
 * @package    tikiimporter
 */
class TikiImporter_Wiki extends TikiImporter
{

    /**
     * @see lib/importer/TikiImporter#importOptions
     */
	static public $importOptions = array(
        array('name' => 'wikiRevisions', 'type' => 'text', 'label' => 'Number of page revisions to import (0 for all revisions)'),
        array('name' => 'alreadyExistentPageName', 'type' => 'select', 'label' => 'What to do with page names that already exists in TikiWiki?',
            'options' => array(
                array('name' => 'doNotImport', 'label' => 'Do not import'),
                array('name' => 'override', 'label' => 'Override'),
                array('name' => 'appendPrefix', 'label' => 'Append software name as prefix to the page name')
            )
        )     
    );
    
    /**
     * Main function that starts the importing proccess
     * 
     * Set the import options based on the options the user selected
     * and start the importing proccess by calling the functions to
     * validate, parse and insert the data.
     *  
     * @return void 
     */
    function import()
    {
        // how many revisions to import for each page
        if (!empty($_POST['wikiRevisions']) && $_POST['wikiRevisions'] > 0)
            $this->revisionsNumber = $_POST['wikiRevisions'];
        else
            $this->revisionsNumber = 0;
            
        // what to do with already existent page names
        if (!empty($_POST['alreadyExistentPageName']))
            $this->alreadyExistentPageName = $_POST['alreadyExistentPageName'];
        else
            $this->alreadyExistentPageName = 'doNotImport';
        
        // child classes must implement those two methods
        $this->validateInput();
        $parsedData = $this->parseData();
        $importFeedback = $this->insertData($parsedData);

        $this->saveAndDisplayLog("\nImportation completed!");

        echo "\n\n<b><a href=\"tiki-importer.php\">Click here</a> to finish the import process</b>";
        flush();

        $_SESSION['tiki_importer_feedback'] = $importFeedback;
        $_SESSION['tiki_importer_log'] = $this->log;
   }

    /**
     * Insert the imported data into Tiki.
     * 
     * @param array $parsedData the return of $this->parseData()
     *
     * @return array $countData stats about the content that has been imported
     */
    function insertData($parsedData)
    {
        $countData = array();
        $countPages = 0;

        $this->saveAndDisplayLog("\n" . count($parsedData) . " pages parsed. Starting to insert those pages into Tiki:\n");

        if (!empty($parsedData)) {
            foreach ($parsedData as $page) {
                if ($this->insertPage($page)) {
                    $countPages++;
                    $this->saveAndDisplayLog('Page ' . $page['name'] . " sucessfully imported\n");
                } else {
                    $this->saveAndDisplayLog('Page ' . $page['name'] . " NOT imported (there was already a page with the same name)\n");
                }
            }
        }

        $countData['totalPages'] = count($parsedData);
        $countData['importedPages'] = $countPages;
        return $countData;
    }

    /**
     * Create a new page or new page revision using Tiki bultin functions
     * 
     * Receives an array (actualy a hash) with all the revisions of one specific page
     * and insert the information on Tiki using Tiki bultin functions.
     *
     * This method might be used by wiki importers to insert the pages in Tiki database.
     * In order to do so $page must contain the following keys:
     * - name: the name of the page
     * - revisions: an array of arrays with all the page revisions. Each revision array must contain the keys:
     *     - data: the page content (in Tiki with sintax, parsing must be done before calling this function)
     *     - lastModif: the modification time
     *     - comment: the edition comment
     *     - user: the username
     *     - ip: ip address
     *     - minor: true or false
     * 
     * It also control the number of revisions to import ($this->revisionsNumber) and what to do if
     * the page name already exist ($this->alreadyExistentPageName) based on parameters passed by POST
     * 
     * @param array $page
     * @return bool true if the page has been imported, otherwise returns false 
     */
    function insertPage($page)
    {
        global $tikilib;
        
        if ($tikilib->page_exists($page['name'])) {
            switch ($this->alreadyExistentPageName) {
                case 'override':
                    $tikilib->remove_all_versions($page['name']);
                    break;
                case 'appendPrefix':
                    $page['name'] = $this->softwareName . '_' . $page['name'];
                    break;
                case 'doNotImport':
                    return false;
            }
        }

        if (!empty($page)) { 
            $first = true;
            foreach ($page['revisions'] as $rev) {
                if ($first) {
                    $tikilib->create_page($page['name'], 0, $rev['data'], $rev['lastModif'],
                        $rev['comment'], $rev['user'], $rev['ip']);
                } else {
                    $tikilib->cache_page_info = null;
                    $tikilib->update_page($page['name'], $rev['data'], $rev['comment'], $rev['user'],
                        $rev['ip'], '', $rev['minor'], '', false, null, $rev['lastModif']);
                }
                $first = false;
            }
        }

        return true;
    }
}

?>