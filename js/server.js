/*Written by Henrik Joreteg. Extended by Maximilian Groß.
 Copyright © 2013 by &yet, LLC.
 Released under the terms of the MIT License:
 
 Permission is hereby granted, free of charge, to any person obtaining a copy of
 this software and associated documentation files (the "Software"), to deal in
 the Software without restriction, including without limitation the rights to
 use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of
 the Software, and to permit persons to whom the Software is furnished to do so,
 subject to the following conditions:
 
 The above copyright notice and this permission notice shall be included in all
 copies or substantial portions of the Software.
 
 THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS
 FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS
 OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
 WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN
 CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.*/

var yetify = require('yetify'),
        config = require('getconfig'),
        uuid = require('node-uuid'),
        io = require('socket.io').listen(config.server.port);

io.sockets.on('connection', function(client) {

    // update room list
    listRooms();

    // pass a message
    client.on('message', function(details) {
        var otherClient = io.sockets.sockets[details.to];

        if (!otherClient) {
            return;
        }
        delete details.to;
        details.from = client.id;
        otherClient.emit('message', details);
    });

    client.on('join', function(name) {
        client.join(name);
        io.sockets.in(name).emit('joined', {
            room: name,
            id: client.id
        });
        listRooms();
    });

    function leave() {
        var rooms = io.sockets.manager.roomClients[client.id];
        for (var name in rooms) {
            if (name) {
                io.sockets.in(name.slice(1)).emit('left', {
                    room: name,
                    id: client.id
                });
            }
        }
        listRooms();
    }

    client.on('disconnect', leave);
    client.on('leave', leave);

    client.on('create', function(name, cb) {
        if (arguments.length === 2) {
            cb = (typeof cb === 'function') ? cb : function() {
            };
            name = name || uuid();
        } else {
            cb = name;
            name = uuid();
        }
        // check if exists
        if (io.sockets.clients(name).length) {
            cb('taken');
        } else {
            client.join(name);
            if (cb)
                cb(null, name);
        }
        listRooms();
    });

    function listRooms() {
        //Get all current rooms
        var roomList = io.sockets.manager.rooms;
        console.log(roomList);

        var totalClients = io.sockets.clients(room).length;
        console.log("TOTAL CLIENTS: " + totalClients);

        // new Array to save the clients per room
        var clientsPerRoom = new Array();

        var clientString = "";
        for (var room in roomList) {
            console.log("__START OF LOOP__");

            //console.log(room.id);

            if (room !== "" && room !== "/") {
                room = room.replace("/", "");

                var clients = io.sockets.clients(room).length;
                // has to look like this:
                //clientsPerRoom = {"test" : 3, "xyz" : 4};
                clientString = '"' + room + '" : "' + clients + '",' + clientString;

                console.log("clientsPerRoom[" + room + "] : " + clientsPerRoom[room]);
            }
            console.log("__END OF LOOP__");
        }
        //cut the "," et the end of the string (else: ERROR!)
        clientString = clientString.substr(0, clientString.length - 1);
        // parse it with JSON to pretend beeing a object
        clientsPerRoom = JSON.parse('{' + clientString + '}');
        console.log(clientString);

        // now send it to the client
        io.sockets.emit('roomList', roomList, clientsPerRoom, totalClients);
    }

    client.on('chatMessage', function(msg, room) {
        // send incoming message and room to all clients in the same room

        if (room === '') {
            console.log('THIS ::');
            return;
        }

        console.log('Sending msg to room: ' + room);
        io.sockets.in(room).emit('chatMessage', msg);
    });

});

if (config.uid)
    process.setuid(config.uid);
console.log(yetify.logo() + ' -- signal server: http://192.168.100.61:' + config.server.port);