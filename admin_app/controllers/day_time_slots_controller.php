<?php
class DayTimeSlotsController extends AppController {

	var $name = 'DayTimeSlots';
	var $uses = array('ConDay', 'TimeSlot', 'DayTimeSlot');
	
	function index() {
//		$this->Track->recursive = 0;

//		$this->set('tracks', $this->paginate());
		
		$days = $this->ConDay->find('all');
		
		$slots_by_day = $this->DayTimeSlot->slotsByDay($days);
		
		$this->set(compact('days', 'slots_by_day'));
	}

}
?>