$(".rowListaUsers").click(function() {
    var testID = $(this).data("info");
    $("#userProfileName").html("Nome " + testID);
})