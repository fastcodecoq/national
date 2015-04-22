<?php

// Get email address
require_once 'config.php';

// Ensures no one loads page and does simple spam check
if( isset($_POST['name']) && empty($_POST['spam-check']) ) {
	
	// Declare our $errors variable we will be using later to store any errors
	$error = array();

//array(21) { ["name"]=> string(0) "" ["last_name"]=> string(0) "" ["address"]=> string(0) "" ["email"]=> string(0) "" ["phone"]=> string(0) "" ["fax"]=> string(0) "" ["subject"]=> string(0) "" ["departure"]=> string(0) "" ["contact-arrival"]=> string(0) "" ["ddeparture"]=> string(0) "" ["darrival"]=> string(0) "" ["hour"]=> string(0) "" ["mins"]=> string(0) "" ["contact-pickuptime"]=> string(2) "am" ["contact-groupsize"]=> string(0) "" ["contact-way"]=> string(4) "null" ["contact-motorcoach"]=> string(4) "null" ["contact-heard"]=> string(4) "null" ["contact-whatother"]=> string(0) "" ["message"]=> string(0) "" ["spam-check"]=> string(0) "" }
	
	// Setup our basic variables
	$input_name = strip_tags($_POST['name']);
	$input_email = strip_tags($_POST['email']);
	$input_subject = strip_tags($_POST['subject']);
	$input_message = strip_tags($_POST['message']);

		//news fields
	$input_lastname = strip_tags($_POST['last_name']);
	$input_phone = strip_tags($_POST['phone']);
	$input_fax = strip_tags($_POST['fax']);
	$input_departure = strip_tags($_POST['departure']);
	$input_arrival = strip_tags($_POST['arrival']);
	$input_ddeparture = strip_tags($_POST['ddeparture']);
	$input_darrival = strip_tags($_POST['darrival']);


	$now = date("d/m/Y");
	
	// We'll check and see if any of the required fields are empty
	if( strlen($input_name) < 2 ) $error['name'] = 'Please enter your name.';
	if( strlen($input_lastname) < 2 ) $error['lastname'] = 'Please enter your last name.';
	if( strlen($input_message) < 5 ) $error['message'] = 'Please leave a message.';
	if( strlen($input_phone) < 10 ) $error['phone'] = 'Please enter a valid phone.';
	if( strlen($input_departure) < 4 ) $error['departure'] = 'Please enter a valid pickup address.';
	if( strlen($input_arrival) < 4 ) $error['arrival'] = 'Please enter a valid destination address.';
	if( strlen($input_ddeparture) < 4 ) $error['ddeparture'] = 'Please enter a valid departure date.';
	if( strlen($input_darrival) < 4 ) $error['darrival'] = 'Please enter a valid arrival date.';	
	if( strlen($input_message) < 5 ) $error['message'] = 'Please leave a message.';	

	// Make sure the email is valid
	if( !filter_var($input_email, FILTER_VALIDATE_EMAIL) ) $error['email'] = 'Please enter a valid email address.';

	// Set a subject & check if custom subject exist
	$subject = "Contact National LC";
	if( $input_subject ) $subject .= ": $input_subject";

	$fax = (!empty($input_fax)) ? "- " . $input_fax : "";

	  $thead = "<table width='555' border='0' background='$url_texture_background'>
  		<thead>
  		  <tr>
  		  <td colspan='2'>&nbsp;&nbsp;<img src='http://denaliink.com/betaNLC/img/logo.png' alt='' /> <br> <br></td>
  		  </tr>
  		</thead>";

		$body = " $thead
		<tbody>

	    <tr><td colspan='2'><p>&nbsp;&nbsp;&nbsp;&nbsp;Message, <br><br> &nbsp;&nbsp;&nbsp;&nbsp;$input_message <br><br><br><br><br> &nbsp;&nbsp;&nbsp;--------------------- <br></p></td></tr>
		<tr><td colspan='2'>&nbsp;&nbsp;&nbsp;&nbsp;User Info <br /><br /></td></tr>
		<tr><td style='width:120px'>&nbsp;&nbsp;&nbsp;&nbsp;Name:</td><td><b>$input_name</b></td></tr>
		<tr><td>&nbsp;&nbsp;&nbsp;&nbsp;Last Name:</td><td>$input_lastname</td></tr>
		<tr><td>&nbsp;&nbsp;&nbsp;&nbsp;Phone:</td><td>$input_phone</td></tr>
		<tr><td>&nbsp;&nbsp;&nbsp;&nbsp;Pickup Address:</td><td>$input_departure</td></tr>
		<tr><td>&nbsp;&nbsp;&nbsp;&nbsp;Date Departure:</td><td>$input_ddeparture</td></tr>
		<tr><td>&nbsp;&nbsp;&nbsp;&nbsp;Destination Address:</td><td>$input_arrival</td></tr>
		<tr><td>&nbsp;&nbsp;&nbsp;&nbsp;Date Arrival:</td><td>$input_darrival</td></tr>
		<tr><td rowspan='2' ><br /><br /><br /><br /></td></tr>
	
		</tbody>
	 </table>
	 ";

	 $buss = (!empty($input_subject)) ? "(" . $input_subject . ")" : "";

	 $body_ = "$thead
		<tbody>
		<tr><td><br>&nbsp;&nbsp;&nbsp;&nbsp;Hello <b>$input_name</b> $buss,<br><br></td></tr>
		<tr><td><br>$thanks_message</td></tr>
		<tr><td><br><br><br><br><br>&nbsp;&nbsp;&nbsp;&nbsp;-------------<br><br></td></tr>
		<tr><td>&nbsp;&nbsp;&nbsp;&nbsp;7015 NE 42nd Ave</td></tr>
		<tr><td>&nbsp;&nbsp;&nbsp;&nbsp;Portland, OR 97218</td></tr>		
		<tr><td>&nbsp;&nbsp;&nbsp;&nbsp;USA</td></tr>
		<tr><td>&nbsp;&nbsp;&nbsp;&nbsp;Phone: (503) 336-1196 </td></tr>
		<tr><td><br /><br /><br /><br /><br /></td></tr>
		</tbody>
		</table>";

		$headers = 'MIME-Version: 1.0' . "\r\n";		
		$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";	

		$headers_ = $headers;

		$headers .= 'To: National L info <info@nationalluxurycoach.com>' . "\r\n";
		$headers .= 'From: ' . $input_name . ' <' . $input_email . '>' . "\r\n";

		$headers_ .= 'To: ' . $input_name . ' <' . $input_email . '>' . "\r\n";
		$headers_ .= 'From: National L info <info@nationalluxurycoach.com>' . "\r\n";




	// Now check to see if there are any errors 
	if( count($error) == 0 ) {

		// No errors, send mail using conditional to ensure it was sent
		if( mail($your_email_address, $subject, $body, $headers) && mail($input_email,"National LC Thank u for contact us", $body_, $headers_) ) {
			echo '<p class="success">Your email has been sent!</p>';
		} else {
			echo '<p class="error">There was a problem sending your email!</p>';
		}
		
	} else {
		
		// Errors were found, output all errors to the user
		$response = "";
		
		foreach ($error as $err) {
			
			$response .= $err . "<br /> \n";

		}

		echo "<p class='error'>$response</p>";
		
	}
	
} else {

	die('Direct access to this page is not allowed.');

}