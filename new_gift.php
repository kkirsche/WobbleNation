<?php
include("include/bittorrent.php");
dbconn();
loggedinorreturn();


/******************************************************
/* So, let's set when christmas is and find out what day today is
/* This way we know whether or not to give out some gifts!
/*****************************************************/
//Set the current year, that way we don't have to update the script every year
	$currentYear = date("Y");
	
	//Now let's set the date of christmas using mktime, see below for the format of the date
	//mktime(hour,minute,second,month,day,year)
	$christmasDay = mktime(0,0,0,12,25,$currentYear);
	
	//Now let's find out what day it is today
	$today = mktime(date("G"), date("i"), date("s"), date("m"),date("d"),date("Y"));
	
	//Check if they're opening or just looking around...
	$open = 0 + $_GET["open"];
	
	//If they aren't opening, tell them they should be!
	if($open != 1){
		stderr("Error","You should be opening a gift, not looking at it!");
	}
	
if ($today >= $christmasDay) {
	/******************************************************
	/* So, it's christmas time
	/* Let's give out some gifts!
	/*****************************************************/
		if($CURUSER["gotgift"] == 'no'){
			//Give them their damn gift!
			give_gift();
		} else {
			//They already got one!
			stderr("Sorry...", "You already got your gift!");
		}
	} else {
		//user is early, tell them when to come back!
		stderr("Sorry...", "Be patient! Can't open your present until xmas! <b>" . date("j", ($christmasDay - $today)) . "</b> day(s) to go. <br> Today: " . date('l dS 			\of F 	Y h:i:s A', $today) . "<br>Christmas Day: " . date('l dS \of F Y h:i:s A', $christmasDay));
	}
	
//Start all the functions!

