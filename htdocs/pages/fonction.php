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

/*Connexion à la base de donnée $bdd*/
function connexionBdd($bd){ 
	mysql_pconnect("server","bdd","password");
	mysql_select_db($bd) or die("Erreur: Connexion BDD impossible");
}
       
/*Deconnexion à la base de donnée*/
function deconnexionBdd(){
	mysql_close(); 
}

//Ajout d'un formulaire ou boutton 
function input($type,$name,$value,$checked){
		echo("<div class=\"button\">");
			echo("<input type=\"$type\" name=\"$name\" value=\"$value\" $checked/>");
		echo("</div>");
} 

//Ajout d'un formulaire ou boutton 
function inputAux($type,$name,$value){
	echo("<input type=\"$type\" name=\"$name\" value=\"$value\"/>");
} 

//ajout d'une liste
function liste($name,$choix,$size){
	echo("<select name=\"$name\" size=\"$size\">");
	for($i=0;$i<count($choix);$i++){
		$par_defaut = '';
		if(isset($_POST[$name])){
			if ($_POST[$name] == "$i"){
				$par_defaut ="selected";
			}
		}
             	echo("<option value=\"".$choix[$i]."\" $par_defaut>".$choix[$i]."</option>");
	}
   	echo("</select>");
} 

//ajout d'une liste dynamique (javascript)--identifiant est l'id d'une division à rendre visible
function liste2($name,$id,$choix,$size,$identifiant){
	echo("<select name=\"$name\" id=\"$id\" size=\"$size\" onChange=\"setVisible('$identifiant');\">");
			
	if ($_POST[$name]=="")	echo("<option value=\"\" \"selected\"></option>");
	else 				echo("<option value=\"\"></option>");
	for($i=0;$i<count($choix);$i++){
		$par_defaut = '';
		if(isset($_POST[$name])){
			if ($_POST[$name] == "$i"){
				$par_defaut ="selected";
			}
		}
             	echo("<option value=\"".$choix[$i]."\" $par_defaut>".$choix[$i]."</option>");
	}
   	echo("</select>");
} 


function clear(){
	echo("<div class=\"clear\"></div>");
}

/*retourn le nom d'un fichier associé à un identifiant*/
function getFileName($idEtudiant){
	return 'e-'.$idEtudiant.'.csv';
}

/*fonction qui génère un nouvel identifiant enseignant.*/
function genereIdEnseignant(){
	$result = mysql_query("Select * From enseignant");
	return mysql_num_rows($result) + 1;
}

/*fonction qui génère un nouvel identifiant étudiant.*/
function genereIdEtudiant(){
	$result = mysql_query("Select * From etudiant");
	return mysql_num_rows($result) + 1;
}

/*fonction qui génère un nouvel identifiant password.*/
function genereIdPassword(){
	$result = mysql_query("Select * From password");
	return mysql_num_rows($result) + 1;
}

/*Génére un mot de passe de $nbChar aléatoirement*/
function genereMdp($nbChar) {
    	$chaine ="mnoTUzS5678kVvwxy9WXYZRNCDEFrslq41GtuaHIJKpOPQA23LcdefghiBMbj0";
    	srand((double)microtime()*1000000);
    	for($i=0; $i<$nbChar; $i++)	
		@$pass .= $chaine[rand()%strlen($chaine)];
	return $pass;
}

/*renvoi vrai si aucun enregistrement dans la bdd ne correspond à l'enseignant de nom $nom et de prénom $prenom'*/
function isEnseignantInexistant($nom,$prenom){
	$result = mysql_query("Select count(*) From `enseignant` Where nom='$nom' And prenom='$prenom'");
	return (mysql_result($result,0)==0);
}

/*renvoi l'id associé à un enseignant*/
function getIdEnseignant($nom,$prenom){
	$result = mysql_query("Select idEnseignant from `enseignant` where nom='$nom' And prenom='$prenom'");
	$donnees = mysql_fetch_array($result);
	return $donnees['idEnseignant'];
}

