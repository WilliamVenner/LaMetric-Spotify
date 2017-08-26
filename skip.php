<?php
    
	$headers = getallheaders();
	
	if (!isset($headers["Authorization"])) {
		return;
	}
	
	$auth = $headers["Authorization"];
    
    	require("inc/api.php");
    	$Spotify = new Spotify($auth);
    
	$Spotify -> API("me/player/next", true);
    
?>
