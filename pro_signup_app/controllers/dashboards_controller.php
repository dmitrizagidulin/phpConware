<?php
class DashboardsController extends AppController {
	var $name = 'Dashboards';
	var $uses = array('Panel', 'PanelPref', 'QuestionAnswer', 'Question',
						'ConDay', 'TimeSlot', 'DayTimeSlot', 
						'UserTimeSlot', 'PanelSchedule', 'PanelParticipant',
						'UserConfirm');

	function index() {
		if ($this->loggedIn()) {
//			$this->redirect(array('controller'=>'dashboards', 'action' => 'view'));
			$this->redirect(array('controller'=>'dashboards', 'action' => 'confirm_schedule'));
		}
	}

	function confirm_schedule() {
		$user_id = $this->Session->read('user_id');
		$user_email = $this->Session->read('user_email');
		if ($user_id && $user_email) {
			$this->set('user_email', $user_email);
		} else {
			$this->redirect(array('controller'=>'users', 'action' => 'login'));
		}
		
		// Insert or edit the incoming data from the form
		if (!empty($this->data)) {
			$this->UserConfirm->create();
			$this->data['UserConfirm']['user_id'] = $user_id;
			
			if($this->data['UserConfirm']['essential_adjustments']) {
				$this->data['UserConfirm']['opt_essential'] = 1;
			}
			if($this->data['UserConfirm']['optional_adjustments']) {
				$this->data['UserConfirm']['opt_optional'] = 1;
			}
			
			if ($this->UserConfirm->save($this->data)) {
				$this->Session->setFlash(__('Saved. Thank you for confirming your schedule!', true));
			} else {
				$error_msg = '* ' . implode('<br />* ', $this->UserConfirm->invalidFields() );
				$this->Session->setFlash(__($error_msg, true), 'default', array('class' => 'error-message'));
			}
			
		}
		$this->data = array();
		
		$confirms = $this->UserConfirm->find('all', array(
			'recursive' => -1,
			'conditions' => array(
				'UserConfirm.user_id' => $user_id,
			),
		));
		$last_comment = end($confirms);
		if($last_comment) {
			$this->data = $last_comment;
		}
		
		$this->PanelParticipant->unbindModel(
			array('belongsTo' => array('User'))
		);
		$panels_partic = $this->PanelParticipant->find('all', array(
			'recursive' => -1,
			'conditions' => array(
				'PanelParticipant.user_id' => $user_id,
			),
		));
		$partic_by_id = $this->hashByKey($panels_partic, 'PanelParticipant', 'panel_id');
		$panel_ids = array_keys($partic_by_id);

		if($panels_partic) {
			$panels_sorted = $this->PanelSchedule->find('all', array(
				'recursive' => -1,
				'fields' => array(
					'PanelSchedule.panel_id',
					'MIN(PanelSchedule.day_time_slot_id) AS day_time_slot_id',
					'MIN(PanelSchedule.room_id) AS room_id',
					'MIN(Room.abbrev) as abbrev'
				),
				'joins' => array(
					array(
						'table' => 'rooms',
						'alias' => 'Room',
						'type' => 'inner',
						'foreignKey' => false,
						'conditions' => array('Room.id = PanelSchedule.room_id'),
					),
				),
				'conditions' => array(
					'PanelSchedule.panel_id' => $panel_ids,
				),
				'group' => array('PanelSchedule.panel_id'),
				'order' => array('day_time_slot_id', 'Room.sort_order'),
			));
		} else {  // User is not on any panels
			$panels_sorted = array();
		}

		
		$panel_details = $this->Panel->find('all', array(
			'recursive' => 1,
			'conditions' => array(
				'Panel.id' => $panel_ids,
			),
		));
		$panel_details = $this->hashByKey($panel_details, 'Panel', 'id');

		$panels_by_slot = $this->hashByKey($panels_sorted, array(0, 'PanelSchedule'), 'day_time_slot_id');
		$slot_ids = array_keys($panels_by_slot);
		$slot_details = $this->DayTimeSlot->find('all', array(
		));
		$slot_details = $this->hashByKey($slot_details, 'DayTimeSlot', 'id');

		$this->PanelParticipant->unbindModel(
			array('belongsTo' => array('Panel', 'DayTimeSlot'))
		);
		$all_participants = $this->PanelParticipant->find('all', array(
			'fields' => array(
				'DISTINCT PanelParticipant.user_id', 'PanelParticipant.leader', 'PanelParticipant.moderator',
				'PanelParticipant.panel_id',
				'User.first_name', 'User.last_name'
			),
			'joins' => array(
				array(
					'table' => 'users',
					'alias' => 'User',
					'type' => 'inner',
					'foreignKey' => false,
					'conditions' => array('User.id = PanelParticipant.user_id'),
				),
			),
			'conditions' => array(
				'PanelParticipant.panel_id' => $panel_ids,
			),
			'order' => array(
				'PanelParticipant.panel_id',
				'User.last_name',
				'User.first_name',
			),
		));
		$all_participants = $this->hashListByKey($all_participants, 'PanelParticipant', 'panel_id');
		$this->set(compact('partic_by_id', 'panels_sorted', 'panel_details', 'slot_details', 
			'all_participants', 'last_comment'));
	}
	
	function view() {
		$uid = $this->Session->read('user_id');
		$user_email = $this->Session->read('user_email');
		if ($uid && $user_email) {
//			$results = $this->User->findByUsername($username);
			$this->set('user_email', $user_email);
		} else {
			$this->redirect(array('controller'=>'users', 'action' => 'login'));
		}
		$panels_total = $this->Panel->find('count');
		$questions_total = $this->Question->find('count');
		$items_total = $panels_total + $questions_total;
		
		$user_panels_count = $this->PanelPref->find('count', array('conditions' => array('user_id'=>$uid)));
		$user_questions_count = $this->QuestionAnswer->find('count', array('conditions' => array('user_id'=>$uid)));
		$items_filled_out = $user_panels_count + $user_questions_count;
		
		$user_panel_prefs = NULL;
		if($user_panels_count) {
			// Load the list of the user panel preferences
			$user_panel_prefs = $this->PanelPref->find('all', array(
					'recursive' => 1,
					'conditions' => array('user_id'=>$uid),
					'order' => 'PanelPref.panel_id'));
		}
		$user_questions = NULL;
		if($user_questions_count) {
			// Load the list of the user panel preferences
			$user_questions = $this->QuestionAnswer->find('all', array(
					'recursive' => 1,
					'conditions' => array('user_id'=>$uid),
					'order' => 'QuestionAnswer.question_id'));
		}
		$last_filled_id = $this->PanelPref->lastPanelForUser($uid);
		$next_panel_id = $this->Panel->nextPanelAfter($last_filled_id);
		
		$last_question_id = $this->QuestionAnswer->lastQuestionForUser($uid);
		$next_question_id = $this->Question->nextQuestionAfter($last_question_id);
		
		$this->set('num_panels_remain', $items_total - $items_filled_out);
		$this->set('num_panels_total', $items_total);
		$this->set('num_panels_filled', $items_filled_out);
		
		$this->set('user_panel_prefs', $user_panel_prefs);
		$this->set('user_questions', $user_questions);

		$this->set('last_filled_id', $last_filled_id);
		$this->set('next_panel_id', $next_panel_id);
		$this->set('last_question_id', $last_question_id);
		$this->set('next_question_id', $next_question_id);
		
		$first_panel = $this->Panel->find('first', array('order' => array('Panel.id')));
		$this->set('first_panel_id', $first_panel['Panel']['id']);
		
	}
}
?>