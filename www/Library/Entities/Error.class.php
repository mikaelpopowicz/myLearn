<?php
namespace Library\Entities;

class Error extends \Library\Entity
{
	private $code,
	$message,
	$type;
	
	public function code()
	{
		return $this->code;
	}
	
	public function message()
	{
		return $this->message;
	}
	
	public function type()
	{
		return $this->type
	}
}
?>