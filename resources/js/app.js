$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    cache: false
});

$(document).on("ajaxStop", function() {
    $("#spinner").hide();
    $(".overlay").remove();
});

$(document).on("ajaxStart", function() {
    $("#spinner").show();
    $("body").append("<div class='overlay'></div>");
});
