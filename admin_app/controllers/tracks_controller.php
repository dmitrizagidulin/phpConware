<?php
class TracksController extends AppController {

	var $name = 'Tracks';

	function index() {
		$this->Track->recursive = 0;
		$this->set('tracks', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid track', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('track', $this->Track->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Track->create();
			if ($this->Track->save($this->data)) {
				$this->Session->setFlash(__('The track has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The track could not be saved. Please, try again.', true));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid track', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Track->save($this->data)) {
				$this->Session->setFlash(__('The track has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The track could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Track->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for track', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Track->delete($id)) {
			$this->Session->setFlash(__('Track deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Track was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
?>