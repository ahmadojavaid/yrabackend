<?php
	include_once('functions.php'); 
?>

<?php

	$sql_order = "SELECT COUNT(*) as num FROM tbl_reservation";
	$total_order = mysqli_query($connect, $sql_order);
	$total_order = mysqli_fetch_array($total_order);
	$total_order = $total_order['num'];

	$sql_category = "SELECT COUNT(*) as num FROM tbl_category";
	$total_category = mysqli_query($connect, $sql_category);
	$total_category = mysqli_fetch_array($total_category);
	$total_category = $total_category['num'];

	$sql_menu = "SELECT COUNT(*) as num FROM tbl_menu";
	$total_menu = mysqli_query($connect, $sql_menu);
	$total_menu = mysqli_fetch_array($total_menu);
	$total_menu = $total_menu['num'];

    $sql_gallery = "SELECT COUNT(*) as num FROM tbl_gallery";
    $total_gallery = mysqli_query($connect, $sql_gallery);
    $total_gallery = mysqli_fetch_array($total_gallery);
    $total_gallery = $total_gallery['num'];

    $sql_news = "SELECT COUNT(*) as num FROM tbl_news";
    $total_news = mysqli_query($connect, $sql_news);
    $total_news = mysqli_fetch_array($total_news);
    $total_news = $total_news['num'];        

?>

        <!--breadcrumbs start-->
        <div id="breadcrumbs-wrapper" class=" grey lighten-3">
          <div class="container">
            <div class="row">
              <div class="col s12 m12 l12">
                <h5 class="breadcrumbs-title">Dashboard</h5>
                <ol class="breadcrumb">
                  <li><a href="dashboard.php">Dashboard</a>
                  </li>
                  <li><a href="#" class="active">Home</a>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <!--breadcrumbs end-->

        <!--start container-->
        <div class="container">
            <div class="section">

                        <!--card stats start-->
            <div id="card-stats" class="seaction">
              <div class="row">
                            <div class="col s12 m6 l3">
                            <a href="reservation.php">
                                <div class="card">
                                    <div class="card-content blue-grey white-text">
                                        <p class="card-stats-title"></i>RESERVATION</p>
                                        <h4 class="card-stats-number"><?php echo $total_order;?></h4>
                                        <p class="card-stats-compare"><span class="green-text text-lighten-5">Reservation</span>
                                        </p>
                                    </div>
                                    <div class="card-action  blue-grey darken-2">
                                        <div id="clients-bar"></div>
                                    </div>
                                </div>
                            </a>
                            </div>

                            <div class="col s12 m6 l3">
                            <a href="category.php">
                                <div class="card">
                                    <div class="card-content blue-grey white-text">
                                        <p class="card-stats-title">CATEGORY</p>
                                        <h4 class="card-stats-number"><?php echo $total_category;?></h4>
                                        <p class="card-stats-compare"><span class="green-text text-lighten-5">Total Category</span>
                                        </p>
                                    </div>
                                    <div class="card-action  blue-grey darken-2">
                                        <div id="clients-bar"></div>
                                    </div>
                                </div>
                            </a>
                            </div>

                            <div class="col s12 m6 l3">
                            <a href="menu.php">
                                <div class="card">
                                    <div class="card-content blue-grey white-text">
                                        <p class="card-stats-title">RESTAURANT MENU</p>
                                        <h4 class="card-stats-number"><?php echo $total_menu;?></h4>
                                        <p class="card-stats-compare"><span class="purple-text text-lighten-5">Total Menu</span>
                                        </p>
                                    </div>
                                    <div class="card-action  blue-grey darken-2">
                                        <div id="clients-bar"></div>
                                    </div>
                                </div>
                            </a>
                            </div>

                            <div class="col s12 m6 l3">
                            <a href="gallery.php">
                                <div class="card">
                                    <div class="card-content blue-grey white-text">
                                        <p class="card-stats-title">GALLERY</p>
                                        <h4 class="card-stats-number"><?php echo $total_gallery;?></h4>
                                        <p class="card-stats-compare"><span class="purple-text text-lighten-5">Total Gallery</span>
                                        </p>
                                    </div>
                                    <div class="card-action  blue-grey darken-2">
                                        <div id="clients-bar"></div>
                                    </div>
                                </div>
                            </a>
                            </div>

                            <div class="col s12 m6 l3">
                            <a href="news.php">
                                <div class="card">
                                    <div class="card-content blue-grey white-text">
                                        <p class="card-stats-title">NEWS</p>
                                        <h4 class="card-stats-number"><?php echo $total_news;?></h4>
                                        <p class="card-stats-compare"><span class="purple-text text-lighten-5">Total News</span>
                                        </p>
                                    </div>
                                    <div class="card-action  blue-grey darken-2">
                                        <div id="clients-bar"></div>
                                    </div>
                                </div>
                            </a>
                            </div>

                            <div class="col s12 m6 l3">
                            <a href="#push-notification" class="modal-trigger" target="_blank">
                                <div class="card">
                                    <div class="card-content blue-grey white-text">
                                        <p class="card-stats-title">PUSH NOTIFICATION</p>
                                        <h4 class="card-stats-number"><i class="mdi-social-notifications"></i></h4>
                                        <p class="card-stats-compare"><span class="deep-purple-text text-lighten-5">Go to Firebase Console</span>
                                        </p>
                                    </div>
                                    <div class="card-action  blue-grey darken-2">
                                        <div id="clients-bar"></div>
                                    </div>
                                </div>
                            </a>
                            </div> 

                            <div class="col s12 m6 l3">
                            <a href="setting.php">
                                <div class="card">
                                    <div class="card-content blue-grey white-text">
                                        <p class="card-stats-title">TAX & CURRENCY</p>
                                        <h4 class="card-stats-number"><i class="mdi-editor-attach-money"></i></h4>
                                        <p class="card-stats-compare"><span class="blue-grey-text text-lighten-5">Manage Tax & Currency</span>
                                        </p>
                                    </div>
                                    <div class="card-action  blue-grey darken-2">
                                        <div id="clients-bar"></div>
                                    </div>
                                </div>
                            </a>
                            </div>                                                          

                            <div class="col s12 m6 l3">
                            <a href="admin.php">
                                <div class="card">
                                    <div class="card-content blue-grey white-text">
                                        <p class="card-stats-title">SETTING</p>
                                        <h4 class="card-stats-number"><i class="mdi-action-settings"></i></h4>
                                        <p class="card-stats-compare"><span class="blue-grey-text text-lighten-5">Manage Setting</span>
                                        </p>
                                    </div>
                                    <div class="card-action  blue-grey darken-2">
                                        <div id="clients-bar"></div>
                                    </div>
                                </div>
                            </a>
                            </div>                           
                           
                        </div>
            </div>
    </div>
</div>