<script type="text/javascript">
	function showPanelists(slot_id) {
		$('#panelists'+slot_id).slideDown();
	}
	function hidePanelists(slot_id) {
		$('#panelists'+slot_id).slideUp();
	}
</script>

<div class="day_time_slots">
	<h1><?php __('Panel Recommendations (by Time Slot)');?></h1>

	<p>
	See Also: [<a href="/admin/panels/scheduled/">Scheduled Panels and Panelists</a>]
	[<a href="/admin/panels/unscheduled/">Unscheduled Panels</a>]
	</p>

<?php foreach($days as $day) {
		$day_id = $day['ConDay']['id'];
		if(array_key_exists($day_id, $slots_by_day)) { 
			$time_slots = $slots_by_day[$day_id];
		} else {
			$time_slots = array();
		}
?>
<?php
		foreach($time_slots as $time_slot) { 
			$slot_name = strftime("%H:%M", strtotime($time_slot['TimeSlot']['start']));
			
//			if($this->Util->endsWith($slot_name, '30')) {
//				continue;  // Skip the half-hour time slots
//			}

			$slot_id = $time_slot['DayTimeSlot']['id'];
			if(array_key_exists($slot_id, $prefs_by_user)) {
				$slot_panels = $prefs_by_user[$slot_id];
			} else {
				$slot_panels = array();
			}
			if(array_key_exists($slot_id, $scheduled_panels)) {
				$scheduled = $scheduled_panels[$slot_id];
			} else {
				$scheduled = array();
			}
?>
		<h3><?php echo $day['ConDay']['name'];?> - <?php echo $slot_name;?> (slot id <?php echo $slot_id;?>)</h3>
		<div style="padding: 0.5em 1em; margin-bottom: 1.5em;">
<?php 
//			if(array_key_exists($slot_id, $avail_by_slot)) {
//				$avail_users = $avail_by_slot[$slot_id];
//			} else {
//				$avail_users = array();
//			}
?>
			<!--  <b><?php // echo count($avail_users);?> panelists available</b> -->
			<h4>Scheduled Panels</h4>
<?php 
			if(!$scheduled) {
				echo "<p>None</p>";
			} else { // Has scheduled panels ?>
			<table style="margin-bottom: 1em;">
			<thead>
			<tr>
				<th>Action</th>
				<th>Room</th>
				<th>Panel</th>
				<th title="Panel Id">Id</th>
				<th>Panelists</th>
			</tr>
			</thead>
			<tbody>
<?php 			foreach($scheduled as $panel) {
					$sched_panel_id = $panel['PanelSchedule']['panel_id'];
					if(array_key_exists($sched_panel_id, $scheduled_users)) {
						$users_for_panel = $scheduled_users[$sched_panel_id];
					} else {
						$users_for_panel = array();
					}
?>
				<tr>
					<td style="white-space: nowrap; font-size: 80%;">
					[<?php echo $this->Html->link('clear schedule', 
						array(
							'controller' => 'panels',
							'action' => 'schedule_clear',
							'panel' => $sched_panel_id,
						)
					); ?>]
					</td>
					<td><b><?php echo $panel['Room']['name'];?></b></td>
					<td><?php echo $panel['Panel']['name']?></td>
					<td title="Panel Id"><?php echo $sched_panel_id;?></td>
					
					<td>[<?php echo $this->Html->link('edit panelists', 
						array(
							'controller' => 'panels',
							'action' => 'panelist_edit',
							'panel' => $sched_panel_id,
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
<?php 			} ?>
			</tbody>
			</table>
			
<?php 		} ?>

			<h4>Unscheduled Panels</h4>
<?php 
			if(!$unscheduled_panels) {
				echo "<p>Turned off</p>";
			} else { // Has scheduled panels ?>
			<table style="margin-bottom: 1em;">
			<thead>
			<tr>
				<th>Panel</th>
				<th title="Panel Id">Id</th>
				<th>Action</th>
			</tr>
			</thead>
			<tbody>
<?php 			foreach($unscheduled_panels as $panel) {
					$sched_panel_id = $panel['Panel']['id'];
?>
				<tr>
					<td><?php echo $panel['Panel']['name']?></td>
					<td title="Panel Id"><?php echo $sched_panel_id;?></td>
					<td>[<?php echo $this->Html->link('schedule', 
						array(
							'controller' => 'panels',
							'action' => 'schedule_new',
						'panel' => $sched_panel_id,
						'slot' => $slot_id,
						)
					); ?>]</td>
				</tr>
<?php 			} ?>
			</tbody>
			</table>
			
<?php 		} ?>

			
			<h4>Recommended Panels (<?php echo count($slot_panels);?> total):</h4>
			<table class="panel_recs">
			<thead>
			<tr>
				<th>Action</th>
				<th>Id</th>
				<th>Name</th>
				<th title="# of available participants">AP</th>
				<th title="# of possible slots for panel">PS</th>
			</tr>
			</thead>
			<tbody>
<?php 
			foreach($slot_panels as $panel) {
				$panel_id = $panel['PanelPref']['panel_id'];
				if(array_key_exists($panel_id, $poss_slots_by_panel)) {
					$poss_slots = count($poss_slots_by_panel[$panel_id]);
				} else {
					$poss_slots = 0;
				}
?>
			<tr>
				<td style="font-size: 80%;">[<?php echo $this->Html->link('schedule', 
						array(
							'controller' => 'panels',
							'action' => 'schedule_new',
						'panel' => $panel_id,
						'slot' => $slot_id,
						)
					); ?>]
				</td>
				<td title="id"><?php echo $panel_id;?></td>
				<td><?php echo $panel['Panel']['name'];?></td> 
				<td title="# of available participants"><b><?php echo $panel[0]['panels_int'];?></b></td>
				<td title="# of possible slots for panel"><?php echo $poss_slots;?></td>
			<tr>
<?php 		} ?>
			</tbody>
			</table>
			
			<!-- [<a href="javascript:void(0);" onclick="showPanelists(<?php echo $slot_id;?>);">Show All</a>]<br /> -->		
			<div class="panelists_avail" id="panelists<?php echo $slot_id;?>">
		
			[<a href="javascript:void(0);" onclick="hidePanelists(<?php echo $slot_id;?>);">Hide</a>]<br />
			</div>
			
			
			<div class="panel_recs" id="panelRecs<?php echo $slot_id;?>">
			</div>
		</div>
<?php
		}
?>
	</td>
<?php } // foreach($days as $day) ?>

</div>