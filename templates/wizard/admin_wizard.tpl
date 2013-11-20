{* $Id$ *}

<h1>{tr}Tiki Setup Wizard{/tr}</h1>
{tr}The Tiki Admin Wizard helps you quickly configure key features and settings. Use the <a href="tiki-admin.php" target="_blank">Admin Panel</a> to configure other features and settings not included in this wizard or when not using the wizard. Uncheck the checkbox above to keep this wizard from showing upon admin login{/tr}.
<br>
{tr}Tiki Profiles is a quick and easy way to setup a preconfigures application, e.g. a Blog site{/tr}.
<div class="adminWizardContent">
<fieldset>
	<legend>{tr}Get Started{/tr}</legend>
<div style="display:block;margin-left: auto; margin-right: auto">
	<img src="img/icons/large/wizard48x48.png" alt="{tr}Tiki Admin Wizard{/tr}" />
		<input type="submit" class="btn btn-default" name="continue" value="{tr}Start admin wizard{/tr}" /><br>
</div>
<div style="display:block;margin-left: auto; margin-right: auto">
	<img src="img/icons/large/profiles48x48.png" alt="{tr}Tiki Profiles{/tr}" />
		<input  type="submit" class="btn btn-default" name="use-default-prefs" value="{tr}Easy application setup using profiles{/tr}" /><br>
</div>
<div style="display:block;margin-left: auto; margin-right: auto; margin-bottom: 10px">
	<img src="img/icons/large/stock_missing-image48x48.png" alt="{tr}No wizard{/tr}" />
		<input  type="submit" class="btn btn-default" name="skip" value="{tr}Skip wizard and don't show again{/tr}" />
</div>
</fieldset>
<br>
<fieldset>
<legend>{tr}Server Fitness{/tr}</legend>
	{tr _0=$tiki_version}To check if your server meets the requirements for running Tiki version %0, please visit <a href="tiki-check.php" target="_blank">Tiki Server Compatibility Check</a>{/tr}.
</fieldset>
<br>
</div>
