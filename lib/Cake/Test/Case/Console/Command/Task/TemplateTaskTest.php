<?php
/**
 * TemplateTask file
 *
 * Test Case for TemplateTask generation shells task
 *
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       Cake.Test.Case.Console.Command.Task
 * @since         CakePHP(tm) v 1.3
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
App::uses('ShellDispatcher', 'Console');
App::uses('ConsoleOutput', 'Console');
App::uses('ConsoleInput', 'Console');
App::uses('Shell', 'Console');
App::uses('TemplateTask', 'Console/Command/Task');

/**
 * TemplateTaskTest class
 *
 * @package       Cake.Test.Case.Console.Command.Task
 */
class TemplateTaskTest extends CakeTestCase {

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$out = $this->getMock('ConsoleOutput', array(), array(), '', false);
		$in = $this->getMock('ConsoleInput', array(), array(), '', false);

		$this->Task = $this->getMock('TemplateTask',
			array('in', 'err', 'createFile', '_stop', 'clear'),
			array($out, $out, $in)
		);
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		parent::tearDown();
		unset($this->Task);
	}

/**
 * test that set sets variables
 *
 * @return void
 */
	public function testSet() {
		$this->Task->set('one', 'two');
		$this->assertTrue(isset($this->Task->templateVars['one']));
		$this->assertEquals('two', $this->Task->templateVars['one']);

		$this->Task->set(array('one' => 'three', 'four' => 'five'));
		$this->assertTrue(isset($this->Task->templateVars['one']));
		$this->assertEquals('three', $this->Task->templateVars['one']);
		$this->assertTrue(isset($this->Task->templateVars['four']));
		$this->assertEquals('five', $this->Task->templateVars['four']);

		$this->Task->templateVars = array();
		$this->Task->set(array(3 => 'three', 4 => 'four'));
		$this->Task->set(array(1 => 'one', 2 => 'two'));
		$expected = array(3 => 'three', 4 => 'four', 1 => 'one', 2 => 'two');
		$this->assertEquals($expected, $this->Task->templateVars);
	}

/**
 * test finding themes installed in
 *
 * @return void
 */
	public function testFindingInstalledThemesForBake() {
		$consoleLibs = CAKE . 'Console' . DS;
		$this->Task->initialize();
		$this->assertEquals($this->Task->templatePaths['default'], $consoleLibs . 'Templates' . DS . 'default' . DS);
	}

/**
 * test getting the correct theme name.  Ensure that with only one theme, or a theme param
 * that the user is not bugged.  If there are more, find and return the correct theme name
 *
 * @return void
 */
	public function testGetThemePath() {
		$defaultTheme = CAKE . 'Console' . DS . 'Templates' . DS . 'default' . DS;
		$this->Task->templatePaths = array('default' => $defaultTheme);

		$this->Task->expects($this->exactly(1))->method('in')->will($this->returnValue('1'));

		$result = $this->Task->getThemePath();
		$this->assertEquals($defaultTheme, $result);

		$this->Task->templatePaths = array('default' => $defaultTheme, 'other' => '/some/path');
		$this->Task->params['theme'] = 'other';
		$result = $this->Task->getThemePath();
		$this->assertEquals('/some/path', $result);

		$this->Task->params = array();
		$result = $this->Task->getThemePath();
		$this->assertEquals($defaultTheme, $result);
		$this->assertEquals('default', $this->Task->params['theme']);
	}

/**
 * test generate
 *
 * @return void
 */
	public function testGenerate() {
		App::build(array(
			'Console' => array(
				CAKE . 'Test' . DS . 'test_app' . DS . 'Console' . DS
			)
		));
		$this->Task->initialize();
		$this->Task->expects($this->any())->method('in')->will($this->returnValue(1));

		$result = $this->Task->generate('classes', 'test_object', array('test' => 'foo'));
		$expected = "I got rendered\nfoo";
		$this->assertEquals($expected, $result);
	}

/**
 * test generate with a missing template in the chosen theme.
 * ensure fallback to default works.
 *
 * @return void
 */
	public function testGenerateWithTemplateFallbacks() {
		App::build(array(
			'Console' => array(
				CAKE . 'Test' . DS . 'test_app' . DS . 'Console' . DS,
				CAKE_CORE_INCLUDE_PATH . DS . 'console' . DS
			)
		));
		$this->Task->initialize();
		$this->Task->params['theme'] = 'test';
		$this->Task->set(array(
			'model' => 'Article',
			'table' => 'articles',
			'import' => false,
			'records' => false,
			'schema' => ''
		));
		$result = $this->Task->generate('classes', 'fixture');
		$this->assertRegExp('/ArticleFixture extends CakeTestFixture/', $result);
	}
}
