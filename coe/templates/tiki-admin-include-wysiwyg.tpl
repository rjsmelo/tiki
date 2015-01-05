{* $Id$ *}

{remarksbox type="tip" title="{tr}Tip{/tr}"}{tr}Wysiwyg means What You See Is What You Get, and is handled in Tikiwiki by <a href="http://fckeditor.net">FCKeditor</a>{/tr}.{/remarksbox}

<form action="tiki-admin.php?page=wysiwyg" method="post">
	<div class="heading input_submit_container" style="text-align: right">
		<input type="submit" name="wysiwygfeatures" value="{tr}Change preferences{/tr}" />
	</div>
	<fieldset class="admin">
		<legend>{tr}Wysiwyg Editor Features{/tr}</legend>
		{preference name=wysiwyg_optional}
		<div class="adminoptionboxchild" id="wysiwyg_optional_childcontainer">
			{preference name=wysiwyg_default}
		</div>

		{preference name=wysiwyg_memo}
		{preference name=wysiwyg_wiki_parsed}
		{preference name=wysiwyg_wiki_semi_parsed}
		{preference name=wysiwyg_htmltowiki}
		{preference name=wysiwyg_toolbar_skin}

	</fieldset>
	<div class="heading input_submit_container" style="text-align: center">
		<input type="submit" name="wysiwygfeatures" value="{tr}Change preferences{/tr}" />
	</div>
</form>
