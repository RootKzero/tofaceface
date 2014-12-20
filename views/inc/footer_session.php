<span class="grid_title_small" style="margin-bottom: 0;">&copy; <?php echo date('Y')." ".SITE_NAME; ?></span>

<div class="footer_responsive">
	<?php foreach( $this->pagesGeneral as $key ) : ?>
    	<a class="link_small" href="<?php echo URL_BASE.$key['url'].'/'; ?>"><?php echo stripslashes( $key['title'] ); ?></a>
	<?php endforeach; ?>
		
</div>