<?php
class RoomSizesController extends AppController {

	var $name = 'RoomSizes';

	function index() {
		$this->RoomSize->recursive = 0;
		$this->set('roomSizes', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid room size', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('roomSize', $this->RoomSize->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->RoomSize->create();
			if ($this->RoomSize->save($this->data)) {
				$this->Session->setFlash(__('The room size has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The room size could not be saved. Please, try again.', true));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid room size', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->RoomSize->save($this->data)) {
				$this->Session->setFlash(__('The room size has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The room size could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->RoomSize->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for room size', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->RoomSize->delete($id)) {
			$this->Session->setFlash(__('Room size deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Room size was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
?>