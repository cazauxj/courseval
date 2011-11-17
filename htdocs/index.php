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

  	error_reporting(E_ERROR);//error_reporting(E_ALL);
	define("USER","0");
	define("ETUDIANT","1");
	define("DELEGUE","2");
	define("ADMIN","3");

	include("pages/fonction.php");
	//connexionBdd("fichesEvaluation");
	connexionBdd("fiches_eval");
	session_start();

	$log = USER;
	if(isset($_SESSION['mdp']) && isset($_SESSION['login'])){
		$mdp = $_SESSION['mdp'];
		$login = $_SESSION['login']; 
		$log = getTypeUser($login,$mdp);
		if ($log==ETUDIANT)		$log=ETUDIANT;
		elseif ($log==DELEGUE)	$log=DELEGUE;
		elseif ($log==ADMIN)	$log=ADMIN;
	} 

	include("pages/header.php");	
	echo("<script  type=\"text/javascript\" src=\"javascript/scripts.js\"></script>");
	echo("<div id=\"contener\">");
		$page = $_GET['page'];
		$id = $_GET['id'];	
		$rep="pages/";

		if (($log!=USER && file_exists('./pages/'.$page.'.php') && (substr_count($page,"../")==0))||		($page='connexion'))	
			include($rep.$page.".php");
		else
			header('Location:index.php?page=connexion&amp;id=0'); 

	echo("<br/></div>");
	//importCsvEnseignant('csv/importEns1.csv');
	deconnexionBdd();
	include("pages/footer.php");
?>
