<?php
/* RoomSizes Test cases generated on: 2011-05-01 23:05:47 : 1304305547*/
App::import('Controller', 'RoomSizes');

class TestRoomSizesController extends RoomSizesController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class RoomSizesControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.room_size', 'app.room', 'app.track', 'app.panel', 'app.panel_type');

	function startTest() {
		$this->RoomSizes =& new TestRoomSizesController();
		$this->RoomSizes->constructClasses();
	}

	function endTest() {
		unset($this->RoomSizes);
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