<div class="panelLengths view">
<h2><?php  __('Panel Length');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $panelLength['PanelLength']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $panelLength['PanelLength']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Minutes'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $panelLength['PanelLength']['minutes']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Panel Length', true), array('action' => 'edit', $panelLength['PanelLength']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Panel Length', true), array('action' => 'delete', $panelLength['PanelLength']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $panelLength['PanelLength']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Panel Lengths', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Panel Length', true), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Panels', true), array('controller' => 'panels', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Panel', true), array('controller' => 'panels', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php __('Related Panels');?></h3>
	<?php if (!empty($panelLength['Panel'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Panel Type Id'); ?></th>
		<th><?php __('Name'); ?></th>
		<th><?php __('Description'); ?></th>
		<th><?php __('Url Slug'); ?></th>
		<th><?php __('Panel Length Id'); ?></th>
		<th><?php __('Track Id'); ?></th>
		<th><?php __('Num Panelists'); ?></th>
		<th><?php __('Num Moderators'); ?></th>
		<th><?php __('Keywords'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($panelLength['Panel'] as $panel):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $panel['id'];?></td>
			<td><?php echo $panel['panel_type_id'];?></td>
			<td><?php echo $panel['name'];?></td>
			<td><?php echo $panel['description'];?></td>
			<td><?php echo $panel['url_slug'];?></td>
			<td><?php echo $panel['panel_length_id'];?></td>
			<td><?php echo $panel['track_id'];?></td>
			<td><?php echo $panel['num_panelists'];?></td>
			<td><?php echo $panel['num_moderators'];?></td>
			<td><?php echo $panel['keywords'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'panels', 'action' => 'view', $panel['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'panels', 'action' => 'edit', $panel['id'])); ?>
				<?php echo $this->Html->link(__('Delete', true), array('controller' => 'panels', 'action' => 'delete', $panel['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $panel['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Panel', true), array('controller' => 'panels', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
