<?php
// Initialization
require_once('tiki-setup.php');

if($feature_wiki != 'y') {
  $smarty->assign('msg',tra("This feature is disabled"));
  $smarty->display('error.tpl');
  die;  
}

//print($GLOBALS["HTTP_REFERER"]);

// Create the HomePage if it doesn't exist
if(!$tikilib->page_exists("HomePage")) {
  $tikilib->create_page("HomePage",0,'',date("U"),'Tiki initialization'); 
}

if(!isset($_SESSION["thedate"])) {
  $thedate = date("U");
} else {
  $thedate = $_SESSION["thedate"];
}

// Get the page from the request var or default it to HomePage
if(!isset($_REQUEST["page"])) {
  $_REQUEST["page"]='HomePage';
  $page = 'HomePage';
  $smarty->assign('page','HomePage'); 
} else {
  $page = $_REQUEST["page"];
  $smarty->assign_by_ref('page',$_REQUEST["page"]); 
}

require_once('tiki-pagesetup.php');

// Check if we have to perform an action for this page
// for example lock/unlock
if($tiki_p_admin_wiki == 'y') {
if(isset($_REQUEST["action"])) {
  if($_REQUEST["action"]=='lock') {
    $tikilib->lock_page($page);
  } elseif ($_REQUEST["action"]=='unlock') {
    $tikilib->unlock_page($page);
  }  
}
}


// If the page doesn't exist then display an error
if(!$tikilib->page_exists($page)) {
  $smarty->assign('msg',tra("Page cannot be found"));
  $smarty->display('error.tpl');
  die;
}


// Now check permissions to access this page
if($tiki_p_view != 'y') {
  $smarty->assign('msg',tra("Permission denied you cannot view this page"));
  $smarty->display('error.tpl');
  die;  
}

// BreadCrumbNavigation here
// Get the number of pages from the default or userPreferences
// Remember to reverse the array when posting the array
$anonpref = $tikilib->get_preference('userbreadCrumb',4);
if($user) {
  $userbreadCrumb = $tikilib->get_user_preference($user,'userbreadCrumb',$anonpref);
} else {
  $userbreadCrumb = $anonpref;
}
if(!isset($_SESSION["breadCrumb"])) {
  $_SESSION["breadCrumb"]=Array();
}
if(!in_array($page,$_SESSION["breadCrumb"])) {
  if(count($_SESSION["breadCrumb"])>$userbreadCrumb) {
    array_shift($_SESSION["breadCrumb"]);
  } 
  array_push($_SESSION["breadCrumb"],$page);
} else {
  // If the page is in the array move to the last position
  $pos = array_search($page, $_SESSION["breadCrumb"]);
  unset($_SESSION["breadCrumb"][$pos]);
  array_push($_SESSION["breadCrumb"],$page);
}
//print_r($_SESSION["breadCrumb"]);


// Now increment page hits since we are visiting this page
$tikilib->add_hit($page);

// Get page data
$info = $tikilib->get_page_info($page);

// Verify lock status
if($info["flag"] == 'L') {
  $smarty->assign('lock',true);  
} else {
  $smarty->assign('lock',false);
}

// If not locked and last version is user version then can undo
$smarty->assign('canundo','n');	
if($info["flag"]!='L' && ( ($tiki_p_edit == 'y' && $info["user"]==$user)||($tiki_p_remove=='y') )) {
   $smarty->assign('canundo','y');	
}
if($tiki_p_admin_wiki == 'y') {
  $smarty->assign('canundo','y');		
}

// Process an undo here
if(isset($_REQUEST["undo"])) {
if($tiki_p_admin_wiki == 'y' || ($info["flag"]!='L' && ( ($tiki_p_edit == 'y' && $info["user"]==$user)||($tiki_p_remove=='y')) )) {
  // Remove the last version	
  $tikilib->remove_last_version($page);
  // If page was deleted then re-create
  if(!$tikilib->page_exists($page)) {
    $tikilib->create_page($page,0,'',date("U"),'Tiki initialization'); 
  }
  // Restore page information
  $info = $tikilib->get_page_info($page);  	
}
}

$slides = split("-=[^=]+=-",$info["data"]);
if(count($slides)>1) {
 $smarty->assign('show_slideshow','y');
} else {
 $smarty->assign('show_slideshow','n');
}

$pdata = $tikilib->parse_data($info["data"]);
$smarty->assign_by_ref('parsed',$pdata);
//$smarty->assign_by_ref('lastModif',date("l d of F, Y  [H:i:s]",$info["lastModif"]));
$smarty->assign_by_ref('lastModif',$info["lastModif"]);
if(empty($info["user"])) {
  $info["user"]='anonymous';  
}
$smarty->assign_by_ref('lastUser',$info["user"]);

/*
// force enable wiki comments (for development)
$feature_wiki_comments = 'y';
$smarty->assign('feature_wiki_comments','y');
*/

// Comments engine!
if($feature_wiki_comments == 'y') {
  $comments_per_page = $wiki_comments_per_page;
  $comments_default_ordering = $wiki_comments_default_ordering;
  $comments_vars=Array('page');
  $comments_prefix_var='wiki page';
  $comments_object_var='page';
  include_once("comments.php");
}

$section='wiki';
include_once('tiki-section_options.php');



if($feature_wiki_attachments == 'y') {
  if(isset($_REQUEST["removeattach"])) {
    $owner = $tikilib->get_attachment_owner($_REQUEST["removeattach"]);
    if( ($user && ($owner == $user) ) || ($tiki_p_wiki_admin_attachments == 'y') ) {
      $tikilib->remove_wiki_attachment($_REQUEST["removeattach"]);
    }
  }
  if(isset($_REQUEST["attach"]) && ($tiki_p_wiki_admin_attachments == 'y' || $tiki_p_wiki_attach_files == 'y')) {
    // Process an attachment here
    if(isset($_FILES['userfile1'])&&is_uploaded_file($_FILES['userfile1']['tmp_name'])) {
      $fp = fopen($_FILES['userfile1']['tmp_name'],"rb");
      $data = '';
      $fhash='';
      if($w_use_db == 'n') {
        $fhash = md5($name = $_FILES['userfile1']['name']);    
        $fw = fopen($w_use_dir.$fhash,"w");
        if(!$fw) {
          $smarty->assign('msg',tra('Cannot write to this file:').$fhash);
          $smarty->display('error.tpl');
          die;  
        }
      }
      while(!feof($fp)) {
        if($w_use_db == 'y') {
          $data .= fread($fp,8192*16);
        } else {
          $data = fread($fp,8192*16);
          fwrite($fw,$data);
        }
      }
      fclose($fp);
      if($w_use_db == 'n') {
        fclose($fw);
        $data='';
      }
      $size = $_FILES['userfile1']['size'];
      $name = $_FILES['userfile1']['name'];
      $type = $_FILES['userfile1']['type'];
      $tikilib->wiki_attach_file($page,$name,$type,$size, $data, $_REQUEST["attach_comment"], $user,$fhash);
    }
  }

  $atts = $tikilib->list_wiki_attachments($page,0,-1,'created_desc','');
  $smarty->assign('atts',$atts["data"]);
}

$smarty->assign('wiki_extras','y');

// Display the Index Template
$smarty->assign('dblclickedit','y');
$smarty->assign('mid','tiki-show_page.tpl');
$smarty->assign('show_page_bar','y');
$smarty->display('tiki.tpl');

?>