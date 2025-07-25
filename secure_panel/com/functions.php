<?php
	//includes("inc/Ssh2_crontab_manager.php");

    function checkUser($uid, $oauth_provider, $username,$email,$twitter_otoken,$twitter_otoken_secret) 
	{
		$db = new sqlConnection();	
		//$crontab = new Ssh2_crontab_manager('socialboost.apnaphp.php', '85', 'my_username', 'my_password'); 
		//$crontab->append_cronjob('30 8 * * 6 home/path/to/command/the_command.sh >/dev/null 2>&1');	
	
        $query = $db->fireQuery("SELECT * FROM `customer` WHERE oauth_uid = '$uid' and oauth_provider = '$oauth_provider'");
		

		$rowcount = $db->rowCount($query);   
        if ( $rowcount > 0 ) 
		{
			$result = $db->fetchAssoc($query);
			$_SESSION['id'] = $result[0]['id'];
            $_SESSION['oauth_id'] = $result[0]['oauth_id'];
            $_SESSION['username'] = $result[0]['username'];
			$_SESSION['email'] = $result[0]['email'];
            $_SESSION['oauth_provider'] = $result[0]['oauth_provider'];
			/*if( isset( $_SESSION["logincnt"] ) ){
			  $_SESSION["logincnt"] = $_SESSION["logincnt"] + 1;	
			}
			else{
				 $_SESSION["logincnt"] = 0;	
				 header("location:account.php");
				 die();
			}*/
        } else {
			$current_date = time();
			$start_date = date('y-m-d h:iA',$current_date);
			$expiry = $current_date + (365 * 86400);
			$expiry_date = date('y-m-d h:iA',$expiry);
			$remaining_time = $expiry - $current_date;
			$limit = 5;
			check_expiry($remaining_time,$limit);
            $query = $db->fireQuery("INSERT INTO `customer` (oauth_provider,oauth_uid, name,email,register_date,start_date,expiry_date) VALUES ('$oauth_provider','$uid', '$username','$email',now(),'$start_date','$expiry_date')");	
			
			//$update_date = $db->fireQuery("update customer set start_date = $start_date");		
            
			$query = $db->fireQuery("SELECT * FROM `customer` WHERE oauth_uid = '$uid' and oauth_provider = '$oauth_provider'");			
            $result = $db->fetchAssoc($query);
            return $result;
        }
        return $result;
    }
	
	# Encrypt / Decrypt functions
	function siteEncrypt( $txt ){
		return base64_encode( trim( $txt ) );
	}
	function siteDecrypt( $txt ){
		return base64_decode( strip_tags( trim( $txt ) ) );
	}
	
	// Sendmail
	function SendEmail($to,$from,$subject,$msg,$cond){
   
		//$cond=0     For the simple mail to send
		//$cond=1     For Html Format Mail Send
		if($cond==0)
		{
			$mail_subject = $subject;
			$message = $msg;
			$mail_to = $to;
			$mail_from = $from;
			$headers = "From:".$mail_from;
	
			mail($mail_to, $mail_subject, $message, $headers);
		}
		if($cond==1)
		{
		      $message = '
						<html>
						<head>
						<title>'.$_SESSION['config_val'][0]['varcurrency'].'</title>
						</head>
						<body>
						<table width=100% border=0 cellspacing=0 cellpadding=0 >
						 <tr>
							<td class="skinbg">'.$msg.'</td>
						</tr>
						<tr>
							<td class="skinbg">&nbsp;</td>
						</tr>
						</table>
						</body>
						</html>';
				/* To send HTML mail, you can set the Content-type header. */
				$headers  = "MIME-Version: 1.0\r\n";
				$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
				/* additional headers */
				$headers .= "To: ".$to."\r\n";
				$headers .= "From: ".$from."\r\n";							
				/* and now mail it */
				$qrry = mail($to, $subject, $message, $headers);
				return $qrry;
		}
  }				
  // Validate Email		
  function validateEmail($address) {
		if (function_exists('filter_var')) { //Introduced in PHP 5.2
			if(filter_var($address, FILTER_VALIDATE_EMAIL) === FALSE) {
				return false;
			} else {
				return true;
			}
		} else {
			return preg_match('/^(?:[\w\!\#\$\%\&\'\*\+\-\/\=\?\^\`\{\|\}\~]+\.)*[\w\!\#\$\%\&\'\*\+\-\/\=\?\^\`\{\|\}\~]+@(?:(?:(?:[a-zA-Z0-9_](?:[a-zA-Z0-9_\-](?!\.)){0,61}[a-zA-Z0-9_-]?\.)+[a-zA-Z0-9_](?:[a-zA-Z0-9_\-](?!$)){0,61}[a-zA-Z0-9_]?)|(?:\[(?:(?:[01]?\d{1,2}|2[0-4]\d|25[0-5])\.){3}(?:[01]?\d{1,2}|2[0-4]\d|25[0-5])\]))$/', $address);
		}
	}
	
	function createThumbResize( $sourcepath , $targetpath ,$name , $widt,$heigh ){
	 
			$img = $sourcepath ;
			$handle = fopen ($img, "rb");
			$org = fread ($handle, filesize ($img));
			fclose ($handle);
			$img = imagecreatefromstring( $org );
			$w = imagesx( $img );
			$h = imagesy( $img );
			$nw =$widt;
			$nh =$heigh;
	
			$img2 = imagecreatetruecolor( $nw, $nh );
			imagecopyresampled ( $img2, $img, 0, 0, 0 , 0, $nw, $nh, $w, $h );
	
			//$fimg = $name.'.'.'jpg';		
			$fimg = $name;
			$real_tpath = realpath ($targetpath);
			$file = $real_tpath . "\\" . $fimg;
			imagejpeg( $img2, $file );
			return $file;
	
	}
	
	function full_copy( $source, $target ) 
	{
		if ( is_dir( $source ) ) 
		{
			@mkdir( $target );
			$d = dir( $source );
			while ( FALSE !== ( $entry = $d->read() ) ) 
			{
				if ( $entry == '.' || $entry == '..' ) 
				{
					continue;
				}
				$Entry = $source . '/' . $entry;
				if ( is_dir( $Entry ) ) 
				{
					full_copy( $Entry, $target . '/' . $entry );
					continue;
				}
				copy( $Entry, $target . '/' . $entry );
			}
			$d->close();
		}
		else 
		{
			copy( $source, $target );
		}
	}
	
