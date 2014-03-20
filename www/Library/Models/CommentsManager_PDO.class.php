<?php
namespace Library\Models;
 
use \Library\Entities\Comment;
 
class CommentsManager_PDO extends CommentsManager
{
	public function add(Comment $comment)
	{
		$q = $this->dao->prepare('INSERT INTO comments SET id_c = :cours, id_u = :auteur, commentaire = :commentaire, dateCommentaire = NOW()');
		$q->bindValue(':cours', $comment->cours());
		$q->bindValue(':auteur', $comment->auteur());
		$q->bindValue(':commentaire', $comment->commentaire());
		$q->execute();
	}
	
	public function getListOf($cours)
	{
		if (!ctype_digit($cours))
		{
			throw new \InvalidArgumentException('L\'identifiant de la news passé doit être un nombre entier valide');
		}
     
		$q = $this->dao->prepare('SELECT id_q AS id, id_c AS cours, id_u AS auteur, dateCommentaire, commentaire FROM comments WHERE id_c = :cours ORDER BY dateCommentaire DESC');
		$q->bindValue(':cours', $cours, \PDO::PARAM_INT);
		$q->execute();
     
		$q->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Library\Entities\Comment');
     
		$comments = $q->fetchAll();
     
		foreach ($comments as $comment)
		{
			$comment->setDateCommentaire(new \DateTime($comment->dateCommentaire()));
		}
     
		return $comments;
	}
	
	public function getCountOf($cours)
	{
		return $this->dao->query('SELECT COUNT(*) FROM comments WHERE id_c = '.$cours)->fetchColumn();
	}
}