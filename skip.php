<?php
	
	if (!function_exists("getallheaders")) {
		
		// getallheaders is required to get the Authorization header as it does not appear
		// in $_SERVER or anywhere else. Therefore, try updating all of your software -
		// web server, PHP, etc. and try again.
		
		// This works absolutely fine on Apache and PHP 7.
		
		http_response_code("501 Not Implemented");
		error_log("https://github.com/WilliamVenner/LaMetric-Spotify/issues/2#issuecomment-325140347");
		return;
		
	}

	$headers = getallheaders();
	
	if (!isset($headers["Authorization"])) {
		return;
	}
	
	$auth = $headers["Authorization"];
    
    	require("inc/api.php");
    	$Spotify = new Spotify($auth);
    
	$Spotify -> API("me/player/next", true);
    
?>
