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
abstract class Zend_Service_Tumblr_Post_Abstract
{
	
	/**
	 * Generator / source of post
	 *
	 * @var string
	 */
	protected $_generator;
	
	/**
	 * Date of post
	 *
	 * @var string
	 */
	protected $_date;
	
	/**
	 * Tags for post
	 *
	 * @var array
	 */
	protected $_tags = array();
	
	/**
	 * Format of content
	 *
	 * @var string
	 */
	protected $_format;
	
	/**
	 * Post to a group instead of your own blog
	 *
	 * @var string
	 */
	protected $_group;
	
	/**
	 * Zend_Tumblr_Service
	 *
	 * @var Zend_Tumblr_Service
	 */
	protected $_service;
	
	/**
	 * Base parameters
	 *
	 * @var array
	 */
	protected $_params;
	
	public function __construct($service)
	{
		$this->_service = $service;
	}
	
	/**
	 * Generator getter
	 *
	 * @return string
	 */
	public function getGenerator()
	{
		return $this->_generator;
	}
	
	/**
	 * Generator setter
	 *
	 * @param string $generator 
	 * @return void
	 */
	public function setGenerator($generator)
	{
		$this->_generator = $generator;
	}
	
	/**
	 * Date getter
	 *
	 * @return void
	 */
	public function getDate()
	{
		return $this->_date;
	}
	
	/**
	 * Date setter
	 *
	 * @param string $date 
	 * @return void
	 */
	public function setDate($date)
	{
		$this->_date = $date;
	}
	
	/**
	 * Format getter
	 *
	 * @return string
	 */
	public function getFormat()
	{
		return $this->_format;
	}
	
	/**
	 * Format setter
	 *
	 * @param string $format 
	 * @return void
	 */
	public function setFormat($format)
	{
		$this->_format = $format;
	}
	
	/**
	 * Tags getter
	 *
	 * @return array
	 */
	public function getTags()
	{
		return $this->_tags;
	}
	
	/**
	 * Tags setter
	 *
	 * @param array $tags 
	 * @return void
	 */
	public function setTags(array $tags)
	{
		$this->_tags = $tags;
	}
	
	/**
	 * Add a tag
	 *
	 * @param string $tag 
	 * @return void
	 */
	public function addTag($tag)
	{
		$this->_tags[] = $tag;
	}
	
	/**
	 * Group getter
	 *
	 * @return string
	 */
	public function getGroup()
	{
		return $this->_group;
	}
	
	/**
	 * Group setter
	 *
	 * @param string $group
	 * @return void
	 */
	public function setGroup($group)
	{
		$this->_group = $group;
	}
	
	/**
	 * Save method for post type
	 *
	 * @abstract
	 * @return void
	 */
	abstract public function save();
	
	/**
	 * Build base paramaters for posts
	 *
	 * @return array base parameters
	 */
	protected function _buildBaseParams()
	{
		$this->_addParam('email', $this->_service->getEmail());
		$this->_addParam('password', $this->_service->getPassword());
		$this->_addParam('generator', $this->getGenerator());
		$this->_addParam('date', $this->getDate());
		if (count($this->getTags())) {
			$this->_addParam('tags', implode(',', $this->getTags()));
		}
		
		$this->_addParam('format', $this->getFormat());
		$this->_addParam('group', $this->getGroup());
		return $this->_getParams();
	}
	
	/**
	 * Get base parameters
	 *
	 * @return array
	 */
	protected function _getParams()
	{
		return $this->_params;
	}
	
	/**
	 * Add a base parameter
	 * 
	 * Additionally takes care of checking for values that are not set
	 *
	 * @param string $name 
	 * @param string $value 
	 * @return void
	 */
	protected function _addParam($key, $value)
	{
		if ($value !== null) {
			$this->_params[$key] = $value;
		}
	}
}
