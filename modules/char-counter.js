$(document).ready(function(){
    $("#messageInput").bind("keyup", function(){
        var counter = $('#messageInput').val().length;
        var completeCounter =(counter + " / 256");
        $('#charCounter').text(completeCounter);
    })
    $("#editMessageInput").bind("keyup", function(){
        var counter = $('#editMessageInput').val().length;
        var completeCounter =(counter + " / 256");
        $('#editCharCounter').text(completeCounter);
    })
})