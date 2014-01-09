<?php
defined('PHPFOX') or exit('NO DICE!');
class Bgchanger_Component_Controller_Admincp_Index extends Phpfox_Component
{
    public function process()
    {
        
        $bIsEdit = false;
        if($this->request()->getInt('delete') > 0)
        {
            if($aBg = Phpfox::getService('bgchanger')->deleteBg($this->request()->getInt('delete')))
            {
                $this->url()->send('admincp.bgchanger', null, Phpfox::getPhrase('bgchanger.delete_background_successfully'));
            }
            else
            {
                $this->url()->send('admincp.bgchanger', null, Phpfox::getPhrase('bgchanger.can_t_find_background_with_id_you_provide'));
            }
        }
        if($this->request()->getInt('edit') > 0)
        {
            if($aBg = Phpfox::getService('bgchanger')->getForEdit($this->request()->getInt('edit')))
            {
                $bIsEdit = true;
                $this->template()->assign(array(
                    'aBg' => $aBg
                ));
            }
            else
            {
                $this->url()->send('admincp.bgchanger', null, Phpfox::getPhrase('bgchanger.can_t_find_background_with_id_you_provide'));
            }
        }
        if($aVals = $this->request()->getArray('val'))
        {
            if($aVals['type'] == 'upload_bg')
            {
                list($bSuccess, $sErrorDetail) = Phpfox::getService('bgchanger')->uploadBg($aVals);
                if($bSuccess)
                {
                    $this->url()->send('admincp.bgchanger', null, Phpfox::getPhrase('bgchanger.upload_background_successfully'));
                }
                else
                {
                    $this->url()->send('admincp.bgchanger', null, $sErrorDetail);
                }
            }
            elseif($aVals['type'] == 'update_bg')
            {
                $bSuccess = Phpfox::getService('bgchanger')->updateBg($aVals);
                if($bSuccess)
                {
                    $this->url()->send('admincp.bgchanger', null, Phpfox::getPhrase('bgchanger.update_background_successfully'));
                }
                else
                {
                    $this->url()->send('admincp.bgchanger', null, $sErrorDetail);
                }    
            }
            elseif($aVals['type'] == 'update_setting')
            {
                list($bSuccess, $sErrorDetail) = Phpfox::getService('bgchanger')->updateSetting($aVals);
                if($bSuccess)
                {
                    $this->url()->send('admincp.bgchanger', null, Phpfox::getPhrase('bgchanger.update_setting_successfully'));
                }
                else
                {
                    $this->url()->send('admincp.bgchanger', null, $sErrorDetail);
                } 
            }
            elseif($aVals['type'] == 'upload_icon')
            {            
                if($_FILES['image']['name'] != '')
                {
                    $aImage = Phpfox::getLib('file')->load('image', array('jpg', 'gif', 'png'));
                    $bResize = $this->request()->get('is_resize',0);
                    if($bResize == 1)
                    {
                        $bResize = true;
                    }
                    else
                    {
                        $bResize = false;
                    }
                    Phpfox::getService('bgchanger.process')->changeIcon('siteicon',$aImage,$bResize);           
                    $this->url()->send('admincp.bgchanger', null, Phpfox::getPhrase('bgchanger.upload_icon_successfully'));
                }
                else
                {
                    $this->url()->send('admincp.bgchanger', null, Phpfox::getPhrase('bgchanger.icon_path_can_not_empty'));
                }
            }  
        }        
        $this->template()->assign(array(
                'aBgs' => Phpfox::getService('bgchanger')->getAllBgs(),
                'bIsEdit' => $bIsEdit,
                'bRandomBg' => Phpfox::getParam('bgchanger.random_background'),
                'iDefaultBgId' => (Phpfox::getParam('bgchanger.background_id') != '' ? Phpfox::getParam('bgchanger.background_id') : null),      
                'sTextColor' => Phpfox::getParam('bgchanger.text_color'),
                'bShowMenu' => Phpfox::getParam('bgchanger.show_menu'),
                'sPathIcon' => Phpfox::getService('bgchanger.process')->getIcon(),
                'sSiteUrl' => phpfox::getParam('core.path'),
        ));
        $this->template()->setHeader(array(
                'jquery/ui.js' => 'static_script',      
                'admin.js' => 'module_bgchanger',
                'background.css' => 'module_bgchanger'
            ))
            ->setBreadcrumb(Phpfox::getPhrase('bgchanger.bgchanger'), $this->url()->makeUrl('admincp.bgchanger'))
            ->setBreadcrumb(Phpfox::getPhrase('bgchanger.manage_backgrounds'), null, true);
    }
}
?>

