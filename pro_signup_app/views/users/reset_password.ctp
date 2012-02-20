<h1>Password reset</h1>
<?php echo $session->flash(); ?>

<?php echo $this->Form->create('User', array('action'=>'reset_password')); ?>

<?php 
	echo $form->input('email', array('label'=>'Existing email')); 
	echo $form->input('password', array('label'=>'New password (5-15 chars)')); 
	echo $form->input('password_confirmation', array(
		'type'=>'password',
		'label' => 'Retype new password',
	));
?>
Don't have an account? <?php echo $html->link('Please register', array('controller'=>'users', 'action' => 'register')); ?>

<?php echo $form->end('Reset password'); ?>
