<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>
        <video height="500px" autoplay id="localScreen"></video>

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
                alert(e);
            }
        </script>

    </body>
</html>
