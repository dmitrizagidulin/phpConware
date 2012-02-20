<h1>User Confirmations:</h1>

<?php 
	if(!$confirms) {
		echo '<p>No users have confirmed.</p>';
	}
?>

<table>
<thead>
<tr>
	<th>User Id</th>
	<th>Name</th>
	<th>Good?</th>
	<th>Ess.Adjust</th>
	<th>Opt.Adjust</th>
	<th>Other Comments</th>
	<th>Time</th>
</tr>
</thead>
<tbody>
<?php 
	foreach($confirms as $confirm) {
?>
	<tr>
		<td><?php echo $confirm['User']['id'];?>
		<td><?php echo $confirm['User']['name'];?>
		<td><?php echo $confirm['UserConfirm']['opt_good'] ? 'Yes' : '';?>
		<td><?php echo $confirm['UserConfirm']['essential_adjustments'];?>
		<td><?php echo $confirm['UserConfirm']['optional_adjustments'];?>
		<td><?php echo $confirm['UserConfirm']['other_comments'];?>
		<td><?php echo $confirm['UserConfirm']['created'];?>
	</tr>
<?php 
	}
?>
</tbody>
</table>
