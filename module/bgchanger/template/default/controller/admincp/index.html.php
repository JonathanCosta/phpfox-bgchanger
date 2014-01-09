<?php
    defined('PHPFOX') or exit('NO DICE!');
?>
<script type="text/javascript">$Core.loadStaticFile('{$sSiteUrl}static/jscript/colorpicker/css/colorpicker.css');</script>
<script type="text/javascript">$Core.loadStaticFile('{$sSiteUrl}static/jscript/colorpicker/js/colorpicker.js');</script>
{if !$bIsEdit}
<div class="update_setting">
    <div class="table_header">{phrase var='bgchanger.update_setting'}</div>
    <form action="{url link='admincp.bgchanger'}" method="post" name="general_setting">
    <input type="hidden" name="val[type]" value="update_setting">
        <div class="table">
            <div class="table_left">
                <span>{phrase var='bgchanger.random_background'}:</span>
            </div>
            <div class="table_right">
                <select name="val[random]" id="is_random" onchange="$Core.bgchanger.changeRandomBg();">
                    <option value="1" {if $bRandomBg}selected{/if}>{phrase var='bgchanger.true'}</option>
                    <option value="0" {if !$bRandomBg}selected{/if}>{phrase var='bgchanger.false'}</option>
                </select>
            </div>
            <div class="clear"></div>
        </div>
        <div class="table">
            <div class="table_left">
                <span>{phrase var='bgchanger.show_menu'}:</span>
            </div>
            <div class="table_right">
                <select name="val[show_menu]">
                    <option value="1" {if $bShowMenu}selected{/if}>{phrase var='bgchanger.true'}</option>
                    <option value="0" {if !$bShowMenu}selected{/if}>{phrase var='bgchanger.false'}</option>
                </select>
            </div>
            <div class="clear"></div>
        </div>
        <div class="table">
            <div class="table_left">
                <span>{phrase var='bgchanger.text_color'}:</span>
            </div>
            <div class="table_right">
                <input name="backgroundChooser" id="backgroundChooser"  class="colorpicker_select" style="background-color: #{$sTextColor};">
                <input type="hidden" name="val[text_color]" id="text_color" value="{$sTextColor}">
            </div>
            <div class="clear"></div>
        </div>
        
        <div class="table" {if $bRandomBg}style="display:none;"{/if} id="bg_holder">
            <div class="table_left">
                <span>{phrase var='bgchanger.background_id'}:</span>
            </div>
            <div class="table_right">
                <select name="val[default_bg_id]" id="default_bg_id">
                    {foreach from=$aBgs key=iKey item=aBg}
                        <option value="{$aBg.background_id}" {if $iDefaultBgId == $aBg.background_id}selected{/if}>{$aBg.background_id}</option>
                    {/foreach}
                </select>
            </div>
            <div class="clear"></div>
        </div>
        <input type="submit" value="{phrase var='bgchanger.update_setting'}" name="val[submit]" class="button m_top_10">
    </form>
