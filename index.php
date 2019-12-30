<?php
require("WebSocketServer.php");
require("WebSocketFrame.php");

$ws = WebSocketServer::start();

for($i=0;$i<10;$i++){
	//$frame_in = $ws->receiveFrame();
	
	$frame_out = new WebSocketFrame(false,false,false,false,"_Test this payload_");
	
	$ws->sendFrame($frame_out);
	
	sleep(1);
}
?>
