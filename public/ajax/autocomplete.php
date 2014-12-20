<?php
session_start();
error_reporting(0);
if( 
	isset ( $_GET['look'] )
) {
  if( isset( $_GET ) && $_SERVER['REQUEST_METHOD'] == "GET" ) {
	
	/*
	 * --------------------------
	 *   Require/Include Files
	 * -------------------------
	 */
	require_once('../../class_ajax_request/classAjax.php');
	include_once('../../application/functions.php'); 
	include_once('../../application/DataConfig.php');	
	/*
	 * ----------------------
	 *   Instance Class
	 * ----------------------
	 */
	$obj              = new AjaxRequest();
	$response         = $obj->searchUsers( $_GET['look'], ' 
	&& U.status = "active"', 'LIMIT 5 ', $_SESSION['authenticated'] );
	
	$responseTotal    = $obj->searchUsers( $_GET['look'], ' 
	&& U.status = "active"', null, $_SESSION['authenticated'] );
	
	$countPosts      = count( $response );
	$countPostsTotal = count( $responseTotal );
	$words           = str_replace( '#', '%23', strip_tags( $_GET['look'] ) );
	
   		 if( $countPosts != 0 ) : 
			 foreach ( $response as $key ) {
			 	//============ VERIFIED
				if( $key['type_account'] == '1' ) {
					$verified = ' <img style="vertical-align: middle;" src="'.URL_BASE.'public/img/verified_min.png">';
				} else {
					$verified = null;
				}
				$checkBlock      = $obj->checkUserBlock( $_SESSION['authenticated'], $key['id'] ); ?>
			   		<li class="list" data-href="<?php echo URL_BASE.$key['username']; ?>">
			   			<a href="<?php echo URL_BASE.$key['username']; ?>"> 
			   				<img style="vertical-align: middle; border-radius: 3px; -webkit-border-radius: 3px; margin-right: 3px;" src="<?php echo URL_BASE."thumb/24-24-public/avatar/".$key['avatar']; ?>">
			   			 	
			   			 	<span style="line-height: 18px;">
			   			 		<strong><?php echo stripslashes( $key['name'] ).$verified; ?></strong>
			   					<strong style="font-weight: normal; font-size: 12px; vertical-align: 0; float: none;">@<?php echo $key['username']; ?></strong>
			   			 	</span>
			   				</a>
		   		</li><?php }//<<<-- Foreach
		   		if( $countPostsTotal > 5 ) {
		   			?>
		   			<li class="list" style="border-top: 1px solid #DDD;">
		   				<a href="search/?user=true&q=<?php echo $words; ?>" style="padding-top: 8px; padding-bottom: 8px;">
		   					<?php echo $_SESSION['LANG']['search_all']; ?> <strong><?php echo htmlentities( $_GET['look'] ); ?></strong> &raquo;
		   				</a>
		   			</li>
		   			<?php
		   		}
?>
<?php
		else: ?>
		<li class="list">
			<span class="notfound_auto"><?php echo $_SESSION['LANG']['no_results']; ?></span>
			
			</li>
		<?php
		   		endif;  //<<<--- $countPosts != 0
     }//<--
}//<-- ISSET
?>