/* Check expiry before 5 days and send mail */	
function check_expiry($remaining_time,$limit)
{
	$check_limit = $limit * 86400;
	if($remaining_time < $check_limit || $remaining_time == $check_limit)
	{
		$msg		= date('y-m-d',$remaining_time);
		$to 		= "rahul.maaraj@gmail.com";
		$from 		= "rahul.maaraj@gmail.com";
		$subject 	= $limit."Days remaining to expire your account";
		$headers 	= "From:".$from;
		$message 	= 
					'<html>
					<head>
					<title>'.$_SESSION['config_val'][0]['varcurrency'].'</title>
					</head>
					<body>
					<table width=100% border=0 cellspacing=0 cellpadding=0 >
					<tr>
					<td class="skinbg">'.$limit.' Days remaining to expire your account!</td>
					</tr>
					<tr>
					<td class="skinbg">&nbsp;</td>
					</tr>
					</table>
					</body>
					</html>';
					/* To send HTML mail, you can set the Content-type header. */
					$headers  = "MIME-Version: 1.0\r\n";
					$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
					/* additional headers */
					$headers .= "To: ".$to."\r\n";
					$headers .= "From: ".$from."\r\n";							
					/* and now mail it */
					mail($to, $subject, $message, $headers);
	}
}
 

?>
