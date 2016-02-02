<?php

namespace CoolBlueTest\Models;

class Address{

	/*
	 * @var string
	 */
	private $name;

	/*
	 * @var string
	 */
	private $phone;

	/*
	 * @var string
	 */
	private $street;

	public function getName(){
		return $this->name;
	}

	public function setName($name){
		if($name)
		$this->name = $name;
		return $this;
	}

	public function getPhone(){
		return $this->phone;
	}

	public function setPhone($phone){
		$this->phone = $phone;
		return $this;
	}

	public function getStreet(){
		return $this->street;
	}

	public function setStreet($street){
		$this->street = $street;
		return $this;
	}

	public function validateFormData($params){
		foreach ($this->getPropertyList() as $key => $value) {
			if(array_key_exists($key, $params)){
				if(gettype($params[$key]) != $value){
					return false;
				}
			}
		}
		return true;
	}

	protected function getPropertyList(){
		return array('name' => 'string', 'phone' => 'string', 'street' => 'string');
	}

	public function formatToSave(){
		return sprintf("%s,%s,%s", $this->getName(), $this->getPhone(), $this->getStreet());
	}
}