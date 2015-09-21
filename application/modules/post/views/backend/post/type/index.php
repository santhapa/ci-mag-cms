<?php if(\App::isGranted('addPostType')): ?>
	<?php $this->load->view($modulePath.'post/type/new'); ?>
<?php endif; ?>

<?php $this->load->view($modulePath.'post/type/list_content'); ?>
