<?php
class PanelsController extends AppController {

	var $name = 'Panels';
	var $uses = array('Panel', 'PanelPref', 'PanelRating', 
						'ConDay', 'TimeSlot', 'DayTimeSlot', 
						'UserTimeSlot', 'PanelSchedule',
						'PanelParticipant', 'UserAvoid', 'UserCollab', 'User');
	var $paginate = array(
		'limit' => 200,
	);
	
	var $helpers = array('Form', 'Html', 'Javascript', 'Time', 'Util');
	
	function avail_panelists() {
		$panels = $this->Panel->find('all', array(
			'conditions' => array('Panel.disabled' => 0),
			'recursive' => 0,
			'order' => array('Panel.panel_type_id'),
		));
		$this->set(compact('panels'));
	}
	
	function by_time() {
		$days = $this->ConDay->find('all');
		$slots_by_day = $this->DayTimeSlot->slotsByDay($days);
		
//		$avail_by_slot = $this->UserTimeSlot->find('all', array(
//			'conditions' => array('UserTimeSlot.available' => 1),
//			'recursive' => 0,
//		));
//		$avail_by_slot = $this->hashListByKey($avail_by_slot, 'UserTimeSlot', 'day_time_slot_id');
		$avail_by_slot = array();
		$prefs_by_user = $this->PanelPref->find('all', array(
			'fields' => array(
				'UserTimeSlot.day_time_slot_id', 'PanelPref.panel_id',
				'Panel.name',
				'COUNT(DISTINCT PanelPref.user_id) AS panels_int' 
			),
			'conditions' => array(
				'PanelPref.interest' => 2,
				'UserTimeSlot.available' => 1,
				'PanelSchedule.id' => NULL,
				'PanelParticipant.id' => NULL,
			),
			'joins' => array(
				array(
					'table' => 'user_time_slots',
					'alias' => 'UserTimeSlot',
					'type' => 'inner',
					'foreignKey' => false,
					'conditions' => array('PanelPref.user_id = UserTimeSlot.user_id'),
				),
				array(
					'table' => 'day_time_slots',
					'alias' => 'DayTimeSlot',
					'type' => 'inner',
					'foreignKey' => false,
					'conditions' => array(
						'UserTimeSlot.day_time_slot_id = DayTimeSlot.id',
						'DayTimeSlot.enabled' => 1,
					),
				),
				array(
					'table' => 'time_slots',
					'alias' => 'TimeSlot',
					'type' => 'inner',
					'foreignKey' => false,
					'conditions' => array(
						'DayTimeSlot.time_slot_id = TimeSlot.id',
						'TimeSlot.hour' => 1,
					),
				),
				array(
					'table' => 'panels',
					'alias' => 'Panel',
					'type' => 'inner',
					'foreignKey' => false,
					'conditions' => array(
						'PanelPref.panel_id = Panel.id',
						'Panel.disabled' => 0,
					),
				),
				array(
					'table' => 'panel_schedules',
					'alias' => 'PanelSchedule',
					'type' => 'left outer',
					'foreignKey' => false,
					'conditions' => array(
						'PanelPref.panel_id = PanelSchedule.panel_id',
					),
				),
				array(
					'table' => 'panel_participants',
					'alias' => 'PanelParticipant',
					'type' => 'left outer',
					'foreignKey' => false,
					'conditions' => array(
						'PanelParticipant.user_id = PanelPref.user_id',
						'PanelParticipant.day_time_slot_id = UserTimeSlot.day_time_slot_id',
					),
				),
			),
			'group' => array('UserTimeSlot.day_time_slot_id', 'PanelPref.panel_id', 'Panel.name' ),
			'order' => array('panels_int ASC'),
			'recursive' => -1,
		));
		$poss_slots_by_panel = $this->hashListByKey($prefs_by_user, 'PanelPref', 'panel_id');
		$prefs_by_user = $this->hashListByKey($prefs_by_user, 'UserTimeSlot', 'day_time_slot_id');
		
		$scheduled_panels = $this->PanelSchedule->find('all', array('recursive' => 1));
		$scheduled_user_panels = $this->hashListByKey($scheduled_panels, 'PanelSchedule', 'panel_id');
		$scheduled_panels = $this->hashListByKey($scheduled_panels, 'PanelSchedule', 'day_time_slot_id');
		
		if($scheduled_panels) {
			$scheduled_user_panels = array_keys($scheduled_user_panels);
			$this->PanelParticipant->unbindModel(array('belongsTo' => array('Panel')));
			$scheduled_users = $this->PanelParticipant->find('all', array(
				'recursive' => 0,
				'conditions' => array(
					'PanelParticipant.panel_id IN (' . implode(',', $scheduled_user_panels) . ')',
				),
			));
			
			$scheduled_users = $this->hashListByKey($scheduled_users, 'PanelParticipant', 'panel_id');
		} else {
			$scheduled_users = array();
		}
		
		$unscheduled_panels = $this->Panel->find('all', array(
			'recursive' => 1,
			'order' => array('Panel.id'),
			'conditions' => array(
				'PanelSchedule.id' => NULL,
				'Panel.disabled' => 0
			),
			'joins' => array(
				array(
					'table' => 'panel_schedules',
					'alias' => 'PanelSchedule',
					'type' => 'left outer',
					'foreignKey' => false,
					'conditions' => array('PanelSchedule.panel_id = Panel.id'),
				),
			),
		));
		
		$this->set(compact('days', 'slots_by_day', 'avail_by_slot', 'prefs_by_user', 'scheduled_panels', 
			'poss_slots_by_panel', 'scheduled_users',
			'unscheduled_panels'));
	}
	
