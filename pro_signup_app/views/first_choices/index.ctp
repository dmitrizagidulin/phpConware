<div class="dashboard">

	<h2>First Choice Selection</h2>

	<div class="dashboard_section">
	<p>Of the panels you have chosen to participate in, please select your first choice of panels using the radio buttons in the left column below.</p>
<br />
<?php echo $this->Form->create('FirstChoice');?>

<div class="panel_group">
<?php
	$attributes = array('legend' => false);
	echo $this->Form->radio('FirstChoice.panel_id', $options=$panel_options, $attributes);	
?>
</div>

<?php echo $this->Form->end(__(' Select and Finish ', true));?>

	</div>

</div>

