<?php
/* Panel Test cases generated on: 2011-05-02 00:48:45 : 1304311725*/
App::import('Model', 'Panel');

class PanelTestCase extends CakeTestCase {
	var $fixtures = array('app.panel', 'app.panel_type', 'app.panel_length', 'app.track');

	function startTest() {
		$this->Panel =& ClassRegistry::init('Panel');
	}

	function endTest() {
		unset($this->Panel);
		ClassRegistry::flush();
	}

}
?>