<div class="room_time_slots">

<?php echo $this->Form->create('Panel');?>
<?php 
	foreach($rooms as $room) {
?>
	<h3><?php echo $room['Room']['name'];?></h3>
	
	<table width="100%;">
	<tr>
<?php 
		foreach($days as $day) { ?>
		<th><?php echo $day['ConDay']['name'];?>
		</th>
<?php 
		} ?>
	</tr>
<tr>
<?php 
		foreach($days as $day) {
			$day_id = $day['ConDay']['id'];
			if(array_key_exists($day_id, $slots_by_day)) { 
				$time_slots = $slots_by_day[$day_id];
			} else {
				$time_slots = array();
			}
?>
		<td>
<?php
			foreach($time_slots as $time_slot) { 
	//			print $time_slot['TimeSlot']['start'];
	//			print strtotime($time_slot['TimeSlot']['start']);
				print strftime("%H:%M", strtotime($time_slot['TimeSlot']['start']));
				print "<br />";
			} 
?>
	</td>
<?php 
		} // foreach($days as $day) ?>
	</tr>
	</table>

<?php 
	} // foreach($rooms as $room) 
?>
<?php echo $this->Form->end(__('Save', true));?>
</div>