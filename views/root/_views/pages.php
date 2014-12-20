<div class="row">
  <div class="col-md-8" style="width: 100%;">
	<div>
          <h4><a href="<?php echo URL_BASE ?>admin/"><i class="glyphicon glyphicon-home"></i></a> &raquo; Pages
          	<a class="btn btn-primary" href="admin/?id=add_page">
          	+<i class="glyphicon glyphicon-file"></i> Add page
          </a>
          	</h4>
          <hr />

		</div>
<table cellpadding="0" cellspacing="0" border="0" class="dTable">
                <thead>
                <tr>
                	<th>Title</th>
                	<th>Page (Url)</th>
		            <th>Actions</th>
                </tr>
                </thead>
                <tbody>
        
        <?php foreach ( $this->allPages as $key ) {
            ?>
            <tr>
            	<td><?php echo $key['title']; ?></td>
            	<td><?php echo $key['url']; ?></td>
            	<td><a href="admin/?edit=<?php echo $key['id']; ?>">Edit Page</a></td>
				</tr>
            <?php
        } ?>
				
       </tbody>
</table> 

  </div>
	
</div><!-- End Row -->