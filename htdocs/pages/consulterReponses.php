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
	$codesApogee = getCodesApogee();
	$intitules = getIntitules($codesApogee);
	$anneesUniversitaire = getAnneesUniversitaire();
	$nbSections = getNbSections();
	$etat=0;

	if ($action==1){
		$erreurAnneeUniversitaire = false;
		$erreurIntitule = false;

		if(isset($_POST['annee']))	$anneeUniversitaire = $_POST['annee'];	
		else 				$erreurAnneeUniversitaire =true; 
		if(isset($_POST['intitule']))	$intitule = $_POST['intitule'];	
		else				$erreurIntitule=true;

		if($erreurAnneeUniversitaire) echo "<script>alert('Veuillez choisir une année universitaire!');</script>"; 
		elseif($erreurIntitule) 	echo "<script>alert('Veuillez choisir une matière');</script>"; 
		else				$etat=1;
	}	

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
					<div class=\"leftPart6\">Matière:</div>
					<div class=\"rightPart6\">");
						liste('intitule',$intitules,5);
	echo("				</div>
				</div>
				<div class=\"part200\">
					<input type=\"submit\"/>
				</div>
			</div>
		</div>
	</form>");
	
	if ($action==1 && $etat==1){
		$codeApogee = getCodeApogee($intitule);
		$enseignants = getEnseignants($codeApogee);
		$option = getOption($codeApogee);
		$nbReponse = getNbReponse($codeApogee,$anneeUniversitaire);
		$nbCommentaire = getNbCommentaire($codeApogee,$anneeUniversitaire);
		$nbEtudiant = getNbEtudiant($codeApogee,$anneeUniversitaire);

		echo("<p class=\"contenu\">
			Année Universitaire:<span class=\"spanBold\">".$anneeUniversitaire."<br/></span>
			Matière:<span class=\"spanBold\">".$intitule."<br/></span>
			Code Apogee:<span class=\"spanBold\">".$codeApogee."<br/></span>");
			//Option:<span class=\"spanBold\">".$option."<br/></span>");
			if (count($enseignants)>0){
				echo("Enseignants: <span class=\"spanBold\">");
				$i=0;
				while($i<count($enseignants)){
					echo($enseignants[$i]." ".$enseignants[$i+1]);
					$i+=2;
					if (count($enseignants)>$i)	
						echo(", ");
				}
				echo("<br/></span>");
			}
			echo("Nombre de réponses: <span class=\"spanBold\">".$nbReponse."/".$nbEtudiant."<br/></span>
			       Nombre de commentaires: <span class=\"spanBold\">".$nbCommentaire."/".$nbEtudiant."<br/></span>");
		echo("</p>");
		echo("<div class=\"contenuImage\">");
		for ($i=1;$i<=$nbSections;$i++){
			if ($i%2==1)	echo("<div class=\"image\">");
			else		echo("<div class=\"image\">");
			echo("<img src=\"pages/image.php?idSection=$i&date=$anneeUniversitaire&codeApogee=$codeApogee\" alt=\"\"/></div>");
		}
		echo("</div>");
		echo("<p class=\"contenu\">");
			for ($i=1;$i<=$nbSections;$i++){
				$commentaire = getCommentaireResume($i,$codeApogee,$anneeUniversitaire);
				$nomSection = getNomSection($i);
				echo("<p><span class=\"spanBold\">Commentaire $nomSection: </span>".$commentaire."<br/></p>");
			}
		echo("</p>");

		/*
		echo("<div><form action=\"index.php?page=$page&amp;id=2&amp;c=$codeApogee\" method=\"post\">
			<div class=\"contenerFiche\">");
		$j = 0;
		for($i=0;$i<$nbSections;$i++){
			$nomSection = getNomSection($i+1);
			echo("<div class=\"contenairSection\">
				<span class=\"titreSection\">".$nomSection."</span>");
		
				//On affiche l'ensemble des commentaires des étudiants
				$commentaireEtudiants = getCommentaireEtudiants($codeApogee,$i+1,$anneeUniversitaire);
				$txt="";
				for ($j=0;$j<count($commentaireEtudiants);$j++){
					if ($commentaireEtudiants[$j]!="")
						$txt.= "-------------------------------------------------\n".$commentaireEtudiants[$j]."\n";
				}
				$txt.= "-------------------------------------------------\n";
				$message = "";
				echo("<div class=\"wrapper\">
						<div class=\"commentaire\">
							<fieldset>
								<legend>Commentaires des étudiants:</legend>
								<textarea cols=\"50\" rows=\"7\" name=\"message_$i\" readonly>$txt</textarea>
							</fieldset>
				      	</div>
						<div class=\"commentaireRigth\">
							<fieldset>
								<legend>Commentaire résumé:</legend>
								<textarea cols=\"50\" rows=\"7\" name=\"message_$i\">$message</textarea>
							</fieldset>
				      	</div>
					</div>
			</div>");
		}
		echo("</div></form></div>");*/
	}
?>
