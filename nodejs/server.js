var handler = (request, response) => {
    //console.log(request.url)
    //response.end('Hello Node.js Server!')
};
var server = require('http').createServer(handler);
var io = require('socket.io')(server);
var redis = require('redis');

io.listen(8890);
//io.set('transports', ['xhr-polling']);
io.on('connection', function (socket) {

    console.log("client connected");


    var redisClient = redis.createClient();

    redisClient.subscribe('message');

    redisClient.on("message", function(channel, data) {
        console.log(data);
        console.log("mew message add in queue "+ data['message'] + " channel");
        socket.emit(channel, data);
    });

    socket.on('disconnect', function() {
        redisClient.quit();
    });



});