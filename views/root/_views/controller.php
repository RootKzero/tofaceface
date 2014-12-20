<?php
session_start();
//error_reporting(0);

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <base href="<?php echo URL_BASE ?>" target="_top" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex,nofollow">

    <title><?php echo $this->title; ?></title>

    <!-- Bootstrap core CSS -->
    <link href="<?php echo URL_BASE; ?>public/admin/css/bootstrap.css" rel="stylesheet">
	
	<!-- Main styles -->
    <link href="<?php echo URL_BASE; ?>public/admin/css/main.css" rel="stylesheet">
    
    <link rel="stylesheet" type="text/css" href="<?php echo URL_BASE; ?>public/admin/css/tables.css"/>
    <script type="text/javascript" src="<?php echo $_layoutParams['root_js']; ?>modernizr.custom.js"></script>
    <link rel="shortcut icon" href="<?php echo $_layoutParams['root_img']; ?>favicon.ico" />
    
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="js/boostrap/html5shiv.js"></script>
      <script src="js/boostrap/respond.min.js"></script>
    <![endif]-->
    
    <?php 
    //==================
	if( !isset( $idPage ) && !isset( $_GET['edit'] ) && !isset( $_GET['info_user'] ) ) { ?>
				
				
    <script type='text/javascript' src='https://www.google.com/jsapi'></script>
   
    <script type='text/javascript'>
     google.load('visualization', '1', {'packages': ['geochart']});
     google.load("visualization", "1", {packages:["corechart"]});
     google.setOnLoadCallback(drawRegionsMap);
     google.setOnLoadCallback(drawChart);

      function drawRegionsMap() {
        var data = google.visualization.arrayToDataTable([
          ['Country', 'Registered Users'],
          
          <?php 
          $totalCharts = count( $this->getCountry );
          if( $totalCharts != 0 ) {
          	foreach ($this->getCountry as $key ) {
              
			  echo "['". $key['country'] ."',".$key['total']."],";
             }
          }
           ?>
          
        ]);

        var options = {
        	backgroundColor: '#FAFAFA',
        	colorAxis: {colors: ['#FF0000', '#00FF00']}
        };
        

        var chart = new google.visualization.GeoChart(document.getElementById('chart_div'));
        chart.draw(data, options);
    };
    
    function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Task', 'Hours per Day'],
          ['Private', <?php echo $this->profilePrivate[0]['total']; ?>],
          ['Public', <?php echo $this->profilePublic[0]['total']; ?>]
        ]);

        var options = {
          backgroundColor: '#FAFAFA',
          title: 'Profiles'
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));
        chart.draw(data, options);
      };
    </script>

