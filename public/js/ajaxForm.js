function animAlert(context){
    context.css({
        'display': 'block',
    });
    context.animate({
        opacity: 1,
    }, 500, function () {
        setTimeout(function (){
            context.animate({
                opacity: 0,
            }, 500, function () {
                context.css({
                    'display': 'none',
                })
            })
        }, 2000);
    });
}
let error = $('.alert-danger');
let success = $('.alert-success');
let form = $('form#ajaxForm');
$("#send").click(function (event) {
    event.preventDefault();
    $.ajax({
        type: "POST",
        url: form.attr('action'),
        data: form.serialize(),
        success: function (response) {
            $("#tbody").prepend(
                "<tr>" +
                "<td>" + response.recording.id + "</td>" +
                "<td> <a href='http://contractor/"+response.recording.code+"' target='_blank'>http://contractor/" + response.recording.code + "</a></td>" +
                "<td>" + response.recording.link + "</td>" +
                "<td>" + response.recording.count + "</td>" +
                "</tr>"
            );
            $('#alertSuccess').text(response.success);
            animAlert(success);
        },
        error: function (xhr, ajaxOptions, thrownError) {
            json = JSON.parse(xhr.responseText);
            $('#alertError').text(json.errors.link);
            animAlert(error);
        }
    });
});
