<h1>2011 Readercon Signup Form</h1>

<?php foreach($panels as $panel) { 
	$isPanel = ($panel['PanelType']['name'] == 'Panel') || 
		($panel['PanelType']['name'] == 'Special Interest Panel');
	$canParticipate = $isPanel || ($panel['PanelType']['name'] == 'Discussion') || 
		($panel['PanelType']['name'] == 'Event');
?>
	<h3><?php echo $panel['Panel']['name'];?></h3>

<table class="panel">
<tr>
	<td width="50%;">
	<div style="margin-bottom: 1em;">
	<?php echo $panel['Panel']['description'];?>
	</div>
	
	<label>Comments:</label>
	<tt>
	_______________________________________________
	_______________________________________________
	_______________________________________________
	_______________________________________________
	_______________________________________________
	</tt>
	
	</td>
	
	<td width="50%;">

	<div>
	<label>Interest:</label>
	[_] No thanks, not interested<br />
	[_] I'd like to watch this<br />
<?php if($canParticipate) { ?>
	[_] I'd like to participate
<?php } ?>
	</div>
	
	<br />
	
<?php if($isPanel) { ?>
	<div>
	<label>Option:</label>
	[_] Panelist<br />
	[_] Leader (you ask the questions as well as answer them)<br />
	[_] Moderator (you ask the questions but don't answer them)
	</div>
	<br />
<?php } ?>

	<div>
	<label>Rating:</label>
	[_] A+: This sounds terrific; I'd be disappointed if I didn't do it.<br />
	[_] A: This sounds great; I'd really like to do it.<br />
	[_] B: This sounds good; I'd enjoy doing it.
	</div>
	</td>
</tr>
</table>
<?php } ?>