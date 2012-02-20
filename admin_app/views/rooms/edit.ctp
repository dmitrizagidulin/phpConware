<div class="rooms form">
<?php echo $this->Form->create('Room');?>
	<fieldset>
 		<legend><?php __('Edit Room'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('room_size_id');
		echo $this->Form->input('track_id');
		echo $this->Form->input('name');
		echo $this->Form->input('abbrev', array('label' => 'Abbreviation'));
		echo $this->Form->input('sort_order');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('Room.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('Room.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Rooms', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Room Sizes', true), array('controller' => 'room_sizes', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Room Size', true), array('controller' => 'room_sizes', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Tracks', true), array('controller' => 'tracks', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Track', true), array('controller' => 'tracks', 'action' => 'add')); ?> </li>
	</ul>
</div>