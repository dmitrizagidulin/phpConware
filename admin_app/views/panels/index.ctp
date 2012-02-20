<div class="panels">
	<h2><?php __('Panels');?></h2>

<div class="actions_new">
	<ul>
		<li><?php echo $this->Html->link(__('New Panel', true), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Panel Types', true), array('controller' => 'panel_types', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Panel Type', true), array('controller' => 'panel_types', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Panel Lengths', true), array('controller' => 'panel_lengths', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Panel Length', true), array('controller' => 'panel_lengths', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Tracks', true), array('controller' => 'tracks', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Track', true), array('controller' => 'tracks', 'action' => 'add')); ?> </li>
	</ul>
</div>

	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('name');?></th>

			<th><?php echo $this->Paginator->sort('panel_type_id');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($panels as $panel):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
		$panelId = $panel['Panel']['id'];
	?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $this->Html->link($panel['Panel']['id'], array('controller' => 'panel_types', 'action' => 'view', $panel['PanelType']['id'])); ?>
		</td>
		<td>
		<small>[<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $panel['Panel']['id'])); ?>]</small>
		<small>[<?php echo $this->Html->link(__('Del', true), array('action' => 'delete', $panel['Panel']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $panel['Panel']['id'])); ?>]</small>
		<?php echo $this->Html->link($panel['Panel']['name'], array('action' => 'view', $panel['Panel']['id'])); ?>&nbsp;
		</td>

		<td>
			<?php echo $this->Html->link($panel['PanelType']['name'], array('controller' => 'panel_types', 'action' => 'view', $panel['PanelType']['id'])); ?>
		</td>

			<?php //echo $this->Html->link(substr($panel['PanelLength']['name'], 0, 3), array('controller' => 'panel_lengths', 'action' => 'view', $panel['PanelLength']['id'])); ?>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
	));
	?>	</p>

	<div class="paging">
		<?php echo $this->Paginator->prev('<< ' . __('previous', true), array(), null, array('class'=>'disabled'));?>
	 | 	<?php echo $this->Paginator->numbers();?>
 |
		<?php echo $this->Paginator->next(__('next', true) . ' >>', array(), null, array('class' => 'disabled'));?>
	</div>
</div>
