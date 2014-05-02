<?php
namespace Library;
 
class Message extends ApplicationComponent
{
	private $sujet,
	$code,
	$message,
	$icone;
	
	const ICO_CONF = "fa fa-gears";
	
	public function setSujet($sujet)
	{
		$this->sujet = $sujet;
	}
	
	public function setMessage($message)
	{
		$this->message = $message;
	}
	
	public function setIcone($icone)
	{
		$this->icone = $icone;
	}
	
	public function setCode($code)
	{
		$this->code = $code;
	}
	
	public function toString()
	{
		$str = '<div class="main-content">
					<div class="container">
						<h1 class="text-center">'.$this->sujet.'</h1>
						<div id="not-found">
							<h2>
								'.$this->code.'
								<i class="'.$this->icone.'"></i>
							</h2>
						</div>
						<div class="back-home">
							<p>'.$this->message.'</p>
						</div>
					</div><!--/container-->
				</div>';
		return $str;
	}
}