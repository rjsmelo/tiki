{* $Id$ *}

<div class="media">
    <img class="pull-left" src="img/icons/large/wizard_upgrade48x48.png" alt="{tr}Upgrade Wizard{/tr}" title="{tr}Upgrade Wizard{/tr}"/>
    <div class="media-body">
        {tr}You are reaching the end of the <em>Upgrade Wizard</em>{/tr}.
        {tr}Since you are upgrading, you probably had a previous installation of Tiki for a while, and you may already have some experience using a few Tiki features, at least{/tr}.
        <br/><br/>
        {tr}That's why we would like to <strong>ask you to send us some feedback about your usage of Tiki</strong>, while having the chance to connect in the future with other Tiki Admins near you in the Tiki Community{/tr}.
        <a href="http://doc.tiki.org/Connect" target="tikihelp" class="tikihelp" title="{tr}Send feedback & Connect:{/tr}
				<p>{tr}Tiki Connect is a way to let the Tiki project know how it is being used, and which parts people like or would like fixing (or explaining).{/tr}
				<br/><br/>
                {tr}Once '<em>Tiki Connect</em>' is enabled, when you click the '<strong>Send Info</strong>' button below you will be connected with <em>mother.tiki.org</em>, which is where the data will be collected.{/tr}
                <br/><br/>
                {tr}You can also send feedback about Tiki by checking the '<em>Provide Feedback</em>' checkbox (once <em>Tiki Connect</em> is enabled), next to the '<em>Show on admin login</em>' above.{/tr}
                {tr}Icons will appear next to all the preferences where you can 'like' <img src=img/icons/connect_like.png>, request a 'fix' <img src=img/icons/connect_fix.png> or ask 'what is this for?' <img src=img/icons/connect_wtf.png>{/tr}
                <br/><br/>
                {tr}Click to read more{/tr}
	    	    ">
             <img src="img/icons/help.png" alt="" width="16" height="16" class="icon" />
        </a>
        <br/><br/>
        <fieldset>
            <legend>{tr}Connect{/tr}</legend>
            <img class="pull-right" src="img/icons/large/gnome-globe48x48.png" alt="{tr}Connect{/tr}" title="{tr}Connect{/tr}"/>
            {preference name="connect_feature"}
            <div class="adminoptionboxchild" id="connect_feature_childcontainer">
                <div class="t_navbar btn-group form-group">
                    {button _script="#" class="btn btn-default" _text="{tr}Send Info{/tr}" _title="{tr}Send the data{/tr}" _id="connect_send_btn"}
                    {button _script="#" class="btn btn-default" _text="{tr}Preview info{/tr}" _title="{tr}See what is going to be sent{/tr}" _id="connect_list_btn"}
                    {if empty($prefs.connect_site_title)}
                        {button _text="{tr}Fill form{/tr}" class="btn btn-default" _title="{tr}Fill this form in based on other preferences{/tr}" _id="connect_defaults_btn" _script="#"}
                    {/if}
                </div>
                {preference name="connect_send_info"}
                <div class="adminoptionboxchild" id="connect_send_info_childcontainer">
                    {preference name="connect_site_title"}
                    {if $prefs.connect_send_info eq "y" and empty($prefs.connect_site_title)}
                        {remarksbox type="errors" title=""}
                            {tr}Site Title is required{/tr}
                        {/remarksbox}
                    {/if}
                    {preference name="connect_site_email"}
                    {preference name="connect_site_url"}
                    {preference name="connect_site_keywords"}
                    {preference name="connect_site_location"}
                    <div class="adminoptionboxchild" style="padding-left:5em;">
                        {$headerlib->add_map()}
                        <div class="adminoptionboxchild map-container" style="height:250px;width:400px;" data-geo-center="{defaultmapcenter}" data-target-field="connect_site_location"{if $prefs.connect_server_mode eq "y"}
                            data-icon-name="tiki" data-icon-src="img/tiki/tikiicon.png"
                            data-icon-size="[16,16]" data-icon-offset="[-8,-16]" data-marker-filter=".geolocated.connection"{/if}>
                        </div>
                    </div>
                </div>
                {preference name="connect_send_anonymous_info"}
                <div class="adminoptionboxchild"{if $prefs.connect_server_mode neq "y"} style="display:none;"{/if}>
                    <strong>{tr}Advanced settings{/tr}</strong> {tr}Exposed to assist testing and development{/tr}
                    {preference name="connect_frequency"}
                    {preference name="connect_server"}
                    {preference name="connect_last_post"}
                    {preference name="connect_server_mode"}
                    {preference name="connect_guid"}
                </div>
            </div>
        </fieldset>
    </div>
</div>