<div class="users view">
<h2><?php  __('User');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $user['User']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Username'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $user['User']['username']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Email'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $user['User']['email']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $user['User']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Roles'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $user['User']['roles']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit User', true), array('action' => 'edit', $user['User']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete User', true), array('action' => 'delete', $user['User']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $user['User']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Users', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User', true), array('action' => 'add')); ?> </li>
	</ul>
</div>

<div class="clear" style="clear: both;"><br /></div>

	<h2>User's Schedule:</h2>

<?php 
	if(!$panels_sorted) {
		echo '<p style="margin: 2em 0px;">User is not scheduled for any panels</p>';
	}
?>

<?php 
	$day = NULL;
	foreach($panels_sorted as $panel) {
		$panel_id = $panel['PanelSchedule']['panel_id'];
		$panel_detail = $panel_details[$panel_id];
		if(array_key_exists(0, $panel)) {
			$day_time_slot_id = $panel[0]['day_time_slot_id'];
		} else {
			$day_time_slot_id = $panel['PanelSchedule']['day_time_slot_id'];
		}
		$slot = $slot_details[$day_time_slot_id];
		if(array_key_exists(0, $panel)) {
			$room_abbrev = $panel[0]['abbrev'];
		} else {
			$room_abbrev = $panel['Room']['abbrev'];
		}

		$panel_day = $slot['ConDay']['name'];
		$panel_date = $slot['ConDay']['date'];
		$panel_date = strftime("%A %B %d", strtotime($panel_date));
		if($day != $panel_day) {
			echo '<h3 class="panel_day">' . $panel_date . '</h3>';
			$day = $panel_day;
		} 
		$panel_time = $slot['TimeSlot']['start'];
		$panel_time = strftime("%I:%M %p", strtotime($panel_time));
		
		if(array_key_exists($panel_id, $all_participants)) {
			$users_for_panel = $all_participants[$panel_id];
		} else {
			$users_for_panel = array();
		} 
?>
	<div class="schedule_item">
		<i><?php echo $panel_time;?></i>&nbsp;&nbsp;&nbsp;
		<?php echo $room_abbrev;?>&nbsp;&nbsp;&nbsp;
		<b><?php echo $panel_detail['Panel']['name'];?></b>
		<i>
<?php
		$panelists = array();
		foreach($users_for_panel as $sched_user) {
			$sched_user_str = $sched_user['User']['first_name'] . ' ' . $sched_user['User']['last_name'];
			if($sched_user['PanelParticipant']['leader']) {
				$sched_user_str .= ' (leader)';
			}
			if($sched_user['PanelParticipant']['moderator']) {
				$sched_user_str .= ' (moderator)';
			}
			$panelists[] = $sched_user_str;
		}
		echo implode(', ', $panelists)  . '.';
?>
		</i>
		<?php echo $panel_detail['Panel']['description'];?>
	</div>
<?php 
	}
?>


<div class="panel_prefs">
<h3>Would Like To Be On:</h3>
<?php 
if($panels_on) { ?>
<ul>
<?php 
	foreach($panels_on as $panel) { ?>
	<li><?php echo $panel['Panel']['name'];?></li>
<?php 
	} ?>
</ul>
<?php 
} else { ?>
	<p>None</p>
<?php 
}
?>

</div>

<div class="panel_prefs">
<h3>Would Like To Watch:</h3>
<?php 
if($panels_watch) { ?>
<ul>
<?php 
	foreach($panels_watch as $panel) { ?>
	<li><?php echo $panel['Panel']['name'];?></li>
<?php 
	} ?>
</ul>
<?php 
} else { ?>
	<p>None</p>
<?php 
}
?>

</div>

