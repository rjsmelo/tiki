<?php
// (c) Copyright 2002-2010 by authors of the Tiki Wiki/CMS/Groupware Project
//
// All Rights Reserved. See copyright.txt for details and a complete list of authors.
// Licensed under the GNU LESSER GENERAL PUBLIC LICENSE. See license.txt for details.
// $Id$

//this script may only be included - so its better to die if called directly.
$access->check_script($_SERVER["SCRIPT_NAME"],basename(__FILE__));

/**
 * Handles languages translations
 */
class Language extends TikiDb_Bridge {

	/**
	 * @var string
	 */
	public $lang;

	/**
	 * Set the language based on the paratemer or if
	 * no parameter given uses Tiki user or global preference
	 */
	function __construct($lang = null) {
		global $user, $user_preferences;

		if (!is_null($lang)) {
			$this->lang = $lang;
		} else if (isset($user) && isset($user_preferences[$user]['language'])) {
			$this->lang = $user_preferences[$user]['language'];
		} else {
			global $prefs;
			$this->lang = $prefs['language'];
		}	
	}

	/**
	 * Return a list of languages available in Tiki
	 *
	 * @return array list of languages
	 */
	public static function getLanguages() {
		global $langmapping; require_once('lang/langmapping.php');
		return array_keys($langmapping);
	}

	/**
	 * Return a list of languages with translations
	 * in the database
	 *
	 * @return array list of languages with at least one string translated
	 */
	public static function getDbTranslatedLanguages() {
		$languages = array();
		$result = self::fetchAll('SELECT DISTINCT `lang` FROM `tiki_language` ORDER BY `lang` asc');

		foreach ($result as $res) {
			$languages[] = $res['lang'];
		}

		return $languages;
	}

	/**
	 * Update a translation
	 * If $originalStr is not found, a new entry is added. Otherwise, 
	 * if $translatedStr is empty the entry is deleted or if $translatedStr is
	 * not empty the entry is updated with the new translation.
	 *
	 * @param string $originalStr the original string
	 * @param string $translatedStr the translated string
	 * @return void
	 */
	public function updateTrans($originalStr, $translatedStr) {
		$query = 'select * from `tiki_language` where `lang`=? and `source` = ?';
		$result = $this->query($query, array($this->lang, $originalStr));

		if (!$result->numRows()) {
			$query = 'insert into `tiki_language` values(binary ?,?,binary ? )';
			$result = $this->query($query, array($originalStr, $this->lang, $translatedStr));
		} else {
			if (strlen($translatedStr) == 0) {
				$query = 'delete from `tiki_language` where `source`=binary ? and `lang`=?';
				$result = $this->query($query, array($originalStr, $this->lang));
			} else {
				$query = 'update `tiki_language` set `tran`=binary ? where `source`=binary ? and `lang`=?';
				$result = $this->query($query,array($translatedStr,$originalStr,$this->lang));
			}
		}
	}

	/**
	 * Generate a new language.php file based only
	 * on the translations in the database and give the user the
	 * option to download it
	 *
	 * @return void
	 */
	public function downloadFile() {
		$data = $this->_createCustomFile();
		header ("Content-type: application/unknown");
		header ("Content-Disposition: inline; filename=language.php");
		header ("Content-encoding: UTF-8");
		echo $data;
		exit (0);
	}

	/**
	 * Write the new custom.php file to the filesystem
	 */
	public function writeCustomFile() {
		$data = $this->_createCustomFile();
		
		// TODO: generate an error if not possible to write to file
		if (is_writable("lang/{$this->lang}/")) {
			$f = fopen("lang/{$this->lang}/custom.php", 'w');
			fwrite($f, $data);
			fclose($f);
		}
	}

	/**
	 * Write the new translated strings to the actual
	 * language.php file
	 */
	public function writeLanguageFile() {
		$filePath = "lang/{$this->lang}/language.php";

		// TODO: generate an error if not possible to write to file
		if (is_writable($filePath)) {
			$langFile = file($filePath);
			$dbTrans = $this->_getTranslations();

			// foreach translation in the database check each string in the language.php file
			// if the original string is present and the translation is diferent replace it
			foreach ($dbTrans as $dbOrig => $dbNewStr) {
				// scape double quotes
				$dbTrans[$dbOrig] = $dbNewStr = str_replace('"', '\"', $dbNewStr);

				foreach ($langFile as $key => $line) {
					if (preg_match('|^/?/?\s*?"(.+)"\s*=>\s*"(.+)".*|', $line, $matches) && $matches[1] == $dbOrig) {
						if ($matches[2] != $dbNewStr) {
							$langFile[$key] = '"' . $matches[1] . '" => "' . $dbNewStr . "\",\n";
						}
						unset($dbTrans[$dbOrig]);
					}
				}
			}

			// convert every entry in the array $dbTrans (translation that are not presente in language.php)
			// to a string in the format '"original string" => "translation"'
			$newTrans = array();
			foreach ($dbTrans as $orig => $trans) {
				$newTrans[] = '"' . $orig . '" => "' . $trans . "\",\n";
			}
			
			// add new strings to the language.php
			array_splice($langFile, -1, 0, $newTrans);

			// write the new language.php file
			$f = fopen($filePath, 'w');

			foreach ($langFile as $line) {
				fwrite($f, $line);
			}

			fclose($f);
		}
	}

	/**
	 * Return all the custom translations in the database
	 * for the current language
	 *
	 * @return array
	 */
	protected function _getTranslations() {
		$query = "SELECT `source`, `tran` FROM `tiki_language` WHERE `lang`=? ORDER BY `source` asc";
		$result = $this->fetchMap($query,array($this->lang));

		return $result;
	}

	/**
	 * Create a custom.php file for the current language
	 *
	 * @return string the content of the new custom.php file
	 */
	protected function _createCustomFile() {
		$strings = $this->_getTranslations();

		$data = "<?php\n\$lang=";
		$data .= $this->_removeSpaces(var_export($strings, true));
		$data .= ";\n?>\n";

		return $data;
	}

	/**
	 * Remove the spaces added by var_export() in the beggining
	 * of the line to be similar with the file generated by get_strings.php
	 *
	 * @param string $data the content of a new php file with the translations
	 * @return string same as $data but without spaces in the beggining of the line
	 */
	protected function _removeSpaces($data) {
		return preg_replace('/^  /m', '', $data);
	}
}
