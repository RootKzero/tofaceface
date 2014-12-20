<div class="row">
	<div class="col-md-8" style="width: 100%;">
	<div>
          <h4>
          	<a href="<?php echo URL_BASE ?>admin/"><i class="glyphicon glyphicon-home"></i></a> &raquo; Users Admin 
          	<?php
          	if( $_SESSION['id_admon'] == 1 ) {
          		?>
          		<a class="btn btn-primary" href="admin/?id=add_user">
          	+<i class="glyphicon glyphicon-user"></i> Add user
          </a>
          		<?php
          	}
          	 ?>
          	</h4>
          <hr />
          
		</div>

	<table cellpadding="0" cellspacing="0" border="0" class="dTable">
                <thead>
                <tr>
                	<th><span class="sorting" style="display: block;"></span># ID</th>
                	<th>Name</th>
                	<th>User</th>
		            <th>Status</th>
		            <th>Actions</th>
		           
                </tr>
                </thead>
                <tbody>
                <?php
                 foreach ( $this->usersAdmin as $row ) { ?>
               <tr>
				<td><?php echo $row['id'] ?></td>
				<td><?php echo $row['name'] ?></td>
				<td>@<?php echo $row['user'] ?></td>
				<td class="statusTd"><?php echo ucfirst( $row['status'] ) ?></td>
				<td class="statusTd">
					<?php if( $row['id'] != 1 && $_SESSION['id_admon'] == 1 ) : ?>
						<a title="Delete" href="javascript:void(0);" data-id="<?php echo $row['id'] ?>" id="deleteUsers">
						<i class="glyphicon glyphicon-remove"></i>
					</a>
						<?php
else:
	?>
	-
	<?php endif; ?>
				</td>
			   </tr>
                <?php } ?>  
               	     
                	</tbody>
                </table> 

	</div>
</div><!-- End row -->