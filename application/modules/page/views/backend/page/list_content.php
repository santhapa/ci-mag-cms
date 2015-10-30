<div class="box-body">
	<table id="pageList" class="table table-responsive table-bordered table-hover">
		<thead>
			<tr>
				<th width="5%">S.N.</th>
				<th>Title</th>
				<th>Author</th>
				<th>Posted On</th>
				<?php if($status == null): ?>
					<th>Status</th>
				<?php endif; ?>
				<th width="15%">Action</th>
			</tr>
		</thead>
		<tbody>
			<?php 
				$count=isset($offset)? $offset :0;
				// $count=0; 
				$list=0; 
				foreach ($pages as $page): 

				if($status == \page\models\Page::STATUS_TRASH)
				{
					if(!$page->isTrashed()) continue;
				}

				if($status == \page\models\Page::STATUS_DRAFT)
				{
					if(!$page->isDraft()) continue;
				}

				if($status == \page\models\Page::STATUS_PUBLISH)
				{
					if(!$page->isPublished()) continue;
				}

				$count++; 
				$list++; 
			?>
		        <tr>
					<td><?php echo $count; ?></td>
					<td><?php echo $page->getTitle(); ?></td>
					<td><?php echo $page->getAuthor()->getName()?:$page->getAuthor()->getUsername(); ?></td>
					<td><?php echo $page->getCreatedAt()->format('F j, Y'); ?></td>

					<?php if($status == null): ?>
						<td><?php echo \page\models\Page::$statusTypes[$page->getStatus()]; ?></td>
					<?php endif; ?>

					<td>
						<!-- <strong><em>This is you!</em></strong> -->
						<?php
							switch($page->getStatus())
        					{
        						case page\models\Page::STATUS_PUBLISH :{
									if(\App::isGranted('editPage')):
	        						 	echo action_button('edit',site_url('admin/page/edit/'.$page->getSlug()) ,array('title'	=>	'Edit '.$page->getTitle() ))."&emsp;";
			        				endif;
									if(\App::isGranted('deletePage'))
        								echo action_button('trash',site_url('admin/page/trash/'.$page->getSlug()) ,array('title'	=>	'Delete '.$page->getTitle() ))."&emsp;";
        							break;
        						}
        						case page\models\Page::STATUS_DRAFT :{
        							if(\App::isGranted('editPage')):
	        						 	echo action_button('edit',site_url('admin/page/edit/'.$page->getSlug()) ,array('title'	=>	'Edit '.$page->getTitle() ))."&emsp;";
	        						 	echo action_button('publish',site_url('admin/page/publish/'.$page->getSlug()) ,array('title'	=>	'Publish '.$page->getTitle() ))."&emsp;";
			        				endif;
			        				if(\App::isGranted('deletePage'))
        								echo action_button('delete',site_url('admin/page/delete/'.$page->getSlug()) ,array('title'  =>  'Delete '.$page->getTitle().' permanently!' ))."&emsp;";
        							break;
        						}
        						case page\models\Page::STATUS_TRASH :{
									if(\App::isGranted('editPage'))
        								echo action_button('restore', site_url('admin/page/restore/'.$page->getSlug()) ,array('title'	=>	'Restore '.$page->getTitle() ))."&emsp;";
									if(\App::isGranted('deletePage'))
        								echo action_button('delete',site_url('admin/page/delete/'.$page->getSlug()) ,array('title'  =>  'Delete '.$page->getTitle().' permanently!' ))."&emsp;";
        							break;
        						}
        					}
						?>
					</td>
				</tr>
		    <?php endforeach; ?>

		    <?php if($list == 0): ?>
		    <tr>
		    	<td colspan="6" style="text-align: center;">
		    		<strong>No Pages found!</strong>
		    	</td>
		    </tr>

		    <?php endif; ?>
		</tbody>
		<tfoot>
			<tr>
				<th>S.N.</th>
				<th>Title</th>
				<th>Author</th>
				<th>Posted On</th>
				<?php if($status == null): ?>
					<th>Status</th>
				<?php endif; ?>
				<th>Action</th>
			</tr>
		</tfoot>
	</table>
</div><!-- /.box-body -->