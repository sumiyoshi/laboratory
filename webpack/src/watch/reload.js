var io = require("socket.io-client");
var socketio = io.connect('http://localhost:9090');

socketio.on("connected");
socketio.on("reload", function () {
  location.reload();
});
socketio.emit("connected");