/*Retourne le commentaire syntétique associé à un code apogeen à une année universitaire et à une section*/
function getCommentaireResume($idSection,$codeApogee,$date){
	$result = mysql_query("Select commentaire From `synthese` Where idSection=$idSection And date='$date' And codeApogee='$codeApogee'");
	$donnees = mysql_fetch_array($result);
	//return nl2br(htmlentities($donnees['commentaire']));
	return $donnees['commentaire'];
}

/*Retourne le nombre de réponse associé à une matière et une année scolaire*/
function getNbReponse($codeApogee,$anneeUniversitaire){
	$result = mysql_query("Select distinct idEtudiant From `reponse` Where codeApogee='$codeApogee' And date='$anneeUniversitaire' And reponse is not NULL");
	return mysql_num_rows($result);
}

/*Retourne le nombre de commentaires associé à une matière et une année scolaire*/
function getNbCommentaire($codeApogee,$anneeUniversitaire){
	$result = mysql_query("Select distinct idEtudiant From `commentaire` Where codeApogee='$codeApogee' And date='$anneeUniversitaire' And commentaire is not NULL And commentaire<>''");
	return mysql_num_rows($result);
}

/*Retourne le nombre d'étudiant associé à une matière et une année scolaire*/
function getNbEtudiant($codeApogee,$anneeUniversitaire){
	$result = mysql_query("Select distinct idEtudiant From `reponse` Where codeApogee='$codeApogee' And date='$anneeUniversitaire'");
	return mysql_num_rows($result);
}

/*retourne le nombre de questions associé à une section*/
function getNbQuestionsBySection($idSection){
	$result = mysql_query("Select * From question Where section=$idSection");
	return mysql_num_rows($result);
}

/*retourne le plus petit identifiant d'une question associé à une section*/
function getFirstIdQuestionBySection($idSection){
	$result = mysql_query("Select * From question Where section=$idSection");
	$donnees = mysql_fetch_array($result);
	return $donnees['idQuestion'];
}

/*Retourne le nom de la section associé à l'idSection'*/
function getNomSection($idSection){
	$result = mysql_query("Select nomSection From section Where idSection=$idSection");
	$donnees = mysql_fetch_array($result);
	return nl2br(htmlentities($donnees['nomSection']));
}

/*Retourne le nom de la section associé à l'idSection'*/
function getNomSectionBrut($idSection){
	$result = mysql_query("Select nomSection From section Where idSection=$idSection");
	$donnees = mysql_fetch_array($result);
	return $donnees['nomSection'];
}

/*retourne le nombre de sections*/
function getNbSections(){
	$result = mysql_query("Select * From section");
	return mysql_num_rows($result);
}

/*Retourne l'ensemble des commentaires étudiants associé à une matière et à une section*/
function getCommentaireEtudiants($codeApogee,$idSection,$date){
	$commentaires = array();
	$result = mysql_query("Select commentaire From `commentaire` Where codeApogee='$codeApogee' And idSection=$idSection And date='$date' And commentaire is not NULL");
	while($donnees = mysql_fetch_array($result))
		$commentaires[] = $donnees['commentaire'];
	return $commentaires;
}

/*Retourne un array contenant l'ensemble des sections*/
function getSections(){
	$sections = array();
	$result = mysql_query("Select distinct nomSection From section");
	while($donnees = mysql_fetch_array($result))
		$sections[] = nl2br(htmlentities($donnees['nomSection']));
	return $sections;
}

/*Retourne un array contenant le nombre de questions par section*/
function getNbQuestionsParSection($sections){
	$nbQuestionsParSection = array();
	for ($i=1;$i<=count($sections);$i++)
		$nbQuestionsParSection[] = getNbQuestionsBySection($i);
	return $nbQuestionsParSection;
}

/*Retourne la liste des noms et prénoms d'enseignants associé à un code apogee'*/
function getEnseignants($codeApogee){
	$ens = array();
	$result = mysql_query("Select distinct nom,prenom from role Natural Join enseignant Where codeApogee='$codeApogee'");
	while($donnees = mysql_fetch_array($result)){
		$ens[] = nl2br(htmlentities($donnees['prenom']));
		$ens[] = nl2br(htmlentities($donnees['nom']));
	}
	return $ens;
}

