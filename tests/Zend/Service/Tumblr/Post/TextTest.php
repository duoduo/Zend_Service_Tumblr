<?php

/**
 * Zend Framework
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://framework.zend.com/license/new-bsd
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@zend.com so we can send you a copy immediately.
 *
 * @category   Zend
 * @package    Zend_Service_Tumblr
 * @subpackage UnitTests
 * @copyright  Copyright (c) 2005-2008 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 * @version    $Id: BaseTests.php 15893 2009-06-04 23:12:54Z elazar $
 */


/**
 * Test helper
 */
require_once dirname(__FILE__) . '/../../../../TestHelper.php';

/** Zend_Service_Tumblr */
require_once 'Zend/Service/Tumblr.php';

/** Zend_Service_Tumblr_Post_Text */
require_once 'Zend/Service/Tumblr/Post/Text.php';


/**
 * @category   Zend
 * @package    Zend_Service_Tumblr
 * @subpackage UnitTests
 * @copyright  Copyright (c) 2005-2008 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */
 
class Zend_Service_Tumblr_Post_TextTest extends PHPUnit_Framework_TestCase
{
	protected $_tumblr;
	
	protected function setUp()
	{
		$this->_tumblr = new Zend_Service_Tumblr(TESTS_ZEND_SERVICE_TUMBLR_EMAIL, TESTS_ZEND_SERVICE_TUMBLR_PASSWORD);
	}
	
	protected function _getTestData()
	{
		return array(
			'title' => 'Test title',
			'body' => 'Test body',
			'format' => 'html',
			'date' => '2009-01-01',
			'generator' => 'Zend_Service_Tumblr',
			'tags' => array(
				'testing',
				'test'
				)
			);
	}
	
	public function testMinimalTextPostSetterAndGetter()
	{
		$data = $this->_getTestData();
		//new text post 
		$post = $this->_tumblr->createNewPost('text');
		$post->setTitle($data['title']); 
		$post->setBody($data['body']);
		
		$this->assertEquals($post->getTitle(), $data['title']);
		$this->assertEquals($post->getBody(), $data['body']);
	}
	
	public function testMinimalTextPostSave()
	{
		$data = $this->_getTestData();
		//new text post 
		$post = $this->_tumblr->createNewPost('text');
		$post->setTitle($data['title']); 
		$post->setBody($data['body']);	
		$this->assertTrue($post->save());
	}
	
	public function testMinimalTextPostSaveWithBadAuthentication()
	{
		$data = $this->_getTestData();
		$this->_tumblr->setPassword('thewrongpassword');
		$post = $this->_tumblr->createNewPost('text');
		$post->setTitle($data['title']); 
		$post->setBody($data['body']);	
		$this->assertFalse($post->save());
	}
	
	public function testFullTextPostSetterAndGetter()
	{
		$data = $this->_getTestData();
		$post = $this->_tumblr->createNewPost('text');
		$post->setTitle($data['title']);
		$post->setBody($data['body']);
		$post->setGenerator($data['generator']);
		$post->setFormat($data['format']);
		$post->setDate($data['date']);
		$post->setTags($data['tags']);
		
		$this->assertEquals($data['title'], $post->getTitle());
		$this->assertEquals($data['body'], $post->getBody());
		$this->assertEquals($data['generator'], $post->getGenerator());
		$this->assertEquals($data['format'], $post->getFormat());
		$this->assertEquals($data['date'], $post->getDate());
		$this->assertEquals($data['tags'], $post->getTags());
	}
	
	public function testFullTextPostSave()
	{
		$data = $this->_getTestData();
		$post = $this->_tumblr->createNewPost('text');
		$post->setTitle($data['title']);
		$post->setBody($data['body']);
		$post->setGenerator($data['generator']);
		$post->setFormat($data['format']);
		$post->setDate($data['date']);
		$post->setTags($data['tags']);
		$this->assertTrue($post->save());
	}
}