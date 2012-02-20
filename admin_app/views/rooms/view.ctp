<div class="rooms view">
<h2><?php  __('Room');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $room['Room']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Room Size'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($room['RoomSize']['name'], array('controller' => 'room_sizes', 'action' => 'view', $room['RoomSize']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $room['Room']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Abbreviation'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $room['Room']['abbrev']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Sort Order'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $room['Room']['sort_order']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Room', true), array('action' => 'edit', $room['Room']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Room', true), array('action' => 'delete', $room['Room']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $room['Room']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Rooms', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Room', true), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Room Sizes', true), array('controller' => 'room_sizes', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Room Size', true), array('controller' => 'room_sizes', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Tracks', true), array('controller' => 'tracks', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Track', true), array('controller' => 'tracks', 'action' => 'add')); ?> </li>
	</ul>
</div>
