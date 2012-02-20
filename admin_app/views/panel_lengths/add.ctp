<div class="panelLengths form">
<?php echo $this->Form->create('PanelLength');?>
	<fieldset>
 		<legend><?php __('Add Panel Length'); ?></legend>
	<?php
		echo $this->Form->input('name');
		echo $this->Form->input('minutes');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Panel Lengths', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Panels', true), array('controller' => 'panels', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Panel', true), array('controller' => 'panels', 'action' => 'add')); ?> </li>
	</ul>
</div>