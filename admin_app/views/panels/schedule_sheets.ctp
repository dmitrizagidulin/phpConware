<?php 
	foreach($users as $user) {
		$user_id = $user['User']['id'];
		if(array_key_exists($user_id, $user_sorted_panels)) {
			$user_panels = $user_sorted_panels[$user_id];
		} else {
			$user_panels = array();
		}
?>
<h3 title="user id <?php echo $user_id;?>"><?php echo $user['User']['name'];?></h3>
<div style="page-break-after: always;">
<?php 
		if(!$user_panels) {
			echo 'No panels scheduled.';
		} else {
			$day = NULL;
			foreach($user_panels as $panel) {
				$panel_id = $panel['PanelParticipant']['panel_id'];
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
					echo '<h4 class="panel_day">' . $panel_date . '</h4>';
					$day = $panel_day;
				} 
				
				$panel_time = $slot['TimeSlot']['start'];
				$panel_time = strftime("%l:%M %p", strtotime($panel_time));
				$panel_name = $panel_detail['Panel']['name'];
				
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
		}
?>
</div>
zzz
<?php 
	}
?>