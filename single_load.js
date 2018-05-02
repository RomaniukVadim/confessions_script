//Load confession
var thumbsup = "<img src='assets/img/thumbs-up.png' class='thumbsup'/>";
var thumbsdown = "<img src='assets/img/thumbs-down.png' class='thumbsdown'/>";
var fbshare = "<div class='fb-share-button' data-href='" + window.location.href + "' data-layout='button' data-size='small' data-mobile-iframe='true'><a class='fb-xfbml-parse-ignore' target='_blank' href='https://www.facebook.com/sharer/sharer.php?u=" + window.location.href + "&amp;src=sdkpreparse'>Share</a></div>";

function jsonloader() {
    window.get_id = $('#conf_id').val();
    var ajax_url = "includes/get_single_confession.php?id=" + get_id;
    $("#confessions").hide();

    $.get(ajax_url, function(data) {
        $('#good-looking').html("Confession #" + data.conf_id);

        window.new_id = data;

        if (data.votesUp === '') {
            var votesUp = '0';
        } else {
            votesUp = data.votesUp;
        }

        if (data.votesDown === '') {
            var votesDown = '0';
        } else {
            votesDown = data.votesDown;
        }

        var confession = "<div id='" + data.conf_id + "' class='card confession' style='margin-bottom:10px;'>\n" + "<div class='card-block'>" + "<h6 class='card-subtitle mb-2 text-muted'>#" + data.conf_id + "</h6>\n" + "<p class='card-text'>" + data.conf_msg + "</p>\n" + "<a href='#' class='card-link' id='confession-timestamp'>" + data.time + "</a>\n" + "|" + "<div class='button-block'><a href='#votesUp' class='card-link' id='conf_votesUp' value='" + data.conf_id + "' votes='" + votesUp + "'>" + thumbsup + "</a>\n" + "<span id='button-inner' class='votesUp_count-" + data.conf_id + "'>" + votesUp + "</span>" + "</div> " + "<div class='button-block'><a href='#votesDown' class='card-link' id='conf_votesDown' value='" + data.conf_id + "' votes='" + votesDown + "'>" + thumbsdown + "</a>\n" + "<span id='button-inner' class='votesDown_count-" + data.conf_id + "'>" + votesDown + "</span></div>" + fbshare + "</div>" + "</div>";
        if (data.conf_id === undefined) {
            $("#confessions").append("<div class='card confession'>\n<div class='card-block'><h6 class='card-subtitle mb-2 text-muted'>#0</h6>\n<p class='card-text'>" + messages.nosuchconfession + "!</p>\n<a href='#' class='card-link' id='confession-timestamp'>" + messages.aboutnever + "</a></div></div>");
        } else {
            $("#confessions").append(confession);
        }

        $("#confessions").fadeIn(400);
    }).always(function() {
        window.loading = false;
    });

}

jsonloader();

//Load comments of confession 

function commentloader() {
    var ajax_url = "includes/get_comments.php?conf_id=" + get_id;
    $("#comments").hide();

    $.get(ajax_url, function(data) {

        if (data == "[]") {
            var nocomment = "<div class='comm-single' id='0'><div class='comm-topbar'><span class='commTime' id='commTime'>about never</span></div><div class='comm-text'>" + messages.nocomments + "</div><div class='comm-bottom'><div class='comm-author'>Anonymous</div></div></div>";
            $("#comments").append(nocomment);
            $("#comments").fadeIn(400);
        } else {


            $.each(data, function(i, single) {

                if (single.votesUp === '') {
                    var votesUp = '0';
                } else {
                    votesUp = single.votesUp;
                }

                if (single.votesDown === '') {
                    var votesDown = '0';
                } else {
                    votesDown = single.votesDown;
                }

                var commvotes = votesUp - votesDown;

                var comment = "<div class='comm-single' id='" + single.comm_id + "'><div class='comm-topbar'><span class='commTime' id='commTime'>" + single.time + "</span></div><div class='comm-text'>" + single.comm_msg + "</div><div class='comm-bottom'><div class='comm-author'>Anonymous</div><div class='comm-votes-" + single.comm_id + "'>" + commvotes + "</div><div class='comm_voteDown' value='" + single.comm_id + "'></div><div class='comm_voteUp' value='" + single.comm_id + "'></div></div></div>";

                $("#comments").append(comment);

            });
            $("#comments").fadeIn(400);
        }

    }).always(function() {
        window.loading = false;
    });

}

commentloader();

//Voting up

