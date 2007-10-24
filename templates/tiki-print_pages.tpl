<h1><a class="pagetitle" href="tiki-print_pages.php">{tr}Print multiple pages{/tr}</a></h1>

<table class="findtable">
<tr><td class="findtable">{tr}Find{/tr}</td>
<td class="findtable">
</div>
<div class="cbox-data">
<form action="tiki-print_pages.php" method="post">
<input type="hidden" name="printpages" value="{$form_printpages|escape}" />
<input type="hidden" name="printstructures" value="{$form_printstructures|escape}" />
<input type="text" name="find" value="{$find|escape}" /><input type="submit" name="filter" value="{tr}Find{/tr}" /><br />
</form>
</td>
</tr>
</table>

<form action="tiki-print_pages.php" method="post">
<input type="hidden" name="printpages" value="{$form_printpages|escape}" />
<input type="hidden" name="printstructures" value="{$form_printstructures|escape}" />
<input type="hidden" name="find" value="{$find|escape}" />
<table class="normal" cellpadding="5">
 <tr valign="middle">
  <td width="50%"><strong>{tr}Add Pages{/tr}:</strong><br />
   <select name="pageName" size="5">
{section name=ix loop=$pages}
{if !in_array($pages[ix].pageName,$printpages)}{* don't show the page as available,if it is already selected *}
<option value="{$pages[ix].pageName|escape}">{$pages[ix].pageName}</option>
{/if}
{sectionelse}
    <option value="" disabled="disabled">{tr}No pages{/tr}</option>
{/section}
   </select>
   <br /><input type="submit" name="addpage" value="{tr}add page{/tr}" />
  </td>
  <td width="50%"><strong>{tr}Add Pages from Structures{/tr}:</strong><br />
   <select name="structureId" size="5">
{section name=ix loop=$structures}
{if !in_array($structures[ix].page_ref_id,$printstructures)}
<option value="{$structures[ix].page_ref_id|escape}">{$structures[ix].pageName}</option>
{/if}
{sectionelse}
    <option value="" disabled="disabled">{tr}No structures{/tr}</option>
{/section}
   </select>
  <br /><input type="submit" name="addstructure" value="{tr}add structure{/tr}"/>
  <br /><input type="submit" name="addstructurepages" value="{tr}add structure pages{/tr}"/></td>
 </tr>
</table>
{if $printpages}
<h2>{tr}Selected Pages{/tr}:</h2>
<ul>
{section name=ix loop=$printpages}
 <li>{$printpages[ix]}</li>
{/section}
</ul>
{/if}
{if $printstructures}
<h2>{tr}Selected Structures{/tr}</h2>
<ul>
{section name=ix loop=$printnamestructures}
 <li>{$printnamestructures[ix]}</li>
{/section}
</ul>
{/if}
{if $printpages or $printstructures}
<input type="submit" name="clearpages" value="{tr}Clear{/tr}" />
{/if}
</form>

{if $printpages or $printstructures}
<form method="post" action="tiki-print_multi_pages.php">
<input type="hidden" name="printpages" value="{$form_printpages|escape}" />
<input type="hidden" name="printstructures" value="{$form_printstructures|escape}" />
<input type="submit" name="print" value="{tr}Print{/tr}" />
</form>
{/if}

