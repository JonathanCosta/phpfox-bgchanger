<?php
defined('PHPFOX') or exit('NO DICE!');
class Bgchanger_Component_Block_Login_Header extends Phpfox_Component
{
    public function process()
    {
        $this->template()->assign(array(
                'sJanrainUrl' => (Phpfox::isModule('janrain') ? Phpfox::getService('janrain')->getUrl() : '')
            )
        );
    }
}
?>
