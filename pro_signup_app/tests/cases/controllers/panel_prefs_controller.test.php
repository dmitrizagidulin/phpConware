<?php
/* PanelPrefs Test cases generated on: 2011-05-03 02:11:25 : 1304403085*/
App::import('Controller', 'PanelPrefs');

class TestPanelPrefsController extends PanelPrefsController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class PanelPrefsControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.panel_pref', 'app.user', 'app.panel', 'app.panel_type', 'app.panel_length', 'app.track');

	function startTest() {
		$this->PanelPrefs =& new TestPanelPrefsController();
		$this->PanelPrefs->constructClasses();
	}

	function endTest() {
		unset($this->PanelPrefs);
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