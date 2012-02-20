<?php
class Panel extends AppModel {
	var $name = 'Panel';
	var $recursive = 1;
	
	
	var $validate = array(
		'panel_type_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'name' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'disabled' => array(
			'boolean' => array(
				'rule' => array('boolean'),
				'allowEmpty' => true,
				'required' => false,
				'message' => 'Invalid option for Disabled checkbox',
			),
		),
	);
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'PanelType' => array(
			'className' => 'PanelType',
			'foreignKey' => 'panel_type_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'PanelLength' => array(
			'className' => 'PanelLength',
			'foreignKey' => 'panel_length_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Track' => array(
			'className' => 'Track',
			'foreignKey' => 'track_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
	
	public function nextPanelAfter($panel_id) {  // $number = 5, $sort = "created DESC"
		$next_panel = $this->find('first', 
									array('fields' => 'Panel.id',
										'recursive' => -1,
										'order' => 'Panel.id ASC',
										'conditions' => array(
											'Panel.id >' => $panel_id,
											'Panel.disabled' => 0,
										)
									));
		if($next_panel) {
			return $next_panel['Panel']['id'];
		} else {  // No more panels after this one
			return NULL;
		}
	}

	public function panelBefore($panel_id) {
		$prev_panel = $this->find('first', 
									array('fields' => 'Panel.id',
										'recursive' => -1,
										'order' => 'Panel.id DESC',
										'conditions' => array(
											'Panel.id <' => $panel_id,
											'Panel.disabled' => 0,
										)
									));
		if($prev_panel) {
			return $prev_panel['Panel']['id'];
		} else {  // No more panels before this one
			return NULL;
		}
	}
	
	function paginate($conditions, $fields, $order, $limit, $page = 1, $recursive = null, $extra = array()) {
		$recursive = 1;
		$group = $fields = array('id', 'name', 'panel_type_id');
		$conditions = array('disabled' => 0);
		return $this->find('all', compact('conditions', 'fields', 'order', 'limit', 'page', 'recursive', 'group'));
	}
}
?>