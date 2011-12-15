<?php
/**
 * Adds Twitter functionality
 * This functions connect to the wrapper (TwitterOAuth) wich in turn connects to the API
 * Exclusive to the WobbleNation theme
 * 
 * @package WordPress
 * @subpackage WobbleNation
**/

//$request = new TwitterRequest('novteqtest', 'twitter987');
//$request->updateStatus("Let's party like we are a robot from 1984");


/**
 * Main class, handles pretty much all the possible requests
**/
class TwitterRequest {
	
	function TwitterRequest($username='', $password='') {
		$this->username = $username;
		$this->password = $password;
	}
	
	function getRecentUpdates($max = 5, $offset = 0) {
		
		$url = 'http://api.twitter.com/1/statuses/user_timeline.json?screen_name=' . $this->username . '&count=' . $max . '&page=' . $offset;
		$requestType = 'GET';
		$results = $this->request($url, $requestType);
		$tweets = json_decode($results);
		curl_close($this->ch);
		return $tweets;
		
	}
	
	function updateStatus($status) {
		if(strlen($status) <= 140) {
			
			$url = "http://twitter.com/statuses/update.xml?status=".urlencode(stripslashes(urldecode($status)));
		    $results = $this->request($url);
		    $resultArray = curl_getinfo($this->ch);
		
		    //echo "http code: ".$resultArray['http_code']."<br />";
		
		    if($resultArray['http_code'] == "200"){
		        //echo "<br />OK! posted to http://twitter.com/".$username."/<br />";
		    } else {
		        //var_dump($resultArray);
		    }
			curl_close($this->ch);
		}
	}
	
	//Executes the requests
	function request($url, $requestType = 'POST') {
		
		$this->ch = curl_init();
	    curl_setopt($this->ch, CURLOPT_URL, $url);
        curl_setopt($this->ch, CURLOPT_VERBOSE, 1);
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($this->ch, CURLOPT_HTTPHEADER, array('Expect:'));
    
        curl_setopt($this->ch, CURLOPT_USERPWD, $this->username.":".$this->password);
        curl_setopt($this->ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        
        if($requestType == 'POST') {
        	curl_setopt($this->ch, CURLOPT_POST, 1);
        }
		
		 $result = curl_exec($this->ch);
		 
		 return $result;
	}
	
}

/**
 * Checks if the user has setup and is logged into a twitter account
 *
**/
function check_twitter_credentials() {
	$options = get_option('ts_options');
	if(!empty($options['twitter-accesstoken-oauthtoken']) && !empty($options['twitter-accesstoken-oauthtokensecret'])) {
		$access_token['oauth_token'] = $options['twitter-accesstoken-oauthtoken'];
		$access_token['oauth_token_secret'] = $options['twitter-accesstoken-oauthtokensecret'];
		$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);
		$credentials = $connection->get('account/verify_credentials');
		if(!empty($credentials)) {
			return $access_token;
		}
		else {
			return false;
		}
	}
}
?>