<?php

class UsersAndProfiles extends CakeMigration {

/**
 * Migration description
 *
 * @var string
 * @access public
 */
	public $description = '';

/**
 * Actions to be performed
 *
 * @var array $migration
 * @access public
 */
	public $migration = array(
		'up' => array(
            'create_table' => array(
                'users' => array(
                    'id' => array('type' => 'integer','null'    => false,'default' => 0,'key' => 'primary'),
                    'name' => array('type'    =>'string','null'    => false,'default' => NULL,'length'  => 36),
                    'city' => array('type' =>'string','default' =>NULL,'length' => 30),
                    'indexes' => array('PRIMARY' => array('column' => 'id','unique' => 1))
                ),

            'profiles' => array(
                    'id' => array('type' => 'integer','null' => false,'default' => 0,'key'     => 'primary'),
                    'profile_type' => array('type'    =>'string','null'    => false,'default' => NULL,'length'  => 36),
                    'email' => array('type' =>'string','null' => false,'length' => 36),
                    'education' => array('type' => 'string','null' => true,'default' => NULL),
                    'indexes' => array('PRIMARY' => array('column' => 'id','unique' => 1)
                    )
                )
        ),),
                'down' => array(
		),
	);

/**
 * Before migration callback
 *
 * @param string $direction, up or down direction of migration process
 * @return boolean Should process continue
 * @access public
 */
	public function before($direction) {
		return true;
	}

/**
 * After migration callback
 *
 * @param string $direction, up or down direction of migration process
 * @return boolean Should process continue
 * @access public
 */
	public function after($direction) {
		return true;
	}


}


