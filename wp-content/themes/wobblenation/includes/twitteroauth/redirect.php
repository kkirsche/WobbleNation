<?php

/* Start session and load library. */
if(!isset($_SESSION))
	session_start();

require_once('twitteroauth.php');
require_once('config.php');

/* Build TwitterOAuth object with client credentials. */
$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET);
 
/* Get temporary credentials. */
$callback = empty($_GET['callback']) ? OAUTH_CALLBACK : str_replace('--http--', 'http://', urldecode($_GET['callback'])) . '/includes/twitteroauth/callback.php';
$request_token = $connection->getRequestToken($callback);

/* Save temporary credentials to session. */
$_SESSION['oauth_token'] = $token = $request_token['oauth_token'];
$_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];
 
/* If last connection failed don't display authorization link. */
switch ($connection->http_code) {
  case 200:
    /* Build authorize URL and redirect user to Twitter. */
    $url = $connection->getAuthorizeURL($token);
    header('Location: ' . $url); 
    break;
  default:
    /* Show notification if something went wrong. */
    echo $connection->http_code.'<br />';
    var_dump($_SESSION);
    echo 'Could not connect to Twitter. Refresh the page or try again later.';
}
