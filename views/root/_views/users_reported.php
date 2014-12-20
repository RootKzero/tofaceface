<div class="row">
<div class="col-md-8" style="width: 100%;">
	<div>
		<h4><a href="<?php echo URL_BASE ?>admin/"><i class="glyphicon glyphicon-home"></i></a> &raquo; Users reported</h4>
         <hr />
     </div>

	<table cellpadding="0" cellspacing="0" border="0" class="dTable">
                <thead>
                <tr>
                	<th><span class="sorting" style="display: block;"></span># ID</th>
                	<th>Report By</th>
		            <th>User reported</th>
		            <th>Date</th>
                </tr>
                </thead>
                <tbody>
                	 	<?php
               	foreach ( $this->usersReported as $key )
               	{
               		
				?>
               <tr>
              
				<td><?php echo $key['report_id'] ?></td>
				<td><a target="_blank" href="admin/?info_user=<?php echo $key['id'] ?>">@<?php echo $key['username'] ?></a></td>
				<td><a target="_blank" href="admin/?info_user=<?php echo $key['r_id'] ?>">@<?php echo $key['r_username'] ?></a></td>
				<td><?php echo date( 'y/m/d',strtotime(  $key['date'] ) ) ?></td>
		
                	</tr>
                	
                	       <?php	   
				}
               	 ?>  
               	     
                	</tbody>
                </table> 

	</div>
</div><!-- End row -->