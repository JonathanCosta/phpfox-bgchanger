<?php
defined('PHPFOX') or exit('NO DICE!');
class Bgchanger_Service_Process extends Phpfox_Service
{
    public function changeIcon($sType ='siteicon',$aImage,$bResize = false)
    {
        $aInfo = getimagesize($aImage['tmp_name']);
        switch ($aInfo['mime'])
        {
            case 'image/png':
                $sExt = 'png';
                break;
            case 'image/gif':
                $sExt = 'gif';
                break;
            case 'image/jpg':
            case 'image/jpeg':
                $sExt = 'jpg';
                break;    
            default:
                return Phpfox_Error::set(Phpfox::getPhrase('bgchanger.not_a_valid_file_extension'));
                break;
        }            
        //$sIconFile = PHPFOX_DIR_MODULE . 'bgchanger/static/image' . PHPFOX_DS . 'siteicon.' . $sExt;
        $sIconFile = PHPFOX_DIR_FILE.'static' . PHPFOX_DS . 'siteicon.' . $sExt;
        
        $this->removeIcon('siteicon');
        $iWidth = 30;
        $iHeight = 30;
        if (@move_uploaded_file($aImage['tmp_name'], $sIconFile))
        {        
            if ($bResize === true)
            {
                Phpfox::getLib('image')->createThumbnail($sIconFile, $sIconFile, $iWidth, $iHeight);    
            }
            return true;
        }
        return Phpfox_Error::set(Phpfox::getPhrase('bgchanger.unable_to_upload_image'));
    }
    
    public function removeIcon($sType = 'siteicon')
    {    
        //$sCustomPath = PHPFOX_DIR_MODULE.'bgchanger/static/image'.PHPFOX_DS;
        $sCustomPath = PHPFOX_DIR_FILE.'static' . PHPFOX_DS;
        switch($sType){
            case 'siteicon':
                if(file_exists($sCustomPath.'siteicon.png'))
                {
                     phpfox::getLib('file')->unlink($sCustomPath.'siteicon.png');
                }
                if(file_exists($sCustomPath.'siteicon.gif'))
                {
                     phpfox::getLib('file')->unlink($sCustomPath.'siteicon.gif');
                }
                if(file_exists($sCustomPath.'siteicon.jpg'))
                {
                     phpfox::getLib('file')->unlink($sCustomPath.'siteicon.jpg');
                }
                return true;
            default:
                break;
        }        
        return false;
    }
    
    public function getIcon($sType ="siteicon")
    {
        $sCustomPath = PHPFOX_DIR_FILE.'static' . PHPFOX_DS;
        switch ($sType)
        {
            case 'siteicon':
                $sDefaulUrl = '';
                if(file_exists($sCustomPath . 'siteicon.png'))
                {
                    return  Phpfox::getParam('core.path').'file/static/siteicon.png';  
                }
                if(file_exists($sCustomPath . 'siteicon.gif'))
                {
                    return  Phpfox::getParam('core.path').'file/static/siteicon.gif';  
                }
                if(file_exists($sCustomPath . 'siteicon.jpg'))
                {
                    return  Phpfox::getParam('core.path').'file/static/siteicon.jpg';
                }
                return $sDefaulUrl;
            default:
                break;
        }
        return "";
    }
}
?>
