<?php
require_once 'MyPDO/MyPDO.emoji-tracker.include.php'; 

/* -------------------------------------------------
 * HASHTAG CLASS
 *	> get id, word
 *	> get all
 *	> get from emoji
 * -------------------------------------------------
 */

class Hashtag {
	/* --- Attributes --- */

	private $id = null;
	private $word = null;



	/* --- Constructor --- */
	
	// disable constructor
	function __construct() {}



	/* --- Basic Getters --- */
	// get id
	public function getId() { 
		return $this->id; 
	}

	// get word
	public function getWord() {
		return $this->word;
	}



	/* --- Complex Getters --- */

	/* GET ALL HASHTAGS
	 * Grabs all the moods from the database
	 * @return array<Hashtag>
	 */

	public static function getAll() {
		$stmt = MyPDO::getInstance()->prepare("SELECT * FROM hashtag");
		$stmt->execute();
		$stmt->setFetchMode(PDO::FETCH_CLASS, "Hashtag");
		if (($object = $stmt->fetchAll()) !== false)
			return $object;
		else
			throw new Exception("Hashtag table does'nt exist? Hmmm...");
	}



	/* GET ALL HASHTAGS FROM EMOJI
	 * return a list of instances of Hashtags used with a given emoji
	 * @params idEmoji, integer id of the used emoji
	 * @return array<Hashtag> list of instances of hashtags
	 */
	public function getFromEmoji($idEmoji) {
		$query = "
			SELECT * FROM hashtag 
			WHERE id IN ( SELECT idHashtag FROM relation WHERE idEmoji = ? )
		";

		$stmt = MyPDO::getInstance()->prepare($query);
		$stmt->bindValue(1,$idEmoji);
		$stmt->execute();

		$stmt->setFetchMode(PDO::FETCH_CLASS, "Hashtag");
		if (($object = $stmt->fetchAll()) !== false)
			return $object;
		else
			throw new Exception("Emoji id:$idEmoji does not exists.");
	}
}