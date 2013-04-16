/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

var localBlob = location.search && location.search.split('?')[1];
//debug(localBlob);
//debug(window.location.href);

var videoSize = 'normal';

function mirrorLocalVideo() {
    $("#localVideo").toggleClass('mirrored');
    $("#localVideo").removeAttr('controls');
}

function mirrorRemoteVideos() {
    $("#remotes").find('video').toggleClass('mirrored');
}


function debug(text) {
    var tmp = $('#debug').html();
    $('#debug').html(tmp + "<br>" + text);
    console.log(text);
}

function md5(text) {
    var strMD5 = $().crypt({
        method: "md5",
        source: text
    });
    return strMD5;
}

function get_random_color() {
    var letters = '0123456789ABCDEF'.split('');
    var color = '#';
    for (var i = 0; i < 6; i++) {
        color += letters[Math.round(Math.random() * 15)];
    }

    // dont use 100% white as color because of the white background
    if (color === '#000000' || color === '#FFFFFF') {
        color = get_random_color();
    }
    return color;
}


// scroll chatwindow 

function scrollChatWindow() {
    var height = $('#chatTextarea')[0].scrollHeight;
    $('#chatTextarea').scrollTop(height);
}
;



// expand tiles
var zindex = 0;

$(".tileHeader").click(function() {
    zindex++;
    var backgroundColor = $(this).parent().css('backgroundColor');
    var display = $(this).parent().find('.tileContent').css('display');
    $(this).addClass('up');
    $(this).parent().css({'z-index': zindex});
    $(this).parent().find('.tileContent').css({'backgroundColor': backgroundColor, 'z-index': zindex});
    $(this).parent().find('.tileContent').slideDown();
});

$('.tileFooter').click(function() {
    $(this).parent().slideUp();
    $(this).parent().parent().find('.tileHeader').removeClass('up');
});



function changeVideoSize() {
    if (videoSize === 'normal') {
        $('video').width('600');
        videoSize = 'large';

    } else if (videoSize === 'large') {
        $('video').width('290');
        videoSize = 'normal';

    } else {
        videoSize = 'normal';
    }
}

$('#chatInput').bind('keyup', function(e) {
    if (e.keyCode === 13) { // 13 is enter key
        webrtc.sendChatMessage();
    }
});

$("#localClock").MyDigitClock({fontSize: 20});