/******************************************************
/* Give_Gift()
/* This is the function to generate a random gift for the user with varying levels of rarity.
/*****************************************************/
function give_gift() {
	global $CURUSER;
	
	//First, who are we giving them to?
	$userid = 0 + $CURUSER["id"];
	if(!is_valid_id($userid)) {
		stderr("Error", "Invalid User ID");} 
	else {
		
		//Set minimum and maximum and then generate a random number. We'll use this later.
		$randomMinimum = 1;
		$randomMaximum = 100;
		$chance = mt_rand($randomMinimum, $randomMaximum);
		
		//Set percentage of rareness.
		$common = range(1, 49);
		$uncommon = range(50, 85);
		$rare = range(86, 96);
		$barelyever = range(97, 100);
	
		//Check if the user will be getting a common, uncommon, rare, or barely ever gift
		//Start with the common gifts!
		if(in_array($chance, $common)) {
			//Common Gifts - 49%

			//Let's generate what gift the user is getting! First, we set the possible common gifts, and choose randomly.
			$possibleGifts = array("smallUpload", "mediumUpload", "smallGold", "mediumGold", "smallDiamond");
			$randomlyChosenGift = array_rand($possibleGifts);
			$yourGift = $possibleGifts[$randomlyChosenGift];
		
			//Let's give the user their gift, let's start with small upload (5 GB Upload credit), and work our way through the array.
			if ($yourGift == "smallUpload") {
				//Set size of gift
				$smallUpload = "5";
				//Give upload gift!
				give_upload_gift($smallUpload);
			} elseif($yourGift == "mediumUpload") {
				//Set size of gift
				$mediumUpload = "10";
				//Give the user their gift
				give_upload_gift($mediumUpload);
			} elseif($yourGift == "smallGold") {
				//Set size of gift
				$smallGold = "2500";
				//Give the user the gift
				give_gold_gift($smallGold);
			} elseif($yourGift == "mediumGold") {
				//Set size of gift
				$mediumGold = "5000";
				//Give the user the gift
				give_gold_gift($mediumGold);
			} elseif($yourGift == "smallDiamond") {
				//Set diamond size
				$smallDiamond = "small";
				$whatColorDiamond = generate_diamond_color();
				//Give the user their diamond!
				give_diamond_gift($smallDiamond, $whatColorDiamond);
			}
			//User got their gift!
		} elseif(in_array($chance, $uncommon)) {
			//Uncommon Gifts - 35%
		
			//Let's generate what gift the user is getting! First, we set the possible uncommon gifts, and choose randomly.
			$possibleGifts = array("largeUpload", "extraLargeUpload", "largeGold", "smallDiamond");
			$randomlyChosenGift = array_rand($possibleGifts);
			$yourGift = $possibleGifts[$randomlyChosenGift];
		
			//Let's give the user their gift, let's start with large upload (50 GB Upload credit), and work our way through the array.
			if ($yourGift == "largeUpload") {
				//Set size of gift
				$largeUpload = "50";
				//Give gift!
				give_upload_gift($largeUpload);	
				} elseif($yourGift == "extraLargeUpload") {
				//Set size of gift
				$largeUpload = "75";
				//Give upload gift!
				give_upload_gift($largeUpload);
			} elseif($yourGift == "largeGold") {
				//Set size of gift
				$largeGold = "10000";
				//Give the user the gift
				give_gold_gift($largeGold);
			} elseif($yourGift == "smallDiamond") {
				//Set diamond size
				$smallDiamond = "small";
				$whatColorDiamond = generate_diamond_color();
				//Give the user their diamond!
				give_diamond_gift($smallDiamond, $whatColorDiamond);
			}
		
			//User got their gift!
		
		} elseif(in_array($chance, $rare)) {
			//Rare - 10%
		
			//Let's generate what gift the user is getting! First, we set the possible rare gifts, and choose randomly.
			$possibleGifts = array("hugeUpload", "oneInvite", "hugeGold", "largeDiamond");
			$randomlyChosenGift = array_rand($possibleGifts);
			$yourGift = $possibleGifts[$randomlyChosenGift];
		
			//Let's give the user their gift, let's start with huge upload (100 GB Upload credit), and work our way through the array.
			if ($yourGift == "hugeUpload") {
				//Set size of gift
				$largeUpload = "100";
				//Give upload gift!
				give_upload_gift($largeUpload);
			} elseif($yourGift == "oneInvite") {
				//if user is a swabbie, don't give them invites, or Capricorn gets mad 
				if($CURUSER["class" == "1") {
					//Set size of gift
					$swabbieUpload = "100";
					//Give upload gift!
					give_upload_gift($swabbieUpload);
				} else {
					//Set the number of Invites being given
					$howManyfInvites = "1";
					//Give the invites
					give_invite_gift($howManyfInvites);}
			} elseif($yourGift == "hugeGold") {
				//Set size of gift
				$hugeGold = "25000";
				//Give the user the gift
				give_gold_gift($hugeGold);
			} elseif($yourGift == "largeDiamond") {
				//Set diamond size
				$largeDiamond = "big";
				$whatColorDiamond = generate_diamond_color();
				//Give the user their diamond!
				give_diamond_gift($largeDiamond, $whatColorDiamond);
			}
		
			//User got their gift!
		
		} elseif(in_array($chance, $barelyever)) {
			//Barely Ever - 3%
				//if user is a swabbie, don't give them invites, or Capricorn gets mad 
				if($CURUSER["class" == "1") {
					//Set size of gift
					$swabbieUpload = "100";
					//Give upload gift!
					give_upload_gift($swabbieUpload);
				} else {
					//We only have one gift, so don't do anything random ;)
					//Set the number of Invites being given
					$howManyfInvites = "2";
					//Give the invites
					give_invite_gift($howManyfInvites);
			}
		}
	}
}

/******************************************************
/* generate_diamond_color()
/* This is the function to generate a small diamond for the user in give_gift()
/*****************************************************/
function generate_diamond_color() {
	//Set possible colors of diamonds
	$colors = array("Silver", "Green", "Red", "Blue");
	$randomColor = array_rand($colors);
	$giftDiamondColor = $colors[$randomColor];
	
	return $giftDiamondColor;
	}
	
/******************************************************
/* give_upload_gift()
/* This is the function to give the user their upload credit and let them know!
/*****************************************************/

function give_upload_gift($size) {
	global $CURUSER, $SITENAME;
	$userid = 0 + $CURUSER["id"];
	$thisYear = date("Y");
				
	//MySQL for adding upload
	mysql_query("UPDATE users SET uploaded=uploaded+1024*1024*1024*$size, gotgift='yes' WHERE id=".sqlesc($userid)."") or sqlerr(__FILE__, __LINE__);
				
	//Announce in IRC that they won
	$msg = "ANN \002[\002\0034CHRiSTMAS GiFT\003\002]\002 \0033".$CURUSER['username']."\003 just won $size GB upload credit!\003";
	ircannounce($msg);
				
	//We should tell them what they won ;)
	stderr("Congratulations!","<h2>You just won $size GB upload credit!</h2>
					Thanks for your support and sharing through year $thisYear! <br /> Merry Christmas and a Happy New Year from the crew here at ".$SITENAME."!");
}

/******************************************************
/* give_gold_gift()
/* This is the function to give the user their gold and let them know!
/*****************************************************/
function give_gold_gift($goldSize) {
	
	global $CURUSER, $SITENAME;
	$userid = 0 + $CURUSER["id"];
	$thisYear = date("Y");
	
	//MySQL for adding gold
	mysql_query("UPDATE users SET seedbonus = seedbonus + $goldSize, gotgift='yes' WHERE id=".sqlesc($userid)."") or sqlerr(__FILE__, __LINE__);
				
	//Announce in IRC that they won
	$msg = "ANN \002[\002\0034CHRiSTMAS GiFT\003\002]\002 \0033".$CURUSER['username']."\003 just won $goldSize gold!\003";
	ircannounce($msg);
				
	$goldSizeGiven = number_format($goldSize);
	//We should tell them what they won ;)
	stderr("Congratulations!","<h2>You just won $goldSizeGiven gold!</h2>
	Thanks for your support and sharing through year $thisYear! <br /> Merry Christmas and a Happy New Year from the crew here at ".$SITENAME."!");

}

/******************************************************
/* give_diamond_gift()
/* This is the function to give the user their diamond and let them know!
/*****************************************************/
function give_diamond_gift($diamondSize, $color) {
	//Set some stuff to use in the function
	global $CURUSER, $SITENAME;
	$userid = 0 + $CURUSER["id"];
	$thisYear = date("Y");
				
	//generate random diamond function and then get stuff ready to add it to their account
	$type = "$color$diamondSize";
	$stringSize = ucwords($diamondSize);
	$yourDiamond = "$stringSize $color Diamond";
	$where = "Christmas Gift";
	$now = time();
				
	//MySQL for adding random small diamond
	mysql_query("INSERT INTO diamonds (`start`, `end`, `type`, `page`, `taken`, `takenon`, `userid`, `comment`) VALUES ('$now', '$now', '$type', ".sqlesc($where).", 'yes', '$now', ".sqlesc($userid).", ".sqlesc($where).")") or sqlerr(__FILE__, __LINE__);
	//Put in their top bar that they actually got the diamond
	mysql_query("UPDATE users SET gotgift='yes', diamond = diamond + 1 WHERE id=".sqlesc($userid)."") or sqlerr(__FILE__, __LINE__);
				
	//Announce in IRC that they won
	$msg = "ANN \002[\002\0034CHRiSTMAS GiFT\003\002]\002 \0033".$CURUSER['username']."\003 just won a $yourDiamond!\003";
	ircannounce($msg);
				
				
	//We should tell them what they won ;)
	stderr("Congratulations!","<h2>You just won a $yourDiamond!</h2>
				Thanks for your support and sharing through year $thisYear! <br /> Merry Christmas and a Happy New Year from the crew here at ".$SITENAME."!");
}

/******************************************************
/* give_invite_gift()
/* This is the function to give the user their invite and let them know!
/*****************************************************/
function give_invite_gift($numberOfInvites) {
	//Set some stuff to use in the function
	global $CURUSER, $SITENAME;
	$userid = 0 + $CURUSER["id"];
	$thisYear = date("Y");
	
	//Give the actual gift via SQL
	mysql_query("UPDATE users SET invites=invites+$numberOfInvites, gotgift='yes'WHERE id=".sqlesc($userid)."") or sqlerr(__FILE__, __LINE__);
	
	//Set the message and announce it in IRC		
	$msg = "ANN \002[\002\0034CHRiSTMAS GiFT\003\002]\002 \0033".$CURUSER['username']."\003 just won \0039$diam DiAM0ND\003 &\0033 1 invite!\003";
	ircannounce($msg);
	
	//we need to see how many to make sure the next line is right
	if ($numberOfInvites == "1") {
		$doWeNeedAnS = "";
	} else {
		$doWeNeedAnS = "s";
	}
	
	//Let the user know how many invites they got!		
	stderr("Congratulations!","<h2> You just won $numberOfInvites invite$doWeNeedAnS!</h2>
			Thanks for your support and sharing through year $thisYear! <br /> Merry Christmas and a Happy New Year from the crew here at ".$SITENAME."!");
			
}
?>