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



// tiles

$('.isTile').hover(function() { // hover
    var backgroundColor = $(this).css('backgroundColor');
    $(this).find('.tileContent').css({'backgroundColor': backgroundColor, 'z-index': 10});
    $(this).find('.tileContent').slideDown();
}, function() { // end of hover

    $(this).find('.tileContent').slideUp();
    $(this).find('.tileContent').css({'z-index': 0});
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