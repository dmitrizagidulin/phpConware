<?php
class PanelSchedule extends AppModel {
	var $name = 'PanelSchedule';

	var $validate = array(
		'panel_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'Panel not specified',
				'allowEmpty' => false,
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'room_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'Please select a room',
				'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'day_time_slot_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'Please select a time slot',
				'allowEmpty' => false,
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);
	
	var $belongsTo = array(
		'Panel' => array(
			'className' => 'Panel',
			'foreignKey' => 'panel_id',
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
		),
		'Room' => array(
			'className' => 'Room',
			'foreignKey' => 'room_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
	);
}
?>