<?php
    
    class Spotify {
        
        private $auth;
        
        public function __construct($auth) {
            $this -> auth = $auth;
        }
        
        public function API($url, $post = false, $json = false) {
            
            if (!isset($this -> auth)) {
                throw new Exception('No authentication provided.');
                return;
            }
            
            $ch = curl_init();
            
            curl_setopt($ch, CURLOPT_URL, "https://api.spotify.com/v1/$url");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            
            if ($post)
                curl_setopt($ch, CURLOPT_POST, 1);
            else
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
            
            curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization: ' . $this -> auth]);
            
            $result = curl_exec($ch);
            curl_close($ch);
            
            if ($result)
                if ($json)
                    return json_decode($result,true);
                else
                    return $result;
            
        }
        
    }
    
?>