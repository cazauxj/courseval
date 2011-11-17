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
	$typesImport = array("etudiants","enseignants");
	$etat=0;

	if ($action==1){
		$erreurTypeImport = false;
		$erreurFileName = false;

		if(isset($_POST['typeImport']))	$typeImport = $_POST['typeImport'];	
		else 						$erreurTypeImport =true; 
		if (!isset($_FILES['fileName']['name']))	$erreurFileName=true;
		else if($_FILES['fileName']['name']=="")
				$erreurFileName = true;
		else{	
			$fileName = $_FILES['fileName']['name'];
			/*if ($_FILES['fileName']['type']!="text/comma-separated-values")
				$erreurFormatFichier = true;
			*///echo("Salut:&".$_FILES['fileName']['name']."&".$_FILES['fileName']['type']);
		}
		

		if($erreurTypeImport)	 	echo "<script>alert('1-Veuillez choisir un type de fichier à importer!');</script>";  
		elseif($erreurFileName)	echo "<script>alert('2-Veuillez choisir un fichier csv à importer');</script>";
		elseif($erreurFormatFichier)	echo "<script>alert('3-Veuillez choisir un fichier au format csv');</script>";
		else				$etat=1;
	}	

	if ($action==1 && $etat==1){
		move_uploaded_file($_FILES['fileName']['tmp_name'], "./csv/".$fileName);
		if ($typeImport=="etudiants")			importCsvEtudiant("./csv/".$fileName);
		else if ($typeImport=="enseignants")	importCsvEnseignant("./csv/".$fileName);
		echo($typeImport);
		echo("<p style=\"font-size:12px;text-align:center;\">Fichier importé !</p>");
	} else{
		echo("<form enctype=\"multipart/form-data\" action=\"index.php?page=$page&amp;action=1\" method=\"post\">
			<div class=\"contenu6Part\">
				<div class=\"wrapper\">
					<div class=\"part200\">
						<div class=\"leftPart6\">Formation:</div>
						<div class=\"rightPart6\">RICM 4</div>
					</div>
					<div class=\"part200\">
						<div class=\"leftPart6\">Fichier:</div>
						<div class=\"rightPart6\">");
							liste('typeImport',$typesImport,1);
		echo("				</div>
					</div>
					<div class=\"part400\">
						<div class=\"leftPart6\">
							<input type=\"hidden\" name=\"max_file_size\" value=\"1000\"/>
							Importer ce fichier : <input type=\"file\" name=\"fileName\"/>
						</div>
						<div class=\"rightPart6\">
							<p><input type=\"submit\"/></p>
						</div>
					</div>
				</div>
			</div>
		</form>");
	}
?>
