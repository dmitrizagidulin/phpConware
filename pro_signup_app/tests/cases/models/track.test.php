<?php
/* Track Test cases generated on: 2011-05-01 22:18:40 : 1304302720*/
App::import('Model', 'Track');

class TrackTestCase extends CakeTestCase {
	var $fixtures = array('app.track', 'app.panel', 'app.panel_type');

	function startTest() {
		$this->Track =& ClassRegistry::init('Track');
	}

	function endTest() {
		unset($this->Track);
		ClassRegistry::flush();
	}

}
?>