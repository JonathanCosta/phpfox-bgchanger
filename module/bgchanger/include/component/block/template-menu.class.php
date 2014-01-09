<?php
defined('PHPFOX') or exit('NO DICE!');
class Bgchanger_Component_Block_Template_Menu extends Phpfox_Component
{
    public function process()
    {
        if(phpfox::getParam('bgchanger.show_menu') == false)
        {
            return false;
        }
        $oTpl = phpfox::getLib('template');
        $oTpl = phpfox::getLib('template');
        $aMenu = $oTpl->getMenu('main');
        $aMenuExplores = $oTpl->getMenu('explore');
        $aMainMenu = array();
        $iCnt = 0;
        if(count($aMenu) > 11){
           foreach($aMenu as $iKey => $aValue){
               if($iCnt < 11){
                   $aMainMenu[] = $aValue;
               }
               if($iCnt >= 11){
                   $aMenuExplores[] = $aValue;
               }
               $iCnt++;
           } 
        }
        else
        {
            $aMainMenu = $aMenu;
        }
        
        $this->template()->assign(array(
            'aMainMenuChanger' => $aMainMenu,
            'aMenuExplores' => $aMenuExplores,
        ));
    }
}
?>
