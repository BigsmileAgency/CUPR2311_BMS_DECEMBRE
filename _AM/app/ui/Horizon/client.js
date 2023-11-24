window.addEventListener('load', () => {
	var WebSocketClient = new WebSocket("ws://localhost:9000/", "echo-protocol");
	WebSocketClient.onopen = function (event) {
		console.log("AM server connected");
		WebSocketClient.send(document.querySelector('#phpdata').innerHTML);
	};
	WebSocketClient.onerror = function (event) { console.log("AM server unavailable"); }
	WebSocketClient.onmessage = function (event) {
		let msg = JSON.parse(event.data);
		for (let key in msg) {
			if (msg.hasOwnProperty(key)) {
				switch (key) {
					case 'DECLIFILEUPDATE': window.location.reload(); break;
					case 'COMMONFILEUPDATE': window.location.reload(); break;
				}
			}
		}
	}
});
