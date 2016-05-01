<?php
class Container
{
	protected $parameters = array();

	public function __set($key, $value)
	{
		$this->parameters[$key] = $value;
	}

	public function __get($key)
	{
		return $this->parameters[$key];
	}
}
?>
