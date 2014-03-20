<?
namespace Library\Entities;

class Crypt extends \Library\Entity
{
	private $message,
	$cle;

	public function isValid()
	{
		return !(empty($this->message) || empty($this->cle));
	}

	// SETTERS //

	public function setMessage($message)
	{
		$this->message = $message;
	}

	public function setCle($cle)
	{
		$this->cle = $cle;
	}

	// GETTERS //

	public function message() { return $this->message; }
	public function cle() { return $this->cle; }
}
?>