/*Retourne la liste des matières avec lesquels le délégué n'a pas encore remplit les résumés de fiche d'évaluation*/
function getMatieresDelegue($date){
	$matieres = array();
	$result = mysql_query("Select distinct codeApogee,intitule from matiere Natural Join synthese Where date='$date' and commentaire is NULL");
	while($donnees = mysql_fetch_array($result))
		$matieres[] = nl2br(htmlentities($donnees['intitule']));
	return $matieres;
}

/*Retourne la liste des matières avec lesquels l'étudiant n'a pas encore remplit de fiche d'évaluation*/
function getMatieresEtudiant($date,$idEtudiant){
	$matieres = array();
	$result = mysql_query("Select distinct codeApogee,intitule from matiere Natural Join reponse Where date='$date' and idEtudiant=$idEtudiant and reponse is NULL");
	while($donnees = mysql_fetch_array($result))
		$matieres[] = nl2br(htmlentities($donnees['intitule']));
	return $matieres;
}

/*Retourne le type d'option associé à un code apogee*/
function getOption($codeApogee){
	$result = mysql_query("Select intitule from `option` Where codeApogee='$codeApogee'");
	if($donnees = mysql_fetch_array($result))
		$option = nl2br(htmlentities($donnees['intitule']));
	return $option;
}

/*Retourne un array contenant l'ensemble des filières*/
//A MODIFIER plus tard
function getFilieres(){
	return array("3i","e2i","Géotechnique","Matériaux","PRI","RICM","TIS");
}

/*Retourne un array contenant l'ensemble des questions'*/
function getQuestions(){
	$questions = array();
	$result = mysql_query("Select distinct texteQuestion From question");
	while($donnees = mysql_fetch_array($result))
		$questions[] = nl2br(htmlentities($donnees['texteQuestion']));
	return $questions;
}

function getMdpFromId($idPassword){
	$result = mysql_query("Select pwd From password Where idPassword='$idPassword'");
	$donnees = mysql_fetch_array($result);
	return $donnees['pwd'];
}

/*retourne l'intitulé associé à un codeApoogee*/
function getIntitule($codeApogee) {
	$result = mysql_query("Select intitule From matiere Where codeApogee='$codeApogee'");
	$donnees = mysql_fetch_array($result);
	return nl2br(htmlentities($donnees['intitule']));
}

/*retourne l'ensemble des codes apogee*/
function getCodesApogee(){
	$codesApogee = array();
	$result = mysql_query("Select distinct codeApogee From matiere");
	while($donnees = mysql_fetch_array($result))
		$codesApogee[] = $donnees['codeApogee'];
	return $codesApogee;
}

/*retourne l'ensemble des intitulé associé aux code apogee*/
function getIntitules($codesApogee){
	$intitules = array();
	for ($i=0;$i<sizeof($codesApogee);$i++)
		$intitules[]= getIntitule($codesApogee[$i]);
	return $intitules; 
}

//retourne le code apogee associé à un intitule
function getCodeApogee($intitule){
	$result = mysql_query("Select distinct codeApogee From matiere where intitule='$intitule'");
	$donnees = mysql_fetch_array($result);
	return $donnees['codeApogee'];
}

//retourne les différentes année universitaire ou l'on a saisit des fiches d'évaluation
function getAnneesUniversitaire(){
	$anneesUniversitaire = array();
	$result = mysql_query("Select distinct date From reponse");
	while($donnees = mysql_fetch_array($result))
		$anneesUniversitaire[] = $donnees['date'];
	return $anneesUniversitaire;
}

//renvoi l'année universitaire en cours
function getAnneeUniversitaire(){
	$today = getdate();
	$year = $today[year];
	$months = date('m');
	if ($months<9)	$year--;
	return $year."-".(++$year);
}

