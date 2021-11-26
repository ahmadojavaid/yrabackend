	<?php 
		if(isset($_GET['id'])){
			$ID = $_GET['id'];
		}else{
			$ID = "";
		}
			
		// create array variable to handle error
		$error = array();
			
		// create array variable to store data from database
		$data = array();
			
		if(isset($_POST['btnSave'])){
			$process = $_POST['status'];
			$sql_query = "UPDATE tbl_reservation 
					SET status = ? 
					WHERE ID = ?";
			
			$stmt = $connect->stmt_init();
			if($stmt->prepare($sql_query)) {	
				// Bind your variables to replace the ?s
				$stmt->bind_param('ss', $process, $ID);
				// Execute query
				$stmt->execute();
				// store result 
				$update_result = $stmt->store_result();
				$stmt->close();
			}
			
			// check update result
				if($update_result) {
					$error['update_data'] = "<div class='card-panel teal lighten-2'>
											    <span class='white-text text-darken-2'>
												   Changed Successfully
											    </span>
											</div>";
				} else {
					$error['update_data'] = "<div class='card-panel red darken-1'>
											    <span class='white-text text-darken-2'>
												    Added Failed
											    </span>
											</div>";
				}
		}
		
		// get data from reservation table
		$sql_query = "SELECT * 
				FROM tbl_reservation 
				WHERE ID = ?";
		
		$stmt = $connect->stmt_init();
		if($stmt->prepare($sql_query)) {	
			// Bind your variables to replace the ?s
			$stmt->bind_param('s', $ID);
			// Execute query
			$stmt->execute();
			// store result 
			$stmt->store_result();
			$stmt->bind_result($data['ID'], 
					$data['name'],
					$data['number_of_people'], 
					$data['date_time'], 
					$data['phone'],
					$data['order_list'],
					$data['status'],
					$data['comment'],
					$data['email']
					);
			$stmt->fetch();
			$stmt->close();
		}
		
		// parse order list into array
		$order_list = explode(',',$data['order_list']);
			
	?>


	<!-- START CONTENT -->
    <section id="content">

        <!--breadcrumbs start-->
        <div id="breadcrumbs-wrapper" class=" grey lighten-3">
          	<div class="container">
            	<div class="row">
              		<div class="col s12 m12 l12">
               			<h5 class="breadcrumbs-title">Order Detail</h5>
		                <ol class="breadcrumb">
		                  <li><a href="dashboard.php">Dashboard</a>
		                  </li>
		                  <li><a href="#" class="active">Order Detail</a>
		                  </li>
		                </ol>
              		</div>
            	</div>
          	</div>
        </div>
        <!--breadcrumbs end-->

        <!--start container-->
        <div class="container">
          	<div class="section">
				<div class="row">
		            <div class="col s12 m12 l12">
		              	<div class="card-panel">
		              		<?php echo isset($error['update_data']) ? $error['update_data'] : '';?>
		                	<div class="row">
		                  		<div class="row">
		                    		<div class="input-field col s12">
		                    			<form method="post" class="col s12">

											<table class='bordered'>
												<tr>
													<th>ID</th>
													<td><?php echo $data['ID']; ?></td>
												</tr>
												<tr>
													<th>Name</th>
													<td><?php echo $data['name']; ?></td>
												</tr>
												<tr>
													<th>Email</th>
													<td><?php echo $data['email']; ?></td>
												</tr>
												<tr>
													<th>Number of People</th>
													<td><?php echo $data['number_of_people'];?></td>
												</tr>
												<tr>
													<th>Time</th>
													<td><?php echo $data['date_time']; ?></td>
												</tr>
												<tr>
													<th>Phone</th>
													<td><?php echo $data['phone']; ?></td>
												</tr>
												<tr>
													<th>Order list</th>
													<td>
														<ul>
														<?php
															$count = count($order_list);
															for($i = 0;$i<$count;$i++){
																if($i == ($count -1)){
																	echo "<br /><li><strong>".$order_list[$i]."</strong></li>";
																}else{
																	echo "<li>".$order_list[$i]."</li>";
																}
															}
														?>
														</ul>
													</td>
												</tr>
												<tr>
													<th>Comment</th>
													<td><?php echo empty($data['comment']) ? 'No comment' : $data['comment']; ?></td>
												</tr>
												<tr>
													<th>Status</th>
													<td>
														<select name="status" class="form-control">	

														<?php if ($data['status'] == 0) { ?>
															<option value="0" selected="selected">PENDING</option>
															<option value="1">COMPLETED</option>
															<option value="2">CANCELED</option>

														<?php } else if ($data['status'] == 1) { ?>
															<option value="0">PENDING</option>
															<option value="1" selected="selected">COMPLETED</option>
															<option value="2">CANCELED</option>
														
														<?php } else { ?>
															<option value="0">PENDING</option>
															<option value="1">COMPLETED</option>
															<option value="2" selected="selected">CANCELED</option>
														<?php } ?>
	
														</select>
													</td>
												</tr>
											</table>
											<br>
											<button type="submit" class="btn waves-effect waves-light indigo right" name="btnSave">Update <i class="mdi-content-send right"></i></button>
										
										</form>		           
		                    		</div>
		                  		</div>
		                	</div>
		              	</div>
		            </div>
		        </div>
        	</div>
        </div>

	</section>