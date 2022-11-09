$(document).ready(function() {

    // Placeholder IE
    $('input, textarea').placeholder();


});

$(document).ready(function() {
    $(".menu a").click(function(event) {
        event.preventDefault();
        $(this).parent().addClass("activo");
        $(this).parent().siblings().removeClass("activo");
        var tab = $(this).attr("href");
        $(".contenido > div").not(tab).css("display", "none");
        $(tab).fadeIn();
    });
});