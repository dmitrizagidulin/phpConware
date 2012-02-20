<div class="tracks form">
<?php echo $this->Form->create('Track');?>
	<fieldset>
 		<legend><?php __('Edit Track'); ?></legend>
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

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('Track.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('Track.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Tracks', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Panels', true), array('controller' => 'panels', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Panel', true), array('controller' => 'panels', 'action' => 'add')); ?> </li>
	</ul>
</div>