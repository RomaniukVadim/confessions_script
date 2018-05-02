//Count characters 
$('#confession-textbox').keyup(function() {
    var max = 1000;
    var min = 20;
    var len = $(this).val().length;
    if (len >= max) {
        $('#charNum').text(messages.charlimitreached);
    } else {
        var char = max - len;
        $('#charNum').text(char + messages.charleft);
    }
});

//Upload Confession

$(document).on('click', '.confess-btn', function() {

    var text = $('#confession-textbox').val();

    if (text.length < 20) {
        $('#conf-short').fadeIn(400);
        $('#conf-short').delay(3000).fadeOut(400);
    } else {

        $("#confession-textbox").val('');
        $.ajax({
            type: 'POST',
            url: 'includes/upload_confession.php',
            data: {
                confession: text
            },
            success: function(data) {

                if (data.status === 'ok') {
                    $.cookie('perday', 'true', {
                        expires: 1
                    });
                    $('#conf-success').fadeIn(400);
                    $('#conf-success').delay(3000).fadeOut(400);

                    setTimeout(function() {
                        $(location).attr('href', 'index.php');
                    }, 3800);

                } else if (data.status === 'limit_reached') {
                    $('#conf-limit').fadeIn(400);
                    $('#conf-limit').delay(3000).fadeOut(400);

                    setTimeout(function() {
                        $(location).attr('href', 'index.php');
                    }, 3800);

                } else {
                    $('#conf-error').fadeIn(400);
                    $('#conf-error').delay(3000).fadeOut(400);

                    setTimeout(function() {
                        $(location).attr('href', 'index.php');
                    }, 3800);
                }

            },
            error: function() {
                $('#conf-error').fadeIn(400);
                $('#conf-error').delay(3000).fadeOut(400);
            }
        });

    }

});