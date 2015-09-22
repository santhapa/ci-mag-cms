<div class="box-body">
	<table id="postList" class="table table-responsive table-bordered table-hover">
		<thead>
			<tr>
				<th width="5%">S.N.</th>
				<th>Title</th>
				<th>Post Type</th>
				<th>Category</th>
				<th>Author</th>
				<th>Posted On</th>
				<th>Status</th>
				<th width="15%">Action</th>
			</tr>
		</thead>
		<tbody>
			<?php $count=0; foreach ($posts as $post): 

				if($status == \post\models\Post::STATUS_TRASH)
				{
					if(!$post->isTrashed()) continue;
				}

				if($status == \post\models\Post::STATUS_DRAFT)
				{
					if(!$post->isDraft()) continue;
				}
				$count++; 
			?>
		        <tr>
					<td><?php echo $count; ?></td>
					<td><?php echo $post->getTitle(); ?></td>
					<td><?php echo ucfirst($post->getPostType()->getName()); ?></td>
					<td>
						<?php
    						foreach ($post->getCategorys() as $i=>$cat) {
								echo $i==0 || $i==count($post->getCategorys())?'':', ';
								echo $cat->getName();
							}
    					?>
					</td>
					<td><?php echo $post->getAuthor()->getName()?:$post->getAuthor()->getUsername(); ?></td>
					<td><?php echo $post->getCreatedAt()->format('F j, Y'); ?></td>
					<td><?php echo \post\models\Post::$statusTypes[$post->getStatus()]; ?></td>
					<td>
						<!-- <strong><em>This is you!</em></strong> -->
						<?php
							switch($post->getStatus())
        					{
        						case post\models\Post::STATUS_ACTIVE :{
									if(\App::isGranted('editPost')):
	        						 	echo action_button('edit',site_url('admin/post/edit/'.$post->getSlug()) ,array('title'	=>	'Edit '.$post->getTitle() ))."&emsp;";
			        				endif;
									if(\App::isGranted('deletePost'))
        								echo action_button('trash',site_url('admin/post/trash/'.$post->getSlug()) ,array('title'	=>	'Delete '.$post->getTitle() ))."&emsp;";
        							break;
        						}
        						case post\models\Post::STATUS_DRAFT :{
        							if(\App::isGranted('editPost')):
	        						 	echo action_button('edit',site_url('admin/post/edit/'.$post->getSlug()) ,array('title'	=>	'Edit '.$post->getTitle() ))."&emsp;";
	        						 	echo action_button('publish',site_url('admin/post/publish/'.$post->getSlug()) ,array('title'	=>	'Publish '.$post->getTitle() ))."&emsp;";
			        				endif;
			        				if(\App::isGranted('deletePost'))
        								echo action_button('delete',site_url('admin/post/delete/'.$post->getSlug()) ,array('title'  =>  'Delete '.$post->getTitle().' permanently!' ))."&emsp;";
        							break;
        						}
        						case post\models\Post::STATUS_TRASH :{
									if(\App::isGranted('editPost'))
        								echo action_button('restore', site_url('admin/post/restore/'.$post->getSlug()) ,array('title'	=>	'Restore '.$post->getTitle() ))."&emsp;";
									if(\App::isGranted('deletePost'))
        								echo action_button('delete',site_url('admin/post/delete/'.$post->getSlug()) ,array('title'  =>  'Delete '.$post->getTitle().' permanently!' ))."&emsp;";
        							break;
        						}
        					}
						?>
					</td>
				</tr>
		    <?php endforeach; ?>

		    <?php if($count == 0): ?>
		    <tr>
		    	<td colspan="6" style="text-align: center;">
		    		<strong>No Posts found!</strong>
		    	</td>
		    </tr>

		    <?php endif; ?>
		</tbody>
		<tfoot>
			<tr>
				<th>S.N.</th>
				<th>Title</th>
				<th>Post Type</th>
				<th>Category</th>
				<th>Author</th>
				<th>Posted On</th>
				<th>Status</th>
				<th>Action</th>
			</tr>
		</tfoot>
	</table>
</div><!-- /.box-body -->