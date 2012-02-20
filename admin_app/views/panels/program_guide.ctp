<h1>Program Guide</h1>

<?php 
if(!$panels_sorted) {
	echo '<p style="margin: 2em 0px;">No panels have been scheduled yet.</p>';
}
?>

<ol>
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
	<li class="schedule_item">
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
	</li>
<?php 
	}
?>
</ol>