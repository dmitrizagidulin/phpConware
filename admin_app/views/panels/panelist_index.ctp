<h1>Panelist Index</h1>

<?php 
	foreach($users as $user) {
		$user_id = $user['User']['id'];
		if(array_key_exists($user_id, $panels_by_user)) {
			$user_panels = $panels_by_user[$user_id];
		} else {
			continue;
		}
		$panel_prog_nums = array();
		foreach($user_panels as $panel) {
			$panel_id = $panel['PanelParticipant']['panel_id'];
			$panel_order_num = $panel_guide_numbers[$panel_id];
			$panel_prog_nums[] = $panel_order_num;
		}
		sort($panel_prog_nums);
		$panel_prog_nums = implode(', ', $panel_prog_nums);
?>
<?php echo $user['User']['first_name'];?> 
<?php echo $user['User']['last_name'];?> 

<?php echo $panel_prog_nums;?>
<br />
<?php 	
	}
?>