<?php 
	$percentage = (float)$num_panels_filled / (float)$num_panels_total * 100;
?>
<script>
	$(document).ready(function() {
		$("#pagesRemaining").progressBar(<?php echo $percentage;?>);
	});
</script>
<div class="dashboard">

	<h2>Panel Preferences</h2>

	<div class="dashboard_section">
	<h3 class="dashboard_count">Pages Filled Out: <?php echo $num_panels_filled; ?> out of <?php echo $num_panels_total;?></h3>
<div class="progressBar" id="pagesRemaining"></div>
<br />
<?php 

if(!$percentage) {
	echo $html->link('Start', array(
									'controller'=>'panel_prefs', 
									'action' => 'panel', $first_panel_id), 
								array('class'=>'dashboard_action')); 
}
elseif($next_panel_id) {
	echo $html->link('Continue', array(
									'controller'=>'panel_prefs', 
									'action' => 'panel', $next_panel_id), 
								array('class'=>'dashboard_action'));
} elseif($next_question_id) {
	echo $html->link('Continue', array(
									'controller'=>'question_answers', 
									'action' => 'question', $next_question_id), 
								array('class'=>'dashboard_action'));
} elseif($num_panels_remain) {
	echo $html->link('Start', array(
									'controller'=>'panel_prefs', 
									'action' => 'panel', $first_panel_id), 
								array('class'=>'dashboard_action')); 
} else {
}
?>
	</div>

<?php if($user_panel_prefs) { ?>
	<h2 style="margin-top: 1em;">Your Answers - Programming Items</h2>
	<div class="dashboard_section">
<table class="programming_items_list">
	<thead>
	<tr>
		<td>Edit</td>
		<td>Item Name</td>
		<td>Rating</td>
		<td>Interest</td>
		<td>Role</td>
	</tr>
	</thead>
<?php 	foreach($user_panel_prefs as $pref) { 
			$interest = $pref['PanelPref']['interest'];
			$interest_str = '';
			if(1 == $interest) {
				$interest_str = 'Watch';
			} elseif(2 == $interest) {
				$interest_str = 'Participate';
			}
			$rating_str = '';
			if($pref['PanelPref']['panel_rating_id']) {
				$rating_str = substr($pref['PanelRating']['description'], 0, 3);  // 1st 3 chars
				$rating_str = str_replace(':', '', $rating_str);
			}
			$role_str = ''; 
			if($pref['PanelPref']['opt_panelist']) {
				$role_str .= 'Panelist<br />';
			}
			if($pref['PanelPref']['opt_leader']) {
				$role_str .= 'Leader<br />';
			}
			if($pref['PanelPref']['opt_moderator']) {
				$role_str .= 'Moderator<br />';
			}
			?>
	<tr>
	<td>[<?php echo $html->link('edit', array(
									'controller'=>'panel_prefs', 
									'action' => 'panel', $pref['PanelPref']['panel_id'])); ?>]
	<td><?php echo $pref['Panel']['name'];?></td>
	<td><?php echo $rating_str;?></td>
	<td><?php echo $interest_str; ?></td>
	<td><?php echo $role_str; ?></td>
	</tr>
<?php 	} ?>
</table>
	</div>
<?php } ?>

<?php if($user_questions) { ?>
	<h2 style="margin-top: 1em;">Your Answers - Questions</h2>
	<div class="dashboard_section">
<table class="programming_items_list">
	<thead>
	<tr>
		<td>Edit</td>
		<td>Question</td>
		<td>Answer</td>
	</tr>
	</thead>
<?php 	foreach($user_questions as $question) { ?>
	<tr>
	<td>[<?php echo $html->link('edit', array(
									'controller'=>'question_answers', 
									'action' => 'question', $question['QuestionAnswer']['question_id'])); ?>]
	<td><?php echo $question['Question']['name'];?></td>
	<td><?php echo $question['QuestionOption']['name'];?></td>
	</tr>
<?php 	} ?>
</table>
	</div>
<?php } ?>
</div>

