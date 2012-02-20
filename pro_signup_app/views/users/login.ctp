<h1>Login</h1>
<?php echo $session->flash('auth'); ?>

<p>Don't have an account? Please <?php echo $html->link('Register', array('controller'=>'users', 'action' => 'register')); ?>.


<?php echo $form->create('User', array('action'=>'login')); ?>

<?php echo $form->input('email'); ?>
<?php echo $form->input('password'); ?>
<?php echo $html->link('Reset password', array('controller'=>'users', 'action' => 'reset_password')); ?>

<?php echo $form->end('Login'); ?>