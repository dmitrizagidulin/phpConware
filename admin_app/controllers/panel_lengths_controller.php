<?php
class PanelLengthsController extends AppController {

	var $name = 'PanelLengths';

	function index() {
		$this->PanelLength->recursive = 0;
		$this->set('panelLengths', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid panel length', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('panelLength', $this->PanelLength->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->PanelLength->create();
			if ($this->PanelLength->save($this->data)) {
				$this->Session->setFlash(__('The panel length has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The panel length could not be saved. Please, try again.', true));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid panel length', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->PanelLength->save($this->data)) {
				$this->Session->setFlash(__('The panel length has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The panel length could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->PanelLength->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for panel length', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->PanelLength->delete($id)) {
			$this->Session->setFlash(__('Panel length deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Panel length was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
?>