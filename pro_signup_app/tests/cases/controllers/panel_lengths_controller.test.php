<?php
/* PanelLengths Test cases generated on: 2011-05-01 23:59:37 : 1304308777*/
App::import('Controller', 'PanelLengths');

class TestPanelLengthsController extends PanelLengthsController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class PanelLengthsControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.panel_length', 'app.panel', 'app.panel_type', 'app.track');

	function startTest() {
		$this->PanelLengths =& new TestPanelLengthsController();
		$this->PanelLengths->constructClasses();
	}

	function endTest() {
		unset($this->PanelLengths);
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