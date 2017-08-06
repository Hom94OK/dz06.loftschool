// POPUP
$(".order__form-button").on("click", function (e) {
    e.preventDefault();
    // var dsa = 'tlkasn;lkdsa';
    $(this).closest("body").find(".f-popup__bg").css({
        'display': 'flex'
    });
    // $( ".order__form-tag" ).load( "form-handler.php", function(data) {
    //     $(this).closest("body").find(".f-popup__title").html(data);
    // });

    //$(this).closest('body').find('.f-popup__content').text(dsa);
    $.ajax({
        type: "POST",
        url: "form-handler.php",
        data: $(".order__form-tag").serialize() // serializes the form's elements.
    }).done(function (data) {
        $(".f-popup__content").html(data);
    })

});
$(".f-popup__close").on("click", function (e) {
    e.preventDefault();
    $(this).closest(".f-popup__bg").hide();
});
