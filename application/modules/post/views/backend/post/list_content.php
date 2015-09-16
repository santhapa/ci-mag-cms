<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box box-solid box-mag">
				<div class="box-header with-border">
					<h3 class="box-title"><strong>List of Category</strong></h3>
				</div><!-- /.box-header -->
				<div class="box-body">
					<table class="table table-striped">
						<tbody>
							<tr>
								<th width="5%">S.N.</th>
		        				<th>Category</th>
		        				<th>Number of Posts</th>
		        				<th width="15%">Actions</th>
							</tr>
					<?php 
						$count = 0;
						if(count($categorys) > 0):
							foreach($categorys as $cat): if($cat->getSlug() == 'uncategorized') continue; $count++;
							?>
							<tr>
								<td><?php echo $count;?>.</td>
								<td><?php echo $cat->getName();?></td>
        						<td><?php echo ($cat->getPosts()) ? count($cat->getPosts()) : 0 ?></td>
        						<td><?php
        							if(\App::isGranted('editCategory')):
		        						echo action_button('edit',site_url('admin/post/category/edit/'.$cat->getSlug()) ,array('title'	=>	'Edit '.$cat->getName() ))."&emsp;";
        							endif;
        							if(\App::isGranted('deleteCategory')):
		        						echo action_button('delete',site_url('admin/post/category/delete/'.$cat->getSlug()) ,array('title'	=>	'Delete '.$cat->getName() ));
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
						    		<strong>No Category found!</strong>
						    	</td>
						    </tr>

						<?php endif; ?>
						</tbody>
						<tfoot>
							<tr>
								<th>S.N.</th>
		        				<th>Caegory</th>
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