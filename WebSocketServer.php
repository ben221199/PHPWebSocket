<?php
class WebSocketServer{
	
	const GUID = "258EAFA5-E914-47DA-95CA-C5AB0DC85B11";
	
	private $IN;
	private $OUT;
	
	private function __construct(){
		set_time_limit(0);
		$this->IN = fopen("php://input","r");
		$this->OUT = fopen("php://output","w");
		$this->sendHeaders();
	}
	
	public function sendFrame(WebSocketFrame $frame){
		fwrite($this->OUT,$frame);
		fflush($this->OUT);
		ob_flush();
		flush();
	}
	
	private function sendHeaders(){		
		http_response_code(101);
		header("Connection: Upgrade");
		header("Sec-WebSocket-Accept: ".base64_encode(sha1($_SERVER["HTTP_SEC_WEBSOCKET_KEY"].self::GUID,true)));
		header("Upgrade: websocket");
		
		if(ob_get_level()==0){
			ob_start();
		}
	}
	
	public function receiveFrame(){
		return WebSocketFrame::fromString($this->IN);
	}
	
	public static function start(){
		return new static();
	}
	
}
?>
