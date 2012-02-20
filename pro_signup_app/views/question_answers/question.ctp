<?php 
	$percentage = (float)$num_questions_filled / (float)$num_questions_total * 100;
?>
<script>
	$(document).ready(function() {
		$("#pagesRemaining").progressBar(<?php echo $percentage;?>);
	});
</script>
<div class="panel_prefs">
<div class="progressBar" id="pagesRemaining" style="text-align: center;"></div>
<h1 class="panel_name"><?php echo $question['Question']['name']; ?></h1>

<p><?php echo $question['Question']['description'];?></p>

<?php echo $this->Form->create('QuestionAnswer', array('url' => '/question_answers/question/' . $question_id));?>

<div class="panel_group">
<?php
	$attributes = array('legend' => false);
	echo $this->Form->radio('QuestionAnswer.question_option_id', $options=$question_options, $attributes);	
?>
</div>
<div class="panel_group">
<?php if($custom_option) { ?>
		<label><?php echo $custom_option['QuestionOption']['name'];?></label>
		
		<?php echo $this->Form->input('QuestionAnswer.custom', array('label'=>false));?>
<?php } ?>
</div>
	
	<?php echo $this->Form->hidden('required', array('value' => (int)$question['Question']['required']));?>
	<?php echo $this->Form->hidden('question_id', array('value' => $question_id));?>
<?php echo $this->Form->end(__(' Next ', true));?>
</div>


