<?php
App::uses('AppModel', 'Model');
/**
 * Profile Model
 *
 */
class Profile extends AppModel {
/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'id';


    public $belongsTo = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );
}
