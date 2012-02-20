<?php
class UsersController extends AppController {

	var $name = 'Users';
	var $uses = array(
		'User', 'PanelPref', 'Panel', 'ConDay', 'TimeSlot', 'DayTimeSlot', 
		'UserTimeSlot', 'PanelSchedule', 'PanelParticipant', 'UserConfirm'
	);
	var $paginate = array(
		'limit' => 300,
		'order' => array(
			'User.id' => 'asc',
		),
	);
	
	function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('add');
		if($this->action == 'add' || $this->action == 'edit') {
			$this->Auth->authenticate = $this->User;
		}
	}
	
	function confirmations() {
		$confirms = $this->UserConfirm->find('all', array(
			'order' => array('UserConfirm.created DESC'),
		));
		
		$this->set(compact('confirms'));
	}
	
	function login() {
		
	}
	
	function logout() {
		$this->redirect($this->Auth->logout());
	}
	
	function index() {
		$this->User->recursive = 0;
		$this->set('users', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid user', true));
			$this->redirect(array('action' => 'index'));
		}
		$panels_on = $this->PanelPref->find('all', array('recursive' => 1,
									'conditions' => 
										array('PanelPref.user_id' => $id, 'PanelPref.interest' => 2)));
		$panels_watch = $this->PanelPref->find('all', array('recursive' => 1,
									'conditions' => 
										array('PanelPref.user_id' => $id, 'PanelPref.interest' => 1)));
										$this->set('user', $this->User->read(null, $id));
		$panels_not_interested = $this->PanelPref->find('all', array('recursive' => 1,
									'conditions' => 
										array('PanelPref.user_id' => $id, 'PanelPref.interest' => 0)));
		$this->set('panels_on', $panels_on);
		$this->set('panels_watch', $panels_watch);
		$this->set('panels_not_interested', $panels_not_interested);
		
		$user_id = $id;
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
					'MIN(DayTimeSlot.con_day_id) AS con_day_id',
					'MIN(DayTimeSlot.time_slot_id) AS time_slot_id',
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
					array(
						'table' => 'day_time_slots',
						'alias' => 'DayTimeSlot',
						'type' => 'inner',
						'foreignKey' => false,
						'conditions' => array('DayTimeSlot.id = PanelSchedule.day_time_slot_id'),
					),
				),
				'conditions' => array(
					'PanelSchedule.panel_id IN (' . implode(',', $panel_ids) . ')',
				),
				'group' => array('PanelSchedule.panel_id'),
				'order' => array('con_day_id', 'time_slot_id', 'Room.sort_order'),
			));
			$panel_details = $this->Panel->find('all', array(
				'recursive' => 1,
				'conditions' => array(
					'Panel.id IN (' . implode(',', $panel_ids) . ')',
				),
			));
		} else {  // User is not on any panels
			$panels_sorted = array();
			$panel_details = array();
		}

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
		$this->set(compact('partic_by_id', 'panels_sorted', 'panel_details', 'slot_details', 'all_participants'));
		
	}

	function add() {
		if (!empty($this->data)) {
			$this->User->create();
			if ($this->User->save($this->data)) {
				$this->Session->setFlash(__('The user has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.', true));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid user', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->User->save($this->data)) {
				$this->Session->setFlash(__('The user has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->User->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for user', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->User->delete($id)) {
			$this->Session->setFlash(__('User deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('User was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
?>