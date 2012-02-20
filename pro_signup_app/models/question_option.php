<?php
class QuestionOption extends AppModel {
	var $name = 'QuestionOption';
	var $recursive = 1;

	var $belongsTo = array(
		'Question' => array(
			'className' => 'Question',
			'foreignKey' => 'question_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
	);
	
	var $hasMany = array(
		'QuestionAnswer' => array(
			'className' => 'QuestionAnswer',
			'foreignKey' => 'question_option_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);
}
?>