<?php
class RoomTimeSlotsController extends AppController {

	var $name = 'RoomTimeSlots';
	var $uses = array('ConDay', 'TimeSlot', 'DayTimeSlot', 'RoomTimeSlot', 'Room');
	
	function index() {
//		$this->Track->recursive = 0;

//		$this->set('tracks', $this->paginate());
		$rooms = $this->Room->find('all');
		$days = $this->ConDay->find('all');
		
		$slots_by_day = array();
		foreach($days as $day) {
			$day_id = $day['ConDay']['id'];
			$day_slots = $this->DayTimeSlot->find('all', array(
					'recursive' => 1,
					'conditions' => array(
						'con_day_id' => $day_id,
						'enabled' => 1,
					),
					'order' => 'TimeSlot.start'));
			$slots_by_day[$day_id] = $day_slots;
		}
		
		$this->set(compact('days', 'slots_by_day', 'rooms'));
	}

}
?>