<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <script type="text/javascript" src="js/jQuery.js"></script>
        <title></title>
    </head>
    <body>
        <video style="max-height: 400px;" autoplay id="localScreen"></video>

        <script>
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
                    localScreen.src = window.URL.createObjectURL(stream);
                    localScreen.play();
                } catch (e) {
                    console.log("Error setting video src: ", e);
                }
            }

            function errorCallback(e) {
                alert("Can't access media" + e);
            }

        </script>

    </body>
</html>
