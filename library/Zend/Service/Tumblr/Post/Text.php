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
 * @package    Zend_Service
 * @subpackage Tumblr
 * @copyright  Copyright (c) 2005-2008 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 * @version    $Id: $
 */

/**
 * @see Zend_Service_Tumblr_Post_Abstract
 **/
require_once 'Zend/Service/Tumblr/Post/Abstract.php';

/**
 * @category   Zend
 * @package    Zend_Service
 * @subpackage Tumblr
 * @copyright  Copyright (c) 2005-2008 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */
class Zend_Service_Tumblr_Post_Text extends Zend_Service_Tumblr_Post_Abstract
{
	/**
	 * Post title
	 *
	 * @var string
	 */
	protected $_title;
	
	/**
	 * Post body content
	 *
	 * @var string
	 */
	protected $_body;
	
	/**
	 * Title getter
	 *
	 * @return void
	 */
	public function getTitle()
	{
		return $this->_title;
	}
	
	/**
	 * Title setter
	 *
	 * @param string $title 
	 * @return void
	 */
	public function setTitle($title)
	{
		$this->_title = $title;
	}
	
	/**
	 * Body getter
	 *
	 * @return string
	 */
	public function getBody()
	{
		return $this->_body;
	}
	
	/**
	 * Body setter
	 *
	 * @param string $body 
	 * @return void
	 */
	public function setBody($body)
	{
		$this->_body = $body;
	}
	
	/**
	 * Builds params and makes requests
	 *
	 * @return bool
	 */
	public function save()
	{
		$this->_buildBaseParams();
		$this->_addParam('title', $this->getTitle());
		$this->_addParam('body', $this->getBody());
		return $this->_service->makeWriteRequest($this->_getParams());
	}
}