<?php } ?>

  </head>

  <body>

    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="<?php echo URL_BASE ?>admin/">
          	<img src="<?php echo URL_BASE; ?>public/admin/img/logo.png" class="logo">
          	</a>
        </div>
        <div class="navbar-collapse collapse">
        	
		   
				
          <ul class="nav navbar-nav navbar-right navTop">

					<li class="dropdown">
						<a href="#" class="class="dropdown-toggle" data-toggle="dropdown"">
							Hello, <strong><?php echo $this->infoUserAdmin->name; ?></strong> <img src="<?php echo URL_BASE; ?>public/admin/img/avatar.png" class="avatar_admin" width="25" height="25" /> <b class="caret"></b>
							</a>
							<ul class="dropdown-menu">
			                <li><a href="<?php echo URL_BASE ?>admin/?id=users_admin">Users</a></li>
			                <?php if( $_SESSION['id_admon'] == 1 ) : ?>
			                 <li><a href="<?php echo URL_BASE ?>admin/?id=add_user">+ Add user</a></li>
			                 <?php endif; ?>
			              </ul>
						</li>
					<li class="dropdown">
						<a href="#" class="class="dropdown-toggle" data-toggle="dropdown""><i class="glyphicon glyphicon-cog"></i> <b class="caret"></b></a>
						 <ul class="dropdown-menu">
			                <li><a href="<?php echo URL_BASE ?>admin/?id=pages">Pages</a></li>
			                <li><a href="<?php echo URL_BASE ?>admin/?id=users">Users</a></li>
			                <li><a href="<?php echo URL_BASE ?>admin/?id=users_reported">Users reported</a></li>
			                <li><a href="<?php echo URL_BASE ?>admin/?id=posts_reported">Posts reported</a></li>
			                <li><a href="<?php echo URL_BASE ?>admin/?id=ad">Advertising</a></li>
			                <li><a href="<?php echo URL_BASE ?>admin/?id=password">Password</a></li>
			                <li class="divider"></li>
			                <li><a id="logout"><i class="glyphicon glyphicon-log-out"></i> Logout</a></li>
			              </ul>
						</li>
          </ul>
          
        </div><!--/.navbar-collapse -->
      </div>
    </div>


    <div class="container">
    	
    	<?php
		
			//==================
			if( !isset( $idPage ) 
				&& !isset( $_GET['edit'] ) 
				&& !isset( $_GET['info_user'] ) 
				&& !isset( $_GET['users_admin'] )
				
			) {
				include( 'update.php' ); 
			}
			//==================
			if( $idPage == 'users' ) {
				include( 'users.php' );
		}
			//==================
			if( $idPage == 'users_reported' ) {
				include( 'users_reported.php' );
				
			}
			//==================
			if( $idPage == 'posts_reported' ) {
				include( 'post_reported.php' );
				
			}
			//==================
			if( $idPage == 'ad' ) {
				include( 'ad.php' );
				
			}
			//==================
			if( $idPage == 'pages' ) {
				include( 'pages.php' );
				
			}
			//==================
			if( $idPage == 'password' ) {
				include( 'password.php' );
				
			}
			//==================
			if( isset( $_GET['edit'] ) ) {
				include( 'edit_pages.php' );
				
			}
			
			//==================
			if( isset( $_GET['info_user'] ) ) {
				include( 'info_user.php' );
				
			}
			
			//==================
			if( $idPage == 'users_admin' ) {
				include( 'users_admin.php' );
			}

            //==================
			if( $idPage == 'add_user' ) {
				include( 'add_user.php' );
			}

			//==================
			if( $idPage == 'add_page' ) {
				include( 'add_page.php' );
			}
			
			?> 
  
      <hr>
      <footer>
        <p>&copy; Admin - <?php echo date('Y'); ?></p>
      </footer>
    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <script src="<?php echo $_layoutParams['root_js']; ?>jquery-1.7.1.min.js"></script>
    <script src="<?php echo URL_BASE; ?>public/admin/js/boostrap/bootstrap.min.js"></script>
    <script src="<?php echo $_layoutParams['root_js']; ?>jquery.easing.1.3.js"></script>
    <script src="<?php echo $_layoutParams['root_js']; ?>jquery.placeholder.1.1.1.min.js"></script>
    <script src="<?php echo $_layoutParams['root_js']; ?>jquery-ui-1.8.17.custom.min.js"></script>
    <script src="<?php echo URL_BASE; ?>public/admin/js/actions.js"></script>
    <script src="<?php echo URL_BASE; ?>public/admin/js/jquery.autosize.min.js"></script>
    <script src="<?php echo URL_BASE; ?>public/admin/js/jquery.dataTables.js"></script>
   
   <script type="text/javascript">
   
   	oTable = $('.dTable').dataTable({
		"bJQueryUI": false,
		"bAutoWidth": false,
		"sPaginationType": "full_numbers",
		"sDom": '<"H"fl>t<"F"ip>'
		<?php if( $idPage != 'users_admin' ) : ?>
		,"aaSorting": [[ 0, "desc" ]]
		<?php endif; ?>
	});
	
	$('textarea').autosize(); 
   </script>
  </body>
</html>