<?php
class QuestionAnswersController extends AppController {

	var $name = 'QuestionAnswers';
	var $uses = array('Question', 'QuestionOption', 'QuestionAnswer');
	
	
	/**
	 * Insert or edit a panelist's preferences for a given question id
	 * @param integer $id questions.id (NOT question_answers.id)
	 */
	function question($id = null) {
		$user_id = $this->Session->read('user_id');
		$question_answer = NULL;
		if($id) {
			// Check to see if the user has already created an answer record for this question
			// If so, load it
			$question_answer = $this->QuestionAnswer->find('first', 
									array('conditions' => array('QuestionAnswer.question_id' => $id, 'QuestionAnswer.user_id' => $user_id)));
		}
		
		// Insert or edit the incoming data from the form
		if (!empty($this->data)) {
 			if($question_answer) { // If this is an edit operation
 				$this->data['QuestionAnswer']['id'] = $question_answer['QuestionAnswer']['id'];
			} else {
				$this->QuestionAnswer->create();
			}
			$this->data['QuestionAnswer']['user_id'] = $user_id;
			$saved_question_id = $this->data['QuestionAnswer']['question_id'];
			
			if ($this->QuestionAnswer->save($this->data)) {
				$next_question_id = $this->Question->nextQuestionAfter($saved_question_id);
				if($next_question_id) {
					// More questions remains to fill out
//					$this->Session->setFlash(__('Saved', true));
					$this->redirect(array('controller'=>'question_answers', 'action' => 'question', $next_question_id));
				} else {
					// This was the last question. Redirect to start
					$this->Session->setFlash(__('Saved. Thank you for filling out the question preferences!', true));
					$this->redirect(array('controller'=>'first_choices', 'action' => 'index'));
				}
			} else {
				$error_msg = '* ' . implode('<br />* ', $this->QuestionAnswer->invalidFields() );
				$this->Session->setFlash(__($error_msg, true), 'default', array('class' => 'error-message'));
			}
			
		} elseif($question_answer) {
			$this->data = $question_answer;
		} else {
			// First form load (no incoming data), no existing pref saved
		}
		
		if (!$id) {
			$this->Session->setFlash(__('Invalid question id', true));
			$this->redirect(array('controller'=>'dashboards', 'action' => 'index'));
		}
		
		$question = $this->Question->read(null, $id);
		$this->set('question', $question);
		$this->set('question_id', $id);

		$question_options = $this->QuestionAnswer->QuestionOption->find('list', array(
				'fields' => array('QuestionOption.id', 'QuestionOption.name'),
				'conditions' => array('QuestionOption.question_id'=>$id,
										'QuestionOption.key <>' => 'custom'),
				'order' => 'QuestionOption.sort'));
		
		$custom_option = $this->QuestionAnswer->QuestionOption->find('first', array(
				'fields' => array('QuestionOption.id', 'QuestionOption.name'),
				'conditions' => array('QuestionOption.question_id'=>$id,
										'QuestionOption.key' => 'custom')));
		$this->set(compact('question_options', 'custom_option'));
		
		$questions_total = $this->Question->find('count');
		$filled_out = $this->QuestionAnswer->find('count', array('conditions' => array('user_id'=>$user_id)));
		$this->set('num_questions_total', $questions_total);
		$this->set('num_questions_filled', $filled_out);
	}
}
?>