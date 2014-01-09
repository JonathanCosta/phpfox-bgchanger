$Core.bgchanger = {   
    data:{}, 
    bIsLoad: false,
    changeRandomBg: function()
    {
        is_random = $('#is_random').val();
        if(is_random == 0)
        {
            $('#bg_holder').slideDown();
        }
        else
        {
            $('#bg_holder').slideUp();
        }
    },
}
$Behavior.bgchanger = function()
{
    var aOptions = {
        onSubmit: function(hsb, hex, rgb)
        {            
            $('#js_colorpicker_drop_1').val(hex); 
            $('#text_color').attr('value', hex);
            $('#backgroundChooser').css('backgroundColor', '#'+hex);
        }
    };
    $('#backgroundChooser').ColorPicker(aOptions);
}

