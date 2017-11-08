var config = require("./server.config.js");

//webpack の監視プロセス起動
var exec = require('child_process').exec;
for(var i = 0; i < config.attachTask.length; i++) {
  exec(config.attachTask[i]);
}

//サーバ起動
var fs = require("fs");
var server = require("http").createServer(function (req, res) {
  res.writeHead(200, {"Content-Type": "text/plan"});
}).listen(config.port);

// socket 起動
var io = require("socket.io").listen(server);
io.sockets.on("connection", function (socket) {
  socket.on("connected", function () {
  });

  fs.watch(config.watch, {persistent: true, recursive: true}, function (event, filename) {
    if (filename.match(/___/) === null) {
      io.sockets.emit("reload");
    }
  });
});

