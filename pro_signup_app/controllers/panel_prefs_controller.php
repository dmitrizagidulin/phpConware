<?php
class PanelPrefsController extends AppController {

	var $name = 'PanelPrefs';
	var $uses = array('Panel', 'PanelPref', 'PanelRating', 'Question', 'QuestionAnswer');
	
	function index() {
		$this->PanelPref->recursive = 0;
		$this->set('panelPrefs', $this->paginate());
	}

	
	/**
	 * Insert or edit a panelist's preferences for a given panel id
	 * @param integer $id panels.id (NOT panel_prefs.id)
	 */
	function panel($id = null) {
		$user_id = $this->Session->read('user_id');
		$panel_pref = NULL;
		if($id) {
			// Check to see if the user has already created a preference record for this panel
			// If so, load it
			$panel_pref = $this->PanelPref->find('first', 
									array('conditions' => array('PanelPref.panel_id' => $id, 'PanelPref.user_id' => $user_id)));
		}
		
		// Insert or edit the incoming data from the form
		if (!empty($this->data)) {
 			if($panel_pref) { // If this is an edit operation
 				$this->data['PanelPref']['id'] = $panel_pref['PanelPref']['id'];
			} else {
				$this->PanelPref->create();
			}
			$this->data['PanelPref']['user_id'] = $user_id;
			$saved_panel_id = $this->data['PanelPref']['panel_id'];
			
			if ($this->PanelPref->save($this->data)) {
				$next_panel_id = $this->Panel->nextPanelAfter($saved_panel_id);
				if($next_panel_id) {
					// More panels remains to fill out
//					$this->Session->setFlash(__('Saved', true));
					$this->redirect(array('controller'=>'panel_prefs', 'action' => 'panel', $next_panel_id));
				} else {
					// This was the last panel. Redirect to start of questions
					$this->redirect(array('controller'=>'release_forms', 'action' => 'sign'));
				}
			} else {
				$error_msg = '* ' . implode('<br />* ', $this->PanelPref->invalidFields() );
				$this->Session->setFlash(__($error_msg, true), 'default', array('class' => 'error-message'));
//				$this->redirect(array('controller'=>'panel_prefs', 'action' => 'panel', $saved_panel_id));
			}
			$rating = $this->data['PanelPref']['panel_rating_id'];
			$interest = $this->data['PanelPref']['interest'];
			
		} elseif($panel_pref) {
			$this->data = $panel_pref;
			$rating = $panel_pref['PanelPref']['panel_rating_id'];
			$interest = $panel_pref['PanelPref']['interest'];
		} else {
			// First form load (no incoming data), no existing pref saved
			$interest = 0;
			$this->data['PanelPref']['interest'] = $interest;
			$this->data['PanelPref']['opt_panelist'] = 1;
			$rating = NULL;
		}
		
		if (!$id) {
			$this->Session->setFlash(__('Invalid panel pref', true));
			$this->redirect(array('action' => 'index'));
		}
		
		$panel = $this->Panel->read(null, $id);
		$this->set('panel', $panel);
		$this->set('panel_id', $id);
		
		$panel_ratings = $this->PanelPref->PanelRating->find('list', array(
				'fields' => array('PanelRating.id', 'PanelRating.description'),
				'order' => 'PanelRating.id DESC',));
		$this->set(compact('panel_ratings', 'rating', 'interest'));
		
		$panels_total = $this->Panel->find('count');
		$questions_total = $this->Question->find('count');
		
		$filled_out = $this->PanelPref->find('count', array('conditions' => array('user_id'=>$user_id)));
		$filled_out_questions = $this->QuestionAnswer->find('count', array('conditions' => array('user_id'=>$user_id)));
		
		$this->set('num_panels_total', $panels_total + $questions_total);
		$this->set('num_panels_filled', $filled_out + $filled_out_questions);
		
		$prev_panel_id = $this->Panel->panelBefore($id);
		$this->set('prev_panel_id', $prev_panel_id);
	}
}
?>