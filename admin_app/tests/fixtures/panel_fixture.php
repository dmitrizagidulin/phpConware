<?php
/* Panel Fixture generated on: 2011-05-02 00:48:44 : 1304311724 */
class PanelFixture extends CakeTestFixture {
	var $name = 'Panel';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
		'panel_type_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'index'),
		'name' => array('type' => 'string', 'null' => false, 'default' => NULL, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'description' => array('type' => 'text', 'null' => false, 'default' => NULL, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'url_slug' => array('type' => 'string', 'null' => false, 'default' => NULL, 'key' => 'unique', 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'panel_length_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'length' => 10),
		'track_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'length' => 10, 'key' => 'index'),
		'num_panelists' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'length' => 10),
		'num_moderators' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'length' => 10),
		'keywords' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 500, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'url_slug' => array('column' => 'url_slug', 'unique' => 1), 'panel_type_id' => array('column' => 'panel_type_id', 'unique' => 0), 'track_id' => array('column' => 'track_id', 'unique' => 0)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM')
	);

	var $records = array(
		array(
			'id' => 1,
			'panel_type_id' => 1,
			'name' => 'Lorem ipsum dolor sit amet',
			'description' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'url_slug' => 'Lorem ipsum dolor sit amet',
			'panel_length_id' => 1,
			'track_id' => 1,
			'num_panelists' => 1,
			'num_moderators' => 1,
			'keywords' => 'Lorem ipsum dolor sit amet'
		),
	);
}
?>