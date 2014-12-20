<?php 
/*----------------------------------------------
 *  SHOW NUMBER NOTIFICATIONS IN BROWSER ( 1 )
 * --------------------------------------------
 */
if( $this->notiMsg->total != 0 &&  $this->notiIntera->total != 0 ) {
	$totalNotifications = '('.( $this->notiMsg->total + $this->notiIntera->total ).') ';
} else if( $this->notiMsg->total == 0 &&  $this->notiIntera->total != 0  ) {
	$totalNotifications = '('.$this->notiIntera->total.') ';
} else if ( $this->notiMsg->total != 0 &&  $this->notiIntera->total == 0 ) {
	$totalNotifications = '('.$this->notiMsg->total.') ';
} else {
	$totalNotifications = null;
}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<base href="<?php echo URL_BASE; ?>" target="_top" />
		<title><?php echo $totalNotifications; if( isset( $this->title ) ) : echo $this->title.' - '; endif; ?><?php echo SITE_NAME; ?></title>
		<meta name="description" content="<?php echo DESCRIPTION_SITE; ?>" />
		<meta name="keywords" content="<?php echo KEYWORDS_SITE; ?>" />
		<link href="<?php echo $_layoutParams['root_css']; ?>styles.css" rel="stylesheet" type="text/css" />
		<link rel="stylesheet" type="text/css" href="<?php echo $_layoutParams['root_css']; ?>reset.css" charset="UTF-8" />
		<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0" />
		<script type="text/javascript" src="<?php echo $_layoutParams['root_js']; ?>modernizr.custom.js"></script>		
		<link rel="shortcut icon" href="<?php echo $_layoutParams['root_img']; ?>favicon.ico" />
		<!--[if lt IE 9]>
          <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]--> 
<?php if( Session::get( 'authenticated' ) ): ?>
<script type="text/javascript">
        
//<----- Notifications
function Notifications() {	
	
	 var _title = '<?php if( isset( $this->title ) ) : echo addslashes( $this->title ).' - '; endif; ?><?php echo addslashes( SITE_NAME ); ?>';
	 console.time('cache');
	 $.get("public/ajax/notifications.php", function( data ) {	
		if ( data ) {
			//* Messages */
			if( data.messages != 0 ) {
				
				var totalMsg = data.messages;
				
				$('#noti_msg').fadeIn().html(data.messages);
			} else {
				$('#noti_msg').fadeOut().html('');
				
				if(  data.interactions == 0 ) {
					 $('title').html( _title );
				}
			}
			
			//* Interactions */
			if( data.interactions != 0 ) {
				
				var totalIntera = data.interactions;
				$('#noti_connect').fadeIn().html(data.interactions);
			}
			
			//* Error */
			if( data.error == 1 ) {
				window.location.reload();
			}
			
			var totalGlobal = parseInt( totalMsg ) + parseInt( totalIntera );
		
		if( data.interactions != 0 && data.messages != 0 ) {
		    $('title').html( "("+ totalGlobal + ") " + _title );
		  } else if( data.interactions != 0 && data.messages == 0 ) {
		    $('title').html( "("+ data.interactions + ") " + _title );
		  } else if( data.interactions == 0 && data.messages != 0 ) {
		    $('title').html( "("+ data.messages + ") " + _title );
		  } 
		
		}//<-- DATA
	     	
		},'json');
		
		console.timeEnd('cache'); 
}//End Function TimeLine
	
timer = setInterval("Notifications()", 10000);
        </script>
            <?php endif; ?>