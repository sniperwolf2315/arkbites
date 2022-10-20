<?php
	/*
	 * ABC ERP - Sistema ERP para PYMEs
	* Copyright (C) 2014 Santiago Faci <santi@arkabytes.com>
	*
	* This program is free software; you can redistribute it and/or
	* modify it under the terms of the GNU General Public License
	* as published by the Free Software Foundation; either version 2
	* of the License, or (at your option) any later version.
	*
	* This program is distributed in the hope that it will be useful,
	* but WITHOUT ANY WARRANTY; without even the implied warranty of
	* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	* GNU General Public License for more details.
	*
	* You should have received a copy of the GNU General Public License
	* along with this program; if not, write to the Free Software
	* Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
	*/

	if ($numero > $tamano) {
		echo "<div style='text-align:center'>";
		if ($inicio > 0)
			echo "<a href='" . $_SERVER['PHP_SELF'] . "?id=" . $id . "&busqueda_rapida=" . $busqueda_rapida . "&inicio=" . ($inicio - $tamano) . "'>< </a>";
		for ($i = 0; $i < $paginas; $i++) {
			if (($i * $tamano) == $inicio)
				echo "[" . ($i + 1) . "] ";
			else
				echo "<a href='?id=" . $id . "&busqueda_rapida=" . $busqueda_rapida . "&inicio=" . ($i * $tamano) . "'>[" . ($i + 1) . "]</a> ";
		}
		if ($inicio < ($numero - $tamano))
			echo "<a href='?id=" . $id . "&busqueda_rapida" . $busqueda_rapida . "&inicio=" . ($inicio + $tamano) . "'> ></a>";
		echo "</div>";
	}
?>