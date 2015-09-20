$(document).ready(function(){
    // validate plugin js
    $('input.required, textarea.required, select.required').parent('div').prev('label').append('<em class="required" style="color:red;">*</em>');

    $(".validate").validate({
        errorClass: 'form-error',
        wrapper: "span",
    });

    // this will get the full URL at the address bar ans selects menu
    var url = window.location.href;
    // passes on every "a" tag
    $(".sidebar-menu a").each(function() {
        // checks if its the same on the address bar
        if (url == (this.href)) {
            $(this).closest("li").addClass("active");
            $(this).parents('li').addClass('menu-open active');
            $(this).parents('ul').addClass('menu-open');
            $(this).parents('ul').css('display', 'block');
        }
    });

    // alert box for actions delete/block/unblock
    $('.fa-trash-o').click(function(){
        return confirm('Are you sure to delete?');
    });

    $('.fa-remove').click(function(){
        return confirm('Are you sure to remove permanently?');
    });

    $('.fa-ban').click(function(){
        return confirm('Are you sure to block?');
    });

    $('.fa-check-square-o').click(function(){
        return confirm('Are you sure to unblock?');
    });

    $('.fa-mail-reply').click(function(){
        return confirm('Are you sure to restore?');
    });

    $('.fa-thumbs-o-up').click(function(){
        return confirm('Are you sure to publish?');
    });
});


function welcomeUserNoty(msg) {
    var s = noty({
        text: msg,
        type: 'info',
        dismissQueue: true,
        layout: 'topRight',
        theme: 'defaulTheme',
        timeout: 4000,
        closeWith:['button']
    });
}