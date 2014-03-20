<?php
namespace Library\Entities;

class Session extends \Library\Entity
{
	private $session;

	const PREG_SESS = "#^[0-9]{4}\/[0-9]{4}$#";
	const SESS_INVALIDE = 1;

	public function isValid()
	{
		return !(empty($this->session));
	}

	// SETTERS //

	public function setSession($session)
	{
		if(!empty($session) && preg_match(self::PREG_SESS, $session))
		{
			$this->session = $session;
		}
		else
		{
			$this->erreurs[] = self::SESS_INVALIDE;
		}
	}

	// GETTERS //

	public function session() { return $this->session; }
}
?>