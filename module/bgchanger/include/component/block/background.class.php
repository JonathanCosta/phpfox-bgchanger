<?php
defined('PHPFOX') or exit('NO DICE!');
Class Bgchanger_Component_Block_Background extends Phpfox_Component
{
    public function process()
    {
        $sBackground = phpfox::getService('bgchanger')->getBackground();
        $sIcon = phpfox::getService('bgchanger.process')->getIcon();
        $sColor = phpfox::getParam('bgchanger.text_color');
        $bIsViewMenu = phpfox::getParam('bgchanger.show_menu');
        if($sBackground == '')
        {
            $sBackground = phpfox::getParam('core.path').'module/bgchanger/static/image/background.jpg';
        }
        $aUserCustomImages = Phpfox::getService('user')->getUserImages();
        $this->template()->assign(array(
            'sSiteUrl' => phpfox::getParam('core.path'),
            'sBackground' => isset($sBackground) ? $sBackground : '',
            'sIcon' => isset($sIcon) ? $sIcon : '',
            'sSiteTitle' => Phpfox::getParam('core.site_title'),
            'sColor' => isset($sColor) ? $sColor : 'FFFFFF',
            'bIsViewMenu' => isset($bIsViewMenu) ? $bIsViewMenu : false,
            'aUserCustomImages' => isset($aUserCustomImages) ? $aUserCustomImages : array(),
        ));
    }
}
?>
