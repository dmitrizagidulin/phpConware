<div class="roomSizes form">
<?php echo $this->Form->create('RoomSize');?>
	<fieldset>
 		<legend><?php __('Edit Room Size'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('RoomSize.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('RoomSize.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Room Sizes', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Rooms', true), array('controller' => 'rooms', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Room', true), array('controller' => 'rooms', 'action' => 'add')); ?> </li>
	</ul>
</div>