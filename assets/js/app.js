global.$ = global.jQuery = $;
// const $ = require('jquery');
// this "modifies" the jquery module: adding behavior to it
// the bootstrap module doesn't export/return anything
require('bootstrap');

// or you can include specific pieces
// require('bootstrap/js/dist/tooltip');
// require('bootstrap/js/dist/popover');

$(document).ready(function() {
    $('[data-toggle="popover"]').popover();
    $('.collectionClass').collection();
});



$(".erantzuna").on("click", function () {

    const miid = $(this).data("id");
    const selbal = $(this).data("balioa");
    let zuzena = 0;

    $(".erantzuna").each(function (  ) {
        const $bal = $(this).data("balioa");
        if ( $bal !== 1 ) {
            $(this).contents().unwrap().wrap('<p class="strike">');
            $(this).addClass("strike");
        } else {
            $(this).addClass('zuzena_azpimarratu')
        }
        if ( selbal === 1 ) {
            zuzena = 1;
        }
    });

    const $url = "/api/quizzdet/" + miid;
    const $url2 = "/result/" + miid;
    $.ajax({
        url: $url,
        type: "PUT",
        data: "result=" + zuzena,
        success: function ( data ) {
            console.log(data);
        },
        error: function ( err ) {
            console.log(err);
        }
    });


    let $quizz_resp = $(this).data("balioa");
    $("#divPagination").show();
    if ( $quizz_resp === 1 ) {
        $(".emoZuzena").show()
    } else {
        $(".emoOkerra").show()
    }

});


$("#quiestionid").on("click", function () {
    const $miid = $(this).data("id");
    const $url = "/api/question/" + $miid + "/problem";
    let that = this;
    $.ajax({
        url: $url,
        type: "PUT",
        data: "problem=1",
        success: function ( data ) {
            console.log(data);
            $(that).addClass("incorrect_quizz");
        },
        error: function ( err ) {
            console.log(err);
        }
    });
});
