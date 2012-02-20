<h1>Condensed Schedule (for labels)</h1>

<?php 
	foreach($users as $user) {
		$user_id = $user['User']['id'];
		if(array_key_exists($user_id, $user_sorted_panels)) {
			$user_panels = $user_sorted_panels[$user_id];
		} else {
			$user_panels = array();
		}
?>
<b title="user id <?php echo $user_id;?>"><?php echo $user['User']['name'];?></b>
<?php 
		if(!$user_panels) {
			echo 'No panels scheduled.';
		} else {
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
				$panel_day = substr($panel_day, 0, 2);
				$panel_time = $slot['TimeSlot']['start'];
				$panel_time = strftime("%l:%M %p", strtotime($panel_time));
				$panel_name = $panel_detail['Panel']['name'];
?>
zzz<?php echo $panel_day;?>	<?php echo $panel_time;?>	<?php echo $room_abbrev;?>	<?php echo $panel_name;?>

<?php 
			}
		}
?>
<br />
<?php 
	}
?>