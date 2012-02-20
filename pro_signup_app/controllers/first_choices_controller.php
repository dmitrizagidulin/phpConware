<?php
class FirstChoicesController extends AppController {

	var $name = 'FirstChoices';
	var $uses = array('Panel', 'PanelPref', 'FirstChoice');
	
	function index() {
		$user_id = $this->Session->read('user_id');

		$panel_options = $this->PanelPref->find('list', array(
				'fields' => array('PanelPref.panel_id', 'Panel.name'),
				'recursive' => 2,
				'conditions' => array('PanelPref.user_id' => $user_id,
										'PanelPref.interest' => 2),
				'order' => 'PanelPref.panel_id'));
		
		if(!$panel_options) {
			// Nothing to prompt for
			$this->redirect(array('controller'=>'dashboards', 'action' => 'view'));
		}
		
		$first_choice = $this->FirstChoice->find('first', array(
			'conditions' => array('FirstChoice.user_id' => $user_id,)
		));
		// Insert or edit the incoming data from the form
		if (!empty($this->data)) {
 			if($first_choice) { // If this is an edit operation
 				$this->data['FirstChoice']['id'] = $first_choice['FirstChoice']['id'];
			} else {
				$this->FirstChoice->create();
			}
			$this->data['FirstChoice']['user_id'] = $user_id;
			
			if ($this->FirstChoice->save($this->data)) {
				// Redirect to start
				$this->Session->setFlash(__('Saved. Thank you for making your first choice selection.', true));
				$this->redirect(array('controller'=>'dashboards', 'action' => 'view'));
			} else {
				$error_msg = '* ' . implode('<br />* ', $this->FirstChoice->invalidFields() );
				$this->Session->setFlash(__($error_msg, true), 'default', array('class' => 'error-message'));
			}
			
		} elseif($first_choice) {
			$this->data = $first_choice;
		}


		
		$this->set(compact('panel_options'));
	}
}
?>