<?php
namespace Library;

class Loading
{
	private $start,
	$end,
	$load;
	
	public function __construct($start = 0)
	{
		if($start != 0)
		{
			$this->setStart($start);
		}
	}
	
	public function setStart($start)
	{
		$this->start = $start;
	}
	
	public function setEnd($end)
	{
		$this->end = $end;
	}
	
	public function start() { return $this->start; }
	public function end() { return $this->end; }
	public function load() { return number_format($this->end - $this->start,3) * 1000; }
}
?>