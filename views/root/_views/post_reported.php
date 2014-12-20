<div class="row">
 <div class="col-md-8" style="width: 100%;">
	<div>
		<h4><a href="<?php echo URL_BASE ?>admin/"><i class="glyphicon glyphicon-home"></i></a> &raquo; Posts reported</h4>
         <hr />
     </div>

	<table cellpadding="0" cellspacing="0" border="0" class="dTable">
                <thead>
                <tr>
                	<th><span class="sorting" style="display: block;"></span># ID</th>
                	<th>Report By</th>
		            <th>Post reported</th>
		            <th>Date</th>
		            <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                	 	<?php
               	foreach ( $this->postsReported as $key )
               	{
               		if( $key['status'] == 0 )
					{
						$status = 'Deleted';
					}
					else {
						$status = 'Active';
					}
               		
				?>
               <tr>
              
				<td><?php echo $key['report_id'] ?></td>
				<td class="center"><a target="_blank" href="<?php echo URL_BASE.$key['username'] ?>">@<?php echo $key['username'] ?></a></td>
				<td class="center">
					<?php if( $key['status'] != '0'  ): ?>
					<a target="_blank" href="<?php echo URL_BASE.$key['r_username']."/status/".$key['id_post'] ?>">
						View <i class="glyphicon glyphicon-new-window"></i></a>
						<?php
					else:
						?>
						-------
						<?php
						 endif; ?>
						</td>
				<td class="center"><?php echo date( 'y/m/d',strtotime(  $key['date'] ) ) ?></td>
						 <td>
				 
               	 	<?php if( $key['status'] != '0'  ): ?>
               	 	<a data-id="<?php echo $key['id_post'] ?>" class="icons deletePost" title="Delete">Delet</a>
               	 	<?php
					else:
						?>
						----------
						<?php
						 endif; ?>
               	 	
               	 </td>  
                	</tr>
                	
                	       <?php	   
				}
               	 ?>  
               	     
                	</tbody>
                </table> 

	</div>
</div><!-- End row -->