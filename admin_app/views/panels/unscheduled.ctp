<h1>Unscheduled Panels</h1>

<table>
<thead>
<tr>
	<th>Panel</th>
	<th title="panel id">Id</th>
</tr>
</thead>
<?php 
	foreach($unscheduled_panels as $panel) {
		$panel_id = $panel['Panel']['id'];
	
?>
	<tr>
		<td><?php echo $panel['Panel']['name'];?></td>
		<td title="panel id"><?php echo $panel_id; ?></td>

	</tr>
<?php 
	} ?>

</table>