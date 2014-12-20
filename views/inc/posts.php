<h4 class="titleBar box-class"><?php echo $_SESSION['LANG']['post_recent']; ?></h4>
   <span class="news_post"></span> 
    <ul class="posts">
   	    <?php if( $countPost != 0 ): ?>
			<div id="container-loader">
			    <div class="loading-bar"></div>
			  </div>
			   <?php endif; 
			   		 if( $countPost == 0 ): ?>
           <span class="notfound">
              <?php echo $_SESSION['LANG']['no_post_index']; ?>
                 </span>
               	<li class="watermark"></li>
			   		<?php endif; ?>
			 </ul>