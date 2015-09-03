<div class="box-body">
	<table id="postList" class="table table-responsive table-bordered table-hover">
		<thead>
			<tr>
				<th width="5%">S.N.</th>
				<th>Request</th>
				<th>Verse</th>
				<th>Date</th>
				<th width="15%">Action</th>
			</tr>
		</thead>
		<tbody>
			<?php $count=isset($offset)? $offset :0; foreach ($prayers as $prayer): $count++; 
				?>
		        <tr>
					<td><?php echo $count; ?></td>
					<td><?php echo $prayer->getPrayerRequest(); ?></td>
					<td><?php echo ($prayer->getVerse())?: 'N/A'; ?></td>
					<td><?php echo $prayer->getDate()->format('F d, Y'); ?></td>
					<td>
					<?php
						if(\App::isGranted('editPrayer'))
							echo action_button('edit', site_url('admin/prayer/edit/'.$prayer->getId()) ,array('title'	=>	'Edit '.$prayer->getDate()->format('F d, Y'). ' Prayer' ))."&emsp;";
						if(\App::isGranted('deletePrayer'))
							echo action_button('delete',site_url('admin/prayer/delete/'.$prayer->getId()) ,array('title'  =>  'Delete '.$prayer->getDate()->format('F d, Y').' Prayer permanently!' ))."&emsp;";
						?>
					</td>
				</tr>
		    <?php endforeach; ?>

		    <?php 
		    	if($count == 0):
		    	?>
		    	<tr style="text-align:center; ">
		    		<td colspan="5" >
		    			No prayer request found!
		    		</td>
		    	</tr>

		    <?php endif; ?>
		</tbody>
		<tfoot>
			<tr>
				<th>S.N.</th>
				<th>Request</th>
				<th>Verse</th>
				<th>Date</th>
				<th>Action</th>
			</tr>
		</tfoot>
	</table>
</div><!-- /.box-body -->