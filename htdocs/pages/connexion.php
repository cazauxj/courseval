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

	$envoie = $_GET['envoie'];
	if($envoie==1){
		$erreurLogin = $_GET['erreurLogin'];
		$erreurMdp = $_GET['erreurMdp'];
		$erreurConnexion = $_GET['erreurConnexion'];

		if ($erreurLogin) 			echo "<script>alert('Veuillez remplir le champ login!');</script>"; 
		elseif($erreurMdp)			echo "<script>alert('Veuillez saisir votre mot de passe!');</script>"; 
		elseif($erreurConnexion)	echo "<script>alert('Erreur: login et/ou mot de passe invalide');</script>";
	}	
	
	echo("<form action=\"pages/login.php\" method=\"post\">
		<div class=\"connexion\">
		<fieldset>
			<legend>Saisissez ci-dessous votre nom d'utilisateur et votre mot de passe</legend>
			<div class=\"contenu6Part\">
				<div class=\"wrapper\">
					<div class=\"part400\">
						<div class=\"leftPart6\">Login:</div>
						<div class=\"rightPart6\">");
							inputAux("text","login",$login);
	echo("					</div>
					</div>
					<div class=\"part400\">
						<div class=\"leftPart6\">Mot de passe:</div>
						<div class=\"rightPart6\">");
							inputAux("password","mdp",$mdp);
	echo("					</div>
					</div>
				</div>
			</div>
		</fieldset>
		<p class=\"button_identification\"><input type=\"submit\" value=\"envoyer\"/></p>
		</div></form>");
?>
