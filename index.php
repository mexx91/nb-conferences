<html>
    <head>

        <META HTTP-EQUIV="content-type" CONTENT="text/html; charset=utf-8">

        <title>Netbiscuits Conferences</title>
        <!--link href="css/jQueryUi.css" rel="stylesheet"/-->
        <link href='http://fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>
        <link href="//code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" rel="stylesheet"/>
        <link href="css/style.css" rel="stylesheet"/>

        <link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />

    </head>
    <body>
        <div id="content">

            <div id="infoBox">
                <p class="infoBoxText">info box (coming soon) ...</p>
            </div>

            <div id="logo"><a href="./" id="netbiscuitsLogo"></a> <img src="images/icons/camera32white.png" /></div>
            <div class="clear"></div>
            <div id="currentRoom"></div>

            <audio id="knockSound" style="display: none;" src="sounds/knock.mp3"></audio>
            <audio id="beepSound" style="display: none;" src="sounds/beep-24.mp3"></audio>

            <div id="tiles">

                <div id="titleWrap" class="isTile">
                    <div class="tileHeader"><img src="images/icons/pluswhite32.png" /><p>Create conference</p></div>
                    <div class="tileContent">
                        <div id="subTitle"></div>
                        <form id="createRoom" name="createRoom">
                            <input placeholder="Conference name" id="sessionInput" x-webkit-speech/>
                            <img onclick="$('#createRoom').submit()" src="images/icons/check32white.png" />
                        </form>
                    </div>
                </div>


                <div id="chat" class="isTile">
                    <div class="tileHeader"><img src="images/icons/comment32white.png" /><p>Chat</p></div>

                    <div class="tileContent">

                        <div id="chatTextarea" >CHAT:</div>
                        <input type="text" id="chatNameInput" placeholder="Name" />
                        <input id="chatColorInput" type="hidden" />
                        <input type="text" id="chatInput" x-webkit-speech placeholder="Your Message" />
                        <img onclick="webrtc.sendChatMessage()" src="images/icons/check32white.png" />
                    </div> 

                </div>


                <div class="conferenceListWrap isTile">
                    <div class="tileHeader"><img src="images/icons/userwhite32.png" /><p>Active conferences:</p></div>

                    <div class="tileContent">

                        <div class="conferenceList">   
                            <!-- Will be filled and emtied atomaticaly -->
                            <span class="empty"> None. You may create on by yourself</span>
                        </div>
                    </div>
                </div>


                <div class="settings isTile">
                    <div class="tileHeader"><img src="images/icons/gearwhite32.png" /><p>Settings</p></div>
                    <div class="tileContent">

                        <form><label>Video size</label>
                            <select onChange="changeVideoSize()">
                                <option selected>small</option>
                                <option>large</option>
                            </select>
                        </form>

                        <input type="checkbox" onchange="mirrorLocalVideo()"/><label>Mirror local video</label><br>
                        <input type="checkbox" onchange="mirrorRemoteVideos()"/><label>Mirror remote videos</label>
                        <br>
                        <button id="leaveConf" class="hidden" onclick="window.location.href = './'">Leave the conference</button>

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
                    </div> 

                </div>


                <div id="latestchanges" class="isTile">
                    <div class="tileHeader"><img src="images/icons/turnrightwhite32.png" /><p>latest changes</p></div>

                    <div class="tileContent">

                        <ul>
                            <li>new style</li>
                            <li>project uploaded</li>
                        </ul>
                    </div> 

                </div>

                <div id="invite" class="isTile" style="display: none">
                    <div class="tileHeader"><img src="images/icons/userplus32.png" /><p>invite</p></div>

                    <div class="tileContent">
                        <p>share this link to invite conference members</p>
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
            <script type="text/javascript" src="js/jQueryUi.js"></script>
            <!--socket is included via js in simplewebrtc.js -->
        </div>

        <script>
                                document.writeln('<script src="http://' + location.host + ':8080/socket.io/socket.io.js" type="text/javascript"></sc' + 'ript>');
        </script>

        <script src = "js/crypt.js" ></script>
        <!--RTC connection-->
        <script src="js/simplewebrtc.js"></script>
        <!-- other JS-->
        <script src="js/functions.js"></script>

        <script>

            // grab the room from the URL
            var room = location.search && location.search.split('?')[1];

            if (room === '') {
                $('#chat').hide();
            } else {
                $('#chat').show();
            }


            // create a webrtc connection
            var webrtc = new WebRTC({
                // the id/element dom element that will hold "our" video
                localVideoEl: 'localVideo',
                // the id/element dom element that will hold remote videos
                remoteVideosEl: 'remotes',
                // immediately ask for camera access
                autoRequestMedia: true,
                log: true
            });

            // when it's ready, join if we got a room from the URL
            webrtc.on('readyToCall', function() {
                // you can name it anything
                if (room)
                    webrtc.joinRoom(room);
            });

            // Since we use this twice we put it here

            function setRoom(name) {

                //$('form').remove();
                $('#currentRoom').html('<span>' + name + '</span>&nbsp;<img src="images/icons/circlerightwhite32.png"/>');
                $('#invite').find('.tileContent').append('<a href="' + location.href + '" target="">' + location.href + '</a>');
                $('#invite').show();
                $('body').addClass('active');

                $('#chat').show();
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

            $('#chatInput').bind('keyup', function(e) {
                if (e.keyCode === 13) { // 13 is enter key
                    webrtc.sendChatMessage();
                }
            });

        </script>
    </body>
</html>
