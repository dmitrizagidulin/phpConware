<?php
/* Tracks Test cases generated on: 2011-05-01 22:21:06 : 1304302866*/
App::import('Controller', 'Tracks');

class TestTracksController extends TracksController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class TracksControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.track', 'app.panel', 'app.panel_type');

	function startTest() {
		$this->Tracks =& new TestTracksController();
		$this->Tracks->constructClasses();
	}

	function endTest() {
		unset($this->Tracks);
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