$(document).on('click', '#conf_votesUp', function() {
    var id = $(this).attr('value');
    var votes = parseInt($(this).attr('votes'));

    $.ajax({
        type: 'POST',
        url: 'includes/vote.php',
        data: {
            action: 'voteUp',
            conf_id: id
        },
        context: this,
        success: function(data) {

            if (data.status === 'ok') {
                //alert("Voting successful!");
                $.cookie(id, 'true');
                var total_votes = votes + 1;

                $('.votesUp_count-' + id).html(total_votes);
                $("img", this).addClass("pressed");

            } else if (data.status === 'already_voted') {
                alert(messages.alreadyvoted);
            } else {
                alert(messages.somethingbad);
            }


        }
    });

});

//Voting down

$(document).on('click', '#conf_votesDown', function() {
    var id = $(this).attr('value');
    var votes = parseInt($(this).attr('votes'));

    $.ajax({
        type: 'POST',
        url: 'includes/vote.php',
        data: {
            action: 'voteDown',
            conf_id: id
        },
        context: this,
        success: function(data) {

            if (data.status === 'ok') {
                //alert("Voting successful!");
                $.cookie(id, 'true');
                var total_votes = votes + 1;

                $('.votesDown_count-' + id).html(total_votes);
                $("img", this).addClass("pressed");

            } else if (data.status === 'already_voted') {
                alert(messages.alreadyvoted);
            } else {
                alert(somethingbad);
            }


        }
    });

});

//Comment Voting up

$(document).on('click', '.comm_voteUp', function() {
    var id = $(this).attr('value');
    var votes = parseInt($('.comm-votes-' + id).text());

    $.ajax({
        type: 'POST',
        url: 'includes/vote_comment.php',
        data: {
            action: 'voteUp',
            comm_id: id,
            conf_id: get_id
        },
        success: function(data) {

            if (data.status === 'ok') {
                //alert("Voting successful!");
                $.cookie('comm_id' + id, id);
                var total_votes = votes + 1;

                $('.comm-votes-' + id).html(total_votes);
                $('.comm_voteUp').animate({
                    opacity: 1
                });

            } else if (data.status === 'already_voted') {
                alert(messages.alreadyvoted);
            } else {
                alert(messages.somethingbad);
            }


        }
    });

});

//Comment Voting down

$(document).on('click', '.comm_voteDown', function() {
    var id = $(this).attr('value');
    var votes = parseInt($('.comm-votes-' + id).text());

    $.ajax({
        type: 'POST',
        url: 'includes/vote_comment.php',
        data: {
            action: 'voteDown',
            comm_id: id,
            conf_id: get_id
        },
        success: function(data) {

            if (data.status === 'ok') {
                //alert("Voting successful!");
                $.cookie('comm_id' + id, id);
                var total_votes = votes - 1;

                $('.comm-votes-' + id).html(total_votes);
                $('.comm_voteDown').animate({
                    opacity: 1
                });

            } else if (data.status === 'already_voted') {
                alert(messages.alreadyvoted);
            } else {
                alert(messages.somethingbad);
            }


        }
    });

});

//Upload comment

$(document).on('click', '.comment-btn', function() {
    var text = $('#comment-textbox').val();
    var iszero = $('.comm-single').attr('id');
    $("#comment-textbox").val('');

    if (text.length < 20) {
        $('#conf-short').fadeIn(400);
        $('#conf-short').delay(3000).fadeOut(400);
    } else if (new_id == "[]") {
        $('#conf-short').html(messages.messingup);
        $('#conf-short').fadeIn(400);
        $('#conf-short').delay(3000).fadeOut(400);
    } else {

        $.ajax({
            type: 'POST',
            url: 'includes/upload_comment.php',
            data: {
                comment: text,
                conf_id: get_id
            },
            success: function(data) {

                if (data.status === 'ok') {
                    $('#comm-success').fadeIn(400);
                    $('#comm-success').delay(3000).fadeOut(400);

                    var comment = "<div class='comm-single' id='" + "1" + "'><div class='comm-topbar'><span class='commTime' id='commTime'>" + "about now" + "</span></div><div class='comm-text'>" + text + "</div><div class='comm-bottom'><div class='comm-author'>Anonymous</div></div></div>";

                    if (iszero === '0') {
                        $("#comments").html("");
                    }

                    $("#comments").prepend(comment);
                } else {
                    $('#comm-success').html(messages.somethingbad);
                    $('#comm-success').fadeIn(400);
                    $('#comm-success').delay(3000).fadeOut(400);
                }

            },
            error: function() {
                $('#comm-success').html(messages.somethingbad);
                $('#comm-success').fadeIn(400);
                $('#comm-success').delay(3000).fadeOut(400);
            }
        });

    }

});

//Count characters 

$('#comment-textbox').keyup(function() {
    var max = 1000;
    var len = $(this).val().length;
    if (len >= max) {
        $('#charNum').text(messages.charlimitreached);
    } else {
        var char = max - len;
        $('#charNum').text(char + messages.charleft);
    }
});