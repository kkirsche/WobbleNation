<?php

/**
 * Functions to handle and manipulate the thumbnails behaviour and display
 * Since 2.9, it serves mostly as a backup function for old posts that don't contain thumbnails
 * Exclusive to the WobbleNation theme
 * 
 * @package WordPress
 * @subpackage WobbleNation
**/

class thumbnail {
	
	function thumbnail($src, $width = 100, $height = 133, $position = 'left', $crop = 1, $quality = 80) {
	
		$this->src = $src;
		$this->width = $width;
		$this->height = $height;
		$this->position = $position;
		$this->crop = $crop;
		$this->quality = $quality;
		
		$this->doc_root = '';
		$this->mime_type = '';
		$this->thumb_src = '';
		$this->cache_dir = './cache';
		
	}
	
	//Main Process
	function make() {
		$this->src = str_replace(get_bloginfo('url') . '/', '', $this->src);
		
		$this->get_document_root();
		$this->get_mime_type();
		
		// make sure that the src is gif/jpg/png
		if(!$this->valid_src_mime_type($this->mime_type)) { //Overchecking?
		    die("Invalid src mime type: $mime_type");
		}

		// check to see if GD function exist
		if(!function_exists('imagecreatetruecolor')) {
			die("GD Library Error: imagecreatetruecolor does not exist");
		}
		if(strlen($this->src) && file_exists($this->src)) {
			$this->generate_thumbnail();
		}
		else {
			
			//If you want to add a default image, this is the place
			//$this->thumb_src = 'wp-content/.jpg';
			
		}
		
	}
	
	//Generate the new image, the magic happens here
	function generate_thumbnail() {
	
		// open the existing image
		$image = $this->open_image();
		if($image === false) {
			die('Unable to open image : ' . $this->src);
		}
	
		// Get original width and height
		$width = imagesx($image);
		$height = imagesy($image);
	
		// don't allow new width or height to be greater than the original
		/*if( $this->width > $width ) {
			$this->width = $width;
		}
		if( $this->height > $height ) {
			$this->height = $height;
		}*/
	
		// generate new w/h if not provided
		if( $this->width && !$this->height ) {
		
			$this->height = $height * ( $this->width / $width );
			
		} elseif($this->height && !$this->width) {
		
			$this->width = $width * ( $this->height / $height );
			
		} elseif(!$this->width && !$this->height) {
		
			$this->width = $width;
			$this->height = $height;
			
		}
		
		// create a new true color image
		$canvas = imagecreatetruecolor( $this->width, $this->height );
	
		if( $this->crop ) {
	
			$src_x = $src_y = 0;
			$src_w = $width;
			$src_h = $height;
	
			$cmp_x = $width  / $this->width;
			$cmp_y = $height / $this->height;
	
			// calculate x or y coordinate and width or height of source
	
			if ( $cmp_x > $cmp_y ) {
	
				$src_w = round( ( $width / $cmp_x * $cmp_y ) );
				$src_x = round( ( $width - ( $width / $cmp_x * $cmp_y ) ) / 2 );
	
			} elseif ( $cmp_y > $cmp_x ) {
	
				$src_h = round( ( $height / $cmp_y * $cmp_x ) );
				$src_y = round( ( $height - ( $height / $cmp_y * $cmp_x ) ) / 2 );
	
			}
	        
			imagecopyresampled( $canvas, $image, 0, 0, $src_x, $src_y, $this->width, $this->height, $src_w, $src_h );
	
		} else {
	
			// copy and resize part of an image with resampling
			imagecopyresampled( $canvas, $image, 0, 0, 0, 0, $this->width, $this->height, $width, $height );
	
		}
			
		// output image to browser based on mime type
		//$this->show_image( $canvas );
		
		$this->thumb_src = basename($this->src);
		$target_dir = str_replace($this->thumb_src, '', $this->src);
		$this->thumb_src = $target_dir . str_replace('.', '_thumb' . $this->width . 'x' . $this->height . '.', $this->thumb_src);
		
		//echo $this->thumb_src;
		
		if(!file_exists($this->thumb_src)) {
		
			if(stristr($this->mime_type, 'gif')) {
			
				if(!@imagegif($canvas, $this->thumb_src)) {
					$thumbnail = get_bloginfo('stylesheet_directory') . '/images/default_thumbnail.jpg'; 
					?>
					<img src="<?php echo $thumbnail; ?>" alt="thumbnail" />
					<?php
				}
				
			} elseif(stristr($this->mime_type, 'jpeg')) {
			
				if(!@imagejpeg($canvas, $this->thumb_src, $this->quality)) {
					$thumbnail = get_bloginfo('stylesheet_directory') . '/images/default_thumbnail.jpg'; 
					?>
					<img src="<?php echo $thumbnail; ?>" alt="thumbnail" />
					<?php
				}
				
			} elseif(stristr($this->mime_type, 'png')) {
			
				if(!@imagepng($canvas, $this->thumb_src, 9)) {
					$thumbnail = get_bloginfo('stylesheet_directory') . '/images/default_thumbnail.jpg'; 
					?>
					<img src="<?php echo $thumbnail; ?>" alt="thumbnail" />
					<?php
				}
				
			}
			
		}
		
		// remove image from memory
		imagedestroy( $canvas );
	
	}
	
