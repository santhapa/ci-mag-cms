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
	        						echo action_button('permissions',site_url('admin/user/group/permissions/'.$g->getSlug()) ,array('title'	=>	'Edit '.$g->getSlug().' Permissions' ))."&emsp;";
	        						echo action_button('edit',site_url('admin/user/group/edit/'.$g->getSlug()) ,array('title'	=>	'Edit '.$g->getSlug() ))."&emsp;";
	        						echo action_button('delete',site_url('admin/user/group/delete/'.$g->getSlug()) ,array('title'	=>	'Delete '.$g->getSlug() ));
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

<script type="text/javascript">
// $(function(){
// 	$('.clone-group').click(function(e){
// 		e.preventDefault();
// 		var _id = $(this).attr('id').split('-'),
// 			gid = _id[1];		
// 		$('.wrapper').mask("Please wait while we copy the group.");

// 		$.ajax({
// 			type	:'GET',
// 			url		:'<?php echo base_url().'user/group/copygroup/'?>'+gid,
// 			data	:null,
// 			success	:function(res){
// 				res = $.parseJSON(res);
// 				$('.wrapper').unmask();
// 				if(res.response == 'success'){
// 					window.location = '<?php echo base_url().'user/group/edit/'?>'+res.group_id;
// 				}else{
// 					alert('An error occurred while copying the group. Please try again.');
// 				}
// 			},
// 			failure	:function(){
// 			},			
// 		});
// 	});
// });
</script>


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