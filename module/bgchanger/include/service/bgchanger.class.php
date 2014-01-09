<?php
defined('PHPFOX') or exit('NO DICE!');
class bgchanger_Service_bgchanger extends Phpfox_Service
{   
    public function __construct()
    {
        $this->_sTable = Phpfox::getT('bgchanger');
    }
    public function getBackground()
    {
        if(Phpfox::getUserId() == 0)
        {
            $aBgIds = $this->database()->select('background_id')
                                    ->from($this->_sTable)
                                    ->execute('getSlaveRows');
            if(count($aBgIds))
            {
                if(Phpfox::getParam('bgchanger.random_background'))
                {
                    $iKey = array_rand($aBgIds, 1);
                    $aBg = $this->getForEdit($aBgIds[$iKey]['background_id']);
                }
                else
                {
                    if($iBgId = Phpfox::getParam('bgchanger.background_id'))
                    {
                        $aBg = $this->getForEdit($iBgId);   
                    }
                    else
                    {
                        return false;
                    }
                }
                $aBg['destination'] =  Phpfox::getParam('core.path'). 'file/pic/photo/'. sprintf($aBg['destination'], '');
                return $aBg['destination'];
            }
            else
            {
                return false;
            }
        }
    }
    
    public function uploadBg($aVals)
    {
        $bSuccess = false;
        $sErrorDetail = '';
        if($_FILES['image']['name'] != '')
        {
            if($sImagePath = $this->uploadImage())
            {
                   $aVals['destination'] = $sImagePath;
                   $aVals['user_id'] = Phpfox::getUserId();
                   $aVals['server_id'] = Phpfox::getLib('request')->getServer('PHPFOX_SERVER_ID');
                   $aVals['description'] = Phpfox::getLib('parse.input')->clean($aVals['description']);
                   $aVals['time_stamp'] = PHPFOX_TIME;
                   unset($aVals['submit']);
                   unset($aVals['type']);
                   $iId = $this->database()->insert($this->_sTable, $aVals);
                   $bSuccess = ($iId? true:false);
            }
            else
            {
                $sErrorDetail = Phpfox::getPhrase('bgchanger.there_are_some_errors_happen_when_upload_this_image');
            }
        }
        else
        {
            $sErrorDetail = Phpfox::getPhrase('bgchanger.image_path_can_not_empty');
        }
        return array($bSuccess, $sErrorDetail);
    }
    
    public function uploadImage()
    {      
        $oFile = Phpfox::getLib('file');
        $oImage = Phpfox::getLib('image');
        
        if ($aImage = $oFile->load('image', array(
                            'jpg',
                            'gif',
                            'png'
                        ), null
                    )
        )
        {
            $sFileName = $oFile->upload('image', 
                            Phpfox::getParam('photo.dir_photo'), 
                            time()
                        ); 
            if(!empty($sFileName))
            {
                foreach(Phpfox::getParam('photo.photo_pic_sizes') as $iSize)
                {
                    $oImage->createThumbnail(Phpfox::getParam('photo.dir_photo') . sprintf($sFileName, ''), Phpfox::getParam('photo.dir_photo') . sprintf($sFileName, '_' . $iSize), $iSize, $iSize);            
                }     
                $oImage->createThumbnail(Phpfox::getParam('photo.dir_photo') . sprintf($sFileName, ''), Phpfox::getParam('photo.dir_photo') . sprintf($sFileName, '_' . '50_square'), 50, 50);            
            } 
            return $sFileName;
                    
        }
        return false;
    }
    
