<div class="box-body">
	<table id="postList" class="table table-bordered table-hover">
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
			<?php $count=0; foreach ($users as $user): $count++; 
				if($status == \user\models\User::STATUS_TRASH)
				{
					if($user->getStatus() != $status) continue;
				}

				if($status == \user\models\User::STATUS_ACTIVE)
				{
					if($user->getStatus() == \user\models\User::STATUS_TRASH || $user->getStatus() == \user\models\User::STATUS_PENDING) continue;
				}

			?>
		        <tr>
					<td><?=$count; ?></td>
					<td><?=$user->getUsername(); ?></td>
					<td><?=($user->getName())?: 'N/A'; ?></td>
					<td><?=$user->getEmail(); ?></td>
					<td><?=$user->getGroup()->getName(); ?></td>
					<td>
						<!-- <strong><em>This is you!</em></strong> -->
						<?php
							switch($user->getStatus())
        					{
        						case user\models\User::STATUS_PENDING :{
        							echo action_button('edit', site_url('admin/user/edit/'.$user->getUsername()) ,array('title'	=>	'Edit '.$user->getUsername() ))."&emsp;";
        							break;
        						}

        						case user\models\User::STATUS_ACTIVE :{
        						 	echo action_button('wrench',site_url('admin/user/resetpwd/'.$user->getUsername()) ,array('title'	=>	'Reset Password'))."&emsp;";
        						 	echo action_button('edit',site_url('admin/user/edit/'.$user->getUsername()) ,array('title'	=>	'Edit '.$user->getUsername() ))."&emsp;";
		        					echo action_button('block',site_url('admin/user/block/'.$user->getUsername()) ,array('title'  =>  'Block '.$user->getUsername() ))."&emsp;";
        							echo action_button('trash',site_url('admin/user/trash/'.$user->getUsername()) ,array('title'	=>	'Delete '.$user->getUsername() ))."&emsp;";
        							break;
        						}
        						case user\models\User::STATUS_BLOCK :{
        							echo action_button('unblock',site_url('admin/user/unblock/'.$user->getUsername()) ,array('title'  =>  'Unblock '.$user->getUsername() ))."&emsp;";
        							break;
        						}
        						case user\models\User::STATUS_TRASH :{
        							echo action_button('delete',site_url('admin/user/delete/'.$user->getUsername()) ,array('title'  =>  'Delete '.$user->getUsername().' permanently!' ))."&emsp;";
        							break;
        						}
        					}
						?>
					</td>
				</tr>
		    <?php endforeach; ?>
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