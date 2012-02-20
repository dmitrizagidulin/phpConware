<div class="panelTypes view">
<h2><?php  __('Panel Type');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $panelType['PanelType']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $panelType['PanelType']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Description'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $panelType['PanelType']['description']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Panel Type', true), array('action' => 'edit', $panelType['PanelType']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Panel Type', true), array('action' => 'delete', $panelType['PanelType']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $panelType['PanelType']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Panel Types', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Panel Type', true), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Panels', true), array('controller' => 'panels', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Panel', true), array('controller' => 'panels', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php __('Related Panels');?></h3>
	<?php if (!empty($panelType['Panel'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Panel Type Id'); ?></th>
		<th><?php __('Name'); ?></th>
		<th><?php __('Description'); ?></th>
		<th><?php __('Url Slug'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($panelType['Panel'] as $panel):
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
