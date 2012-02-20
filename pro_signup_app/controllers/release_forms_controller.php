<?php
class ReleaseFormsController extends AppController {

	var $name = 'ReleaseForms';
	var $uses = array('ReleaseForm', 'Question');
	
	
	function sign() {
		$user_id = $this->Session->read('user_id');
		$release_form = NULL;
			// Check to see if the user has already created an answer record for this question
			// If so, load it
		$release_form = $this->ReleaseForm->find('first', 
									array('conditions' => array('ReleaseForm.user_id' => $user_id)));
		
		// Insert or edit the incoming data from the form
		if (!empty($this->data)) {
 			if($release_form) { // If this is an edit operation
 				$this->data['ReleaseForm']['id'] = $release_form['ReleaseForm']['id'];
			} else {
				$this->ReleaseForm->create();
			}
			$this->data['ReleaseForm']['user_id'] = $user_id;
			
			if ($this->ReleaseForm->save($this->data)) {
				$next_question_id = $this->Question->nextQuestionAfter(0);
				$this->redirect(array('controller'=>'question_answers', 'action' => 'question', $next_question_id));
			} else {
				$error_msg = '* ' . implode('<br />* ', $this->ReleaseForm->invalidFields() );
				$this->Session->setFlash(__($error_msg, true), 'default', array('class' => 'error-message'));
			}			
		} elseif($release_form) {
			$this->data = $release_form;
		} else {
			// First form load (no incoming data), no existing pref saved
		}
		
	}
}
?>