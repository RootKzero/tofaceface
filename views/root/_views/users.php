<div class="row">
<div class="col-md-8" style="width: 100%;">
	<div>
          <h4><a href="<?php echo URL_BASE ?>admin/"><i class="glyphicon glyphicon-home"></i></a> &raquo; Users (<?php echo $this->countUserGrid ?>)</h4>
          <hr />

		</div>

	<table cellpadding="0" cellspacing="0" border="0" class="dTable">
                <thead>
                <tr>
                	<th><span class="sorting" style="display: block;"></span># ID</th>
                	<th>Name</th>
		            <th>Type account</th>
		            <th>Status</th>
		           
                </tr>
                </thead>
                <tbody>
                	 	<?php
               	foreach ( $this->usersGrid as $key )
               	{
               		if( $key['type_account'] == 0 )
					{
						$chk2 = null;
						$chk = 'checked="checked"';
					}
					else {
						$chk  = null;
						$chk2 = 'checked="checked"';
					}
				?>
               <tr>
              
				<td><?php echo $key['id'] ?></td>
				<td><img style="vertical-align: middle;" src="<?php echo URL_BASE; ?>thumb/18-18-public/avatar/<?php echo $key['avatar'] ?>"> 
					<a href="admin/?info_user=<?php echo $key['id'] ?>">
						@<?php echo $key['username'] ?>
					</a>
					</td>
				<td>
					<?php if( $key['status'] != 'delete' ): ?>
					Normal
					<input class="radioAccount" data-id="<?php echo $key['id'] ?>" type="radio" value="0" <?php echo $chk; ?> name="chk_account_<?php echo $key['id'] ?>" />
					Verified
					<input class="radioAccount" data-id="<?php echo $key['id'] ?>"  type="radio" value="1" <?php echo $chk2; ?> name="chk_account_<?php echo $key['id'] ?>" />
					<?php
					else :
						?>
						--------------------------------
						<?php
					 endif; ?>
				</td>		
				<td class="statusTd"><?php echo ucfirst( $key['status'] ) ?></td>
				 
                	</tr>
                	
                	       <?php	   
				}
               	 ?>  
               	     
                	</tbody>
                </table> 

	</div>
</div><!-- End row -->