<?php
/**
 * Coupler Behavior Test Case File
 *
 * Copyright (c) 2007-2012 David Persson
 *
 * Distributed under the terms of the MIT License.
 * Redistributions of files must retain the above copyright notice.
 *
 * PHP 5
 * CakePHP 2
 *
 * @copyright     2007-2012 David Persson <davidpersson@gmx.de>
 * @link          http://github.com/davidpersson/media
 * @package       Media.Test.Case.Model.Behavior
 * @license       http://www.opensource.org/licenses/mit-license.php The MIT License
 */

App::uses('Set', 'Utility');
require_once dirname(__FILE__) . DS . 'BehaviorTestBase.php';

/**
 * Coupler Behavior Test Case Class
 *
 * @package       Media.Test.Case.Model.Behavior
 */
class CouplerBehaviorTest extends BaseBehaviorTest {

	public function setUp() {
		parent::setUp();

		$this->_behaviorSettings = array(
			'baseDirectory' => $this->Folder->pwd()
		);
	}

	public function testSetup() {
		$Model =& ClassRegistry::init('TheVoid');
		$Model->Behaviors->load('Media.Coupler');

		$Model =& ClassRegistry::init('Song');
		$Model->Behaviors->load('Media.Coupler');
	}

	public function testFind() {
		$Model =& ClassRegistry::init('Song');
		$Model->Behaviors->load('Media.Coupler', $this->_behaviorSettings);
		$result = $Model->find('all');
		$this->assertEqual(count($result), 4);

		/* Virtual */
		$result = $Model->findById(1);
		$this->assertTrue(Set::matches('/Song/file', $result));
		$this->assertEqual($result['Song']['file'], $this->file0);
	}

	public function testSave() {
		$Model =& ClassRegistry::init('Song');
		$Model->Behaviors->load('Media.Coupler', $this->_behaviorSettings);

		$file = $this->Data->getFile(array(
			'application-pdf.pdf' => $this->Folder->pwd() . 'static' . DS . 'doc' . DS . 'application-pdf.pdf'
		));
		$item = array('file' => $file);
		$Model->create();
		$result = $Model->save($item);
		$this->assertTrue($result);

		$result = $Model->findById(5);
		$expected = array(
			'Song' => array (
				'id' => '5',
					'dirname' => 'static/doc',
					'basename' => 'application-pdf.pdf',
					'checksum' => null,
					'file' => $file
		));
		$this->assertEqual($expected, $result);
	}

}

