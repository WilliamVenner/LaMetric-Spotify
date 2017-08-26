<?php
	
	$frames = [
		"frames" => [
			[
				"text" => "?",
				"icon" => "i647"
			],
		]
	];
	
	function output($text) {
		
		global $frames;
		
		$frames["frames"][0]["text"] = $text;
		
		echo(json_encode($frames));
		
	}
	
	$headers = getallheaders();
	
	if (!isset($headers["Authorization"])) {
		output("X"); return;
	}
	
	$auth = $headers["Authorization"];
	
	require("inc/api.php");
	$Spotify = new Spotify($auth);
	$result = $Spotify -> API("me/player/currently-playing", false, true);
	
	if (isset($result["error"])) {
		
		if ($result["error"]["message"] == "invalid id") {
			
			output("[Local File]"); return;
			
		}
		
		if ($result["error"]["message"] == "The access token expired") {
			
			header("HTTP/1.1 401 Unauthorized");
			
			output("[X]"); return;
			
		}
		
		if ($result["error"]["message"] == "API rate limit exceeded") {
			
			output("Too many requests"); return;
			
		}
		
		output("!"); return;
		
	}
	
	if (!isset($result["item"])) {
		output("[X]"); return;
	}
	
	$track_info = $result["item"];
	
	if ($result["is_playing"] != true && $_GET["show-paused"] == "false") {
		
		output("[II]"); return;
		
	}
	
	$s = "";
	
	if ($_GET["show-paused"] == "true" && $result["is_playing"] == false) $s .= "[II] ";
	
	if ($_GET["show-artists"] == "true" && (($_GET["show-paused"] == "true" && $result["is_playing"] == false) || $result["is_playing"] == true)) {
		
		foreach($track_info["artists"] as $i => $artist) {
			
			if ($i > 0 && count($track_info["artists"]) > 1) $s .= ", ";
			
			$s .= $artist["name"];
			
		}
		
		$s .= " - ";
		
	}
	
	$s .= $track_info["name"];
	
	output($s);
	
?>