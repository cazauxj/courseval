<?php
       /*
	* Teacher evaluation project
	* Copyright (C) Polytech'Grenoble 2009.
	* Contact Jeremy.Cazaux@mailoo.org
	* This library is free software; you can redistribute it and/or
	* modify it under the terms of the GNU Lesser General Public
	* License as published by the Free Software Foundation; either
	* version 2.1 of the License, or any later version.
	*
	* This library is distributed in the hope that it will be useful,
	* but WITHOUT ANY WARRANTY; without even the implied warranty of
	* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
	* Lesser General Public License for more details.
	*
	* You should have received a copy of the GNU Lesser General Public
	* License along with this library; if not, write to the Free Software
	* Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307
	* USA
	*/

	include("fonction.php");
	//connexionBdd("fichesEvaluation");
	connexionBdd("fiches_eval");

	$erreurLogin = false;
	$erreurMdp = false;
	$erreurConnexion = false;
		
	if(isset($_POST['login'])){
		$login = $_POST['login'];
		if($_POST['login'] == '') 
			$erreurLogin = true;
	} else $erreurLogin = true;
	
	if(isset($_POST['mdp'])){
		$mdp = $_POST['mdp'];
		if($_POST['mdp'] == '') 
			$erreurMdp = true;
	} else $erreurMdp = true;	

	if(getTypeUser($login,$mdp)==0)	
		$erreurConnexion = true;
	
	$host  = $_SERVER['HTTP_HOST'];
	$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');

	session_start();
	$_SESSION['login'] = $login;
	$_SESSION['mdp'] = $mdp;
	
	$url = "Location: http://$host$uri/../index.php?page=";
	if (!$erreurLogin && !$erreurMdp && !$erreurConnexion)
		$url .= "accueil";
 	else
		$url .= "connexion&envoie=1&login=$login&erreurLogin=$erreurLogin&erreurMdp=$erreurMdp&erreurConnexion=$erreurConnexion";

	deconnexionBdd();
	@header($url);
?>
