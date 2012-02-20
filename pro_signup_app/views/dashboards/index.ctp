<?php
if (isset($error)) {
  echo('Invalid Login.');
}
?>
<p style="font-size: 130%; margin-left: 0px;">Welcome, Readercon 22 program participants.</p>

<p style="font-size: 130%; margin-left: 0px;">Please 
<?php echo $html->link('Register', array('controller'=>'users', 'action' => 'register')); ?>,
or log in below.</p>
<?php echo $form->create('User', array('action' => 'login')); ?>

<?php
    echo $form->input('email');
    echo $form->input('password');
?>
<p>Can't log in? <?php echo $html->link('Reset password', array('controller'=>'users', 'action' => 'reset_password')); ?></p>
<?php echo $form->end('Login');?>


