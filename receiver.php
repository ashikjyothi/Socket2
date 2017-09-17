<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/1.7.3/socket.io.min.js"></script>
	<!-- <script src="//localhost:3001/socket.io/socket.io.js"></script> -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
	<title>Title</title>
	<style>
		.container {
			max-width: 800px;
		}
		p {
			font-size: 14px;
		}
	</style>
</head>
<body>

<div class="container" id="container">
<div class="input-group mb-2">
  <span class="input-group-addon" id="basic-addon1">User</span>
  <input type="text" class="form-control mr-1" id="name" placeholder="Enter Name" aria-describedby="basic-addon2">
  <span class="input-group-addon" id="basic-addon1">Group</span>
  <input type="text" class="form-control ml-1" id="group" placeholder="Enter Group Name" aria-describedby="basic-addon2">
</div>
<div id="message_container">
<div class="card mb-2" style="background:#2ecc71">
  <div class="card-body">
    <h5 class="card-title" style="text-align:center">Chat Demo</h5>
    <!-- <p class="card-text">Message</p> -->
  </div>
</div>
</div>

<div class="input-group">
  <input type="text" class="form-control" id="message" placeholder="Message" aria-describedby="basic-addon2">
	<span class="input-group-btn">
    <button class="btn btn-default" type="button" onclick="send(event);">Send</button>
  </span>
</div>
</div>


<script
  src="https://code.jquery.com/jquery-3.2.1.min.js"
  integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
  crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
<script>

// 	var socket = io.connect('//127.0.0.1:3001', { query: 's=12345' });

// 	console.log("message");
	
// 	socket.on("new_message",function(data){
// 		console.log("data-->",data)
// 		var message_div = `
// 		<div class="card mb-4">
//   	<div class="card-body">
//     <h4 class="card-title">${data.name}</h4>
//     <p class="card-text">${data.message}</p>
//   	</div>
// 		`;
// 		document.getElementById("message_container").innerHTML += message_div;
// 	})

// function send(e){
// 	// console.log("clicked-->",e)
// 		e.preventDefault();
// 		var message = document.getElementById("message").value;
// 		var name = document.getElementById("name").value;
// 		var data = {"name":name,"message":message};
// 		console.log(data)
//     var request = $.ajax({
// 			  type: "post",
//         url: "http://127.0.0.1:88/Socket2/emit_test.php",
// 				// data: JSON.stringify(data)
// 				data: {name:name,message:message}
// 				// dataType: 'JSON'
//     });
//     request.done(function (response, textStatus, jqXHR){
// 				console.log("request sent");
// 				document.getElementById("message").value = "";

// 				// console.log("response-->",response);
// 				// console.log("textStatus-->",textStatus);
// 				// console.log("jqXHR-->",jqXHR);
//     });
//     request.fail(function (jqXHR, textStatus, errorThrown){
//         console.error(
//             "The following error occurred: "+
//             textStatus, errorThrown
//         );
//     });
// }

</script>
<script>

// $.post( "http://127.0.0.1:3001/token", function( data ) {
//   console.log("res-->",data)
// }).done(function(data){
// 	console.log("res-->",data)
// });

// var xhr = new XMLHttpRequest();  
//     xhr.open("POST", "http://127.0.0.1:3001/token");  
//     xhr.send(null); 
//     xhr.onreadystatechange = function(req) 
//         { 
//             // If the request completed, close the extension popup
//             if (req.readyState == 4)
//                 if (req.status == 200){
// 									var data = xhr.responseText;
// 									console.log("token-->",data)
// 								}
//         };

var token = '';
var socketid = '';
var xhr = new XMLHttpRequest();
xhr.onreadystatechange = function() {
    if (xhr.readyState == XMLHttpRequest.DONE) {
				// alert(xhr.responseText);
				var data = JSON.parse(xhr.responseText)
				console.log("data.token-->",data.token)
				token = data.token;
				var socket = io.connect('http://localhost:3001', {
					'query': 'token=' + data.token
				});
				socket.on('connect', function() {
				socketid = socket.io.engine.id;
				console.log("socketid-->",socketid)
				socket.emit("set_user",{name:"ashik",socketid:socketid});
				});
				var request=$.ajax({
			  	type: "post",
        		url: "http://127.0.0.1:88/Socket2/emit_test.php",
				data: {token:data.token}
				});
				request.done(function (response, textStatus, jqXHR){
				// console.log("response-->",response);
    		});
			socket.on("new_message",function(data){
				console.log("data-->",data)
				var message_div = `
				<div class="card mb-2">
				<div class="card-body">
				<h5 class="card-title">${data.name}</h5>
				<p class="card-text">${data.message}</p>
				</div>
				`;
				document.getElementById("message_container").innerHTML += message_div;
			})
    }
}
xhr.open('GET', 'http://127.0.0.1:3001/token', true);
xhr.send(null);

// var socket = io.connect('http://127.0.0.1:3001', {
//   'query': 'token=' + your_jwt
// });


function send(e){
		e.preventDefault();
		var message = document.getElementById("message").value;
		var name = document.getElementById("name").value;
		var groupName = document.getElementById("group").value;
		var data = {"name":name,"message":message,"group":groupName};
		console.log(data)
    var request = $.ajax({
			  type: "post",
        	  url: "http://127.0.0.1:88/Socket2/emit_test.php",
			  data: {name:name,message:message,group:groupName,socketid:socketid,token:token}
    });
    request.done(function (response, textStatus, jqXHR){
				console.log("request sent");
				document.getElementById("message").value = "";
    });
    request.fail(function (jqXHR, textStatus, errorThrown){
        console.error(
            "The following error occurred: "+
            textStatus, errorThrown
        );
    });
}

</script>
</body>
</html>

