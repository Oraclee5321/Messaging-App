$(document).ready(function() {
    $('input[type="checkbox"]').click(function() {
        if ($(this).is(':checked')) {
            $('input[type="password"]').attr('type', 'text');
        } else {
            $('input[type="text"][id!="usernameInput"]').attr('type', 'password');
        };
    });
});

