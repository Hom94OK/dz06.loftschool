$("#authorization").on("click", function (e) {
    e.preventDefault();
    $(this).closest("body").find("#f-authorization").css({
        'display': 'flex'
    });

    // $.ajax({
    //     type: "POST",
    //     url: "f-authorization.php",
    //     data: $(".order__form-tag").serialize() // serializes the form's elements.
    // }).done(function (data) {
    //     $(".f-popup__content").html(data);
    // });

    $("#f-authorization").find(".f-popup__close").on("click", function (e) {
        e.preventDefault();
        $(this).closest("#f-authorization").hide();
    });
});


$(".order__form-button").on("click", function (e) {
    e.preventDefault();
    // var dsa = 'tlkasn;lkdsa';
    $(this).closest("body").find("#f-order").css({
        'display': 'flex'
    });

    $.ajax({
        type: "POST",
        url: "form-handler.php",
        data: $(".order__form-tag").serialize() // serializes the form's elements.
    }).done(function (data) {
        $("#f-order").find(".f-popup__content").html(data);
    });

    $("#f-order").find(".f-popup__close").on("click", function (e) {
        e.preventDefault();
        $(this).closest("#f-order").hide();
    })
});