	function get_tag( $attributes = '' ) {
		
		//print_r($attributes);
		
		if(file_exists($this->thumb_src)) {
			$attributes_markup = '';
			foreach($attributes as $attr => $value) {
				$attributes_markup .= $attr.'="'. $value .'" ';
			}
			$tag = '<img src="' . get_bloginfo('url') . '/' . $this->thumb_src . '" ' . $attributes_markup . ' />';
			return $tag;
		}
		
	}
	
	function generate_tag( $attributes = '' ) {
		
		//print_r($attributes);
		
		if(file_exists($this->thumb_src)) {
			$attributes_markup = '';
			foreach($attributes as $attr => $value) {
				$attributes_markup .= $attr.'="'. $value .'"';
			}
			$tag = '<img src="' . get_bloginfo('url') . '/' . $this->thumb_src . '" ' . $attributes_markup . ' />';
			echo $tag;
		}
		
	}
	
	function open_image() {

		if(stristr($this->mime_type, 'gif')) {
		
			$image = imagecreatefromgif($this->src);
			
		} elseif(stristr($this->mime_type, 'jpeg')) {
		
			@ini_set('gd.jpeg_ignore_warning', 1);
			$image = imagecreatefromjpeg($this->src);
			
		} elseif( stristr($this->mime_type, 'png')) {
		
			$image = imagecreatefrompng($this->src);
			
		}
		
		return $image;
	
	}
	
	function clean_source () {

		// remove http/ https/ ftp
		$this->src = preg_replace("/^((ht|f)tp(s|):\/\/)/i", "", $this->src);
		
		// remove domain name from the source url
		$host = $_SERVER["HTTP_HOST"];
		$this->src = str_replace($host, "", $this->src);
		$host = str_replace("www.", "", $host);
		$this->src = str_replace($host, "", $this->src);
		
		//$src = preg_replace( "/(?:^\/+|\.{2,}\/+?)/", "", $src );
		//$src = preg_replace( '/^\w+:\/\/[^\/]+/', '', $src );
	
		// don't allow users the ability to use '../' 
		// in order to gain access to files below document root
	
		// src should be specified relative to document root like:
		// src=images/img.jpg or src=/images/img.jpg
		// not like:
		// src=../images/img.jpg
		$this->src = preg_replace( "/\.\.+\//", "", $this->src );
		$this->src = substr($this->src, 1, strlen($this->src));
	}

	function get_document_root () {
		if( @file_exists( $_SERVER['DOCUMENT_ROOT'] . '/' . $this->src ) ) {
			$this->doc_root = $_SERVER['DOCUMENT_ROOT'];
		}
		// the relative paths below are useful if timthumb is moved outside of document root
		// specifically if installed in wordpress themes like mimbo pro:
		// /wp-content/themes/mimbopro/scripts/timthumb.php
		$paths = array( '..', '../..', '../../..', '../../../..' );
		foreach( $paths as $path ) {
			if( @file_exists( $path . '/' . $this->src ) ) {
				$this->doc_root = $path;
			}
		}
	
	}
	
