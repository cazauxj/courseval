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

	$id = $_GET['id'];
	$idEtudiant = $login;
	$codeApogee = $_GET['codeApogee'];
	$sections = getSections();
	$anneeUniversitaire = getAnneeUniversitaire();
	$messages = array();
	$etat=0;
	$etat2=0;
	$matieres = getMatieresDelegue($anneeUniversitaire);

	if (count($matieres)==0)	$fin = 1;
	else 					$fin = 0;
	
	/* 	id = 0 -> choix de la matiere 
		id = 1 -> formulaires des commentaires
		id = 2 -> traitement
	*/
	if(!$fin && $id==1){
		$erreurMatiere = false;
		
		if(isset($_POST['matiere'])){
			$matiere = $_POST['matiere'];
			if($_POST['matiere'] == '') 
				$erreurMatiere = true;
		} else $erreurMatiere = true;		
		
		if($erreurMatiere) 			echo "<script>alert('Veuillez désigner une matière!');</script>"; 
		else						$etat=1;   
	}else if (!$fin && $id==2){
		$erreurCommentaire = false;

		if(isset($_GET['c'])){
			$codeApogee = $_GET['c'];
			if($codeApogee == '') 
				$erreurMatiere = true;
		} else $erreurMatiere = true;		

		for($i=0;$i<count($sections);$i++){
			if(isset($_POST["message_$i"]) && $_POST["message_$i"]!="")
				$messages[] = $_POST["message_$i"];
			else{							
				$messages[] = NULL;
				$erreurCommentaire = true;
			}
		}

		if($erreurMatiere) 			echo "<script>alert('Veuillez désigner une matière!');</script>"; 
		else{
			$etat=1;
			if($erreurCommentaire) 	echo "<script>alert('Veuillez remplir tous les champs commantaire!');</script>"; 
			else						$etat2=1;   
		}
	}
	if (!$fin && !$etat){ //si le formulaire n'a pas été rempli correctement, on le fait compléter par l'utilisateur	
	
		echo("<form action=\"index.php?page=$page&amp;id=1\" method=\"post\">
			<div class=\"entete\">
				<div class=\"leftEntete\"><span class=\"bolde\">Formation</span>: RICM 4</div>
				<span class=\"bolde\">Année</span>: $anneeUniversitaire
								
				<div class=\"wrapper\" style=\"margin:5px 0px 5px 0px;\">
					<div class=\"leftEntete2\">
						<span class=\"bolde\">Matière</span>: ");
						liste("matiere",$matieres,1);
		echo("		</div>
					<div class=\"leftEntete2\">
						<input type=\"submit\"/>
					</div>
				</div>
			</div>
		</form>");

	}else if (!$fin && ($id==1 || !$etat2)){ //la matière et l'enseignant ont été choisi - le délégué doit alors saisir les commentaires résumé

		if ($id==2)	$matiere = getIntitule($codeApogee);
		else			$codeApogee = getCodeApogee($matiere);
		$enseignants = getEnseignants($codeApogee);
		$nbReponse = getNbReponse($codeApogee,$anneeUniversitaire);
		$nbCommentaire = getNbCommentaire($codeApogee,$anneeUniversitaire);
		$nbEtudiant = getNbEtudiant($codeApogee,$anneeUniversitaire);
		afficherEnteteFicheEvalDelegue($anneeUniversitaire,$matiere,$enseignants,$nbReponse,$nbCommentaire,$nbEtudiant);
	
		echo("<div class=\"contenuImage\">");
		for ($i=1;$i<=count($sections);$i++){
			if ($i%2==1)	echo("<div class=\"image\">");
			else		echo("<div class=\"image\">");
			echo("<img src=\"pages/image.php?idSection=$i&date=$anneeUniversitaire&codeApogee=$codeApogee\" alt=\"\"/></div>");
		}
		echo("</div>");
		echo("<div class=\"entete2\"></div>");

		echo("<div class=\"systemeEvaluation\">4 = Bien ; 3 = Plutôt Positif ; 2 = Plutôt négatif ; 1 = Insuffisant</div>
		<div><b>Thèmes</b></div>
		<div><form action=\"index.php?page=$page&amp;id=2&amp;c=$codeApogee\" method=\"post\">
			<div class=\"contenerFiche\">");
			$j = 0;
			for($i=0;$i<count($sections);$i++){
				echo("<div class=\"contenairSection\">
					<span class=\"titreSection\">".$sections[$i]."</span>");
			
					/*On affiche l'ensemble des commentaires des étudiants*/
					$commentaireEtudiants = getCommentaireEtudiants($codeApogee,$i+1,$anneeUniversitaire);
					$txt="";
					for ($j=0;$j<count($commentaireEtudiants);$j++){
						if ($commentaireEtudiants[$j]!="")
							$txt.= "-------------------------------------------------\n".$commentaireEtudiants[$j]."\n";
					}
					$txt.= "-------------------------------------------------\n";
					$message = $messages[$i];
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
			echo("</div>");
			echo("<div class=\"contenerEnvoyer\">
					<div class=\"contenerEnvoyerLeft\">
						Attention une fois que vous aurez cliqué sur envoyer, impossible de revenir en arrière.
					</div>
					<div class=\"contenerEnvoyerRight\"><input type=\"submit\"/></div><br/>
				</div>
		</form>
		</div>");

	}else if (!$fin){ //tout est ok
		for($i=0;$i<count($sections);$i++){
			updateTableSynthese($codeApogee,$i+1,nl2br($messages[$i]),$anneeUniversitaire);
		}
		echo "<p style=\"font-size:12px;text-align:center;\">Fiche résumé d'évaluation enregistré. "; 
		$nbFichesRestant = count(getMatieresDelegue($anneeUniversitaire));
		if ($nbFichesRestant==0)
			echo "Vous avez remplit toutes les fiches résumé de cette campagne.</p>"; 
		else
			echo "Il vous reste encore $nbFichesRestant résumé de fiche d'évaluation à remplir.</p>"; 
		
	} else{
		echo "<p style=\"font-size:12px;text-align:center;\">Vous avez remplit toutes les fiches résumé de cette campagne.</p>"; 
	}
?>
