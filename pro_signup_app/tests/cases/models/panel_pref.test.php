<?php
/* PanelPref Test cases generated on: 2011-05-03 01:56:02 : 1304402162*/
App::import('Model', 'PanelPref');

class PanelPrefTestCase extends CakeTestCase {
	var $fixtures = array('app.panel_pref', 'app.user', 'app.panel', 'app.panel_type', 'app.panel_length', 'app.track');

	function startTest() {
		$this->PanelPref =& ClassRegistry::init('PanelPref');
	}

	function endTest() {
		unset($this->PanelPref);
		ClassRegistry::flush();
	}

}
?>