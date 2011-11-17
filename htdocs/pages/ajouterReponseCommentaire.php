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
	$sections = getSections();
	$questions = getQuestions();
	$nbQuestionsParSection = getNbQuestionsParSection($sections);
	$anneeUniversitaire = getAnneeUniversitaire();
	$matieres = getMatieresEtudiant($anneeUniversitaire,$idEtudiant);
	$messages = array();
	$etat=false;
	$etat2=false;
	$fin=false;
	
	if (count($matieres)==0)	$fin = true;

	/* 	id = 0 -> choix de la matiere 
		id = 1 -> formulaires des commentaires
		id = 2 -> traitement
	*/
	if(!$fin && $id==1){

		$erreurMatiere = false;
		$erreurRadio = false;
		
		if(isset($_POST['matiere'])){
			$matiere = $_POST['matiere'];
			if($_POST['matiere'] == '') {
				$erreurMatiere = true;
			}
		} else $erreurMatiere = true;
	
		if($erreurMatiere) 	echo "<script>alert('Veuillez désigner une matière!');</script>"; 
		else				$etat=true;

	}else if(!$fin && $id==2){

		$erreurMatiere = false;
		$erreurRadio = false;
		
		if(isset($_GET['c'])){
			$codeApogee = $_GET['c'];
			if($_GET['c'] == '') {
				$erreurMatiere = true;
			}
		} else $erreurMatiere = true;
		
		for($i=0; $i<count($questions); $i++){
			if (!isset($_POST["$i"]))
				$erreurRadio = true;
			$boutonRadioCoche[$i] = $_POST["$i"];
		}

		if($erreurMatiere) 		echo "<script>alert('Veuillez désigner une matière!');</script>"; 
		else{	
			$etat = true;
			if($erreurRadio)	echo "<script>alert('Veuillez répondre à toutes les questions!');</script>"; 
			else				$etat2=true;
		}
	}	
	
	if (!$fin && !$etat){ //si le formulaire n'a pas été rempli correctement, on le fait compléter par l'utilisateur		
		echo("<form action=\"index.php?page=$page&amp;id=1\" method=\"post\">
			<div class=\"entete\">
				<div class=\"boldItalic\">
					<div class=\"wrapper\">
						<div class=\"leftEntete\">Formation: RICM 4</div>
						Année: $anneeUniversitaire
					</div>
				</div>
				<div class=\"wrapper\" style=\"margin:5px 0px 5px 0px;\">
					<div class=\"leftEntete2\">Matière: ");
						liste("matiere",$matieres,1);
		echo("		</div>
					<div class=\"leftEntete2\">
						<input type=\"submit\"/>
					</div>
				</div>
			</div>
		</form>");

	}else if (!$fin && ($id==1 || !$etat2)){
		if ($id==2)	$matiere = getIntitule($codeApogee);
		else			$codeApogee = getCodeApogee($matiere);
		$enseignants = getEnseignants($codeApogee);
		afficherEnteteFicheEval($anneeUniversitaire,$matiere,$enseignants);
		echo("<form action=\"index.php?page=$page&amp;id=2&amp;c=$codeApogee\" method=\"post\">
			<div class=\"entete\">
				<div class=\"systemeEvaluation\">4 = Bien ; 3 = Plutôt Positif ; 2 = Plutôt négatif ; 1 = Insuffisant</div>
				<div><b>Thèmes</b></div>
			</div>
			<div class=\"contenerFiche\">");
			$j = 0;
			for($i=0;$i<count($sections);$i++){
				echo("<div class=\"contenairSection\">
					<div class=\"section\">
						<span class=\"titreSection\">".$sections[$i]."</span>
						<div class=\"wrapper\">	
							<div class=\"rightRadioButton\">");
								for($n=4;$n>0;$n--)
									echo("<div class=\"button\">$n</div>");
				echo("		</div>
						</div>");
				$k = $j;
	
				while($j<$k+$nbQuestionsParSection[$i]){
					echo("<div class=\"wrapper\">
							<div class=\"leftQuestion\">".$questions[$j]."</div>
							<div class=\"rightRadioButton\">");
								for ($l=4;$l>0;$l--){
									$checked = '';
									if($boutonRadioCoche[$j] == $l){
										$checked = "checked";
									}
									input("radio",$j,$l,$checked);
								}
					echo("	</div>
						</div>");
					$j++;
				}
		
				if(isset($_POST["message_$i"]))	$messages[] = $_POST["message_$i"];
				else							$messages[] = NULL;
				$message = $messages[$i];
				echo("<div class=\"wrapper\">
					<div class=\"commentaire\">
						<fieldset>
							<legend>Commentaires :</legend>
							<textarea cols=\"50\" rows=\"7\" name=\"message_$i\">$message</textarea>
						</fieldset>
				      </div>
				</div>
			</div>
		</div>");
		}
		echo("<div class=\"contenerEnvoyer\">
				<div class=\"contenerEnvoyerLeft\">Attention une fois que vous aurez cliqué sur envoyer, impossible de revenir en arrière.</div><div class=\"contenerEnvoyerRight\"><input type=\"submit\"/></div><br/></div>
		</div></form>");

	} else if (!$fin && $etat2){//si tout est ok on insère les enregistrements dans la Bdd
		for ($i=0;$i<count($questions);$i++) 
			updateTableReponse($idEtudiant,$codeApogee,$i+1,$boutonRadioCoche[$i]);
		for ($i=0;$i<count($sections);$i++)
			updateTableCommentaire($idEtudiant,$codeApogee,$i+1,$_POST["message_$i"],$anneeUniversitaire);
		echo "<p style=\"font-size:12px;text-align:center;\">Fiche d'évaluation enregistré ! "; 

		$nbFichesRestant = count(getMatieresEtudiant($anneeUniversitaire,$idEtudiant));
		if ($nbFichesRestant==0)
			echo "Vous avez remplit toutes les fiches d'évaluation de cette campagne.</p>"; 
		else
			echo "Il vous reste encore $nbFichesRestant  fiche d'évaluation à remplir.</p>"; 
	} else{
		echo "<p style=\"font-size:12px;text-align:center;\">Vous avez remplit toutes les fiches d'évaluation de cette campagne.</p>"; 
	}
?>
