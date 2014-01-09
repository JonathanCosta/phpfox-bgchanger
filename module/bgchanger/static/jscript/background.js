
var $bIsClickOnExplorerMenu = false;
var $bIsClickBody = false;
$Behavior.clickExplorerMenuInit =function()
{
    $((getParam('bJsIsMobile') ? '#content' : 'body')).click(function()
    {
        if( $bIsClickBody == false)
        {
            $('.explorer_menu_item').removeClass('active'); 
            $bIsClickOnExplorerMenu = false; 
        }
        else{
            $bIsClickBody = false;
            $bIsClickOnExplorerMenu = true;
        }
    });
    $('.explorer_menu').click(function()
    {
        if($bIsClickOnExplorerMenu == false)
        {
            $('.explorer_menu_item').addClass('active');
            $bIsClickBody = true;
        }
    });
    $('ul.explorer_menu_item li a').click(function()
    {
        $('.explorer_menu_item').removeClass('active'); 
    });  
}
var username;
var password;
$Behavior.loadInitCustomLogin = function()
{
    $('#username_or_email').bind('focus', function(){
        if($(this).val() == username){
            $(this).attr('value','');
        }
    });
    $('#username_or_email').bind('blur', function(){
        if($(this).val() == ''){
            $(this).attr('value',username);
        }
    });
    $('#login_password').bind('focus', function(){
        if($(this).val() == password){
            $(this).attr('value','');
        }
    });
    $('#login_password').bind('blur', function(){
        if($(this).val() == ''){
            $(this).attr('value',password);
        }
    });
}
