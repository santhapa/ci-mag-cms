<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box box-solid box-mag">
				<div class="box-header with-border">
					<h3 class="box-title"><strong>List of Post Type</strong></h3>
				</div><!-- /.box-header -->
				<div class="box-body">
					<table class="table table-striped">
						<tbody>
							<tr>
								<th width="5%">S.N.</th>
		        				<th>Post Type</th>
		        				<th>Number of Posts</th>
		        				<th width="15%">Actions</th>
							</tr>
					<?php 
						$count = 0;
						if(count($postTypes) > 0):
							foreach($postTypes as $pt): if($pt->getSlug() == 'general') continue; $count++;
							?>
							<tr>
								<td><?php echo $count;?>.</td>
								<td><?php echo $pt->getName();?></td>
        						<td><?php echo ($pt->getPosts()) ? count($pt->getPosts()) : 0 ?></td>
        						<td><?php
        							if(\App::isGranted('editPostType')):
		        						echo action_button('edit',site_url('admin/post/type/edit/'.$pt->getSlug()) ,array('title'	=>	'Edit '.$pt->getName() ))."&emsp;";
        							endif;
        							if(\App::isGranted('deletePostType')):
		        						echo action_button('delete',site_url('admin/post/type/delete/'.$pt->getSlug()) ,array('title'	=>	'Delete '.$pt->getName() ));
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
						    		<strong>No Post Types found!</strong>
						    	</td>
						    </tr>

						<?php endif; ?>
						</tbody>
						<tfoot>
							<tr>
								<th>S.N.</th>
		        				<th>Post Type</th>
		        				<th>Number of Posts</th>
		        				<th>Actions</th>
							</tr>
						</tfoot>
					</table>
				</div>
			</div><!-- /.box -->
		</div><!-- /.col -->
	</div><!-- /.row -->
</section>