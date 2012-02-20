<?php
/* PanelLength Test cases generated on: 2011-05-01 23:59:19 : 1304308759*/
App::import('Model', 'PanelLength');

class PanelLengthTestCase extends CakeTestCase {
	var $fixtures = array('app.panel_length', 'app.panel', 'app.panel_type', 'app.track');

	function startTest() {
		$this->PanelLength =& ClassRegistry::init('PanelLength');
	}

	function endTest() {
		unset($this->PanelLength);
		ClassRegistry::flush();
	}

}
?>