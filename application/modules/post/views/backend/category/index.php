<?php if(\App::isGranted('addCategory')): ?>
	<?php $this->load->view($modulePath.'category/new'); ?>
<?php endif; ?>

<?php $this->load->view($modulePath.'category/list_content'); ?>