//renvoi le nom et le prénom(stocké dans un fichier csv) associé à un identifiant étudiant
function getPrenomNomEmailFromIdEtudiant($idEtudiant){
	$f = fopen("csv/".getFileName($idEtudiant), 'rb');
	if ($ligne = fgetcsv($f, 1024)) {
		$nom = $ligne[0];
		$prenom = $ligne[1];
		$email = $ligne[2];
		return array($prenom,$nom,$email);
	} else 
		return Null;
}

//Mise à jour de la table réponse
function updateTableReponse($idEtudiant,$codeApogee,$idQuestion,$reponse){
	$result = mysql_query("Update reponse set reponse=$reponse where idEtudiant='$idEtudiant' And codeApogee='$codeApogee' And idQuestion=$idQuestion");
}

//Mise à jour de la table commentaire
function updateTableCommentaire($idEtudiant,$codeApogee,$idSection,$commentaire,$date){
	$result = mysql_query("Update commentaire set commentaire='$commentaire' where idEtudiant=$idEtudiant And codeApogee='$codeApogee' And idSection=$idSection and date='$date'");
}

//Mise à jour de la table synthèse
function updateTableSynthese($codeApogee,$idSection,$commentaire,$date){
	$result = mysql_query("Update synthese set commentaire='$commentaire' where codeApogee='$codeApogee' And idSection=$idSection And date='$date'");
}

/*Retourne le type d'utilisateur associé à un login et mdp
  Type de valeurs retournée: 0(user),1(etudiant),2(delegue),3(admin)
*/
function getTypeUser($login,$mdp){
	$result = mysql_query("Select type From password Where pwd='$mdp' and idPassword=$login");
	if($result!=NULL && $donnees = mysql_fetch_array($result))	return $donnees['type'];
	else 											return 0;
}

