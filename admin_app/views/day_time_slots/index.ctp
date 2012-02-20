<div class="day_time_slots">
	<h1><?php __('Time Slots (By Day)');?></h1>
	
<table>
<tr>
<?php foreach($days as $day) { ?>
	<th><?php echo $day['ConDay']['name'];?><br />
	[edit]
	</th>
<?php } ?>
</tr>

<tr>
<?php foreach($days as $day) {
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
			print " (" . $time_slot['DayTimeSlot']['id']. ")";
			print "<br />";
		} 
?>
	</td>
<?php } // foreach($days as $day) ?>
</tr>
</table>

</div>