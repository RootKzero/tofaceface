 <?php
 $countTrends = count(  $this->trending );
 
 if( $countTrends == 0 ) {
 	$noresult = '<li>'.$_SESSION['LANG']['no_trending'].'</li>';
 }
 
 //<--- MAX NUMBER TRENDS
 $numbMax = 2;
 if( isset( $this->trending ) && $countTrends != 0 ):
  ?>
 <!-- Grid 1 -->
	   <div class="grid_1">
	   		<!-- container_grid -->
	   		<div class="container_grid">
	   			<span class="grid_title_small"><?php echo $_SESSION['LANG']['trending']; ?></span>
	   			<ul class="trending">
	   		<?php 
	   		foreach ( $this->trending as $key ) {
	   			if( $key->total >= $numbMax ):
					++$number;
				?>
				<li>
	   					<a href="<?php echo URL_BASE."search/?q=%23".$key->trends ?>">#<?php echo $key->trends ?></a>
	   				</li>
				<?php
				endif;
				
				if( $key->total <= $numbMax && !isset( $number ) ):
					  $noresult = '<li>'.$_SESSION['LANG']['no_trending'].'</li>';
					endif;
				 }//<--- FOREACH
			   //<-- No Trends -->
			   echo $noresult;
	   		?>
	   		</ul>
	   	</div><!-- container_grid -->
   </div><!-- Grid 1 -->
   <?php endif; ?>