<?php 
    include('models/thumbClass.php');
	$explode = explode( '-',$_GET['x'] );
	$x     = $explode[0];
	$y     = $explode[1];
	$file  = $explode[2];
    $image = new thumbnail( $file ); 
    $image->size( $x, $y ); 
    $image->show();
?>