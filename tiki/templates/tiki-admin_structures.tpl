{* $Header: /cvsroot/tikiwiki/tiki/templates/tiki-admin_structures.tpl,v 1.20 2003-12-05 11:53:21 chris_holman Exp $ *}

<a href="tiki-admin_structures.php" class="pagetitle">{tr}Structures{/tr}</a>
<!-- the help link info --->
  
{if $feature_help eq 'y'}
<a href="http://tikiwiki.org/tiki-index.php?page=Structures" target="tikihelp" class="tikihelp" title="{tr}Tikiwiki.org help{/tr}: {tr}Structures{/tr}">
<img border='0' src='img/icons/help.gif' alt='help' /></a>{/if}

<!-- link to tpl -->

{if $feature_view_tpl eq 'y'}
<a href="tiki-edit_templates.php?template=templates/tiki-admin_structures.tpl" target="tikihelp" class="tikihelp" title="{tr}View tpl{/tr}: {tr}admin structures tpl{/tr}">
<img border='0' src='img/icons/info.gif' alt='edit tpl' /></a>
{/if}

<!--- beginning of next bit --->

<h2>{tr}Structures{/tr}</h2>
<table class="normal">
<tr>
  <td class="heading">{tr}Structure ID{/tr}</td>
  <td  class="heading">&nbsp;</td>
</tr>
{cycle values="odd,even" print=false}
{section loop=$channels name=ix}
<tr>
  <td class="{cycle advance=false}">
  <a class="tablename" href="tiki-edit_structure.php?page_ref_id={$channels[ix].page_ref_id}">
      {$channels[ix].pageName}
	  {if $channels[ix].page_alias}
        ({$channels[ix].page_alias})
	  {/if}
  </a>
  </td>
  <td class="{cycle}">
  <a class="link" href="tiki-admin_structures.php?export={$channels[ix].page_ref_id|escape:"url"}"><img src='img/icons/export.gif' alt="{tr}export pages{/tr}" title="{tr}export pages{/tr}" border='0' /></a>
  <a class="link" href="tiki-admin_structures.php?export_tree={$channels[ix].page_ref_id|escape:"url"}"><img src='img/icons/expand.gif' alt="{tr}dump tree{/tr}" title="{tr}dump tree{/tr}" border='0' /></a>
  <a class="link" href="tiki-admin_structures.php?remove={$channels[ix].page_ref_id|escape:"url"}"><img src='img/icons2/delete.gif' alt="{tr}remove{/tr}" title="{tr}remove{/tr}" border='0' /></a>
  <a class="link" href="tiki-create_webhelp.php?struct={$channels[ix].page_ref_id|escape:"url"}"><img src="img/icons/whelp.gif" alt="{tr}create webhelp{/tr}" title="{tr}create webhelp{/tr}" border='0' /></a>
  {if $channels[ix].webhelp eq 'y'} 
  <a class="link" href="whelp/{$channels[ix].pageName}/index.html"><img src="img/icons/whelp_toc.gif" alt="{tr}view webhelp{/tr}" title="{tr}view webhelp{/tr}" border='0' /></a>
  {/if}
  </td>
</tr>
{/section}
</table>
{if $askremove eq 'y'}
<br/>
<a class="link" href="tiki-admin_structures.php?rremove={$remove|escape:"url"}">{tr}Destroy the structure leaving the wiki pages{/tr}</a><br/>
<a class="link" href="tiki-admin_structures.php?rremovex={$remove|escape:"url"}">{tr}Destroy the structure and remove the pages{/tr}</a>
{/if}

<h2>{tr}Create new structure{/tr}</h2>
<small>{tr}Use single spaces to indent structure levels{/tr}</small>
<form action="tiki-admin_structures.php" method="post">
<table class="normal">
<tr>
   <td class="formcolor">{tr}Structure ID{/tr}:</td>
   <td class="formcolor"><input type="text" name="name" /></td>
   <td class="formcolor">{tr}Alias{/tr}:</td>
   <td class="formcolor"><input type="text" name="alias" /></td>
</tr>    
<tr>
   <td class="formcolor">{tr}tree{/tr}:<br/>(optional)</td>
   <td colspan=3 class="formcolor"><textarea rows="5" cols="60" name="tree"></textarea></td>
</tr>    
<tr>
   <td class="formcolor">&nbsp;</td>
   <td colspan=3 class="formcolor"><input type="submit" value="{tr}create new structure{/tr}" name="create" /></td>
</tr>
</table>
</form>
