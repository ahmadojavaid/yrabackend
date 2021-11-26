<?php
	include_once('../includes/config.php');
	
	// get data from android app
	$name 				= $_POST['name'];
	$number_of_people 	= $_POST['number_of_people'];
	$date_time 			= $_POST['date_time'];
	$phone 				= $_POST['phone'];
	$order_list 		= $_POST['order_list'];
	$comment 			= $_POST['comment'];
	$email 				= $_POST['email'];
	
	$sql_query = "set names 'utf8'";
	$stmt = $connect->stmt_init();
	if($stmt->prepare($sql_query)) {	
		// Execute query
		$stmt->execute();
		// store result 
		$stmt->close();
	}
	
	// insert data into reservation table
	$sql_query = "INSERT INTO tbl_reservation (name, number_of_people, date_time, phone, order_list, comment, email) 
					VALUES (?, ?, ?, ?, ?, ?, ?)";
	
	$stmt = $connect->stmt_init();
	if($stmt->prepare($sql_query)) {	
		// Bind your variables to replace the ?s
		$stmt->bind_param('sssssss', 
					$name,
					$number_of_people, 
					$date_time, 
					$phone, 
					$order_list,
					$comment,
					$email
					);
		// Execute query
		$stmt->execute();
		$result = $stmt->affected_rows;
		// store result 
		//$result = $stmt->store_result();
		$stmt->close();
	}
	
	// get admin email from user table
	$sql_query = "SELECT Email 
			FROM tbl_user";
	
	$stmt = $connect->stmt_init();
	if($stmt->prepare($sql_query)) {	
		// Execute query
		$stmt->execute();
		// store result 
		$stmt->store_result();
		$stmt->bind_result($email);
		$stmt->fetch();
		$stmt->close();
	}
	
	// if new reservation has been successfully added to reservation table 
	// send notification to admin via email
	if($result) {
		$to = $email;
		$subject = '[IMPORTANT] Your Restaurant App Reservation Information';			
		$message='<div style="background-color: #f9f9f9;" align="center"><br />
					  <table style="font-family: OpenSans,sans-serif; color: #666666;" border="0" width="600" cellspacing="0" cellpadding="0" align="center" bgcolor="#FFFFFF">
					    <tbody>
					      <tr>
					        <td width="600" valign="top" bgcolor="#FFFFFF"><br>
					          <table style="font-family:OpenSans,sans-serif; color: #666666; font-size: 10px; padding: 15px;" border="0" width="100%" cellspacing="0" cellpadding="0" align="left">
					            <tbody>
					              <tr>
					                <td valign="top"><table border="0" align="left" cellpadding="0" cellspacing="0" style="font-family:OpenSans,sans-serif; color: #666666; font-size: 10px; width:100%;">
					                    <tbody>
					                      <tr>
					                        <td>
					                          <p style="color:#262626; font-size:20px; line-height:32px;font-weight:500;">There is New Reservation!<br>
					                           Please check Admin Panel.</p>
					                          <p style="color:#262626; font-size:20px; line-height:32px;font-weight:500;margin-bottom:30px;">Thanks you,<br />
					                            Your Restaurant App.</p></td>
					                      </tr>
					                    </tbody>
					                  </table></td>
					              </tr>
					               
					            </tbody>
					          </table></td>
					      </tr>
					      <tr>
					        <td style="color: #262626; padding: 20px 0; font-size: 20px; border-top:5px solid #52bfd3;" colspan="2" align="center" bgcolor="#ffffff">Copyright © Your Restaurant App.</td>
					      </tr>
					    </tbody>
					  </table>
					</div>';
 
			$headers = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$headers .= 'From: Your Restaurant App <don-not-reply@solodroid.co.id>' . "\r\n";
			// Mail it
			@mail($to, $subject, $message, $headers);
		echo "OK";
	} else {
		echo "Failed";
	}

?>