    public function deleteImage($aBg)
    {    
        if (!empty($aBg['destination']))
        {
            $aImages = array(
                Phpfox::getParam('photo.dir_photo') . sprintf($aBg['destination'], ''),
                Phpfox::getParam('photo.dir_photo') . sprintf($aBg['destination'], '_50'),
                Phpfox::getParam('photo.dir_photo') . sprintf($aBg['destination'], '_50_square'),
                Phpfox::getParam('photo.dir_photo') . sprintf($aBg['destination'], '_75'),
                Phpfox::getParam('photo.dir_photo') . sprintf($aBg['destination'], '_100'),
                Phpfox::getParam('photo.dir_photo') . sprintf($aBg['destination'], '_150'),
                Phpfox::getParam('photo.dir_photo') . sprintf($aBg['destination'], '_240'),
                Phpfox::getParam('photo.dir_photo') . sprintf($aBg['destination'], '_500'),
                Phpfox::getParam('photo.dir_photo') . sprintf($aBg['destination'], '_1024')
            );            
            
            $iFileSizes = 0;
            foreach ($aImages as $sImage)
            {
                if (file_exists($sImage))
                {
                    $iFileSizes += filesize($sImage);
                    
                    @unlink($sImage);
                }
            }
            
            if ($iFileSizes > 0)
            {
                Phpfox::getService('user.space')->update($aBg['user_id'], 'photo', $iFileSizes, '-');
            }
        }

        $this->database()->update($this->_sTable, array('destination' => null), 'background_id = ' . (int) $aBg['background_id']);    
        
        return true;
    }
    
    public function getAllBgs()
    {
        $aBgs = $this->database()->select('*')
                                ->from($this->_sTable)
                                ->order('background_id')
                                ->execute('getSlaveRows');
        return $aBgs;
    }
    
    public function getForEdit($iBgId)
    {
        return $this->database()->select('*')
                                ->from($this->_sTable)
                                ->where('background_id='.(int)$iBgId)
                                ->execute('getSlaveRow');
    }
    public function updateSetting($aVals)
    {
        $sErrorDetail = '';
        $bSuccess = true;
        if(preg_match('/^[a-f0-9]{6}$/i', $aVals['text_color']))
        {
            $this->database()->update(Phpfox::getT('setting'),array('value_actual' => $aVals['text_color']), 'var_name="text_color" AND module_id="bgchanger"');
        }
        else
        {
            $bSuccess = false;
            $sErrorDetail = Phpfox::getPhrase('bgchanger.invalid_color');
            return array($bSuccess, $sErrorDetail);
        }
        $this->database()->update(Phpfox::getT('setting'),array('value_actual' => $aVals['show_menu']), 'var_name="show_menu" AND module_id="bgchanger"');
        if($aVals['random'])
        {
            
            $this->database()->update(Phpfox::getT('setting'),array('value_actual' => $aVals['random']), 'var_name="random_background" AND module_id="bgchanger"');
            $this->cache()->remove();
            return array($bSuccess, $sErrorDetail);
        }
        else
        {
            if(empty($aVals['default_bg_id']))
            {
                $sErrorDetail = Phpfox::getPhrase('bgchanger.default_background_can_not_be_null_if_you_select_random_background_is_false');
            }
            else
            {
                $this->database()->update(Phpfox::getT('setting'),array('value_actual' => $aVals['default_bg_id']), 'var_name="background_id" AND module_id="bgchanger"');
                $this->database()->update(Phpfox::getT('setting'),array('value_actual' => $aVals['random']), 'var_name="random_background" AND module_id="bgchanger"');
                $this->cache()->remove();
                return array($bSuccess, $sErrorDetail);
            }
        }
    }
    
    public function updateBg($aVals)
    {
        $bIsSuccess = false;
        $aUpdate = array(
            'title' => $aVals['title'],
            'description' => $aVals['description']
        );  
        $iId = $this->database()->update($this->_sTable,$aUpdate,'background_id='.(int)$aVals['background_id']);
        $bIsSuccess = ($iId?true:false);
        return $bIsSuccess;            
    }
    
    public function deleteBg($iBgId)
    {
        if($aBg = $this->getForEdit($iBgId))
        {
            $this->deleteImage($iBgId);
            return $this->database()->delete($this->_sTable,'background_id = '.(int)$iBgId);    
        }
        else
        {
            return false;
        }
        
    }
}
?>