	function get_mime_type() {

	    $os = strtolower(php_uname());
		$mime_type = '';
	
		// use PECL fileinfo to determine mime type
		if( function_exists('finfo_open')) {
			$finfo = finfo_open(FILEINFO_MIME);
			$mime_type = finfo_file($finfo, $this->src);
			finfo_close($finfo);
		}
	
		// try to determine mime type by using unix file command
		// this should not be executed on windows
	    if(!$this->valid_src_mime_type($mime_type) && !(preg_match('/windows/i', $os))) {
			if(preg_match("/freebsd|linux/", $os)) {
				$mime_type = trim(@shell_exec('file -bi $file'));
				//$mime_type = trim( @shell_exec( 'file -bi ' . escapeshellcmd( $file ) ) );
			}
		}
	
		// use file's extension to determine mime type
		if(!$this->valid_src_mime_type($mime_type)) {
	
			// set defaults
			$mime_type = 'image/jpeg';
			// file details
			$fileDetails = pathinfo($this->src);
			$ext = strtolower($fileDetails["extension"]);
			// mime types
			$types = array(
	 			'jpg'  => 'image/jpeg',
	 			'jpeg' => 'image/jpeg',
	 			'png'  => 'image/png',
	 			'gif'  => 'image/gif'
	 		);
			
			if(strlen($ext) && strlen($types[$ext])) {
				$mime_type = $types[$ext];
			}
			
		}
		
		$this->mime_type = $mime_type;

	}
	
	function valid_src_mime_type($mime_type) {

		if(preg_match("/jpg|jpeg|gif|png/i", $mime_type)) {
			return true;
		}
		return false;

	}
	
	function check_cache() {

		// make sure cache dir exists
		if(!file_exists($this->cache_dir)) {
			// give 777 permissions so that developer can overwrite
			// files created by web server user
			mkdir($this->cache_dir);
			chmod($this->cache_dir, 0777);
		}
	
		$this->show_cache_file($this->cache_dir);

	}

	function show_cache_file() {
	
		$cache_file = $this->cache_dir . '/' . $this->get_cache_file();
	
		if( file_exists( $cache_file ) ) {
	    	
		    if( isset( $_SERVER[ "HTTP_IF_MODIFIED_SINCE" ] ) ) {
			
				// check for updates
				$if_modified_since = preg_replace( '/;.*$/', '', $_SERVER[ "HTTP_IF_MODIFIED_SINCE" ] );					
				$gmdate_mod = gmdate( 'D, d M Y H:i:s', filemtime( $cache_file ) );
				
				if( strstr( $gmdate_mod, 'GMT' ) ) {
					$gmdate_mod .= " GMT";
				}
				
				if ( $if_modified_since == $gmdate_mod ) {
					header( "HTTP/1.1 304 Not Modified" );
					exit;
				}
	
			}
			
			$fileSize = filesize($cache_file);
					
			// send headers then display image
			header("Content-Type: " . $this->mime_type);
			//header("Accept-Ranges: bytes");
			header("Last-Modified: " . gmdate('D, d M Y H:i:s', filemtime($cache_file)) . " GMT");
			header("Content-Length: " . $fileSize);
			header("Cache-Control: max-age=9999, must-revalidate");
			header("Expires: " . gmdate("D, d M Y H:i:s", time() + 9999) . "GMT");
			
			readfile($cache_file);
			
			die();
	
		}
		
	}

	function get_cache_file () {
	
		static $cache_file;
		if(!$cache_file) {
			$frags = split( "\.", $_REQUEST['src'] );
			$ext = strtolower( $frags[ count( $frags ) - 1 ] );
			if(!$this->valid_extension($ext)) { $ext = 'jpg'; }
			//$cachename = get_request( 'src', 'timthumb' ) . get_request( 'w', 100 ) . get_request( 'h', 100 ) . get_request( 'zc', 1 ) . get_request( '9', 80 );
			//$cachename = $this->get_request( 'src', 'timthumb' ) . $this->width . $this->height . $this->crop . $this->quality;
			$cachename = $this->src . $this->width . $this->height . $this->crop . $this->quality;
			$cache_file = md5( $cachename ) . '.' . $ext;
		}
		return $cache_file;
	
	}
	
	function get_request( $property, $default = 0 ) {
	
		if( isset($_REQUEST[$property]) ) {
			return $_REQUEST[$property];
		} else {
			return $default;
		}
	
	}
	
	function valid_extension ($ext) {

		if( preg_match( "/jpg|jpeg|png|gif/i", $ext ) ) return 1;
		return 0;

	}	
	
	
}


?>