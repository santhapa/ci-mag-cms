<?php if(\App::isGranted('manageUserGroup')): ?>
	<?php $this->load->view($modulePath.'group/new'); ?>
<?php endif; ?>

<?php $this->load->view($modulePath.'group/list_content'); ?>
