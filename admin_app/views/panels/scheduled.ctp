<h1>Scheduled Panels and Panelists</h1>

<table>
<thead>
<tr>
	<th>Time</th>
	<th>Room</th>
	<th>Panel</th>
	<th title="panel id">Id</th>
	<th>Panelists</th>
</tr>
</thead>
<?php 
	foreach($scheduled_panels as $panel) {
		$panel_id = $panel['Panel']['id'];
	
		if(array_key_exists($panel_id, $scheduled_users)) {
			$users_for_panel = $scheduled_users[$panel_id];
		} else {
			$users_for_panel = array();
		}
		$slot_id = $panel['DayTimeSlot']['id'];
		$time_slot = $time_slots[$slot_id];
		$day_name = $time_slot['ConDay']['name'];
		$slot_name = strftime("%H:%M", strtotime($time_slot['TimeSlot']['start']));
?>
	<tr>
		<td title="day_time_slot id: <?php echo $slot_id;?>"><?php echo $day_name;?> <?php echo $slot_name;?></td>
		<td><?php echo $panel['Room']['name'];?></td>
		<td><?php echo $panel['Panel']['name'];?></td>
		<td title="panel id"><?php echo $panel_id; ?></td>
		<td>[<?php echo $this->Html->link('edit panelists', 
						array(
							'controller' => 'panels',
							'action' => 'panelist_edit',
						'panel' => $panel_id,
						'slot' => $slot_id,
						)
					); ?>]
<?php 
		foreach($users_for_panel as $sched_user) {
			$sched_user_str = $sched_user['User']['name'];
			if($sched_user['PanelParticipant']['leader'] || $sched_user['PanelParticipant']['moderator']) {
				$sched_user_str = '<u>' . $sched_user_str . '</u>';
			}
			if($sched_user['PanelParticipant']['moderator']) {
				$sched_user_str = '<i>' . $sched_user_str . '</i>';
			}
			$sched_user_str = $sched_user_str . ', ';
			echo $sched_user_str;
		}
?>
		</td>
	</tr>
<?php 
	} ?>

</table>