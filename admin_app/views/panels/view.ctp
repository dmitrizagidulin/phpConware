<div class="panels view">
<h2><?php  __('Panel');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $panel['Panel']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Panel Type'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($panel['PanelType']['name'], array('controller' => 'panel_types', 'action' => 'view', $panel['PanelType']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $panel['Panel']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Description'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $panel['Panel']['description']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Url Slug'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $panel['Panel']['url_slug']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Panel Length'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($panel['PanelLength']['name'], array('controller' => 'panel_lengths', 'action' => 'view', $panel['PanelLength']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Track'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($panel['Track']['name'], array('controller' => 'tracks', 'action' => 'view', $panel['Track']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Num Panelists'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $panel['Panel']['num_panelists']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Num Moderators'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $panel['Panel']['num_moderators']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Keywords'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $panel['Panel']['keywords']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Panel', true), array('action' => 'edit', $panel['Panel']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Panel', true), array('action' => 'delete', $panel['Panel']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $panel['Panel']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Panels', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Panel', true), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Panel Types', true), array('controller' => 'panel_types', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Panel Type', true), array('controller' => 'panel_types', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Panel Lengths', true), array('controller' => 'panel_lengths', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Panel Length', true), array('controller' => 'panel_lengths', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Tracks', true), array('controller' => 'tracks', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Track', true), array('controller' => 'tracks', 'action' => 'add')); ?> </li>
	</ul>
</div>
