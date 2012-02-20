<?php

class QuestionAnswer extends AppModel {
	var $name = 'QuestionAnswer';

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
		'question_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'Invalid question id',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'custom' => array(
			'rule' => array('customValidate'),
			'message' => 'Please provide more details.',
			//'allowEmpty' => false,
			//'required' => false,
			//'last' => false, // Stop validation after this rule
			//'on' => 'create', // Limit validation to 'create' or 'update' operations
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
		'Question' => array(
			'className' => 'Question',
			'foreignKey' => 'question_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'QuestionOption' => array(
			'className' => 'QuestionOption',
			'foreignKey' => 'question_option_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	public function customValidate($check) {
		// Force more details on certain questions
		$option_id = $this->data['QuestionAnswer']['question_option_id'];
		if(in_array($option_id, array('1', '8', '13', '17', '26', '24', '37', '46', '49', '52')) && 
			!$check['custom']) {
			return FALSE;
		}
		if($this->data['QuestionAnswer']['required']) {
			if(!$option_id && !$check['custom']) {
				return FALSE;
			}
		}
		
		return TRUE;
	}
	
	public function lastQuestionForUser($user_id) {
		$last_answer = $this->find('first', 
									array('fields' => 'QuestionAnswer.question_id',
										'recursive' => -1,
										'order' => 'QuestionAnswer.question_id DESC',
										'conditions' => array('QuestionAnswer.user_id' => $user_id)));

		if($last_answer) {
			return $last_answer['QuestionAnswer']['question_id'];
		} else {  // User has not filled out any questions
			return NULL;
		}
	}
}
?>