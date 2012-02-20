<?php 
	$percentage = (float)$num_panels_filled / (float)$num_panels_total * 100;
	$isPanel = ($panel['PanelType']['name'] == 'Panel') || 
		($panel['PanelType']['name'] == 'Special Interest Panel');
	$canParticipate = $isPanel || ($panel['PanelType']['name'] == 'Discussion') || 
		($panel['PanelType']['name'] == 'Event');
?>
<script>
	$(document).ready(function() {
		$("#pagesRemaining").progressBar(<?php echo $percentage;?>);

<?php if(!$interest || ($interest == NO_THANKS)) { ?>
		$("#panelRating").hide();
<?php } ?>

<?php if(!$interest || ($interest != PARTICIPATE)) { ?>
		$("#panelOptions").hide();
<?php } ?>
		// Not Interested
		$("#PanelPrefInterest0").click(function() {
			$("#panelRating").slideUp();
			$("#panelOptions").slideUp();
		});
		
		// Would like to watch
		$("#PanelPrefInterest1").click(function() {
			$("#panelRating").slideDown();
			$("#panelOptions").slideUp();
		});
<?php if($canParticipate) { ?>
		// Would like to participate
		$("#PanelPrefInterest2").click(function() {
			$("#panelRating").slideDown();
			$("#panelOptions").slideDown();
		});
<?php } ?>
	});
</script>
<div class="panel_prefs">
<div class="progressBar" id="pagesRemaining" style="text-align: center;"></div>

<?php if($prev_panel_id) { ?>
	<?php echo $this->Html->link(__('< Previous', true), array('action' => 'panel', $prev_panel_id));?> |
	<?php echo $this->Html->link(__('List All Answers', true), array('controller' => 'dashboards', 'action' => 'view'));?>
<?php } ?>

<h1 class="panel_name"><?php echo $panel['Panel']['name']; ?></h1>

<p><?php echo $panel['Panel']['description'];?></p>

<?php echo $this->Form->create('PanelPref', array('url' => '/panel_prefs/panel/' . $panel_id));?>

<div class="panel_group">
	<h2 class="panel_pref">Interest:</h2>
	<fieldset class="panel_fields">
<?php
//	$options = array(0 => 'No thanks, not interested',
//					1 => "I'd like to watch this panel",
//					2 => "I'd like to be on this panel");
//	$attributes = array('legend' => false);
//	echo $this->Form->radio('PanelPref.interest', $options, $attributes);
?>
<input type="radio" name="data[PanelPref][interest]" id="PanelPrefInterest0" value="0" <?php if($interest==0) echo 'checked="checked"';?> />
<label for="PanelPrefInterest0">No thanks, not interested</label>
<input type="radio" name="data[PanelPref][interest]" id="PanelPrefInterest1" value="1" <?php if($interest==1) echo 'checked="checked"';?> />
<label for="PanelPrefInterest1">I'd like to watch this</label>

<?php if($isPanel) { ?>
<input type="radio" name="data[PanelPref][interest]" id="PanelPrefInterest2" value="2" <?php if($interest==2) echo 'checked="checked"';?> />
<label for="PanelPrefInterest2">I'd like to be on this panel</label>		
<?php } elseif($canParticipate) { ?>
<input type="radio" name="data[PanelPref][interest]" id="PanelPrefInterest2" value="2" <?php if($interest==2) echo 'checked="checked"';?> />
<label for="PanelPrefInterest2">I'd like to participate</label>		
<?php } ?>

<?php if($isPanel) { ?>
		<div style="margin-left: 2em;" id="panelOptions">
		<h2 class="panel_pref">Panel Options:</h2>
		<?php echo $this->Form->checkbox('PanelPref.opt_panelist'); ?>
		<label>Panelist</label>
		<?php echo $this->Form->checkbox('PanelPref.opt_leader'); ?>
		<label>Leader (you ask the questions as well as answer them)</label>
		<?php echo $this->Form->checkbox('PanelPref.opt_moderator'); ?>
		<label>Moderator (you ask the questions but don't answer them)</label>
		</div>
<?php } // Panels only ?>

	</fieldset>
</div>

<div class="panel_group" id="panelRating">
	<h2 class="panel_pref">Rating:</h2>
	<fieldset class="panel_fields">
<?php
	$attributes = array('legend' => false);
	echo $this->Form->radio('PanelPref.panel_rating_id', $options=$panel_ratings, $attributes);
?>
	</fieldset>
</div>

	
	<?php echo $this->Form->input('PanelPref.comment');?>
	<?php echo $this->Form->hidden('panel_id', array('value' => $panel_id));?>
<?php echo $this->Form->end(__(' Next ', true));?>
</div>


