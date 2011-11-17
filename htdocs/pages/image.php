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

        include "libchart/classes/libchart.php";
	include "fonction.php";
	header("Content-type: image/png"); 
	connexionBdd("fiches_eval");

	$idSection = $_GET['idSection'];
	$codeApogee = $_GET['codeApogee'];
	$date = $_GET['date'];
	$nomSection = getNomSectionBrut($idSection);
	$listeIdQuestion = array();
	$listeQuestion = array();

	$chart = new VerticalBarChart(500,310);
	$dataSet = new XYDataSet();

	$result = mysql_query("Select Distinct idQuestion, resume From reponse Natural Join question where date='$date' And section=$idSection And codeApogee='$codeApogee' And reponse is not NULL");
	while ($donnees = mysql_fetch_array($result)){
		$listeIdQuestion[] = $donnees['idQuestion'];
		$listeQuestion[] = $donnees['resume'];
	}

	for ($i=0;$i<count($listeIdQuestion);$i++){
		$somme = 0;
		$idQuestion = $listeIdQuestion[$i];
		$result = mysql_query("Select reponse From reponse where date='$date' And reponse is not NULL And idQuestion=$idQuestion And codeApogee='$codeApogee'");
		$nb = mysql_num_rows($result);
		while ($donnees = mysql_fetch_array($result))
			$somme+=$donnees['reponse'];	
		$dataSet->addPoint(new Point($listeQuestion[$i],Round($somme/$nb,2)));
	}
	
	$chart->setDataSet($dataSet);
	$chart->setTitle($nomSection);
	$chart->render();
	deconnexionBdd(); 	
?>