//affiche l'entête d'une fiche d'évaluation avec l'année universitaire et la matière choisi par l'utilisateur
function afficherEnteteFicheEval($anneeUniversitaire,$matiere,$enseignants){
	echo("<div class=\"entete2\">
		<div class=\"wrapper\">
			<div class=\"leftEntete3\">
				<span class=\"bolde\">Formation</span>: RICM 4
			</div>
			<div class=\"leftEntete3\">
				<span class=\"bolde\">Année</span>: $anneeUniversitaire
			</div>
			<div class=\"leftEntete3\">
				<span class=\"bolde\">Matière</span>: $matiere
			</div>
		</div>");
		if (count($enseignants)>2)	echo("<span class=\"bolde\">Enseignants</span>: ");
		else						echo("<span class=\"bolde\">Enseignant</span>: ");
		$i=0;
		while($i<count($enseignants)){
			echo($enseignants[$i]." ".$enseignants[$i+1]);
			$i+=2;
			if (count($enseignants)>$i)	
				echo(", ");
		}
	echo("</div>");
}

//affiche l'entête d'une fiche d'évaluation avec l'année universitaire et la matière choisi par l'utilisateur
function afficherEnteteFicheEvalDelegue($anneeUniversitaire,$matiere,$enseignants,$nbReponse,$nbCommentaire,$nbEtudiant){
	echo("<div class=\"entete2\">
		<div class=\"wrapper\">
			<div class=\"leftEntete3\">
				<span class=\"bolde\">Formation</span>: RICM 4
			</div>
			<div class=\"leftEntete3\">
				<span class=\"bolde\">Année</span>: $anneeUniversitaire
			</div>
			<div class=\"leftEntete3\">
				<span class=\"bolde\">Matière</span>: $matiere
			</div>
		</div>");
		if (count($enseignants)>2)	echo("<span class=\"bolde\">Enseignants</span>: ");
		else						echo("<span class=\"bolde\">Enseignant</span>: ");
		$i=0;
		while($i<count($enseignants)){
			echo($enseignants[$i]." ".$enseignants[$i+1]);
			$i+=2;
			if (count($enseignants)>$i)	
				echo(", ");
		}
		echo("<br/><span class=\"bolde\">Nombre de réponses:</span> ".$nbReponse."/".$nbEtudiant."<br/><span class=\"bolde\">Nombre de commentaires:</span> ".$nbCommentaire."/".$nbEtudiant."<br/>");
	echo("</div>");
}

/*Créé le fichier csv d'un étudiant afin de stocker son nom et son prénom pour la notification par email*/
function createCsvFile($idEtudiant,$nom,$prenom,$email){
	$dir = 'csv/';
	$fileName = getFileName($idEtudiant);
	$f = fopen($dir.$fileName, "w+" ) or die('erreur d\'écriture<br/>');
	fputcsv($f, array($nom, $prenom,$email)); //fputcsv($fp, split($delimiter, $result));
	fclose($f);
}

/*Importe les données étudiant d'un fichier cvs dans une base de donnée
  Format d'un fichier .csv étudiant: "nom, prénom, @email,isDelegue, groupeCM, groupeTD, groupeTP, {codeApogeeMatière} avec isDelegue un boolean valant 1 si un étudiant est délégué, 0 sinon*/
function importCsvEtudiant($fichier){
	$nbSections = getNbSections();
	$anneeUniversitaire = getAnneeUniversitaire();
	$f = fopen($fichier, 'rb');
echo("appel à importCsvEtudiant");
	$nbL = 1; // compteur de ligne
	while($ligne=fgetcsv($f,1024,',')){
		$champs = count($ligne);//nombre de champ dans la ligne en question 
		echo "<b>  " . $champs . " champs de la ligne " . $nbL . " </b><br />";
		$nbL ++;
	//for ($ligne = fgetcsv($f, 1024); !feof($f); $ligne = fgetcsv($f, 1024)) {
  		//$j = sizeof($ligne);
		$j = $champs;
		//echo("Nb colonne:".$j."<br/>");
		
		echo("nom:".$ligne[1]." - prenom:".$ligne[0]." - email:".$ligne[2]." - isDelegue:".$ligne[3]);

		if ($j>6){
			$nom = $ligne[0];
			$prenom = $ligne[1];
			$email = $ligne[2];
			$isDelegue = $ligne[3];
			$groupeCM = $ligne[4];
			$groupeTD = $ligne[5];
			$groupeTP = $ligne[6];
			$idEtudiant = genereIdEtudiant();
			$idPassword = $idEtudiant;
;			$mdp = genereMdp(10);

			//insertion d'un enregistrement dans la table étudiant et password
			mysql_query("Insert Into etudiant Values($idEtudiant,$idPassword,$groupeCM,$groupeTD,$groupeTP,0)");
			echo("Insert Into etudiant Values($idEtudiant,$idPassword,$groupeCM,$groupeTD,$groupeTP,0)<br/>");
			mysql_query("Insert Into password Values($idPassword,'$mdp',1)");			

			//Génération du fichier "e-idEtudiant.cvs" associé à l'étudiant idEtudiant: nom, prenom
			createCsvFile($idEtudiant,$nom,$prenom,$email);
				
			if ($isDelegue){//On crée un nouvel identifiant et enregistrement associé au délégué
				$idEtudiant2 = genereIdEtudiant();
				$idPassword2 = $idEtudiant2;//genereIdPassword();
				$mdp2 = genereMdp(10);

				//insertion d'un enregistrement dans la table étudiant et password
				mysql_query("Insert into etudiant values($idEtudiant2,$idPassword2,$groupeCM,$groupeTD,$groupeTP,$isDelegue)");
				mysql_query("Insert Into password Values($idPassword2,'$mdp2',2)");

				//stockage du nom et du prénom (pour la notification) d'un d'élégué
				createCsvFile($idEtudiant2,$nom,$prenom,$email); 
			}

			//Initialisation des tables réponses que devra saisir l'étudiant identifié par l'identifiant $idEtudiant
	  		for ($i = 7; $i < $j; $i++) {
	    			$codeApogee = $ligne[$i]; 
				
				//Initialisation des tables réponses pour toutes les questions et sections
				for ($k=1;$k<=$nbSections;$k++){
					$nbQuestions = getNbQuestionsBySection($k);
					$firstIdQuestion = getFirstIdQuestionBySection($k);
					for ($l=0;$l<$nbQuestions;$l++){
						$idQuestion = $firstIdQuestion+$l;
						mysql_query("Insert into reponse values($idEtudiant,'$codeApogee',$idQuestion,NULL,'$anneeUniversitaire')"); 
					}
					//Initialisation de la table commentaire
					mysql_query("Insert into commentaire values($idEtudiant, '$codeApogee',$k, '$anneeUniversitaire', NULL)"); 
				}									
	    		}
 
			
			//Initialisation de la table synthèse si on est en présence d'un délégué
			if ($isDelegue){
				$result = mysql_query("Select Distinct codeApogee from commentaire where commentaire is NULL");
				while ($donnees=mysql_fetch_array($result)){
					$codeApogee = $donnees['codeApogee'];
					for ($k=1;$k<=$nbSections;$k++)
						mysql_query("Insert into synthese values($k, '$codeApogee','$anneeUniversitaire', NULL)");
				} 
			}			
		} else	echo("Erreur. Le fichier Etudiant.csv doit être de la forme 'nom prenom delegue {codeApogee}' avec delegue=1 si l'étudiant est un délégué, 0 sinon.'<br/>");
  	}
}

/*Envoi une notification par mail à tous les étudiants qui n'ont pas remplis la fiche d'une liste de matières identifié par leurs code codeApogee*/
function notificationEtudiantParMail(){
	$anneeUniversitaire = getAnneeUniversitaire();
	$listesIdEtudiant = array();
	$listesPwd = array();
	$subject = "[Polytech'Grenoble - Fiche d'évaluation des enseignants RICM à remplir]";
	$message = "<br/><br/>Veuillez remplir dans les plus bref délais les fiches d'évaluation des enseignements suivants:<br/>";

	//on récupère tous les identifiants des étudiant de l'année universitaire en cours qui n'ont pas encore rempli la fiche d'évaluation
	$result = mysql_query("Select Distinct idEtudiant From reponse Where reponse is Null And date='$anneeUniversitaire'");
	while ($donnees = mysql_fetch_array($result)){
		$listesIdEtudiant[] = $donnees['idEtudiant'];
		$result2 = mysql_query("Select idPassword From etudiant Where idEtudiant=". $donnees['idEtudiant']);
		if ($donnees2 = mysql_fetch_array($result2))
			$listesPwd[] = getMdpFromId($donnees2['idPassword']);
	}

	// Headers de l'email html
	$headers = 'From: Polytech\'Grenoble <fichesEvals.polytechGrenoble@gmail.com>'."\r\n";
	$headers .="Bcc:Polytech\'Grenoble <fichesEvals.polytechGrenoble@gmail.com>\r\n";
	$headers .= 'Mime-Version: 1.0'."\r\n";
	$headers .= 'Content-type: text/html; charset=utf-8'."\r\n";
	$headers .= "\r\n";

	//pour chaque identifiant, on récupère la liste des matières qu'il n'a pas rempli et on lui envoi un mail
	for ($i=0;$i<count($listesIdEtudiant);$i++){
		$idEtudiant = $listesIdEtudiant[$i];
		$messageEtudiant = $message;
		$result = mysql_query("Select Distinct codeApogee From reponse Where idEtudiant=$idEtudiant And date='$anneeUniversitaire' And reponse is NULL");
		$nbFiches = count(mysql_num_rows($result));
		while ($donnees = mysql_fetch_array($result)){
			$codeApogee = $donnees['codeApogee'];
			$intitule = getIntitule($codeApogee);
			$messageEtudiant .= "- ".$intitule."<br/>";
			
		}
		$messageEtudiant .= "<br/>Login: ".$listesIdEtudiant[$i]."<br/>Mot de passe: ".$listesPwd[$i]."<br/>";

		$prenomNomEmail = getPrenomNomEmailFromIdEtudiant($idEtudiant);
		//$email = $prenomNomEmail[1].".".$prenomNomEmail[0]."@hddotmailXX.fr";
		$email = $prenomNomEmail[1].".".$prenomNomEmail[0]."@e.ujf-grenoble.fr";
		//$email = $prenomNomEmail[2];
		$messageEtudiant.="<a href=\"http://evaluation-enseignants.toile-libre.org\">http://evaluation-enseignants.toile-libre.org</a>";
		
		$messageEtudiant = "Bonjour ".$prenomNomEmail[1]." ".$prenomNomEmail[0].",".$messageEtudiant;

		if ($nbFiches>0){
			mail($email, $subject,$messageEtudiant,$headers);
			//echo("<p>Mail envoyé</p>");
			/*echo("<br/>email:".$email);
			echo("<br/>subject:".$subject);
			echo("<br/>messageEtudiant:". htmlentities($messageEtudiant)."<br/><br/>");*/
		} 
	}
}

/*Envoi une notification par mail aux délégué qui n'ont pas rempli les commentaires dans la table synthèse'*/
function notificationDelegueParMail(){
	$anneeUniversitaire = getAnneeUniversitaire();
	$listesIdDelegue = array();
	$listesPwd = array();
	$subject = "[Polytech' - Fiche syntèse d'évaluation des enseignants RICM à remplir]";
	$message = "<br/><br/>Veuillez remplir dans les plus bref délais les fiches synthèse d'évaluation des enseignements suivants:<br/>";

	//on récupère tous les identifiants des délégués de l'année universitaire en cours qui n'ont pas encore rempli la fiche d'évaluation
	$result = mysql_query("Select Distinct idEtudiant From etudiant Where delegue=1");
	while ($donnees = mysql_fetch_array($result)){
		$listesIdDelegue[] = $donnees['idEtudiant'];
		$result2 = mysql_query("Select idPassword From etudiant Where idEtudiant=". $donnees['idEtudiant']);
		if ($donnees2 = mysql_fetch_array($result2))
			$listesPwd[] = getMdpFromId($donnees2['idPassword']);
	}

	// Headers de l'email html
	$headers = 'From: Polytech <fichesEvals.polytechGrenoble@gmail.com>' . "\r\n";
	$headers .="Bcc:fichesEvals.polytechGrenoble@gmail.com\r\n";
	$headers .= 'Mime-Version: 1.0'."\r\n";
	$headers .= 'Content-type: text/html; charset=utf-8'."\r\n";
	$headers .= "\r\n";

	$result = mysql_query("Select Distinct codeApogee From synthese Where commentaire is NULL And date='$anneeUniversitaire'");
	while ($donnees = mysql_fetch_array($result)){
		$codeApogee = $donnees['codeApogee'];
		$intitule = getIntitule($codeApogee);
		$idSection = $donnees['idSection'];
		$message .= "- ".$intitule."<br/>";
	}

	if(mysql_num_rows($result)>0){
		//echo("Nb délégué:".count($listesIdDelegue));
		//pour chaque identifiant, on récupère la liste des matières qu'il n'a pas rempli et on lui envoi un mail
		for ($i=0;$i<count($listesIdDelegue);$i++){
			$idDelegue = $listesIdDelegue[$i];
			$messageDelegue = $message;
			$messageDelegue .= "<br/>Login:".$idDelegue."<br/>Mot de passe:".$listesPwd[$i]."<br/>";
			$messageDelegue .="<a href=\"http://evaluation-enseignants.toile-libre.org\">http://evaluation-enseignants.toile-libre.org</a>";
			$prenomNomEmail = getPrenomNomEmailFromIdEtudiant($idDelegue);
			//$email = $prenomNom[0].".".$prenomNom[1]."@e.ujf-grenoble.fr";	
			$messageDelegue = "Bonjour ".$prenomNomEmail[1]." ".$prenomNomEmail[0].",".$messageDelegue;
			//$email = $prenomNomEmail[2];
			//$email = $prenomNomEmail[1].".".$prenomNomEmail[0]."@hddotmailXX.fr";
			$email = $prenomNomEmail[1].".".$prenomNomEmail[0]."@e.ujf-grenoble.fr";
			mail($email, $subject, $messageDelegue,$headers);
			//echo("<p>Mail envoyé</p>");
			/*echo("<br/>email:".$email);
			echo("<br/>subject:".$subject);
			echo("<br/>message:".nl2br($message)."<br/><br/>");*/
		}
	} 
}

/*Importe les données enseignant d'un fichier cvs dans une base de donnée
  Format d'un fichier .csv enseignant: "Le fichier enseignant.csv doit être de la forme 'nom prenom {codeApogee,cm,td,tp}' avec cm=1 (respectivement td et tp) si l'enseignant enseigne des cours en cm (respectivement en td et tp), 0 sinon."*/
function importCsvEnseignant($fichier){
	$anneeUniversitaire = getAnneeUniversitaire();
	$f = fopen($fichier, 'rb');
	for ($ligne = fgetcsv($f, 1024); !feof($f); $ligne = fgetcsv($f, 1024)) {
  		$j = sizeof($ligne);
		if ($j>=2){
			$nom = $ligne[0];
			$prenom = $ligne[1];

			if (isEnseignantInexistant($nom,$prenom)) {//insertion d'un enregistrement dans la table enseignant
				$idEnseignant = genereIdEnseignant();
				mysql_query("Insert Into enseignant Values($idEnseignant,'$nom','$prenom')");
			}else
				$idEnseignant = getIdEnseignant($nom,$prenom);

			//Initialisation des tables rôles
			$i=2;
			while($i<$j){
	    			$codeApogee = $ligne[$i];
				$cm = $ligne[$i+1];
				$td = $ligne[$i+2];
				$tp = $ligne[$i+3];
				echo("Insert into role values('$codeApogee',$idEnseignant,'$anneeUniversitaire',$cm,$td,$tp)<br/>"); 
				mysql_query("Insert into role values('$codeApogee',$idEnseignant,'$anneeUniversitaire',$cm,$td,$tp)"); 
				$i+=4;
			} 
					
		} else	echo("Erreur. Le fichier enseignant.csv doit être de la forme 'nom prenom  {codeApogee,cm,td,tp}' avec cm=1 (respectivement td et tp) si l'enseignant enseigne des cours en cm (respectivement en td et tp), 0 sinon.'");
  	}
}


/*numMenu correspond au nombre de menu horizontalement à l'étage 1*/
function menuAux($xml,$nbMenu,$numMenu,$etage){
	foreach($xml->contenu as $contenu) {
		$lien  = htmlentities(utf8_decode($contenu->lien));
		$titre = htmlentities(utf8_decode($contenu->titre));
		if (!$contenu->sousContenu->contenu){
			if ($lien=="deconnexion")	echo("<li><a href=\"pages/".$lien.".php\">".$titre."</a></li>");
			else						echo("<li><a href=\"index.php?page=".$lien."\">".$titre."</a></li>");
		} else {
			echo("<li><a class=\"hide\" href=\"index.php?page=".$lien."\">");
			if ($etage>1){
				if($numMenu==$nbMenu)
					echo(" &lt;&lt; ".$titre."</a><ul class=\"left\">");
				else
					echo($titre." &gt;&gt;</a><ul>");
			} else
				echo($titre."</a><ul>");
			menuAux($contenu->sousContenu,$nbMenu,$numMenu,$etage+1);
			echo("</ul></li>");
		}
		if ($etage==1)
			$numMenu++;
	}
	$numMenu=1;
}
function menu($menuXml,$log){
	if (file_exists('xml/'.$menuXml.'.xml')) { 
		$xml = simplexml_load_file('xml/'.$menuXml.'.xml') or die("fichier impossible à charger");
		echo("<div class=\"conteneurMenu\"><div class=\"menu\"><ul>");
		menuAux($xml,$xml->nbMenu,1,1);	
		echo("</ul></div></div>");
		/*if ($log!=USER){	
			echo("</ul></div>
				<div class=\"rightMenu\">Se deconnecter</div>
			</div>");
		}*/
	} else
		echo "fichier innexistant";
}

?>
