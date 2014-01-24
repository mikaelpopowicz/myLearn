<?php
namespace Library\Entities\NEW;

class classe extends \Library\Entity {
	
	protected  $session,$id_session,$libelle; // 
	
	const LIBELLE_INVALIDE = 1;
	
	
	public function isValid()
	{
		return !(empty($this->session) || (empty($this->id_session) (empty(this->libelle)) );
	}
	
	// SETTERS //
   
	public function setSession($session)
	{
			$this->libelle = $libelle;
	}
   
	public function setId_session($id_session)
	{
			$this->id_session = $id_session;
	}
		
	public function setLibelle($libelle)
	{	
		if (empty($libelle))
		{
			$this->erreurs[] = self::LIBELLE_INVALIDE;
		}
		else
		{
			$this->libelle = $libelle;
		}
	}

		// GETTERS //
   
	public function session()
	{
		return $this->session;
	}
   
	public function id_session()
	{
		return $this->id_session;
	}
	public function id_session()
	{
		return $this->libelle;
	}

}

?>