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
 * @category   Zend
 * @package    Zend_Service
 * @subpackage Tumblr
 * @copyright  Copyright (c) 2005-2008 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */
class Zend_Service_Tumblr_Tumblelog
{	
	/**
	 * Zend_Tumblr_Service instance
	 *
	 * @var Zend_Tumblr_Service
	 */
	protected $_service;
	
	/**
	 * Tumblelog name
	 *
	 * @var string
	 */
	protected $_name;
	
	/**
	 * Tumblelog timezone
	 *
	 * @var string
	 */
	protected $_timezone;
	
	/**
	 * Tumblelog title
	 *
	 * @var string
	 */
	protected $_title;
	
	/**
	 * Tumblelog url
	 *
	 * @var string
	 */
	protected $_url;
	
	/**
	 * Tumblelog avatar url
	 *
	 * @var string
	 */
	protected $_avatarUrl;
	
	/**
	 * Is tumblelog authenticated
	 *
	 * @var string
	 */
	protected $_authenticated = false;
	
	/**
	 * Is default blog
	 *
	 * @var bool
	 */
	protected $_isPrimary;
	
	/**
	 * Tumblelog type
	 *
	 * @var string
	 */
	protected $_type;
	
	/**
	 * Tumblelog private id
	 *
	 * @var string
	 */
	protected $_privateId;
	
	/**
	 * Setup
	 *
	 * @param Zend_Tumblr_Service $service 
	 */
	public function __construct(Zend_Service_Tumblr $service, $url)
	{
		$this->_service = $service;
		$this->setUrl($url);
		$this->_read();
	}
	
	/**
	 * Fetch tumblelog from Tumblr and read in data
	 *
	 * @return void
	 */
	protected function _read()
	{
		$params = array();
		/*if ($this->_service->hasAuthentication()) {
			$params['email'] = $this->_service->getEmail();
			$params['password'] = $this->_service->getPassword();
		}*/
		
		$doc = $this->_service->makeReadRequest($this->getURL() . Zend_Service_Tumblr::PATH_READ, $params);
		$tumblelog = $doc->getElementsByTagName('tumblelog')->item(0);
		$this->setTitle($tumblelog->getAttribute('title'));
		$this->setType($tumblelog->getAttribute('type'));
		$this->setName($tumblelog->getAttribute('name'));
		//$this->setUrl($tumblelog->getAttribute('url'));
		$this->setAvatarURL($tumblelog->getAttribute('avatar-url'));
		//$this->setTitle($tumblelog->getAttribute('is-primary'));
		//$this->setTitle($tumblelog->getAttribute('private-id'));
		//exit;
	}
	
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
	 * Type getter
	 *
	 * @return void
	 */
	public function getType()
	{
		return $this->_type;
	}
	
	/**
	 * Type setter
	 *
	 * @param string $type 
	 * @return void
	 */
	public function setType($type)
	{
		$this->_type = $type;
	}
	
	/**
	 * Private id getter
	 *
	 * @return void
	 */
	public function getPrivateId()
	{
		return $this->_privateId;
	}
	
	/**
	 * Private id setter
	 *
	 * @param string $privateId 
	 * @return void
	 */
	public function setPrivateId($privateId)
	{
		$this->_privateId = $privateId;
	}
	
	/**
	 * Name getter
	 *
	 * @return void
	 */
	public function getName()
	{
		return $this->_name;
	}
	
	/**
	 * Name setter
	 *
	 * @param string $name 
	 * @return void
	 */
	public function setName($name)
	{
		$this->_name = $name;
	}
	
	/**
	 * Avatar URL getter
	 *
	 * @return void
	 */
	public function getAvatarUrl()
	{
		return $this->_avatarUrl;
	}
	
	/**
	 * Avatar URL setter
	 *
	 * @param string $avatarUrl 
	 * @return void
	 */
	public function setAvatarUrl($avatarUrl)
	{
		$this->_avatarUrl = $avatarUrl;
	}
	
	/**
	 * Checks if tumblelog is primary tumblelog
	 *
	 * @return void
	 */
	public function isPrimary()
	{
		return $this->_isPrimary;
	}
	
	/**
	 * Is primary setter
	 *
	 * @param string $isPrimary 
	 * @return void
	 */
	public function setIsPrimary($isPrimary)
	{
		$this->_isPrimary = $isPrimary;
	}
	
	/**
	 * URL getter
	 *
	 * @return string
	 */
	public function getUrl()
	{
		return $this->_url;
	}
	
	/**
	 * URL setter
	 *
	 * @param string $address 
	 * @return void
	 */
	public function setUrl($url)
	{
		$this->_url = $url;
	}
}
