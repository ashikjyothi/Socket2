var socket 	= require('socket.io'),
	express	= require('express'),
	https	= require('https'),
	http 	= require('http'),
	logger 	= require('winston'),
	jwt = require('jsonwebtoken'),
	socketioJwt = require('socketio-jwt');

logger.remove(logger.transports.Console);
logger.add(logger.transports.Console, { colorize: true, timestamp: true});
logger.info('SocketIO > listening on port ');

var jwtSecret = 'secret'
var app = express();
var http_server = http.createServer(app).listen(3001);

// function emitNewOrder(http_server){
// 	var io = socket.listen( http_server );
// 	io.sockets.on('connection',function(socket){
// 		console.log("socket connection-->",socket.id)
// 		// socket.on("new_order",function(data){
// 		// 	io.emit("new_order",data)
// 		// })
// 		socket.on("new_message",function(data){
// 			console.log("new_message-->",data)
// 			io.emit("new_message",data)
// 		})
// 	});
// }

app.get('/', function (req, res) {
	console.log("GET")
	res.send('Hello World')
	})
	
	app.use(function (req, res, next) {
		res.header("Access-Control-Allow-Origin", "*");
		res.header("Access-Control-Allow-Headers", "X-Requested-With");
		next();      
	});


	app.get('/token', function(req, res){
		console.log("generate token")
		var profile = {
			first_name: 'John',
			last_name: 'Doe',
			email: 'john@doe.com'
		};
		var token = jwt.sign(profile, jwtSecret);
		res.send({token: token});
	});


	app.post('/token', function (req, res) {
			console.log("generate token")
			// TODO: validate the actual user user
			var profile = {
				first_name: 'John',
				last_name: 'Doe',
				email: 'john@doe.com'
			};
		
			// we are sending the profile in the token
			var token = jwt.sign(profile, jwtSecret);
		
			res.json({token: token});
		});

emitNewOrder(http_server);




// ------------------------------------------------------------------------------------------

function emitNewOrder(http_server){
	var io = socket.listen( http_server );
	// var io = require("socket.io")(http_server);
		io.use(socketioJwt.authorize({
			secret: jwtSecret,
			handshake: true
		}));


		io.sockets.on('connection',function(socket){	
			// in socket.io 1.0
			console.log('New User Connected-->', socket.id);
			console.log("user count-->",io.engine.clientsCount)
				socket.on("set_user",function(data){
					var socket = io.sockets.sockets[data.socketid];
					socket.username = data.name;
				})
				socket.on("new_message",function(data){
				console.log("socket-->",socket)
				var socket = io.sockets.sockets[data.socketid];
				// console.log("socketData-->",socket);
				if(socket.rooms[data.group]){
					console.log("User already in room");
					console.log("socket.rooms-->",socket.rooms)
				  }else{
					console.log("User not in room");
					Object.keys(socket.rooms).forEach(function(key, idx) {
						if(idx!=0){
							socket.leave(key)
						}
						// console.log("key-->",key,"","idx-->",idx)
					 });
				  }
				// console.log("socket.rooms-->",socket.rooms)
				console.log("new_message-->",data)
				if(data.group!=""){
					console.log("groupName---->",data.group);
					// socket.join(data.group);
					var rooms=io.sockets.adapter.rooms;
					// console.log("rooms-->",rooms)
					if(io.sockets.adapter.sids[socket.id][data.group]){
						console.log("Room Already created-->",io.sockets.adapter.rooms[data.group])
						io.sockets.to(data.group).emit("new_message",data);
					}else{
						console.log("creating room")
						socket.join(data.group);
						io.sockets.to(data.group).emit("new_message",data);
					}
				}else{
					io.emit("new_message",data)
				}
				
			})
		})
// -------------------------------------------------------------
// io.sockets
// .on('connection', socketioJwt.authorize({
//   secret: 'secret',
//   timeout: 15000 // 15 seconds to send the authentication message
// })).on('authenticated', function(socket) {
//   //this socket is authenticated, we are good to handle more events from it.
//   console.log('hello! ' + socket.decoded_token.name);
// }).on("new_message",function(data){
// 	console.log("new_message-->",data)
// 	io.emit("new_message",data)
// });
//---------------------------------------------------------------------


}