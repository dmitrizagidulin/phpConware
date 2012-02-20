<?php

class FirstChoice extends AppModel {
	var $name = 'FirstChoice';
	var $validate = array(
		'user_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'Invalid user specified.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'panel_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'Please select a panel as your first choice.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

	var $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Panel' => array(
			'className' => 'Panel',
			'foreignKey' => 'panel_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
	);

}
?>