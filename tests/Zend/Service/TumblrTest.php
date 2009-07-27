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
require_once dirname(__FILE__) . '/../../TestHelper.php';


/**
 * @category   Zend
 * @package    Zend_Service_Tumblr
 * @subpackage UnitTests
 * @copyright  Copyright (c) 2005-2008 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */
 
class Zend_Service_TumblrTest extends PHPUnit_Framework_TestCase
{
	protected $_tumblr;
	
	protected function setUp()
	{
		$this->_tumblr = new Zend_Service_Tumblr();
	}
}