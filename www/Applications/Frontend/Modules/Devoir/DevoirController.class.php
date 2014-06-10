<?php
namespace Applications\Frontend\Modules\Devoir;
class DevoirController extends \Library\BackController
{
	public function executeIndex(\Library\HTTPRequest $request)
	{
		$appelprofs= $this->managers->getManagerOf("Professeur")->getList();
		$this->page->addVar('lesprofs', $appelprofs);
		if ($request->postexists('valider'))
		{
			$nb1=$request->postData('nb1');
			$nb2=$request->postData('nb2');
			if (empty($nb1) || (empty($nb2)))
			{
				$this->page->addVar('message', 'va te faire foutre');
			}
			else
			{
				if (!is_numeric($nb1) && !is_numeric($nb2))
				{
					$this->page->addVar('message','pas bon tes valeurs ne sont pas numériques');
				}
				else
				{
					$this->page->addVar('message', $nb1+$nb2);
				}
			}
			/*
		
		{
			$renvoie =  $request->postData('prenom').' '. $request->postData('nom');
			$this->page->addVar('renvoie',$renvoie);
		}
		*/
		}
		
	}
}
	
/*
	$request->postExists('var') renvoi un booleen, vrai si $_POST['var'] existe bien, sinon faux
	$request->postData('var') renvoi la valeur de $_POST['data']
*/
	
	

//$appelmatiere = $this->managers->getManagerOf("Matiere")->getList();
//$this->page->addVar('lesmatieres', $appelmatiere);
// Pour $GET $POST  on a deux méthodes chacunes
	
?>
