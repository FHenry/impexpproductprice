<?php
/* Copyright (C) 2013  Florian HENRY <florian.henry@open-concept.pro>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

/**
 *	\file		lib/impexpproductprice.lib.php
 *	\ingroup	impexpproductprice
 *	\brief		impexpproductprice library
 */



function impexpproductpriceadmin_prepare_head()
{
	global $langs, $conf;
	
	$langs->load("impexpproductprice@impexpproductprice");

	$h = 0;
	$head = array();

	$head[$h][0] = dol_buildpath("/impexpproductprice/admin/admin_impexpproductprice.php",1);
	$head[$h][1] = $langs->trans("Settings");
	$head[$h][2] = 'settings';
	$h++;
	$head[$h][0] = dol_buildpath("/impexpproductprice/admin/about.php",1);
	$head[$h][1] = $langs->trans("About");
	$head[$h][2] = 'about';
	$h++;

	complete_head_from_modules($conf,$langs,$object,$head,$h,'impexpproductprice');

	return $head;
}