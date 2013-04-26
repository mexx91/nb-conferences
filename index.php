<html>
    <head>

        <META HTTP-EQUIV="content-type" CONTENT="text/html; charset=utf-8">

        <title>Netbiscuits Conferences</title>
        <!--link href="css/jQueryUi.css" rel="stylesheet"/-->
        <link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>
        <link href="css/style.css" rel="stylesheet"/>

        <link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />

    </head>
    <body>
        <div id="content">

            <div id="logo"><a href="./" id="netbiscuitsLogo"></a> <img src="images/icons/camera32white.png" /></div>

            <div id="clocks">
                <div class="clock"><span id="localClock"></span></div>
            </div>

            <div class="clear"></div>

            <div id="exitButton"><a href="./">exit conference</a></div>

            <div id="currentRoom"></div>

            <div class="clear"></div>

            <audio id="knockSound" style="display: none;" src="sounds/knock.mp3"></audio>
            <audio id="beepSound" style="display: none;" src="sounds/beep-24.mp3"></audio>

            <div id="tiles">

                <div id="titleWrap" class="isTile">
                    <div class="tileHeader"><img src="images/icons/pluswhite32.png" /><p>Create conference</p></div>
                    <div class="tileContent">
                        <div id="subTitle"></div>
                        <form id="createRoom" name="createRoom">
                            <input placeholder="Conference name" id="sessionInput" x-webkit-speech/>
                            <img onclick="$('#createRoom').submit();" src="images/icons/check32white.png" />
                        </form>

                        <div class="tileFooter"></div>
                    </div>
                </div>


                <div class="conferenceListWrap isTile">
                    <div class="tileHeader"><img src="images/icons/userwhite32.png" /><p>Active conferences</p></div>

                    <div class="tileContent">

                        <div class="conferenceList">   
                            <!-- Will be filled and emtied atomaticaly -->
                            <span class="empty"> None. You may create on by yourself</span>
                        </div>

                        <div class="tileFooter"></div>
                    </div>
                </div>


                <div class="settings isTile">
                    <div class="tileHeader"><img src="images/icons/gearwhite32.png" /><p>Settings</p></div>
                    <div class="tileContent">

                        <!--button onclick="window.open(location.href + '&screen', '_blank')">Share your screen</button><br-->

                        <button onclick="adScreenSharing()">Share your screen</button><br>

                        <script>
                                function adScreenSharing() {
                                    var src = location.href + '&screen';
                                    $('body').append("<iframe style='display: none;' src='" + src + "'></iframe>");
                                }

                        </script>

                        <form><label>Video size</label>
                            <select onChange="changeVideoSize()">
                                <option selected>small</option>
                                <option>large</option>
                            </select>
                        </form>

                        <input type="checkbox" onchange="$('#localVideo').toggleClass('hidden');"/><label>Hide local video from yourself</label><br>
                        <input type="checkbox" onchange="mirrorLocalVideo()"/><label>Mirror local video layer</label><br>
                        <input type="checkbox" onchange="mirrorRemoteVideos()"/><label>Mirror remote video layers</label>

                        <div class="tileFooter"></div>
                    </div>
                </div>

                <div id="faq" class="isTile">
                    <div class="tileHeader"><img src="images/icons/lightbulbwhite32.png" /><p>faq</p></div>

                    <div class="tileContent">

                        <ul>
                            <li>everyone can create a room</li>
                            <li>the creator joins the room automatically</li>
                            <li>empty rooms are removed automatically</li>
                            <li>you can see and join every conference via the 'active conferences' list</li>
                        </ul>
                        <div class="tileFooter"></div>
                    </div> 
                </div>


                <div id="chat" class="isTile">
                    <div class="tileHeader"><img src="images/icons/comment32white.png" /><p>Chat<span></span></p></div>

                    <div class="tileContent">

                        <div id="chatTextarea">CHAT:</div>
                        <input type="text" id="chatNameInput" placeholder="Name" />
                        <input id="chatColorInput" type="hidden" />
                        <input type="text" id="chatInput" x-webkit-speech placeholder="Your Message" />
                        <img onclick="webrtc.sendChatMessage()" src="images/icons/check32white.png" />

                        <form action="chatExport.php" method="post" target="_blank">
                            <input type="hidden" id="chatHistory" name="chatHistory">
                            <input id="chatExportButton" onclick="$('#chatHistory').val($('#chatTextarea').html())" type="submit" value="export chat history"></input>
                        </form>

                        <div class="tileFooter"></div>
                    </div> 
                </div>


                <div id="latestchanges" class="isTile">
                    <div class="tileHeader"><img src="images/icons/turnrightwhite32.png" /><p>latest changes</p></div>

                    <div class="tileContent">

                        <ul>
                            <li>chat notification for unread messages</li>
                            <li>chat export function added</li>
                            <li>disabled "create conference" form if you are in one</li>
                            <li>room handling problem fixed</li>
                            <li>exit button added</li>
                            <li>order of tiles changed</li>
                            <li>tile dropdown event changed to click</li>
                            <li>invite link added</li>
                            <li>new style</li>
                            <li>...</li>
                        </ul>

                        <div class="tileFooter"></div>
                    </div> 
                </div>

                <div id="invite" class="isTile" style="display: none">
                    <div class="tileHeader"><img src="images/icons/userplus32.png" /><p>invite</p></div>

                    <div class="tileContent">
                        <p>share this link to invite conference members</p>

                        <div class="tileFooter"></div>
                    </div> 
                </div>

            </div>

            <div class="clear"></div>

            <video id="localVideo" poster="images/unlockPoster.png" autoplay ></video>


            <div id="remotes">

            </div>

            <div class="clear"></div>


            <div id="debug">
                <b>DEBUG:</b><br> 
            </div>
        </div>

        <!-- jQuery-->
        <div id="scripts">
            <script type="text/javascript" src="js/jQuery.js"></script>
        </div>

        <!-- load socket dymnamically -->
        <script> document.writeln('<script src="//' + location.host + ':8080/socket.io/socket.io.js" type="text/javascript"></sc' + 'ript>');
        </script>

        <!--RTC connection-->
        <script src="js/webrtc.js"></script>
        <!--script src="js/simplewebrtcOrig.js"></script-->
        <!-- other JS-->
        <script src="js/clock.js"></script>
        <script src="js/functions.js"></script>

        <script>

            // grab the room from the URL
            var urlStr = location.search && location.search.split('?')[1];
            var room = urlStr.split('&')[0];
            var media = urlStr.split('&')[1];

            console.log(room + ' ' + media);

            if (room === "") {
                $('#chat').hide();
            } else {
                $('#chat').show();
                $('#exitButton').show();
            }

            if (media === 'screen') {
                var hasItAudio = false;
                var vidMan = {chromeMediaSource: 'screen'};
            } else {
                var hasItAudio = true;
                var vidMan = {};
            }

            // create a webrtc connection
            var webrtc = new WebRTC({
                // the id/element dom element that will hold "our" video
                localVideoEl: 'localVideo',
                // the id/element dom element that will hold remote videos
                remoteVideosEl: 'remotes',
                // immediately ask for camera access
                autoRequestMedia: true,
                audio: true,
                log: true,
                media: {
                    audio: hasItAudio,
                    video: {
                        mandatory: vidMan,
                        optional: []
                    }
                }
            });



            // when it's ready, join if we got a room from the URL
            webrtc.on('readyToCall', function() {
                // you can name it anything
                if (room)
                    webrtc.joinRoom(room);
            });

            // Since we use this twice we put it here

            function setRoom(name) {

                $('#titleWrap').remove();

                currentRoomMoreReadableName = name.replace("-", " ");

                $('#currentRoom').html('<span>' + currentRoomMoreReadableName + '</span>&nbsp;<img onClick="window.location.reload()" src="images/icons/exchangewhite32.png"/>');
                $('#invite').find('.tileContent').append('<a href="' + location.href + '" target="">' + location.href + '</a>');
                $('#invite').show();
                $('body').addClass('active');

                $('#chat').show();
                $('#exitButton').show();
            }


            if (room) {
                setRoom(room);
            } else {
                $('form').submit(function() {
                    var val = $('#sessionInput').val().toLowerCase().replace(/\s/g, '-').replace(/[^A-Za-z0-9_\-]/g, '');

                    webrtc.createRoom(val, function(err, name) {
                        var newUrl = location.pathname + '?' + name;
                        if (!err) {
                            history.replaceState({foo: 'bar'}, null, newUrl);
                            setRoom(name);
                        }
                    });
                    return false;
                });
            }

        </script>
    </body>
</html>
