<?php
class Lazyval{
	private $evaluated, $value;
	
	function __construct($fun){
		$this->value = $fun;
		$this->evaluated = false;
	}
	
	public function get(){
		if(!$this->evaluated){
			$this->value = call_user_func($this->value);
			$this->evaluated = true;
		}
		return $this->value;
	}
}
