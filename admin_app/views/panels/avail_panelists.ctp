<h1>Panels and Available Panelists</h1>

<?php 
	foreach($panels as $panel) {
?>
<div class="panel" style="margin: 0.5em 1em;">
	<h4><?php echo $panel['PanelType']['name'];?>: <?php echo $panel['Panel']['name'];?></h4>
	
	<label>Available (Participate)</label>
	
	<label>Available (Watch)</label>
</div>
<?php
	}
?>