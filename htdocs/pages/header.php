<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
   "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<!--
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
-->
<html xmlns="http://www.w3.org/1999/xhtml"  xml:lang="fr">
<head>
        <meta http-equiv="content-type" content="application/xhtml+xml; charset=utf-8" />
	<meta http-equiv="content-language" content="fr"/>
	<meta name="author" content="Cazaux Jérémy, Conq Maxime et Coudurier Frédéric"/>
	<meta name="description"  content=">Fiche d'évaluation des enseignants de polytech'grenoble" />
	<meta name="keywords" content="fiche, evaluation, polytech',grenoble,ujf" />
	<title>Fiche d'évaluation des enseignants de polytech'grenoble</title>
	<link rel="stylesheet" href="css/ficheEvaluation.css" type="text/css" />
</head>
<body>
	<div class="header">
		<div class="logo"></div>
		<div><a id="etiquette"/></div>
		<?php 
			if($log==ETUDIANT)	menu("pagesEtudiant",$log);
			elseif($log==DELEGUE)	menu("pagesDelegue",$log);
			elseif($log==ADMIN)	menu("pagesAdmin",$log);
			else			menu("pagesUser",$log);
		?>
	</div> 