</div>
{/if}
{if $bIsEdit == false}
    <div class="upload_bg_wrapper">
        <div class="table_header">{phrase var='bgchanger.upload_new_background'}</div>
        <form name="bg_upload" method="post" action="{url link='admincp.bgchanger'}" enctype="multipart/form-data">
        <input type="hidden" name="val[type]" value="upload_bg">
            <div class="table">
                <div class="table_left">
                    <span>{phrase var='bgchanger.title'}:</span>
                </div>
                <div class="table_right">
                    <input name="val[title]">
                </div>
                <div class="clear"></div>
            </div>
            <div class="table">
                <div class="table_left">
                    <span>{phrase var='bgchanger.description'}:</span>
                </div>
                <div class="table_right">
                    <input name="val[description]">
                </div>
                <div class="clear"></div>
            </div>
            
            <div class="table">
                <div class="table_left">
                    <span>{phrase var='bgchanger.image_path'}:</span>
                </div>
                <div class="table_right">
                    <input type="file" name="image">
                </div>
                <div class="clear"></div>
            </div>
            <input type="submit" value="{phrase var='bgchanger.upload'}" name="val[submit]" class="button m_top_10">
        </form>
    </div>
{else}
    <div class="edit_bg_wrapper">
    <div class="table_header">{phrase var='bgchanger.edit_background'}</div>
        <form name="bg_edit" method="post" action="{url link='admincp.bgchanger'}" enctype="multipart/form-data">
            <input type="hidden" name="val[background_id]" value="{$aBg.background_id}">
            <input type="hidden" name="val[type]" value="edit_bg">
            <div class="table">
                <div class="table_left">
                    <span>{phrase var='bgchanger.title'}:</span>
                </div>
                <div class="table_right">
                    <input name="val[title]" value="{$aBg.title}">
                </div>
                <div class="clear"></div>
            </div>
            
            <div class="table">
                <div class="table_left">
                    <span>{phrase var='bgchanger.background_description'}:</span>
                </div>
                <div class="table_right">
                    <input name="val[description]" value="{$aBg.description}">
                </div>
                <div class="clear"></div>
            </div>
            <input type="submit" value="{phrase var='bgchanger.update'}" name="val[submit]" class="button m_top_10">
        </form>
    </div>
{/if}
{if !$bIsEdit}
<div class="upload_icon">
    <div class="table_header">{phrase var='bgchanger.manage_icon'}</div>
    <form method="post" action="" enctype="multipart/form-data">
    <input type="hidden" name="val[type]" value="upload_icon">
        {if $sPathIcon == ''}
            <div class="extra_info">{phrase var='bgchanger.icon_site_not_found'}</div>
        {else}
            <div class="table">
                <div class="table_left">
                    <span>{phrase var='bgchanger.current_icon'}:</span>
                </div>
                <div class="table_right">
                    <img src="{$sPathIcon}">
                </div>
                <div class="clear"></div>
            </div>
        {/if}
        <div class="table">
            <div class="table_left">
                <span>{phrase var='bgchanger.icon_path'}:</span>
            </div>
            <div class="table_right">
                <input type="file" name="image">
                <p><label><input type="checkbox" name="is_resize" value="1" autocomplete="off" checked/> {phrase var='bgchanger.automatically_resize'}</label></p>
            </div>
            <div class="clear"></div>
        </div>
        {if $sPathIcon == ''}
            <input type="submit" value="{phrase var='bgchanger.upload_new_icon'}" name="val[submit]" class="button m_top_10">
        {else}
            <input type="submit" value="{phrase var='bgchanger.change_icon'}" name="val[submit]" class="button m_top_10">
        {/if}
    </form>

</div>
{/if}
<div class="all_bg_wrapper">
    <div class="table_header">{phrase var='bgchanger.all_backgrounds'}</div>
<table cellpadding="0" cellspacing="0">
    <tr>
        <th style="width:20px;"></th>
        <th>{phrase var='bgchanger.id'}</th>
        <th style="width: 220px;">{phrase var='bgchanger.title'}</th>
        <th>{phrase var='bgchanger.background_image'}</th>
        <th>{phrase var='bgchanger.description'}</th>
    </tr>
    {foreach from=$aBgs key=iKey item=aBg}
    <tr class="checkRow{if is_int($iKey/2)} tr{else}{/if}">
        
        <td class="t_center">
            <a href="#" class="js_drop_down_link" title="Manage">{img theme='misc/bullet_arrow_down.png' alt=''}</a>
            <div class="link_menu">
                <ul>
                    <li><a href="{url link='admincp.bgchanger' edit=$aBg.background_id}">{phrase var='core.edit'}</a></li>
                    <li><a href="{url link='admincp.bgchanger' delete=$aBg.background_id}" onclick="return confirm('{phrase var='core.are_you_sure'}');">{phrase var='core.delete'}</a></li>        
                </ul>
            </div>        
        </td>    
        <td>{$aBg.background_id}</td>
        <td>{$aBg.title|shorten:75:'...'}</td>
        <td>
            <a href="{$aBg.description}" target="_blank">{img thickbox=true path='photo.url_photo' file=$aBg.destination suffix='_50_square' height=50 width=50}</a>
        </td>
        <td>
            {$aBg.description|shorten:150:'...'}
        </td>
    </tr>
    {/foreach}
</table>
</div>
