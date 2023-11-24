var WebSocketServer = require('./_AM/node_modules/websocket').server;
var http = require('http');
var path = require('path');
var moment = require('./_AM/node_modules/moment');

function Log(msg) {
	console.log(moment(new Date()).format("YYYY/MM/DD hh-mm-ss.SSS") + ": " + msg);
}
function OriginIsAllowed(origin) { return true; }
async function AnalyseWatcherEvent(connection, bannerName, event, path) {
	switch (event) {
		case 'ready': SendMessage(connection, 'READY', 'files watcher working'); break;
		case 'change':
		case 'add':
		case 'unlink': FileModified(connection, bannerName, path); break;
		case 'error': SendMessage(connection, 'ERROR', event); break;
	}
}
function SendMessage(connection, id, data = '') {
	Log(id + (data == '' ? '' : (': ' + data)));
	let msg = {};
	msg[id] = data;
	connection.send(JSON.stringify(msg));
}
function FileModified(connection, bannerName, filePath) {
	let commonFile = (filePath.indexOf(path.join(__dirname, "common")) != -1);
	let boilerPlateFile = (filePath.indexOf(path.join(__dirname, "_AM", "boilerplates")) != -1);
	if (commonFile || boilerPlateFile) {
		// Common file updated
		//--------------------
		SendMessage(connection, 'COMMONFILEUPDATE', filePath);
	}
	else {
		// Decli file updated (taking into account manual directory dupplications)
		//-------------------
		let bannerNameBaseRegex = "\\b" + bannerName + "-([A-Z]{2})-";
		let langDirData = filePath.match(bannerNameBaseRegex + "DATA\\b");
		if (langDirData != null && !filePath.match(/- Cop/i)) {		// Language directory detection (without "- cop(ie)/y", added by Windows when we duplicate language directory)
			let decliDirData = filePath.match(bannerNameBaseRegex + "(\\d{3}x\\d{3}\\b)");
			if (decliDirData != null) {	// Decli subdirectory
				if (langDirData[1] == decliDirData[1])		// Consider only new directory when the language corresponds (to prevent unwanted refresh during directories dupplications)
					SendMessage(connection, 'DECLIFILEUPDATE', filePath);
			}
		}
	}
}

// Create the server
//------------------
var server = http.createServer(function (request, response) {
	Log('Received request for ' + request.url);
	response.writeHead(404);
	response.end();
});
server.listen(9000, function () { Log('Server is listening on port 9000'); });
wsServer = new WebSocketServer({ httpServer: server, autoAcceptConnections: false });
wsServer.on('request', function (request) {
	// Check if we can accept the connection
	//--------------------------------------
	if (!OriginIsAllowed(request.origin)) {
		request.reject();
		Log('Connection from origin ' + request.origin + ' rejected.');
		return;
	}

	// Accept the connection and prepare the wanted events callbacks
	//--------------------------------------------------------------	
	var filesExtensionsToWatch = ["php", "js" , "scss"];
	var watchers = Array();
	var connection = request.accept('echo-protocol', request.origin);
	Log('Connection ' + connection.remoteAddress + ' accepted.');
	connection.on('close', function (reasonCode, description) {
		Log('Peer ' + connection.remoteAddress + ' disconnected. Reason: ' + description);
		watchers.forEach(watcher => watcher.close());
	});
	connection.on('message', function (msg) {
		let bannerName = msg.utf8Data;

		// Initialize the directories watcher
		//-----------------------------------
		var dirToWatch = path.join(__dirname);
		var baseFilesToWatch = (dirToWatch + "/**/*.").replace(/\\/g, '/');
		var chokidar = require('./_AM/node_modules/chokidar');
		filesExtensionsToWatch.forEach(filesExtensionToWatch => {
			let watcher = chokidar.watch(baseFilesToWatch + filesExtensionToWatch, { ignored: /^\./, persistent: true, ignoreInitial: true });
			watcher.on('all', (event, path) => AnalyseWatcherEvent(connection, bannerName, event, path));
			watchers.push(watcher);
		});
	});
});
