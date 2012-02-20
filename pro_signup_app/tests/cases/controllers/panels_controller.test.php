<?php
/* Panels Test cases generated on: 2011-05-02 00:48:57 : 1304311737*/
App::import('Controller', 'Panels');

class TestPanelsController extends PanelsController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class PanelsControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.panel', 'app.panel_type', 'app.panel_length', 'app.track');

	function startTest() {
		$this->Panels =& new TestPanelsController();
		$this->Panels->constructClasses();
	}

	function endTest() {
		unset($this->Panels);
		ClassRegistry::flush();
	}

	function testIndex() {

	}

	function testView() {

	}

	function testAdd() {

	}

	function testEdit() {

	}

	function testDelete() {

	}

}
?>