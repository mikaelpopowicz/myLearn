<?php
namespace Library\Models;

use \Library\Entities\Piece;
 
class PieceManager_PDO extends \Library\Models\PieceManager
{
	public static function getObj($requete, $mode = 'Alone')
	{
		$requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Library\Entities\Piece');
		
		if($mode == 'Alone')
		{
			$result = $requete->fetch();
			echo "<pre>";print_r($result);die('</pre>');
			$result->setDateUpload(new \DateTime($result->dateUpload()));
			
		}
		else if ($mode == 'Groups')
		{
			$result = $requete->fetchAll();
			foreach ($result as $piece)
			{
				$piece->setDateUpload(new \DateTime($piece->dateUpload()));
			}
		}
		return $result;
	}
	
	public function getUniquePJ($id)
	{
		$requete = $this->dao->prepare('SELECT id_pj AS id, libelle, chemin, dateUpload FROM piece_jointe WHERE id_pj = :id');
	
	    $requete->bindValue(':id', $id);
	    $requete->execute();
		$result = \Library\Models\PieceManager_PDO::getObj($requete);
		return $result;
	}
	
	public function ajouterPieceJointe(Piece $piece)
	{

		$requete = $this->dao->prepare('INSERT INTO piece_jointe SET libelle = :lib, chemin = :chemin, dateUpload = sysdate(), id_d = :devoir');
	
	    $requete->bindValue(':lib', $piece->libelle());
		$requete->bindValue(':chemin', $piece->chemin());
		$requete->bindValue(':devoir', $piece->devoir()->id());
	    $requete->execute();
	}
	
	public function ajouterPieceRendu(Piece $piece, $eleve)
	{

		$requete = $this->dao->prepare('INSERT INTO piece_rendu SET libelle = :lib, chemin = :chemin, dateUpload = sysdate(), id_d = :devoir, id_u = :eleve');
	
	    $requete->bindValue(':lib', $piece->libelle());
		$requete->bindValue(':chemin', $piece->chemin());
		$requete->bindValue(':devoir', $piece->devoir()->id());
		$requete->bindValue(':eleve', $eleve);
	    $requete->execute();
	}
	
  	public function deletePJ(Piece $piece)
  	{
  		$this->dao->exec('DELETE FROM piece_jointe WHERE id_pj = '.$piece['id']);
  	}
	
  	public function deletePR(Piece $piece)
  	{
  		$this->dao->exec('DELETE FROM piece_rendu WHERE id_pr = '.$piece['id']);
	} 
}
?>