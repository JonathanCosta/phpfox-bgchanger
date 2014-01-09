<?php
  defined('PHPFOX') or exit('NO DICE!');
?>

{literal}
<style type="text/css">
.user_register_holder,
#left,
#header,
.header_menu_login_label,
#main_content_holder,
div#flymenusbar_contenter
{
    display: none !important;
}
#main_content
{
    margin-left:0;
}
#main_content_holder{
    background: none !important;
    
}
body
{
{/literal}
    color:#{$sColor};
    background-color:#{$sColor}
{literal}
}
a
{
{/literal}
    color:#{$sColor};   
{literal}
}

.front-bg {
    background: none repeat scroll 0 0 #000000;
    height: 200%;
    left: -50%;
    position: fixed;
    width: 200%;
}
.front-bg img {
    bottom: 0;
    left: 0;
    margin: auto;
    min-height: 50%;
    min-width: 50%;
    right: 0;
    top: 0;
    display:block;
}
#front-visitor-page
{
    bottom: 0;
    left: 0;
    max-height: 750px;
    min-height: 545px;
    position: absolute;
    right: 0;
    top: 0;
}

.background_header {
    left: 0;
    position: fixed;
    right: 0;
    top: 0;
    z-index: 1000;
}

</style>
{/literal}
<link type="text/css" rel="stylesheet" href="{$sSiteUrl}module/bgchanger/static/css/default/default/background.css">
<script type="text/javascript" src='{$sSiteUrl}module/bgchanger/static/jscript/background.js'></script>
<div class="background_changer">
    <div class="background_header">
        <div class="background_header_holder">
            <div class="site_icon">
                {if isset($sIcon) && $sIcon != ''}
                    <a href="{url link=''}"><img id="site_icon" src="{$sIcon}"></a>
                {else}
                    {if !empty($sStyleLogo)}
                        <a href="{url link=''}" id="logo"><img src="{$sStyleLogo}" class="v_middle" /></a>
                    {else}
                        <a href="{url link=''}" id="logo">{param var='core.site_title'}</a>
                    {/if}
                {/if}
            </div>
            {if $bIsViewMenu}
            <div class="site_menu" id="header_menu">
               {module name='bgchanger.template-menu'}
            </div>
            {/if}
            <div class="sign_up_site sign_up_site_blue" >
                <a href="{url link='user.register'}">{phrase var='bgchanger.sign_up'}</a>
            </div>
            <div class="site_language">
                {phrase var='bgchanger.language'}:
                <a href="#" id="select_lang_pack">{if Phpfox::getParam('language.display_language_flag') && !empty($sLocaleFlagId)}<img src="{$sLocaleFlagId}" alt="{$sLocaleName}" class="v_middle" /> {/if}{$sLocaleName}</a>
            </div>
        </div>
    </div>
    <div id="front-visitor-page">
        <div class="front-bg">
            <img src="{$sBackground}" class="front-image">
        </div>
    </div>
    <div class="background_content">
        <div class="front_welcome">
            <div class="welcome_title">
                {phrase var='user.ssitename_helps_you_connect_and_share_with_the_people_in_your_life' sSiteName=$sSiteTitle}
            </div>
            <div class="welcome_description">
                {phrase var='bgchanger.welcome_description'}
            </div>

        </div>
        <div class="extra_right_column">
            <div class="front_signin">
                {module name='bgchanger.login-header'} 
            </div>
            {if count($aUserCustomImages) && phpfox::getParam('bgchanger.enable_recent_login_member_avatar')}
            <div class="user_image front_signin">
                    <div class="user_welcome_images_right"> 
                        {foreach from=$aUserCustomImages name=userimages item=aUserCustomImage key=iKey}
                            {if $iKey < 20}
                            <div class="user_image_item">
                                {img user=$aUserCustomImage suffix='_50_square' max_width=50 max_height=50}
                            </div>
                            {/if}
                        {/foreach}
                        <div class="clear"></div>
                    </div>
            </div>  
            {/if}
        </div>
        <div class="clear"></div>
    </div>
</div>
<script type="text/javascript">
    username = "{phrase var='bgchanger.username_or_email'}";
    password = "{phrase var='bgchanger.password'}";
</script>
