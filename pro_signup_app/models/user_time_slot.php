<?php
class UserTimeSlot extends AppModel {
	var $name = 'UserTimeSlot';
	var $validate = array(
		'available' => array(
			'boolean' => array(
				'rule' => array('boolean'),
				'allowEmpty' => true,
				'required' => false,
				'message' => 'Invalid option for Available checkbox',
			),
		),
		'maybe' => array(
			'boolean' => array(
				'rule' => array('boolean'),
				'allowEmpty' => true,
				'required' => false,
				'message' => 'Invalid option for Maybe checkbox',
			),
		),
	);
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
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