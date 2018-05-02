window.flag = 0;

window.nomore=false;

var requestSent = false;

var API = {
	get_conf: "includes/get_confessions.php",
	vote: "includes/vote.php"

}

var thumbsup = "<img src='assets/img/thumbs-up.png' class='thumbsup'/>";
var thumbsdown = "<img src='assets/img/thumbs-down.png' class='thumbsdown'/>";

$(document).ready(function() { 

// Function for loading content

function jsonloader() {

    if(!requestSent) {
    requestSent = true;
            

        $.ajax({ 

            type: "POST",
            url: API.get_conf,
            data: {
                'value': flag
            },
            success: function(data) {
            requestSent = false;

            if(data=="[]" && flag===0) {
                $("#confessions").append("<div class='card confession'>\n<div class='card-block'><h6 class='card-subtitle mb-2 text-muted'>#0</h6>\n<p class='card-text'>" + messages.noconfessions + "</p>\n<a href='#' class='card-link' id='confession-timestamp'>" + messages.aboutnever + "</a></div></div>");
            } else if(data=="[]") { 
                console.log("No more to load");
                window.nomore=true;
            } else {

            
                $.each(data, function(i, single) {

                    if(single.votesUp==='') {
                        var votesUp = '0';
                    } else {
                        votesUp = single.votesUp;
                    }

                    if(single.votesDown==='') {
                        var votesDown = '0';
                    } else {
                        votesDown = single.votesDown;
                    }

                	var confession = "<div id='" + single.conf_id + "' class='card confession' style='margin-bottom:10px;'>\n" + "<div class='card-block'>" + "<h6 class='card-subtitle mb-2 text-muted'>" + "<a href='confession.php?id=" + single.conf_id + "'>#" + single.conf_id + "</a></h6>\n" + "<p class='card-text'>" + single.conf_msg + "</p>\n" + "<a href='#' class='card-link' id='confession-timestamp'>" + single.time + "</a>\n" + "|" + "<div class='button-block'><a href='#votesUp' class='card-link' id='conf_votesUp' value='"+ single.conf_id + "' votes='" + votesUp + "'>" + thumbsup + "</a>\n" + "<span id='button-inner' class='votesUp_count-" + single.conf_id + "'>" + votesUp + "</span></div>" + " " + "<div class='button-block'><a href='#votesDown' class='card-link' id='conf_votesDown' value='" + single.conf_id + "' votes='" + votesDown + "'>" + thumbsdown + "</a>\n" + "<span id='button-inner' class='votesDown_count-" + single.conf_id + "'>" + votesDown + "</span></div>" + "<div class='button-block'><a href='confession.php?id=" + single.conf_id + "' class='card-link'><img src='assets/img/comment-btn.png' class='commentbtn'></img></a><span id='button-inner' class='comment_count'>" + single.comments + "</span></div>" + "</div>" + "</div>";
                    

                        $("#confessions").append(confession);
                        window.flag = parseInt(single.conf_id);

                });
            
            }

            }

        });

    }

}

// Initial call

jsonloader();

// Trigger infinite-scroll until scrollbar appears

var no_scroll_workaround = setInterval(function checkVariable() {

   if (requestSent === false) {
       
       if($(window).height() >= $(document).height() && !window.nomore) {
            jsonloader();
        } else {
        	clearInterval(no_scroll_workaround);
        }

   }

 }, 1000);   

// Trigger infinite-scroll when scroll reaches 80%        

$(window).scroll(function() {

    if($(window).scrollTop() >= ($(document).height() - $(window).height())*0.8) {
        if(!window.nomore) {
        jsonloader();
        }
    }

});

// Trigger infinite-scroll when touch motion is detected / For Android & iOS

$('body').bind('touchmove', function(e) { 

	if(window.nomore!==true) {
    jsonloader();
    }

});

// Voting up

$(document).on('click', '#conf_votesUp', function() {
    var id = $(this).attr('value');
    var votes = parseInt($(this).attr('votes'));

$.ajax({
        type: 'POST',
        url: API.vote,
        data: {
            action: 'voteUp',
            conf_id: id
        },
        context: this,
        success: function(data) {

        if(data.status==='ok') {
          //alert("Voting successful!");
          $.cookie(id, 'true');
          var total_votes = votes + 1;

          $('.votesUp_count-' + id).html(total_votes);
          $("img", this).addClass( "pressed" );

        } else if (data.status==='already_voted') {
            alert(messages.alreadyvoted);
        } else {
            alert(messages.somethingbad);
        }


        }
    });

    }); 

// Voting down

$(document).on('click', '#conf_votesDown', function() {
    var id = $(this).attr('value');
    var votes = parseInt($(this).attr('votes'));
$.ajax({
        type: 'POST',
        url: API.vote,
        data: {
            action: 'voteDown',
            conf_id: id
        },
        context: this,
        success: function(data) {

        if(data.status==='ok') {

          $.cookie(id, 'true');
          var total_votes = votes + 1;
          $("img", this).addClass( "pressed" );

          $('.votesDown_count-' + id).html(total_votes);

        } else if (data.status==='already_voted') {
            alert(messages.alreadyvoted);
        } else {
            alert(messages.somethingbad);
        }

        }
    });

    });

});