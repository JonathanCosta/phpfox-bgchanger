<?php
  defined('PHPFOX') or exit('NO DICE!');
?>
{if Phpfox::getUserBy('profile_page_id') <= 0}
                        <ul>
                            {foreach from=$aMainMenuChanger key=iKey item=aMenu name=menu}
                            
                            {if $iKey != 'explorer'}
                                <li {if ($aMenu.url == 'apps' && count($aInstalledApps)) || (isset($aMenu.children) && count($aMenu.children))}class="explore{if ($aMenu.url == 'apps' && count($aInstalledApps))} explore_apps{/if}"{/if}><a {if !isset($aMenu.no_link) || $aMenu.no_link != true}href="{url link=$aMenu.url}" {else} href="#" onclick="return false;" {/if} class="{if isset($aMenu.external) && $aMenu.external == true}no_ajax_link {/if}ajax_link">
                                    {phrase var=$aMenu.module'.'$aMenu.var_name}{if isset($aMenu.suffix)}{$aMenu.suffix}{/if}</a>    
                                    {if isset($aMenu.children) && count($aMenu.children)}
                                    <ul>
                                        {foreach from=$aMenu.children item=aChild name=child_menu}
                                        <li{if $phpfox.iteration.child_menu == 1} class="first"{/if}><a href="{url link=$aChild.url}">{phrase var=$aChild.module'.'$aChild.var_name}</a></li>
                                        {/foreach}
                                    </ul>
                                    {else}                                
                                    {if $aMenu.url == 'apps' && count($aInstalledApps)}
                                    <ul>
                                        {foreach from=$aInstalledApps item=aInstalledApp}
                                        <li><a href="{permalink module='apps' id=$aInstalledApp.app_id title=$aInstalledApp.app_title}" title="{$aInstalledApp.app_title|clean}">{img server_id=0 path='app.url_image' file=$aInstalledApp.image_path suffix='_square' max_width=16 max_height=16 title=$aInstalledApp.app_title class='v_middle'} {$aInstalledApp.app_title|clean|shorten:22:'...'}</a></li>
                                        {/foreach}
                                    </ul>
                                    {/if}
                                    {/if}
                                </li>
                                 {/if}  
                            {/foreach}  
                            {if count($aMenuExplores)}
                                    <li>
                                        <a href="javascript:void(0);"  class="explorer_menu">{phrase var='bgchanger.explorer'}</a>
                                        <ul class="explorer_menu_item">
                                        {foreach from=$aMenuExplores item=aMenuExplorer}
                                            <li><a {if !isset($aMenuExplorer.no_link) || $aMenuExplorer.no_link != true}href="{url link=$aMenuExplorer.url}" {else} href="#" onclick="return false;" {/if} class="{if isset($aMenuExplorer.external) && $aMenuExplorer.external == true}no_ajax_link {/if}ajax_link">{phrase var=$aMenuExplorer.module'.'$aMenuExplorer.var_name}{if isset($aMenuExplorer.suffix)}{$aMenuExplorer.suffix}{/if}</a></li>
                                        {/foreach}
                                        </ul>
                                    </li>
                            {/if}  
                            {unset var=$aMainMenuChanger var=$aMenu}                        
                        </ul>
{/if}