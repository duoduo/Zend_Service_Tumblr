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
class Zend_Service_Tumblr
{
	/**
	 * Tumblr email
	 *
	 * @var string
	 */
	protected $_email;
	
	/**
	 * Tumblr password
	 *
	 * @var string
	 */
	protected $_password;
	
	/**
	 * Zend_Http_Client_Adapter_Curl
	 *
	 * @var Zend_Http_Client_Adapter_Curl
	 */
	protected $_httpClient;
	
	/**
	 * Valid Tumblr post types
	 *
	 * @var array
	 */
	protected $_validPostTypes = array(
		'text',
		'photo',
		'video',
		'audio',
		'quote',
		'link',
		'conversation'
		);
		
	/**
	 * Tumblr status codes
	 *
	 * @var array
	 */
	protected $_statusCodes = array(
		'success' => 201,
		'forbidden' => 403,
		'bad' => 400
		);
		
	const API_URI = 'http://www.tumblr.com';
	const PATH_WRITE = '/api/write';
	const PATH_READ = '/api/read';
	const PATH_AUTHENTICATE = '/authenticate';
	
	/**
	 * Set email and password on init
	 *
	 * @param string $email 
	 * @param string $password 
	 */
	public function __construct($email = null, $password = null)
	{
		if ($email !== null && $password !== null) {
			$this->_email = $email;
			$this->_password = $password;
		}
	}
	
	/**
	 * Gets http client instance
	 *
	 * @return Zend_Http_Client
	 */
	public function getHttpClient()
	{
		if (!$this->_httpClient instanceof Zend_Http_Client) {
			require_once 'Zend/Http/Client.php';
			require_once 'Zend/Http/Client/Adapter/Curl.php';
			$adapter = new Zend_Http_Client_Adapter_Curl();
			$this->_httpClient = new Zend_Http_Client();
			$this->_httpClient->setAdapter($adapter);
		}
		
		return $this->_httpClient;
	}
	
	/**
	 * Http client instance setter
	 *
	 * @param Zend_Http_Client $httpClient 
	 * @return void
	 */
	public function setHttpClient(Zend_Http_Client $httpClient)
	{
		$this->_httpClient = $httpClient;
	}
	
	/**
	 * Get email
	 *
	 * @return string
	 */
	public function getEmail()
	{
		return $this->_email;
	}
	
	/**
	 * Set email
	 *
	 * @param string $email 
	 * @return void
	 */
	public function setEmail($email)
	{
		$this->_email = $email;
	}
	
	/**
	 * Get password
	 *
	 * @return string $this->_password
	 */
	public function getPassword()
	{
		return $this->_password;
	}
	
	/**
	 * Set password
	 *
	 * @param string $password 
	 * @return void
	 */
	public function setPassword($password)
	{
		$this->_password = $password;
	}
	
	/**
	 * Factory method to create type of post you want
	 *
	 * @param string $postType 
	 * @return 
	 */
	public function createNewPost($postType)
	{
		$postType = strtolower($postType);
		if (in_array($postType, $this->_validPostTypes)) {
			$postType = ucfirst($postType);
			$className = "Zend_Service_Tumblr_Post_{$postType}";
			if (!class_exists($className)) {
                require_once 'Zend/Loader.php';
                Zend_Loader::loadClass($className);
            }

			return new $className($this);
		}
	}
	
	/**
	 * Get tumblelog
	 *
	 * @param string $tumblrAddress 
	 * @return void
	 */
	public function getTumblelog($tumblrAddress)
	{
		require_once 'Zend/Service/Tumblr/Tumblelog.php';
		$tumblelog = new Zend_Service_Tumblr_Tumblelog($this, $tumblrAddress);
	}
	
	/**
	 * Checks to see if authenticate credenticals exist
	 *
	 * @return void
	 */
	public function hasAuthentication()
	{
		if (!is_null($this->getEmail()) && !is_null($this->getPassword())) {
			return true;
		}
		
		return false;
	}
	
	/**
	 * Make read request
	 *
	 * @param string $uri 
	 * @param string $params 
	 * @return DOMDocument
	 */
	public function makeReadRequest($uri, $params = array())
	{
		if ($this->hasAuthentication()) {
			$method = 'POST';
		} else {
			$method = 'GET';
		}
		
		$response = $this->_makeRequest($uri, $method, $params);
		//var_dump($this->getHttpClient()->getLastRequest());
		//var_dump($response); 
		//var_dump($response->getBody());
		//exit;
		if ($response->isSuccessful()) {
            $doc = new DOMDocument();
            $doc->loadXML($response->getBody());
		}
		
		return $doc;
	}
	
	/**
	 * Make tumblr write request
	 *
	 * @param array $params
	 * @return bool
	 */
	public function makeWriteRequest($params)
	{
		$response = $this->_makeRequest(self::API_URI . self::PATH_WRITE, 'POST', $params);
		return $this->_isSuccessfulStatusCode($response->getStatus());
	}
	
	/**
	 * Make tumblr request
	 *
	 * @param string $uri 
	 * @param string $method 
	 * @param array $params 
	 * @return Zend_Http_Response
	 */
	protected function _makeRequest($uri, $method, $params)
	{
		$httpClient = $this->getHttpClient();
		$httpClient->setUri($uri);
		$httpClient->setMethod(Zend_Http_Client::POST);
		$params = $this->_transformFileParam($params);
		if ($method == 'POST') {
			$httpClient->setParameterPost($params);
		} else {
			$httpClient->setParameterGet($params);
		}
		
		return $httpClient->request();
	}
	
	/**
	 * Looks for file paramater and prepends "@" sign for CURL to recongize file upload
	 *
	 * @param string $params 
	 * @return void
	 */
	protected function _transformFileParam($params)
	{
		if(isset($params['data'])){
			$params['data'] = "@{$params['data']}";
		}
		
		return $params;
	}
	
	/**
	 * Checks to see if status code is successful
	 *
	 * @param int $statusCode 
	 * @return bool
	 */
	protected function _isSuccessfulStatusCode($statusCode)
	{
		if ($statusCode == $this->_statusCodes['success']) {
			return true;
		}
		
		return false;
	}
}
