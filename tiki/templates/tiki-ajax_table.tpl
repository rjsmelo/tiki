{* $Header: /cvsroot/tikiwiki/tiki/templates/tiki-ajax_table.tpl,v 1.1 2006-02-05 16:10:07 amette Exp $ *}
<form action="" method="">
	<input type="hidden" name="sort_mode" value="{$sort_mode|escape}" />
	<input type="hidden" name="tag" value="{$tag|escape}" />
	{tr}Find:{/tr} <input type="text" name="find" />
	<input type="submit" onClick="setFilter(this.form.find.value);return false;"/>
</form>

{* Table-based layout - table headings make it easy to play with sort-mode *}
<table>
<tr>
	{section name="j" start=0 loop=$ajax_cols step=1}
	<th><a href="javascript:setSortMode('{$ajax_cols[j]}_desc')" id="ajax_{$ajax_cols[j]}Header">{$ajax_cols[j]}</a></th>
	{/section}
</tr>
{section name="i" start=0 loop=$maxRecords step=1}
<tr class="freetagObject {if $smarty.section.i.index is even}odd{else}even{/if}">
	{section name="j" start=0 loop=$ajax_cols step=1}
	<td id="{$ajax_cols[j]}_{$smarty.section.i.index}" class="ajax_{$ajax_cols[j]}"></td>
	{/section}
</tr>
{/section}
</table>

  <div align="center">
    <div class="mini">
        [<a class="prevnext" href="javascript:setOffset(-{$maxRecords});">{tr}prev{/tr}</a>]&nbsp;
      {tr}Page{/tr}: <span id="actual_page">1</span>/<span id="cant_pages"></span>
        &nbsp;[<a class="prevnext" href="javascript:setOffset({$maxRecords});">{tr}next{/tr}</a>]

      {if $direct_pagination eq 'y'}
	<br />
	<div class="prevnext" id="direct_pagination"></div>
      {/if}
   </div>
  </div>
