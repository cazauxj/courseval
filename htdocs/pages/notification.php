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
	
	$action = $_GET['action'];
	$anneesUniversitaire = getAnneesUniversitaire();
	$etat=0;
	$notifications = array("Etudiants","Délégués");

	if ($action==1){
		$erreurAnneeUniversitaire = false;
		$erreurNotification = false;

		if(isset($_POST['annee']))		$anneeUniversitaire = $_POST['annee'];	
		else 						$erreurAnneeUniversitaire =true; 
		if (isset($_POST['notification']))	$notification = $_POST['notification'];
		else							$erreurNotification=true;

		if($erreurAnneeUniversitaire)echo "<script>alert('Veuillez choisir une année universitaire!');</script>"; 
		elseif($erreurIntitule) 	echo "<script>alert('Veuillez choisir une matière');</script>"; 
		elseif($erreurNotification)	echo "<script>alert('Veuillez choisir la notification');</script>";
		else				$etat=1;
	}	
	
	if ($action==1 && $etat==1){
		
		if ($notification=="Etudiants")		notificationEtudiantParMail();
		else if ($notification=="Délégués")	notificationDelegueParMail();
		echo("<p style=\"font-size:12px;text-align:center;\">Notification effectué.</p>");
	}else{
		echo("<form action=\"index.php?page=$page&amp;action=1\" method=\"post\">
			<div class=\"contenu6Part\">
				<div class=\"wrapper\">
					<div class=\"part200\">
						<div class=\"leftPart6\">Formation:</div>
						<div class=\"rightPart6\">RICM 4</div>
					</div>
					<div class=\"part200\">
						<div class=\"leftPart6\">Année:</div>
						<div class=\"rightPart6\">");
							liste('annee',$anneesUniversitaire,1);
		echo("				</div>
					</div>
					<div class=\"part200\">
						<div class=\"leftPart6\">Notification:</div>
						<div class=\"rightPart6\">");
							liste('notification',$notifications,1);
		echo("				</div>
					</div>
					<div class=\"part200\">
						<div class=\"rightPart6\">
							<input type=\"submit\"/>
						</div>		
					</div>
				</div>
			</div>
		</form>");
	}
?>
