<div class="roomSizes view">
<h2><?php  __('Room Size');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $roomSize['RoomSize']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $roomSize['RoomSize']['name']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Room Size', true), array('action' => 'edit', $roomSize['RoomSize']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Room Size', true), array('action' => 'delete', $roomSize['RoomSize']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $roomSize['RoomSize']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Room Sizes', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Room Size', true), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Rooms', true), array('controller' => 'rooms', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Room', true), array('controller' => 'rooms', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php __('Related Rooms');?></h3>
	<?php if (!empty($roomSize['Room'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Room Size Id'); ?></th>
		<th><?php __('Track Id'); ?></th>
		<th><?php __('Name'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($roomSize['Room'] as $room):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $room['id'];?></td>
			<td><?php echo $room['room_size_id'];?></td>
			<td><?php echo $room['track_id'];?></td>
			<td><?php echo $room['name'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'rooms', 'action' => 'view', $room['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'rooms', 'action' => 'edit', $room['id'])); ?>
				<?php echo $this->Html->link(__('Delete', true), array('controller' => 'rooms', 'action' => 'delete', $room['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $room['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Room', true), array('controller' => 'rooms', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
