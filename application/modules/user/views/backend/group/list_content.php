<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box box-solid box-mag">
				<div class="box-header with-border">
					<h3 class="box-title"><strong>List of Groups</strong></h3>
				</div><!-- /.box-header -->
				<div class="box-body">
					<table class="table table-striped">
						<tbody>
							<tr>
								<th width="5%">S.N.</th>
		        				<th>Group Name</th>
		        				<th>Number of Users</th>
		        				<th width="15%">Actions</th>
							</tr>
					<?php 
						if(count($groups) > 0):
							$count = 0;
							foreach($groups as $g): if($g->getSlug() == 'super_admin') continue; $count++;
							?>
							<tr>
								<td><?php echo $count;?>.</td>
								<td><?php echo $g->getName();?></td>
        						<td><?php echo ($g->getUsers()) ? count($g->getUsers()) : 0 ?></td>
        						<td><?php
        							if(\App::isGranted('moderatePermission'))
	        							echo action_button('permissions',site_url('admin/user/group/permissions/'.$g->getSlug()) ,array('title'	=>	'Edit '.$g->getSlug().' Permissions' ))."&emsp;";
        							
        							if(\App::isGranted('manageUserGroup')):
		        						echo action_button('edit',site_url('admin/user/group/edit/'.$g->getSlug()) ,array('title'	=>	'Edit '.$g->getSlug() ))."&emsp;";
		        						echo action_button('delete',site_url('admin/user/group/delete/'.$g->getSlug()) ,array('title'	=>	'Delete '.$g->getSlug() ));
									endif;
								?>
        						</td>
        					</tr>
        					<?php 
        					endforeach;
        				endif; ?>
        				<?php if($count == 0): ?>
						    <tr>
						    	<td colspan="6" style="text-align: center;">
						    		<strong>No Groups found!</strong>
						    	</td>
						    </tr>

						<?php endif; ?>
						</tbody>
						<tfoot>
							<tr>
								<th>S.N.</th>
		        				<th>Group Name</th>
		        				<th>Number of Users</th>
		        				<th>Actions</th>
							</tr>
						</tfoot>
					</table>
				</div>
			</div><!-- /.box -->
		</div><!-- /.col -->
	</div><!-- /.row -->
</section>

<script>
$(function(){
		
	$('.fa-trash').click(function(){
		return confirm('Are you sure to delete this Group?');
	});

	$('.fa-ban').click(function(){
		return confirm('Are you sure to block this Group?');
	});

	$('.fa-check-square-o').click(function(){
		return confirm('Are you sure to unblock this Group?');
	});

});
				
</script>