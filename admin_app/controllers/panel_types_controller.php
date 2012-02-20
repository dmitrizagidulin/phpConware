<?php
class PanelTypesController extends AppController {

	var $name = 'PanelTypes';

	function index() {
		$this->PanelType->recursive = 0;
		$this->set('panelTypes', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid panel type', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('panelType', $this->PanelType->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->PanelType->create();
			if ($this->PanelType->save($this->data)) {
				$this->Session->setFlash(__('The panel type has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The panel type could not be saved. Please, try again.', true));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid panel type', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->PanelType->save($this->data)) {
				$this->Session->setFlash(__('The panel type has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The panel type could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->PanelType->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for panel type', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->PanelType->delete($id)) {
			$this->Session->setFlash(__('Panel type deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Panel type was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
?>