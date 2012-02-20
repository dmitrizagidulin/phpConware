<?php
class RoomTimeSlot extends AppModel {
	var $name = 'RoomTimeSlot';
	var $validate = array(
		'enabled' => array(
			'boolean' => array(
				'rule' => array('boolean'),
				'allowEmpty' => true,
				'required' => false,
				'message' => 'Invalid option for Enabled checkbox',
			),
		),
	);
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'Room' => array(
			'className' => 'Room',
			'foreignKey' => 'room_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'DayTimeSlot' => array(
			'className' => 'DayTimeSlot',
			'foreignKey' => 'day_time_slot_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

}
?>