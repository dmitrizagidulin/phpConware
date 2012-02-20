<h1>Panelist Registration</h1>
<?php echo $session->flash(); ?>

<div style="width: 50%;">
<p>Already registered? Please <?php echo $html->link('Log In', array('controller'=>'users', 'action' => 'login')); ?>.
<p>Can't log in? <?php echo $html->link('Reset password', array('controller'=>'users', 'action' => 'reset_password')); ?></p>
<p style="font-weight: bold;">Welcome to Readercon 22 program sign-up!</p>

<p>For each of the following program items, please indicate your type and
degree of interest. We invite you to leave comments explaining your
choice or offering other feedback; we especially appreciate
recommendations of good panelists and moderators. After you have
completed that section, you will be asked to give us information about
your at-con schedule, your preferred co-panelists, and other details that 
will help us make your Readercon experience superlative.</p>

<p>This year we have added a short agreement pertaining to recordings of
program items. For many years, Readercon has recorded all the program
items, but we have never had a legal structure in place that would let
us share those recordings with the world. Please sign the agreement
and help us bring the joys of Readercon to those who are unable to
attend the convention.</p>

<p>If at any point you need to step away from sign-up, feel free to do
so. Your progress will automatically be saved. When you're ready to
continue, log back in. You will be able to make changes to your
previous selections right up until the moment you hit the "Select and Finish" button on the last page.</p>

<p>We would greatly appreciate your completion of the sign-up process by
Wednesday, June 8.</p> 

<p>See you in July!</p>
</div>
<?php echo $form->create('User', array('action'=>'register')); ?>

<?php 
	echo $form->input('email'); 
	echo $form->input('name', array('label'=>'Name (as you would like it to appear in the program guide)')); 
	echo $form->input('password', array('label'=>'Password (5-15 chars)')); 
	echo $form->input('password_confirmation', array('type'=>'password'));
?>
Already have an account? <?php echo $html->link('Reset password', array('controller'=>'users', 'action' => 'reset_password')); ?>

<?php echo $form->end('Register'); ?>

