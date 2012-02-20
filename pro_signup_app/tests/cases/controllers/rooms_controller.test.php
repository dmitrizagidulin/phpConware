<?php
/* Rooms Test cases generated on: 2011-05-01 23:05:57 : 1304305557*/
App::import('Controller', 'Rooms');

class TestRoomsController extends RoomsController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class RoomsControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.room', 'app.room_size', 'app.track', 'app.panel', 'app.panel_type');

	function startTest() {
		$this->Rooms =& new TestRoomsController();
		$this->Rooms->constructClasses();
	}

	function endTest() {
		unset($this->Rooms);
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