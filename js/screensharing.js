/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


function toggleVideoSrc() {


    var video_constraints = {
        mandatory: {chromeMediaSource: 'screen'},
        optional: []
    };

    navigator.webkitGetUserMedia({
        video: {
            mandatory: {chromeMediaSource: 'screen'}
        }}
    , successCallback, errorCallback);

    function successCallback(stream) {
        localStream = stream;
        try {

            var src = window.URL.createObjectURL(stream);
            $('#localVideo').attr('src', src);
            $('#localVideo').play();
        } catch (e) {
            console.log("Error setting video src: ", e);
        }
    }

    function errorCallback(e) {
        alert("Can't access media" + e);
    }

}