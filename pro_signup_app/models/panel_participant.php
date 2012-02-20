<?php
class PanelParticipant extends AppModel {
	var $name = 'PanelParticipant';

	var $validate = array(
		'panel_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'Error with user assignment: panel not specified',
				'allowEmpty' => false,
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'user_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'Error with user assignment: user not specified',
				'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'panelist' => array(
			'boolean' => array(
				'rule' => array('boolean'),
				'allowEmpty' => true,
				'required' => false,
				'message' => 'Invalid option for Panelist checkbox',
			),
		),
		'leader' => array(
			'boolean' => array(
				'rule' => array('boolean'),
				'allowEmpty' => true,
				'required' => false,
				'message' => 'Invalid option for Leader checkbox',
			),
		),
		'moderator' => array(
			'boolean' => array(
				'rule' => array('boolean'),
				'allowEmpty' => true,
				'required' => false,
				'message' => 'Invalid option for Moderator checkbox',
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
		),
	);
}
?>