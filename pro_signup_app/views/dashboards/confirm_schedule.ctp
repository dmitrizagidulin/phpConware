<div class="dashboard">

	<h2>Please confirm your schedule:</h2>

<?php 
	if(!$panels_sorted) {
		echo '<p style="margin: 2em 0px;">You are not currently scheduled for any panels.</p>';
	}
?>

<?php 
	$day = NULL;
	foreach($panels_sorted as $panel) {
		$panel_id = $panel['PanelSchedule']['panel_id'];
		$panel_detail = $panel_details[$panel_id];
		if(array_key_exists(0, $panel)) {
			$day_time_slot_id = $panel[0]['day_time_slot_id'];
		} else {
			$day_time_slot_id = $panel['PanelSchedule']['day_time_slot_id'];
		}
		$slot = $slot_details[$day_time_slot_id];
		if(array_key_exists(0, $panel)) {
			$room_abbrev = $panel[0]['abbrev'];
		} else {
			$room_abbrev = $panel['Room']['abbrev'];
		}

		$panel_day = $slot['ConDay']['name'];
		$panel_date = $slot['ConDay']['date'];
		$panel_date = strftime("%A %B %d", strtotime($panel_date));
		if($day != $panel_day) {
			echo '<h3 class="panel_day">' . $panel_date . '</h3>';
			$day = $panel_day;
		} 
		$panel_time = $slot['TimeSlot']['start'];
		$panel_time = strftime("%l:%M %p", strtotime($panel_time));
		
		if(array_key_exists($panel_id, $all_participants)) {
			$users_for_panel = $all_participants[$panel_id];
		} else {
			$users_for_panel = array();
		} 
?>
	<div class="schedule_item">
		<i><?php echo $panel_time;?></i>&nbsp;&nbsp;&nbsp;
		<?php echo $room_abbrev;?>&nbsp;&nbsp;&nbsp;
		<b><?php echo $panel_detail['Panel']['name'];?>.</b>
		<i>
<?php
		$panelists = array();
		foreach($users_for_panel as $sched_user) {
			$sched_user_str = $sched_user['User']['first_name'] . ' ' . $sched_user['User']['last_name'];
			if($sched_user['PanelParticipant']['leader']) {
				$sched_user_str .= ' (leader)';
			}
			if($sched_user['PanelParticipant']['moderator']) {
				$sched_user_str .= ' (moderator)';
			}
			$panelists[] = $sched_user_str;
		}
		echo implode(', ', $panelists)  . '.';
?>
		</i>
		<?php echo $panel_detail['Panel']['description'];?>
	</div>
<?php 
	}
?>

<?php 
	// User has entered previous confirmations and comments
	if($last_comment) {
		$last_time = $last_comment['UserConfirm']['created'];
		$last_date = strftime("%d %B %Y", strtotime($last_time));
		$last_time = strftime("%l:%M %p", strtotime($last_time));
?>
		<h1>Re-Confirm or Enter New Comments</h1>
		<p>
		(Last confirmation saved on: <?php echo $last_date;?> at <?php echo $last_time;?>)
		</p>
<?php 
	} else {  // User has not previously confirmed
?>
		<h1>Enter Confirmation / Comments</h1>
		
<?php 
	}
?>

	<div class="panel_prefs">
	<?php echo $this->Form->create('UserConfirm', array('url' => '/dashboards/confirm_schedule'));?>
	
	<?php echo $this->Form->input('UserConfirm.opt_good', array(
		'label' => 'Looks good!', 
	));?>
	<?php echo $this->Form->input('UserConfirm.opt_essential', array(
		'label' => "Please make the following essential adjustments <br />(e.g. don't put me
on any panels before noon as I will not be functional):", 
	));?>
	
	<?php echo $this->Form->input('UserConfirm.essential_adjustments', array('label'=>false));?>
	
	<?php echo $this->Form->input('UserConfirm.opt_optional', array(
		'label' => "If possible, please make the following non-essential adjustments<br />
(e.g. I would prefer to be on a maximum of one morning panel):", 
	));?>
	
	<?php echo $this->Form->input('UserConfirm.optional_adjustments', array('label'=>false));?>
	
	<?php echo $this->Form->input('UserConfirm.other_comments', array('label'=>'Other comments:'));?>
	
	<?php echo $this->Form->end(__(' Save and submit ', true));?>
	</div>

</div>