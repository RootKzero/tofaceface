	<h4 class="titleBar box-class" id="query_data" data-query="<?php echo htmlentities( strip_tags( $_GET['q'], ENT_QUOTES ) ); ?>">
		<?php echo $_SESSION['LANG']['result_of']; ?> 
		<em style="color: #999;"><?php echo htmlentities( strip_tags( $_GET['q'] ), ENT_QUOTES,'UTF-8' ); ?></em>	
		<?php echo $this->titleH4; ?>
	</h4>
	 <span class="news_post"></span> 
	   	<ul class="posts">
	   		<div id="container-loader">
	   			<div class="loading-bar"></div>
	   		</div>
	   		
	   		<?php
	   		if( $countPost == 0 ): 
	   		?>
       	<span class="notfound" style="display: none;">
       		<?php echo $_SESSION['LANG']['no_results']; ?>
       	</span>
	   		<?php endif; ?>
	   	</ul>