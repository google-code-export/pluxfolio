<?php

/**
 * Classe plxRecord responsable du parcourt des enregistrements
 *
 * @package PLX
 * @author	Anthony GUÉRIN et Florent MONTHEL
 **/
class plxRecord {

	var $result = array(); # Tableau multidimensionnel associatif
	var $i = -1; # Position dans le tableau $result
	var $size = false; # Nombre d'elements dans le tableau $result

	/**
	 * Constructeur qui initialise les variables de classe
	 *
	 * @param	array	tableau associatif des résultats à traiter
	 * @return	null
	 * @author	Anthony GUÉRIN et Florent MONTHEL
	 **/
	function plxRecord(&$array) {

		# On initialise les variables de classe
		$this->result = &$array;
		$this->size = count($this->result);
	}

	/**
	 * Méthode qui incrémente judicieusement la variable $i 
	 *
	 * @return	booléen
	 * @author	Anthony GUÉRIN
	 **/
	function loop() {

		if($this->i < $this->size-1) { # Tant que l'on est pas en fin de tableau
			$this->i++;
			return true;
		}
		# On sort par une valeur negative
		$this->i = -1;
		return false;
	}

	/**
	 * Méthode qui récupère la valeur du champ $field 
	 * correspondant à la position courante
	 *
	 * @param	field	clef du tableau à retourner
	 * @return	string ou false
	 * @author	Anthony GUÉRIN et Florent MONTHEL
	 **/
	function f($field) {

		if($this->i == -1) # Compteur négatif
			$this->i++;
		# On controle que le champ demande existe bien
		if(isset($this->result[ $this->i ][ $field ]))
			return $this->result[ $this->i ][ $field ];
		else # Sinon on sort par une valeur negative
			return false;
	}

}
?>