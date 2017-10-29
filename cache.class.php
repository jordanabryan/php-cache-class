<?php

/**
  * Cache
  * 
  * A simple cache class to save and retrieve html content.
  * Designed to limit database calls in a PHP application
  *
  */
class Cache{

	var $key;
	var $time;
	var $html = '';


	/**
      * 
      * sets the name of the file
      *
      * @param string $key  name of the file to check for 
      *
      */
	public function setKey($key){
		$this->key = dirname(__FILE__) . '/'.$key.'.txt';
	}


	/**
      * 
      * sets the expipre time of the document
      *
      * @param string $time  expire time for the document 
      *
      */
	public function setTime($time){
		$this->time = $time;
	}


	/**
      * 
      * sets the content of the cached file
      *
      * @param string $html  html content to save to the file
      *
      */
	public function setHTML($html){
		$this->html = $html; 
	}


	/**
      * 
      * Checks if a cache file exists by cache key
      *
      * @param string $time  expire time to check for
      * @param string $key  name of the file to check for 
      * @return boolean
      *
      */
	public function checkCache(){
		
		$currentTime = time(); 
		$expireTime = $this->time; 

		if(file_exists($this->key)){
			$fileTime = filemtime($this->key);
		} else {
			return false;
		}

		if(file_exists($this->key) && ($currentTime - $expireTime < $fileTime)) {
			return true;
		}else {
			return false;
		}

	}


	/**
      * 
      * Creates the cached file with the html string
      *
      * @param string $string  HTML content to save into the cache file
      * @param string $key  name of the file to check for 
      *
      */
	public function setCache(){

		$this->deleteCache($this->key);

		$fp = fopen($this->key, 'w+');
		fwrite($fp, $this->html);
		fclose($fp);

	}


	/**
      * 
      * Deletes the cached file
      *
      * @param string $key  name of the file to check for 
	  *
      */
	public function deleteCache(){

		if(file_exists($this->key)){
			unlink($this->key);
		}

	}


	/**
      * 
      * Retrieves the cached file
      *
      * @param string $key  name of the file to check for 
      * @return string
      *
      */
	public function getCache(){

		if(file_exists($this->key)){
			$fh = fopen($this->key, 'r');
			$cachedData = fread($fh, filesize($this->key));
			fclose($fh);
		} else {
			return false;
		}

		if($cachedData){
			$cachedDataArray = array(
				'data' => $cachedData,
				'time' => date('d-m-Y H:i:s', filemtime($this->key))
			);

			return $cachedDataArray;
			
		}

	}
	
}

?>