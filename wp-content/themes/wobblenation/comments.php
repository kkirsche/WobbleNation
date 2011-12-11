<?php // Do not delete these lines
	if ('comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ('Please do not load this page directly. Thanks!');

        if (!empty($post->post_password)) { // if there's a password
            if ($_COOKIE['wp-postpass_' . COOKIEHASH] != $post->post_password) {  // and it doesn't match the cookie
				?>
				
				<p class="nocomments">This post is password protected. Enter the password to view comments.<p>
				
				<?php
				return;
            }
        }

		/* This variable is for alternating comment background */
		$oddcomment = 'alt';
?>

<!-- You can start editing here. -->

<?php if ( have_comments() ) : ?>

<div class="clearer"></div>

<div id="comments">

	<h2 class="subtitle"><?php echo ts_getoption('ts_comments_title'); ?></h2>

	<ol id="comments_list">

		<? wp_list_comments('type=comment&callback=comments_markup'); ?>

	</ol>
	
	<div class="clearer"></div>
	
</div>

 <?php else : // this is displayed if there are no comments so far ?>

  <?php if ('open' == $post->comment_status) : ?> 
		<!-- If comments are open, but there are no comments. -->
		
	 <?php else : // comments are closed ?>
		<!-- If comments are closed. -->
		<p class="nocomments">Comments are closed.</p>
		
	<?php endif; ?>

<?php endif; ?>


<?php if ('open' == $post->comment_status) : ?>
<div class="clearer"></div>

<h2 class="subtitle"><?php comment_form_title(ts_getoption('ts_reply_message'), ts_getoption('ts_response_message')); ?></h2>

<div id="reply">
	
	<span id="cancel-comment-reply">
		<small><?php cancel_comment_reply_link() ?></small>
	</span>
	
	<p><?php echo ts_getoption('ts_comment_instructions'); ?></p>
		
	<div class="clearer"></div>
	
	<?php if ( get_option('comment_registration') && !$user_ID ) : ?>
	<div id="respond">
	<p>
		You must be <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php the_permalink(); ?>">logged in</a> to post a comment.
	</p>
	</div>
	<?php else : ?>
	
	<div id="respond">
	
		<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="comments_form">
		<?php comment_id_fields(); ?>
		
		
		<?php if ( $user_ID ) : ?>
		
		<p>Logged in as <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?action=logout" title="Log out of this account">Logout &raquo;</a></p>
		
		<?php else : 
		$autor = empty($comment_author) ? '' : $comment_author;
		$email = empty($comment_author_email) ? '' : $comment_author_email;
		$url = empty($comment_author_url) ? '' : $comment_author_url;
		
		?>
			<div class="comments_userdata">
				<label for="author">Name: </label>
				<input type="text" name="author" id="author" class="inputtext" value="<?php echo $autor; ?>" />
				
				<label for="email">E-mail: </label>
				<input type="text" name="email" id="email" class="inputtext" value="<?php echo $email; ?>" />
				
				<label for="url">Website: </label>
				<input type="text" name="url" id="url" class="inputtext" value="<?php echo $url; ?>" />
			</div>
		
		<?php endif; ?>
		
		
		<div class="comments_message">
			<label for="comment">Comment: </label>
			<textarea name="comment" id="comment" class="inputarea"></textarea>
			<button type="submit" name="submit" id="submit">Leave Comment</button>
			<!--<input name="submit" type="submit" id="submit" tabindex="5" value="Send" />-->
		</div>
		
		<?php do_action('comment_form', $post->ID); ?>
	
	</form>

	</div>

<?php endif; // If registration required and not logged in ?>

<div class="clearer"></div>

</div>

<?php endif; // if you delete this the sky will fall on your head ?>

<?php 

function comments_markup($comment, $args, $depth) {
global $post;

$GLOBALS['comment'] = $comment; ?>
   <li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
     <div id="comment-<?php comment_ID(); ?>">
     
     	<?php 
     		$def_gravatar = get_bloginfo('template_directory')."/images/avatar_default.jpg";
	     	$gravatar_size = 40;
	     			echo get_avatar(get_comment_author_email(), $gravatar_size);
	     		
     	?>
     	
		<span class="comment_entry">
	    	
	    	<span class="comment_text">
	    		
	    		<span class="comment_meta">
	    		
	    			Posted by
		    		<cite>
		    			<?php comment_author_link() ?> 
	      			</cite>
	      			
	      			on
	      			
	      			<span class="comment_date">
			    		<?php comment_date('F jS, Y, H:i'); ?>
			    	</span>
	      			
	      			<?php comment_reply_link(array_merge( $args, array('reply_text' => ' [Reply]', 'add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth']))); ?>
		    		
		    	</span>
	    		
	    		
		    	<?php if ($comment->comment_approved == '0') : ?>
		    	<em class="warning">Your comment is awaiting moderation</em>
		    	
		    	<div class="clearer"></div>
		    	
		    	<?php endif; ?>
	    		
	    		<?php comment_text(); ?>
	    		
	    		<div class="clearer"></div>
	    	</span>
	    		
	    	<div class="clearer"></div>
    		
		</span>

     </div>
     
     <div class="clearer"></div>
<?php 

}

?>
