<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-solid box-mag">
                <div class="box-header with-border">
                    <h3 class="box-title"><strong>Edit Group Permissions <em>(<?php echo $group->getName();?>)</em></strong></h3>
                </div><!-- /.box-header -->
                <form name="group_permissions" method="post" action="" id="permission_form">
                    <div class="box-body">
                    	<table  class="table table-striped">
                    		<thead>
                    			<tr>
                    				<th width="3%"><input type="checkbox" id="selectAll" title="Select All" /></th>
					        		<th><label for="selectAll">Permission</label></th>
					        		<th>Description</th>
                    			</tr>
                    		</thead>
                    		<tbody>
	        					<?php foreach($allPermissions as $module => $permission):
	        					?>
								<tr style="background-color: #BECCDD;">
	                                <td>
	                                    <input id="<?php echo $module; ?>" type="checkbox" class="checkModule" /></td>
	                                <td colspan="2">
	                                    <label for="<?php echo $module; ?>"><?php echo ucfirst($module)." Permissions"; ?></label>
	                                </td>
	                            </tr>
								<?php foreach ($permission as $p):
								?>
								<tr class="<?php echo $module; ?>">
									<td>
					        			<?php 
					        				$checked = (in_array($p['id'], $dbPermissions)) ? 'checked="checked"' :'';
					        			?>
					        			<input id="<?php echo $p['name'].$p['id']; ?>"
				        				   type="checkbox" value="<?php echo $p['id']; ?>" 
				        				   name="assigned_permissions[]" <?php echo $checked;?> 
				        				   class="checkModule <?php echo ucfirst($module); if ($checked != '') echo ' default'?> " />
					        		</td>
									<td><label for="<?php echo $p['name'].$p['id']; ?>"><?php echo $p['name']; ?></label></td>
									<td><?php echo $p['description']; ?></td>
								</tr>

								<?php endforeach; ?>
							<?php endforeach; ?>
                    		</tbody>
                    	</table>
                    </div>
                    
                    <div class="box-footer clearfix">
                        <div class="form-group">
                            <div class="col-sm-offset-4 col-sm-8">
                                <button type="submit" class="btn btn-primary save-perms" name="save_perms" value="Save Permissions">Save Permissions</button>
        						<input type="reset" class="btn btn-warning" value="Reset"/>
        						<a href="<?php echo site_url('admin/user/group')?>" class="btn btn-danger">Cancel</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div><!-- /.box -->
        </div><!-- /.col -->
    </div><!-- /.row -->
</section>

<script>
	$(function(){
		inspectSelects();

		// toggle select all
		$('#selectAll').bind('click', function(){
			var tbody = $(this).parent('th').parent('tr').parent('thead').next('tbody');
			var checkbox = $(tbody).find('input[type="checkbox"]');
			$(checkbox).each(function(){
				$(this).prop('checked', $('#selectAll').prop('checked'));				
			});
			inspectSelects();
		});

		// toggle module select all
		$('.checkModule').bind('click',function(){			
			var moduleId = $(this).attr('id');
			console.log(moduleId);
			var tbody = $(this).parent('td').parent('tr').parent('tbody');
			var checkbox = $(tbody).find('tr.'+moduleId+' input[type="checkbox"]');
			$(checkbox).each(function(){
				$(this).prop('checked', $('#'+moduleId).prop('checked'));
				inspectSelects();
			})
		});
	});

	function inspectSelects()
	{
		$('tbody').find('input[type="checkbox"]').each(function(){
			if($(this).prop('checked') == false)
				$('#selectAll').prop('checked', false);
		})
	}
</script>