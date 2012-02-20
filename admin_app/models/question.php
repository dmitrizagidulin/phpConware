<?php
class Question extends AppModel {
	var $name = 'Question';
	var $validate = array(
		'question' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $hasMany = array(
		'QuestionOption' => array(
			'className' => 'QuestionOption',
			'foreignKey' => 'question_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'QuestionAnswer' => array(
			'className' => 'QuestionAnswer',
			'foreignKey' => 'question_id',
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

	public function nextQuestionAfter($question_id) {
		if(!$question_id) {
			$question_id = 0;
		}
		$next_question = $this->find('first', 
									array('fields' => 'Question.id',
										'recursive' => -1,
										'order' => 'Question.id ASC',
										'conditions' => array('Question.id >' => $question_id)));
		if($next_question) {
			return $next_question['Question']['id'];
		} else {  // No more Questions after this one
			return NULL;
		}
	}

}
?>