{* Index we display a wiki page here *}
{include file="header.tpl"}
{if $feature_bidi eq 'y'}
<table dir="rtl" ><tr><td>
{/if}

<div id="tiki-main">
  {if $feature_top_bar eq 'y'}
  <div id="tiki-top">
    {include file="tiki-top_bar.tpl"}
  </div>
  {/if}
  <div id="tiki-mid">
    <table id="tikimidtbl" border="0" cellpadding="0" cellspacing="0" >
    <tr>
      {if $feature_left_column eq 'y'}
      <td id="leftcolumn">
      {section name=homeix loop=$left_modules}
      {$left_modules[homeix].data}
      {/section}
      </td>
      {/if}
      <td id="centercolumn"><div id="tiki-center">
			<!-- content -->
      <br/>
        <div class="cbox">
        <div class="cbox-title">
        {tr}Error{/tr}
        </div>
        <div class="cbox-data">
        {$msg}<br/><br/>
        <a href="javascript:history.back()" class="linkmenu">{tr}Go back{/tr}</a><br/><br/>
        <a href="{$tikiIndex}" class="linkmenu">{tr}Return to home page{/tr}</a>
        </div>
        </div>
      </div>
			<!-- end of content -->
			</td>
      {if $feature_right_column eq 'y'}
      <td id="rightcolumn">
      {section name=homeix loop=$right_modules}
      {$right_modules[homeix].data}
      {/section}
      </td>
      {/if}
    </tr>
    </table>
  </div>
  {if $feature_bot_bar eq 'y'}
  <div id="tiki-bot">
    {include file="tiki-bot_bar.tpl"}
  </div>
  {/if}
</div>
{if $feature_bidi eq 'y'}
</td></tr></table>
{/if}

{include file="footer.tpl"}
