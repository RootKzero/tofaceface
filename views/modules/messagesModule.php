<ul class="posts">
	<div id="container-loader">
			   			<div class="loading-bar"></div>
			   		</div>
			   		
	<?php if( $this->countMgs == 0 ): ?>
		<span class="notfound" style="display: none;"><?php echo $_SESSION['LANG']['without_msg']; ?></span>
		<?php endif; ?>
</ul>


