<div class="users form">
<?php echo $this->Form->create('User');?>
	<fieldset>
 		<legend><?php __('Register'); ?></legend>
 		<?php echo $session->flash('auth'); ?>
	<?php
		echo $this->Form->input('username');
		echo $this->Form->input('password');
		echo $this->Form->input('password_confirmation', array('type'=>'password'));
		echo $this->Form->input('first_name', array('label'=>'First Name'));
		echo $this->Form->input('last_name', array('label'=>'Last Name'));
		echo $this->Form->input('name', array('label'=>'Display Name'));
		if($admin) {
			echo $this->Form->input('roles');
		}
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Users', true), array('action' => 'index'));?></li>
	</ul>
</div>