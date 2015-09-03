<div class="box-body">
	<table id="postList" class="table table-responsive table-bordered table-hover">
		<thead>
			<tr>
				<th width="5%">S.N.</th>
				<th>Username</th>
				<th>Name</th>
				<th>Email</th>
				<th>Role</th>
				<th width="15%">Action</th>
			</tr>
		</thead>
		<tbody>
			<?php $count=0; foreach ($users as $user): 
				if(\App::isSuperUser($user, false)) continue;

				if($status == \user\models\User::STATUS_TRASH)
				{
					if($user->getStatus() != $status) continue;
				}

				if($status == \user\models\User::STATUS_ACTIVE)
				{
					if($user->getStatus() == \user\models\User::STATUS_TRASH || $user->getStatus() == \user\models\User::STATUS_PENDING) continue;
				}
				$count++; 
			?>
		        <tr>
					<td><?php echo $count; ?></td>
					<td><?php echo $user->getUsername(); ?></td>
					<td><?php echo ($user->getName())?: 'N/A'; ?></td>
					<td><?php echo $user->getEmail(); ?></td>
					<td><?php echo $user->getGroup()->getName(); ?></td>
					<td>
						<!-- <strong><em>This is you!</em></strong> -->
						<?php
							if($user->getUsername() == 'superadmin'):
								echo '';
							else:
								switch($user->getStatus())
	        					{
	        						case user\models\User::STATUS_PENDING :{
										if(\App::isGranted('editUser'))
											echo action_button('unblock', site_url('admin/user/activate/'.$user->getUsername()) ,array('title'	=>	'Activate '.$user->getUsername() ))."&emsp;";
	        							break;
	        						}

	        						case user\models\User::STATUS_ACTIVE :{
										if(\App::isGranted('resetPassword'))
	        						 		echo action_button('wrench',site_url('admin/user/resetPassword/'.$user->getUsername()) ,array('title'	=>	'Reset Password'))."&emsp;";
										if(\App::isGranted('editUser')):
		        						 	echo action_button('edit',site_url('admin/user/edit/'.$user->getUsername()) ,array('title'	=>	'Edit '.$user->getUsername() ))."&emsp;";
				        					echo action_button('block',site_url('admin/user/block/'.$user->getUsername()) ,array('title'  =>  'Block '.$user->getUsername() ))."&emsp;";
	        							endif;
										if(\App::isGranted('deleteUser'))
	        								echo action_button('trash',site_url('admin/user/trash/'.$user->getUsername()) ,array('title'	=>	'Delete '.$user->getUsername() ))."&emsp;";
	        							break;
	        						}
	        						case user\models\User::STATUS_BLOCK :{
										if(\App::isGranted('editUser'))
	        								echo action_button('unblock',site_url('admin/user/unblock/'.$user->getUsername()) ,array('title'  =>  'Unblock '.$user->getUsername() ))."&emsp;";
	        							break;
	        						}
	        						case user\models\User::STATUS_TRASH :{
										if(\App::isGranted('editUser'))
	        								echo action_button('unblock', site_url('admin/user/activate/'.$user->getUsername()) ,array('title'	=>	'Restore '.$user->getUsername() ))."&emsp;";
										if(\App::isGranted('deleteUser'))
	        								echo action_button('delete',site_url('admin/user/delete/'.$user->getUsername()) ,array('title'  =>  'Delete '.$user->getUsername().' permanently!' ))."&emsp;";
	        							break;
	        						}
	        					}
	        				endif;
						?>
					</td>
				</tr>
		    <?php endforeach; ?>

		    <?php if($count == 0): ?>
		    <tr>
		    	<td colspan="6" style="text-align: center;">
		    		<strong>No Users found!</strong>
		    	</td>
		    </tr>

		    <?php endif; ?>
		</tbody>
		<tfoot>
			<tr>
				<th>S.N.</th>
				<th>Username</th>
				<th>Name</th>
				<th>Email</th>
				<th>Role</th>
				<th>Action</th>
			</tr>
		</tfoot>
	</table>
</div><!-- /.box-body -->