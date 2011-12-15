<?php
/**
 * @file
 * Clears PHP sessions and redirects to the connect page.
 */
 
/* Load and clear sessions */
if(!isset($_SESSION))
	@session_start();

@session_destroy();
 
/* Redirect to page with the connect to Twitter option. */
header('Location: ../../../../../wp-admin/themes.php?page=options.php&delete_twitter_credentials=1');
