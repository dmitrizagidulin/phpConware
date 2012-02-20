<?php
class DayTimeSlot extends AppModel {
	var $name = 'DayTimeSlot';
	var $validate = array(
		'enabled' => array(
			'boolean' => array(
				'rule' => array('boolean'),
				'allowEmpty' => true,
				'required' => false,
				'message' => 'Invalid option for Enabled checkbox',
			),
		),
	);
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'ConDay' => array(
			'className' => 'ConDay',
			'foreignKey' => 'con_day_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'TimeSlot' => array(
			'className' => 'TimeSlot',
			'foreignKey' => 'time_slot_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	public function slotsByDay($days) {
		$slots_by_day = array();
		foreach($days as $day) {
			$day_id = $day['ConDay']['id'];
			$day_slots = $this->find('all', array(
					'recursive' => 1,
					'conditions' => array(
						'con_day_id' => $day_id,
						'enabled' => 1,
					),
					'order' => 'TimeSlot.start'));
			$slots_by_day[$day_id] = $day_slots;
		}
		return $slots_by_day;
	}
	
}
?>