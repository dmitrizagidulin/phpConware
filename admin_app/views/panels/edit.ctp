<div class="panels form">
<?php echo $this->Form->create('Panel');?>
	<fieldset>
 		<legend><?php __('Edit Panel'); ?></legend>
	<?php
		echo $this->Form->input('disabled');
		echo $this->Form->input('id');
		echo $this->Form->input('panel_type_id');
		echo $this->Form->input('name');
		echo $this->Form->input('description');
		echo $this->Form->input('url_slug');
		echo $this->Form->input('panel_length_id');
		echo $this->Form->input('track_id');
		echo $this->Form->input('num_panelists', array('label'=>'Number of Panelists (1-5)'));
		echo $this->Form->input('num_moderators', array('label'=>'Number of Moderators (0-1)'));
		echo $this->Form->input('keywords', array('label'=>'Keywords (comma-separated)'));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('Panel.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('Panel.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Panels', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Panel Types', true), array('controller' => 'panel_types', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Panel Type', true), array('controller' => 'panel_types', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Tracks', true), array('controller' => 'tracks', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Track', true), array('controller' => 'tracks', 'action' => 'add')); ?> </li>
	</ul>
</div>