	function index() {
		$this->Panel->recursive = 0;
		$this->set('panels', $this->paginate());
		
//		$not_interested = $this->PanelPref->find('list', array(
//			'fields' => array('PanelPref.panel_id', 'interest_count'),
//			'conditions' => array('PanelPref.interest' => NO_THANKS),
//			'group' => array('PanelPref.panel_id'),
//			'recursive' => -1,
//		));
//		$watch = $this->PanelPref->find('list', array(
//			'fields' => array('PanelPref.panel_id', 'interest_count'),
//			'conditions' => array('PanelPref.interest' => WATCH),
//			'group' => array('PanelPref.panel_id'),
//			'recursive' => -1,
//		));
//		$participate = $this->PanelPref->find('list', array(
//			'fields' => array('PanelPref.panel_id', 'interest_count'),
//			'conditions' => array('PanelPref.interest' => PARTICIPATE),
//			'group' => array('PanelPref.panel_id'),
//			'recursive' => -1,
//		));
//		$this->set(compact('not_interested', 'watch', 'participate'));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid panel', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('panel', $this->Panel->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Panel->create();
			if ($this->Panel->save($this->data)) {
				$this->Session->setFlash(__('The panel has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The panel could not be saved. Please, try again.', true));
			}
		}
		$panelTypes = $this->Panel->PanelType->find('list');
		$panelLengths = $this->Panel->PanelLength->find('list');
		$tracks = $this->Panel->Track->find('list');
		$this->set(compact('panelTypes', 'panelLengths', 'tracks'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid panel', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Panel->save($this->data)) {
				$this->Session->setFlash(__('The panel has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The panel could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Panel->read(null, $id);
		}
		$panelTypes = $this->Panel->PanelType->find('list');
		$panelLengths = $this->Panel->PanelLength->find('list');
		$tracks = $this->Panel->Track->find('list');
		$this->set(compact('panelTypes', 'panelLengths', 'tracks'));
	}

	function condensed_schedule() {
//		App::import('Vendor', 'phpexcel');
//		App::import('Vendor', 'ExcelWriter2007', array('file' => 'PHPExcel'.DS.'Writer'.DS.'Excel2007.php'));
//		App::import('Vendor', 'ZipArchive', array('file' => 'PHPExcel'.DS.'Shared'.DS.'ZipArchive.php'));
		$users = $this->User->find('all', array(
			'recursive' => -1,
			'fields' => array(
				'User.id', 'User.last_name', 'User.name'
			),
			'conditions' => array(
				'User.roles' => 'pro',
			),
			'order' => array('User.last_name', 'User.first_name')
		));
		$panels_sorted = $this->PanelSchedule->getSortedPanels();
		
		$panel_details = $this->Panel->find('all', array(
			'recursive' => 1,
		));
		$panel_details = $this->hashByKey($panel_details, 'Panel', 'id');
		$panels_by_id = $this->hashByKey($panels_sorted, array(0, 'PanelSchedule'), 'panel_id');
		$slot_details = $this->DayTimeSlot->find('all', array(
		));
		$slot_details = $this->hashByKey($slot_details, 'DayTimeSlot', 'id');
		
		$panel_participants = $this->PanelParticipant->find('all', array(
			'recursive' => -1,
			'fields' => array(
				'DISTINCT PanelParticipant.user_id', 'PanelParticipant.leader', 'PanelParticipant.moderator',
				'PanelParticipant.panel_id',
			),
		));
		$panel_participants = $this->hashListByKey($panel_participants, 'PanelParticipant', 'panel_id');
		
		// Assemble the list of panels, for each user, in sorted order
		$user_sorted_panels = array();
		foreach($panels_sorted as $panel) {
			$panel_id = $panel['PanelSchedule']['panel_id'];
			if(!array_key_exists($panel_id, $panel_participants)) {
				continue;  // Skip panels with no panelists assigned (like the Meet the Prose party)
			}
			$users_on_panel = $panel_participants[$panel_id];
			foreach($users_on_panel as $assignment) {
				$user_id = $assignment['PanelParticipant']['user_id'];
				$user_sorted_panels[$user_id][] = array_merge($assignment, $panel);
			}
		}
		
//		$objPHPExcel = new PHPExcel();
//		// Set properties
//		$objPHPExcel->getProperties()->setCreator("Readercon.org");
//		$objPHPExcel->getProperties()->setLastModifiedBy("Readercon.org");
//		$objPHPExcel->getProperties()->setTitle("Concise Schedule");
//		$objPHPExcel->getProperties()->setSubject("Concise Schedule");
//		$objPHPExcel->getProperties()->setDescription("Concise Schedule for labels");
//		$objPHPExcel->setActiveSheetIndex(0);
//
//		$objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Hello');
//		$objPHPExcel->getActiveSheet()->SetCellValue('B2', 'world!');
//		$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
//		$objWriter->save('test.xlsx');

		$this->set(compact('users', 'panel_details', 'slot_details', 
					'user_sorted_panels'));
	}
	
	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for panel', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Panel->delete($id)) {
			$this->Session->setFlash(__('Panel deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Panel was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
	
	function print_signup() {
		$this->layout = 'print';
		$panels = $this->Panel->find('all', array(
					'recursive' => 0,
					'order' => 'Panel.id'));
		$this->set(compact('panels'));
	}
	
	function program_guide() {
		$panels_sorted = $this->PanelSchedule->getSortedPanels();
		$panel_details = $this->Panel->find('all', array(
			'recursive' => 1,
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
			'order' => array(
				'PanelParticipant.panel_id',
				'User.last_name',
				'User.first_name',
			),
		));
		$all_participants = $this->hashListByKey($all_participants, 'PanelParticipant', 'panel_id');
		$this->set(compact('panels_sorted', 'panel_details', 'slot_details', 'all_participants'));
	}
	
	function panelist_edit() {
		$panel_id = (int)$this->params['named']['panel'];
		$slot_id = (int)$this->params['named']['slot'];
		if(!$panel_id || !$slot_id) {
			$this->Session->setFlash('Error: Panel or Slot not specified.');
			$this->redirect(array('controller' => 'panels', 'action' => 'scheduled'));
		}
		$slot = $this->DayTimeSlot->findById($slot_id);
		$panel = $this->Panel->findById($panel_id);
		$panel_length = $panel['PanelLength']['minutes'];
		$success = TRUE;
		// Incoming post data
		if (!empty($this->data)) {
			$error_msg = 'The panel could not be scheduled for this room and time slot. Please, try again.';
			// Clear existing panelists
			$this->PanelParticipant->deleteAll(array(
				'PanelParticipant.panel_id' => $panel_id,
			));
			
			// Save panelists
			if($this->data['PanelParticipant']) {
				$this->PanelParticipant->create();
				// Save Leader, if applicable
				$leader_id = (int)$this->data['PanelParticipant']['leader'];
				if($leader_id) {
					$leader_data = array();
					$leader_data['PanelParticipant']['day_time_slot_id'] = $slot_id;
					$leader_data['PanelParticipant']['panel_id'] = $panel_id;
					$leader_data['PanelParticipant']['user_id'] = $leader_id;
					$leader_data['PanelParticipant']['leader'] = 1;
					$this->PanelParticipant->save($leader_data); 
				}
				// Save Moderator, if applicable
				$this->PanelParticipant->create();
				$moderator_id = (int)$this->data['PanelParticipant']['moderator'];
				if($moderator_id) {
					$moderator_data = array();
					$moderator_data['PanelParticipant']['day_time_slot_id'] = $slot_id;
					$moderator_data['PanelParticipant']['panel_id'] = $panel_id;
					$moderator_data['PanelParticipant']['user_id'] = $moderator_id;
					$moderator_data['PanelParticipant']['moderator'] = 1;
					$this->PanelParticipant->save($moderator_data);
				}
				// Save other panelists
				if(array_key_exists('panelists', $this->data['PanelParticipant'])) {
					$selected_panelists = $this->data['PanelParticipant']['panelists'];
				} else {
					$selected_panelists = array();
				}
				foreach($selected_panelists as $panelist_id) {
					$panelist_id = (int)$panelist_id;
					if(!$panelist_id) {
						continue;
					}
					$this->PanelParticipant->create();
					$panelist_data = array();
					$panelist_data['PanelParticipant']['day_time_slot_id'] = $slot_id;
					$panelist_data['PanelParticipant']['panel_id'] = $panel_id;
					$panelist_data['PanelParticipant']['user_id'] = $panelist_id;
					$panelist_data['PanelParticipant']['panelist'] = 1;
					$this->PanelParticipant->save($panelist_data); 
				}
			}
			
			if ($success) {
				$this->Session->setFlash(__('The panelists have been saved', true));
				$this->redirect(array('controller' => 'panels', 'action' => 'scheduled'));
			} else {
				$this->Session->setFlash(__($error_msg, true));
			}
		}
		
		$this->PanelPref->unbindModel(array('belongsTo' => array('Panel')));
		$participants = $this->PanelPref->find('all', array(
			'recursive' => 1,
			'conditions' => array(
				'PanelPref.panel_id' => $panel_id,
				'PanelPref.interest' => 2,
				"OR" => array(
					'PanelParticipant.id' => NULL,
					'PanelParticipant.panel_id' => $panel_id,
				),
			),
			'order' => array('PanelPref.panel_rating_id DESC', 'User.name'),
			'joins' => array(
				array(
					'table' => 'users',
					'alias' => 'User',
					'type' => 'inner',
					'foreignKey' => false,
					'conditions' => array('PanelPref.user_id = User.id'),
				),
				array(
					'table' => 'user_time_slots',
					'alias' => 'UserTimeSlot',
					'type' => 'inner',
					'foreignKey' => false,
					'conditions' => array(
						'UserTimeSlot.user_id = User.id',
						'UserTimeSlot.day_time_slot_id = ' . $slot_id,
						'UserTimeSlot.available = 1',
					),
				),
				array(
					'table' => 'panel_participants',
					'alias' => 'PanelParticipant',
					'type' => 'left outer',
					'foreignKey' => false,
					'conditions' => array(
						'PanelParticipant.user_id = User.id',
						'PanelParticipant.day_time_slot_id = ' . $slot_id,
					),
				),
			),
		));
		$panelists_assigned = $this->PanelParticipant->find('all', array(
			'conditions' => array(
				'PanelParticipant.panel_id' => $panel_id,
			),
			'recursive' => -1,
		));
		$panelists_assigned = $this->hashByKey($panelists_assigned, 'PanelParticipant', 'user_id');
		$leader = $this->PanelParticipant->find('first', array(
			'conditions' => array(
				'PanelParticipant.panel_id' => $panel_id,
				'PanelParticipant.leader' => 1,
			),
		));
		if($leader) {
			$leader = $leader['PanelParticipant']['user_id'];
		} else {
			$leader = 0;
		}
		$moderator = $this->PanelParticipant->find('first', array(
			'conditions' => array(
				'PanelParticipant.panel_id' => $panel_id,
				'PanelParticipant.moderator' => 1,
			),
		));
		if($moderator) {
			$moderator = $moderator['PanelParticipant']['user_id'];
		} else {
			$moderator = 0;
		}
		
		
		$participants_by_id = $this->hashListByKey($participants, 'User', 'id');
		$participant_ids = array_keys($participants_by_id);
		
		// Now get a list of users force-assigned to the panel (but not necessarily marked as available etc)
		$assigned_conditions = array(
				'PanelParticipant.panel_id' => $panel_id,
		);
		if($participant_ids) {  // Filter out potential panelists already accounted for
			$assigned_conditions[] = 'PanelParticipant.user_id NOT IN (' . implode(',', $participant_ids) . ')';
		}
		$non_avail_assigned = $this->PanelParticipant->find('all', array(
			'conditions' => $assigned_conditions,
			'joins' => array(
				array(
					'table' => 'users',
					'alias' => 'User',
					'type' => 'inner',
					'foreignKey' => false,
					'conditions' => array('PanelParticipant.user_id = User.id'),
				),
			),
		));
		
		if($participant_ids) {
			$user_avoids = $this->UserAvoid->find('all', array(
				'recursive' => 1,
				'conditions' => array(
					'UserAvoid.requester_id IN ('. implode(',', $participant_ids) . ')',
				),
			));
			$user_avoids = $this->hashListByKey($user_avoids, 'UserAvoid', 'requester_id');
			
			$user_collabs = $this->UserCollab->find('all', array(
				'recursive' => 1,
				'conditions' => array(
					'UserCollab.requester_id IN ('. implode(',', $participant_ids) . ')',
				),
			));
			$user_collabs = $this->hashListByKey($user_collabs, 'UserCollab', 'requester_id');
		} else {
			$user_avoids = array();
			$user_collabs = array();
		}
		
		
		$this->set(compact('panel', 'slot', 'participants', 'leader', 'moderator', 'panelists_assigned', 
			'user_avoids', 'user_collabs', 'participant_ids', 'non_avail_assigned'));
		
	}
	
	function panelist_index() {
		$panel_guide_numbers = $this->PanelSchedule->getPanelsByProgramGuideOrder();
		$panels_by_user = $this->PanelParticipant->find('all', array(
			'recursive' => -1,
			'fields' => array(
				'DISTINCT PanelParticipant.user_id',
				'PanelParticipant.panel_id'
			),
		));
		$panels_by_user = $this->hashListByKey($panels_by_user, 'PanelParticipant', 'user_id');
		
		$users = $this->User->find('all', array(
			'fields' => array(
				'User.id',
				'User.first_name',
				'User.last_name'
			),
			'order' => array('User.last_name', 'User.first_name'),
		));
		
		$this->set(compact('panel_guide_numbers', 'panels_by_user', 'users'));
	}
	
/**
 * Clear room and time slot assignments for a panel. 
 * Assigned panelists are unaffected
 */
	function schedule_clear() {
		$panel_id = (int)$this->params['named']['panel'];
		if(!$panel_id) {
			$this->Session->setFlash('Error: Panel not specified.');
			$this->redirect(array('controller' => 'panels', 'action' => 'by_time'));
		}
		
		// Make sure panel exists in the db
		$panel = $this->Panel->findById($panel_id);
		if(!$panel) {
			$this->Session->setFlash('Clear Schedule - Error: No panel found by that id.');
			$this->redirect(array('controller' => 'panels', 'action' => 'by_time'));
		}
		
		// Clear the room and time slot assignment for this panel
		$this->PanelSchedule->deleteAll(array(
			'PanelSchedule.panel_id' => $panel_id,
		));
		
		// Also clear the timeslot of the assigned panelists for that panel
		// (leave assignments intact)
		$this->PanelParticipant->updateAll(
			array('PanelParticipant.day_time_slot_id' => NULL),
			array('PanelParticipant.panel_id' => $panel_id)
		);
		$panel_name = $panel['Panel']['name'];
		$this->Session->setFlash('Room and time slot assignment cleared for ' . $panel_name . '.');
		$this->redirect(array('controller' => 'panels', 'action' => 'by_time'));
	}
	
	function schedule_new() {
		$panel_id = (int)$this->params['named']['panel'];
		$slot_id = (int)$this->params['named']['slot'];
		if(!$panel_id || !$slot_id) {
			$this->Session->setFlash('Error: Panel or Slot not specified.');
			$this->redirect(array('controller' => 'panels', 'action' => 'by_time'));
		}
		$slot = $this->DayTimeSlot->findById($slot_id);
		$panel = $this->Panel->findById($panel_id);
		$panel_length = $panel['PanelLength']['minutes'];
		// Incoming post data
		if (!empty($this->data)) {
			$error_msg = 'The panel could not be scheduled for this room and time slot. Please, try again.';
			// Schedule the first slot.
			$this->data['PanelSchedule']['panel_id'] = $panel_id;
			
			$scheduled_minutes = 0;
			$success = TRUE;
			$panel_slot_id = $slot_id; 
			while(($scheduled_minutes < $panel_length) && $success) {
				$this->data['PanelSchedule']['day_time_slot_id'] = $panel_slot_id;
				$this->PanelSchedule->create();
				if (!$this->PanelSchedule->save($this->data)) {
//				if(!print "Saved: slot $slot_id, panel $panel_id, room {$this->data['PanelSchedule']['room_id']}<br />") {
					$success = FALSE;
				}
				$panel_slot_id += 1;  // Schedule the next slot if necessary
				$scheduled_minutes += 30;
			}
			
			// Now save panelists
			if($this->data['PanelParticipant']) {
				$this->PanelParticipant->create();
				// Save Leader, if applicable
				$leader_id = (int)$this->data['PanelParticipant']['leader'];
				if($leader_id) {
					$leader_data = array();
					$leader_data['PanelParticipant']['day_time_slot_id'] = $slot_id;
					$leader_data['PanelParticipant']['panel_id'] = $panel_id;
					$leader_data['PanelParticipant']['user_id'] = $leader_id;
					$leader_data['PanelParticipant']['leader'] = 1;
					$this->PanelParticipant->save($leader_data); 
				}
				// Save Moderator, if applicable
				$this->PanelParticipant->create();
				$moderator_id = (int)$this->data['PanelParticipant']['moderator'];
				if($moderator_id) {
					$moderator_data = array();
					$moderator_data['PanelParticipant']['day_time_slot_id'] = $slot_id;
					$moderator_data['PanelParticipant']['panel_id'] = $panel_id;
					$moderator_data['PanelParticipant']['user_id'] = $moderator_id;
					$moderator_data['PanelParticipant']['moderator'] = 1;
					$this->PanelParticipant->save($moderator_data);
				}
				// Save other panelists
				if(array_key_exists('panelists', $this->data['PanelParticipant'])) {
					$selected_panelists = $this->data['PanelParticipant']['panelists'];
				} else {
					$selected_panelists = array();
				}
				foreach($selected_panelists as $panelist_id) {
					$panelist_id = (int)$panelist_id;
					if(!$panelist_id) {
						continue;
					}
					$this->PanelParticipant->create();
					$panelist_data = array();
					$panelist_data['PanelParticipant']['day_time_slot_id'] = $slot_id;
					$panelist_data['PanelParticipant']['panel_id'] = $panel_id;
					$panelist_data['PanelParticipant']['user_id'] = $panelist_id;
					$panelist_data['PanelParticipant']['panelist'] = 1;
					$this->PanelParticipant->save($panelist_data); 
				}
			}
			
			if ($success) {
				$this->Session->setFlash(__('The panel has been scheduled', true));
				$this->redirect(array('controller' => 'panels', 'action' => 'by_time'));
			} else {
				$this->Session->setFlash(__($error_msg, true));
			}
		}
		$assigned_rooms = $this->PanelSchedule->find('all', array(
			'fields' => array('PanelSchedule.room_id'),
			'conditions' => array('PanelSchedule.day_time_slot_id' => $slot_id),
		));
		$room_options = array();
		$assigned_rooms = $this->hashByKey($assigned_rooms, 'PanelSchedule', 'room_id');
		if($assigned_rooms) {
			$assigned_rooms = array_keys($assigned_rooms);
			$assigned_rooms = implode(',', $assigned_rooms);
			$room_options['conditions'] = array(
				'Room.id NOT IN (' . $assigned_rooms . ')'
			);
		}
		
//		$panelists_scheduled_for_slot = $this->PanelParticipant->find('all', array(
//			'recursive' => 0,
//			'fields' => array('PanelParticipant.user_id')
//		));
		
		$rooms = $this->PanelSchedule->Room->find('list', $room_options);
		$this->PanelPref->unbindModel(array('belongsTo' => array('Panel')));
		$participants = $this->PanelPref->find('all', array(
			'recursive' => 1,
			'conditions' => array(
				'PanelPref.panel_id' => $panel_id,
				'PanelPref.interest' => 2,
				'PanelParticipant.id' => NULL,
			),
			'order' => array('PanelPref.panel_rating_id DESC', 'User.name'),
			'joins' => array(
				array(
					'table' => 'users',
					'alias' => 'User',
					'type' => 'inner',
					'foreignKey' => false,
					'conditions' => array('PanelPref.user_id = User.id'),
				),
				array(
					'table' => 'user_time_slots',
					'alias' => 'UserTimeSlot',
					'type' => 'inner',
					'foreignKey' => false,
					'conditions' => array(
						'UserTimeSlot.user_id = User.id',
						'UserTimeSlot.day_time_slot_id = ' . $slot_id,
						'UserTimeSlot.available = 1',
					),
				),
				array(
					'table' => 'panel_participants',
					'alias' => 'PanelParticipant',
					'type' => 'left outer',
					'foreignKey' => false,
					'conditions' => array(
						'PanelParticipant.user_id = User.id',
						'PanelParticipant.day_time_slot_id = ' . $slot_id,
					),
				),
			),
		));
		
		$panelists_assigned = $this->PanelParticipant->find('all', array(
			'conditions' => array(
				'PanelParticipant.panel_id' => $panel_id,
			),
			'recursive' => -1,
		));
		$panelists_assigned = $this->hashByKey($panelists_assigned, 'PanelParticipant', 'user_id');
		$leader = $this->PanelParticipant->find('first', array(
			'conditions' => array(
				'PanelParticipant.panel_id' => $panel_id,
				'PanelParticipant.leader' => 1,
			),
		));
		if($leader) {
			$leader = $leader['PanelParticipant']['user_id'];
		} else {
			$leader = 0;
		}
		$moderator = $this->PanelParticipant->find('first', array(
			'conditions' => array(
				'PanelParticipant.panel_id' => $panel_id,
				'PanelParticipant.moderator' => 1,
			),
		));
		if($moderator) {
			$moderator = $moderator['PanelParticipant']['user_id'];
		} else {
			$moderator = 0;
		}
		$participant_ids = array_keys($this->hashListByKey($participants, 'User', 'id'));
		$user_avoids = $this->UserAvoid->find('all', array(
			'recursive' => 1,
			'conditions' => array(
				'UserAvoid.requester_id IN ('. implode(',', $participant_ids) . ')',
			),
		));
		$user_avoids = $this->hashListByKey($user_avoids, 'UserAvoid', 'requester_id');
		
		$user_collabs = $this->UserCollab->find('all', array(
			'recursive' => 1,
			'conditions' => array(
				'UserCollab.requester_id IN ('. implode(',', $participant_ids) . ')',
			),
		));
		$user_collabs = $this->hashListByKey($user_collabs, 'UserCollab', 'requester_id');
		
		$this->set(compact('panel', 'slot', 'rooms', 'participants', 'leader', 'moderator', 'panelists_assigned', 'user_avoids', 'user_collabs', 'participant_ids'));
	}
	
	function schedule_sheets() {
		$this->layout = 'print';
		
		$users = $this->User->find('all', array(
			'recursive' => -1,
			'fields' => array(
				'User.id', 'User.last_name', 'User.name'
			),
			'conditions' => array(
				'User.roles' => 'pro',
			),
			'order' => array('User.last_name', 'User.first_name')
		));
		$panels_sorted = $this->PanelSchedule->getSortedPanels();
		
		$panel_details = $this->Panel->find('all', array(
			'recursive' => 1,
		));
		$panel_details = $this->hashByKey($panel_details, 'Panel', 'id');
//		$panels_by_id = $this->hashByKey($panels_sorted, array(0, 'PanelSchedule'), 'panel_id');
		$slot_details = $this->DayTimeSlot->find('all', array(
		));
		$slot_details = $this->hashByKey($slot_details, 'DayTimeSlot', 'id');
		
		$panel_participants = $this->PanelParticipant->find('all', array(
			'recursive' => -1,
			'fields' => array(
				'DISTINCT PanelParticipant.user_id', 'PanelParticipant.leader', 'PanelParticipant.moderator',
				'PanelParticipant.panel_id',
			),
		));
		$panel_participants = $this->hashListByKey($panel_participants, 'PanelParticipant', 'panel_id');
		
		// Assemble the list of panels, for each user, in sorted order
		$user_sorted_panels = array();
		foreach($panels_sorted as $panel) {
			$panel_id = $panel['PanelSchedule']['panel_id'];
			if(!array_key_exists($panel_id, $panel_participants)) {
				continue;  // Skip panels with no panelists assigned (like the Meet the Prose party)
			}
			$users_on_panel = $panel_participants[$panel_id];
			foreach($users_on_panel as $assignment) {
				$user_id = $assignment['PanelParticipant']['user_id'];
				$user_sorted_panels[$user_id][] = array_merge($assignment, $panel);
			}
		}

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
			'order' => array(
				'PanelParticipant.panel_id',
				'User.last_name',
				'User.first_name',
			),
		));
		$all_participants = $this->hashListByKey($all_participants, 'PanelParticipant', 'panel_id');
		
		$this->set(compact('users', 'panel_details', 'slot_details', 
					'user_sorted_panels', 'all_participants'));
	}
	
	function scheduled() {
		$scheduled_panels = $this->PanelSchedule->find('all', array(
			'recursive' => 1,
			'order' => array('PanelSchedule.panel_id'),
		));
		$scheduled_user_panels = $this->hashListByKey($scheduled_panels, 'PanelSchedule', 'panel_id');
		
		if($scheduled_panels) {
			$scheduled_user_panels = array_keys($scheduled_user_panels);
			$this->PanelParticipant->unbindModel(array('belongsTo' => array('Panel')));
			$scheduled_users = $this->PanelParticipant->find('all', array(
				'recursive' => 0,
				'conditions' => array(
					'PanelParticipant.panel_id IN (' . implode(',', $scheduled_user_panels) . ')',
				),
				'order' => array(
					'PanelParticipant.leader DESC',
					'PanelParticipant.moderator DESC',
					'PanelParticipant.user_id',
				),
			));
			
			$scheduled_users = $this->hashListByKey($scheduled_users, 'PanelParticipant', 'panel_id');
		} else {
			$scheduled_users = array();
		}
		
		$time_slots = $this->DayTimeSlot->find('all', array(
			'conditions' => array(
			),
		));
		$time_slots = $this->hashByKey($time_slots, 'DayTimeSlot', 'id');
		$this->set(compact('scheduled_panels', 'scheduled_users', 'time_slots'));
	}

	function unscheduled() {
		$unscheduled_panels = $this->Panel->find('all', array(
			'recursive' => 1,
			'order' => array('Panel.id'),
			'conditions' => array(
				'PanelSchedule.id' => NULL,
				'Panel.disabled' => 0
			),
			'joins' => array(
				array(
					'table' => 'panel_schedules',
					'alias' => 'PanelSchedule',
					'type' => 'left outer',
					'foreignKey' => false,
					'conditions' => array('PanelSchedule.panel_id = Panel.id'),
				),
			),
		));
		$this->set(compact('unscheduled_panels'));
	}
}
?>