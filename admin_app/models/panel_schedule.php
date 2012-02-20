<?php
class PanelSchedule extends AppModel {
	var $name = 'PanelSchedule';

	var $validate = array(
		'panel_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'Panel not specified',
				'allowEmpty' => false,
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'room_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'Please select a room',
				'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'day_time_slot_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'Please select a time slot',
				'allowEmpty' => false,
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);
	
	var $belongsTo = array(
		'Panel' => array(
			'className' => 'Panel',
			'foreignKey' => 'panel_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'DayTimeSlot' => array(
			'className' => 'DayTimeSlot',
			'foreignKey' => 'day_time_slot_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Room' => array(
			'className' => 'Room',
			'foreignKey' => 'room_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
	);
	
	public function getPanelsByProgramGuideOrder() {
		$panels_sorted = $this->getSortedPanels();
		if(!$panels_sorted) {
			return array();
		}
		$prog_guide_order = 1;
		$panels_by_order = array();
		foreach($panels_sorted as $panel) {
			$panel_id = $panel['PanelSchedule']['panel_id'];
			$panels_by_order[$panel_id] = $prog_guide_order;
			$prog_guide_order += 1;
		}
		return $panels_by_order;
	}
	
	public function getSortedPanels() {
		$panels_sorted = $this->find('all', array(
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
			'group' => array('PanelSchedule.panel_id'),
			'order' => array('con_day_id', 'time_slot_id', 'Room.sort_order'),
		));
		return $panels_sorted;
	}
}
?>