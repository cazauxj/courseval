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
function setVisible(identifiant) {
	if (document.getElementById(identifiant).className == "hidden")  
		document.getElementById(identifiant).className = "visible";
}function setHidden(identifiant){
	if (document.getElementById(identifiant).className == "visible")  
		document.getElementById(identifiant).className = "hidden";
}

function getEltSelect(){
	return document.getElementById('liste').options[document.getElementById('liste').selectedIndex].value;
}
