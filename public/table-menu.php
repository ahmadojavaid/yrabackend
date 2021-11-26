<?php 
	include_once('functions.php'); 
?>

	<?php 
		// create object of functions class
		$function = new functions;
		
		// create array variable to store data from database
		$data = array();
		
		if(isset($_GET['keyword'])){	
			// check value of keyword variable
			$keyword = $function->sanitize($_GET['keyword']);
			$bind_keyword = "%".$keyword."%";
		}else{
			$keyword = "";
			$bind_keyword = $keyword;
		}
		
		// get currency symbol from setting table
		$sql_query = "SELECT Value 
				FROM tbl_setting 
				WHERE Variable = 'Currency'";
		
		$stmt = $connect->stmt_init();
		if($stmt->prepare($sql_query)) {	
			// Execute query
			$stmt->execute();
			// store result 
			$stmt->store_result();
			$stmt->bind_result($currency);
			$stmt->fetch();
			$stmt->close();
		}	
		
		// get all data from menu table and category table
		if(empty($keyword)){
			$sql_query = "SELECT menu_id, menu_name, category_name, price, menu_status, menu_image, serve_for 
					FROM tbl_menu m, tbl_category c
					WHERE m.category_id = c.category_id  
					ORDER BY m.menu_id DESC";
		}else{
			$sql_query = "SELECT menu_id, menu_name, category_name, price, menu_status, menu_image, serve_for  
					FROM tbl_menu m, tbl_category c
					WHERE m.category_id = c.category_id AND menu_name LIKE ? 
					ORDER BY m.menu_id DESC";
		}
		
		$stmt = $connect->stmt_init();
		if($stmt->prepare($sql_query)) {	
			// Bind your variables to replace the ?s
			if(!empty($keyword)){
				$stmt->bind_param('s', $bind_keyword);
			}
			// Execute query
			$stmt->execute();
			// store result 
			$stmt->store_result();
			$stmt->bind_result($data['menu_id'], 
					$data['menu_name'], 
					$data['category_name'],
					$data['price'], 
					$data['menu_status'],
					$data['menu_image'],
					$data['serve_for']
					);
					
			// get total records
			$total_records = $stmt->num_rows;
		}
		
		// check page parameter
		if(isset($_GET['page'])){
			$page = $_GET['page'];
		}else{
			$page = 1;
		}
		
		// number of data that will be display per page		
		$offset = 10;
						
		//lets calculate the LIMIT for SQL, and save it $from
		if ($page){
			$from 	= ($page * $offset) - $offset;
		}else{
			//if nothing was given in page request, lets load the first page
			$from = 0;	
		}
		
		// get all data from reservation table
		if(empty($keyword)){
			$sql_query = "SELECT menu_id, menu_name, category_name, price, menu_status, menu_image, serve_for  
					FROM tbl_menu m, tbl_category c
					WHERE m.category_id = c.category_id  
					ORDER BY m.menu_id DESC LIMIT ?, ?";
		}else{
			$sql_query = "SELECT menu_id, menu_name, category_name, price, menu_status, menu_image, serve_for  
					FROM tbl_menu m, tbl_category c
					WHERE m.category_id = c.category_id AND menu_name LIKE ? 
					ORDER BY m.menu_id DESC LIMIT ?, ?";
		}
		
		$stmt_paging = $connect->stmt_init();
		if($stmt_paging ->prepare($sql_query)) {
			// Bind your variables to replace the ?s
			if(empty($keyword)){
				$stmt_paging ->bind_param('ss', $from, $offset);
			}else{
				$stmt_paging ->bind_param('sss', $bind_keyword, $from, $offset);
			}
			// Execute query
			$stmt_paging ->execute();
			// store result 
			$stmt_paging ->store_result();
			
			$stmt_paging->bind_result($data['menu_id'], 
					$data['menu_name'], 
					$data['category_name'],
					$data['price'], 
					$data['menu_status'],
					$data['menu_image'],
					$data['serve_for']
					);
			
			// for paging purpose
			$total_records_paging = $total_records; 
		}

		// if no data on database show "No Reservation is Available"
		if($total_records_paging == 0){
	
	?>

	<!-- START CONTENT -->
    <section id="content">

        <!--breadcrumbs start-->
        <div id="breadcrumbs-wrapper" class=" grey lighten-3">
          	<div class="container">
            	<div class="row">
              		<div class="col s12 m12 l12">
               			<h5 class="breadcrumbs-title">Menu List</h5>
		                <ol class="breadcrumb">
		                  <li><a href="dashboard.php">Dashboard</a>
		                  </li>
		                  <li><a href="#" class="active">Manage Menu</a>
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
				<div class="col s12 m12 l9">
				    <div class="row">
				        <form method="get" class="col s12">
				            <div class="row">
				                <table>
				                	<tr>
				                		<td width="25%">
				                			<div class="input-field col s12">
							                    <a href="add-menu.php" class="btn waves-effect waves-light indigo">Add New Menu</a>
							                </div>
				                		</td>
				                		<td width="40%">
				                			<div class="input-field col s12">
							                    <input type="text" class="validate" name="keyword">
							                    <label for="first_name">Search by name :</label>
							                </div>
				                		</td>
				                		<td>
				                			<div class="input-field col s12">
							                	<button type="submit" name="btnSearch" class="btn-floating btn-large waves-effect waves-light"><i class="mdi-action-search"></i></button>
							                </div>
				                		</td>
				                	</tr>
				                </table>
				             </div>
				        </form>
				    </div>
				</div>


				<div class="col s12 m12 l9">
				    <div class="row">
				        <form method="get" class="col s12">
				            <div class="row">
								<div class="input-field col s12">
				                    <h5>No Menu Found!</h5>
				                </div>
				             </div>
				        </form>
				    </div>
				</div>
			</div>
		</div>
	</section>
	<br><br><br><br><br><br><br><br><br><br>
	
	<?php 
		// otherwise, show data
		}else{
			$row_number = $from + 1;
	?>

	<!-- START CONTENT -->
    <section id="content">

        <!--breadcrumbs start-->
        <div id="breadcrumbs-wrapper" class=" grey lighten-3">
          	<div class="container">
            	<div class="row">
              		<div class="col s12 m12 l12">
               			<h5 class="breadcrumbs-title">Menu List</h5>
		                <ol class="breadcrumb">
		                  <li><a href="dashboard.php">Dashboard</a>
		                  </li>
		                  <li><a href="#" class="active">Manage Menu</a>
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
				<div class="col s12 m12 l9">
				    <div class="row">
				        <form method="get" class="col s12">
				            <div class="row">
				                <table>
				                	<tr>
				                		<td width="25%">
				                			<div class="input-field col s12">
							                    <a href="add-menu.php" class="btn waves-effect waves-light indigo">Add New Menu</a>
							                </div>
				                		</td>
				                		<td width="40%">
				                			<div class="input-field col s12">
							                    <input type="text" class="validate" name="keyword">
							                    <label for="first_name">Search by name :</label>
							                </div>
				                		</td>
				                		<td>
				                			<div class="input-field col s12">
							                	<button type="submit" name="btnSearch" class="btn-floating btn-large waves-effect waves-light"><i class="mdi-action-search"></i></button>
							                </div>
				                		</td>
				                	</tr>
				                </table>
				             </div>
				        </form>
				    </div>
				</div>
            
				<div class="row">
		            <div class="col s12 m12 l12">
		              	<div class="card-panel">
		                	<div class="row">
		                  		<div class="row">
		                    		<div class="input-field col s12">
	
										<table class='hoverable bordered'>
										<thead>
											<tr>
												<th>Name</th>
												<th>Image</th>
												<th>Status</th>
												<th>Serve for</th>
												<th>price</th>
												<th>Category</th>
												<th>Action</th>
											</tr>
										</thead>

											<?php 
												while ($stmt_paging->fetch()){ ?>
												<tbody>
													<tr>
														<td><?php echo $data['menu_name'];?></td>
														<td><img src="<?php echo $data['menu_image']; ?>" width="60" height="40"/></td>
														<td>

														<?php if($data['menu_status'] == 'Sold Out') { ?>
															<span class='white-text red lighten-2'>&nbsp;&nbsp;SOLDOUT&nbsp;&nbsp;</span>
															<?php } else if($data['menu_status'] == 'Available') {?>
															<span class='white-text green lighten-2'>&nbsp;&nbsp;AVAILABLE&nbsp;&nbsp;</span>
															<?php } else {?>
															<span class='white-text black lighten-2'>&nbsp;&nbsp;UNKNOWN&nbsp;&nbsp;</span>
															<?php } ?>
														</td>


														<td><?php echo $data['serve_for'];?> People</td>
														<td><?php echo $data['price']." ".$currency;?></td>
														<td><?php echo $data['category_name'];?></td>
														<td>
															<a href="menu-detail.php?id=<?php echo $data['menu_id'];?>">
															<i class="mdi-action-pageview"></i>
															</a>					
															<a href="edit-menu.php?id=<?php echo $data['menu_id'];?>">
															<i class="mdi-editor-mode-edit"></i>
															</a>
															<a href="delete-menu.php?id=<?php echo $data['menu_id'];?>">
															<i class="mdi-action-delete"></i>
															</a>															
														</td>
													</tr>
												</tbody>
													<?php 
													} 
												}
											?>
										</table>

										<h4><?php $function->doPages($offset, 'menu.php', '', $total_records, $keyword); ?></h4>

		                    		</div>
		                  		</div>
		                	</div>
		              	</div>
		            </div>
		        </div>
        	</div>
        </div>

	</section>
					
				