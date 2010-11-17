<?php

/**
 * Classe plxCapcha responsable du traitement antispam
 *
 * @package PLX
 * @author	Anthony GUÉRIN
 **/
class plxCapcha {

	var $min = false; # Longueur min du mot
	var $max = false; # Longueur max du mot
	var $gds = false; # Grain de sel du hachage
	var $word = false; # Mot du capcha
	var $num = false; # Numero de la lettre selectionne
	var $numletter = false; # Traduction du numero de la lettre

	/**
	 * Constructeur qui initialise les variables de classe
	 *
	 * @return	null
	 * @author	Anthony GUÉRIN
	 **/
	function plxCapcha() {

		# Initialisation des variables de classe
		$this->min = 4;
		$this->max = 6;
		$this->gds = 'f5z9Rez6EZ';
		$this->word = $this->createWord();
		$this->num = $this->chooseNum();
		$this->numletter = $this->num2letter();
	}

	function createWord() {

		# On genere une taille compris entre min et max
		$size = mt_rand($this->min,$this->max);
		# Definition de l'alphabet
		$alphabet = 'abcdefghijklmnopqrstuvwxyz';
		$size_a = strlen($alphabet);
		# On genere un tableau word
		for($i = 0; $i < $size; $i++)
			$word[ $i ] = $alphabet[ mt_rand(0,$size_a-1) ];
		# On serialise le tableau et on retourne la valeur
		return implode('',$word);
	}

	function chooseNum() {

		# On choisit un numero entre 1 et la taille du mot
		return mt_rand(1,strlen($this->word));
	}

	function num2letter() {

		# Num = derniere lettre du mot
		if($this->num == strlen($this->word))
			return 'derni&egrave;re';
		# On genere un tableau associatif
		$array = array(
			'1' => 'premi&egrave;re',
			'2' => 'deuxi&egrave;me',
			'3' => 'troisi&egrave;me',
			'4' => 'quatri&egrave;me',
			'5' => 'cinqui&egrave;me',
			'6' => 'sizi&egrave;me',
			'7' => 'septi&egrave;me',
			'8' => 'huiti&egrave;me',
			'9' => 'neuvi&egrave;me',
			'10' => 'dixi&egrave;me');
		# La valeur existe dans le tableau
		if(isset($array[ $this->num ]))
			return $array[ $this->num ];
		else # Sinon on retourne une valeur generique
			return $this->num.'.&egrave;me';
	}

	function q() {

		# Generation de la question capcha
		return 'Quelle est la '.$this->numletter.' lettre du mot '.$this->word.' ?';
	}

	function r() {

		# Generation du hash de la reponse
		return md5($this->gds.$this->word[ $this->num-1 ]);
	}

}
?>