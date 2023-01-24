$(document).ready(function(){
    $("#messageInput").bind("keyup", function(){
        var counter = $('#messageInput').val().length;
        var completeCounter =(counter + " / 256");
        $('#charCounter').text(completeCounter);
    })
    $("#editMessageInput").bind("keyup", function(){
        var counter = $('#editMessageInput').val().length;
        var completeCounter = (counter + " / 256");
        $('#editMessageCharCounter').text(completeCounter);
    })
    $("#editUsernameInput").bind("keyup", function(){
        var counter = $('#editUsernameInput').val().length;
        var completeCounter = (counter + " / 50");
        $('#editUsernameCharCounter').text(completeCounter);
    })
    $("#replyMessageInput").bind("keyup", function(){
        var counter = $('#replyMessageInput').val().length;
        var completeCounter = (counter + " / 256");
        $('#replyCharCounter').text(completeCounter);
    })
    $("#editAdminEmailInput").bind("keyup", function(){
        var counter = $('#editAdminEmailInput').val().length;
        var completeCounter = (counter + " / 50");
        $('#editAdminEmailCharCounter').text(completeCounter);
    })
    $("#editAdminUsernameInput").bind("keyup", function(){
        var counter = $('#editAdminUsernameInput').val().length;
        var completeCounter = (counter + " / 50");
        $('#editAdminUsernameCharCounter').text(completeCounter);
    })

})