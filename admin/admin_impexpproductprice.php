<?php
/* Copyright (C) 2012	Florian HENRY 		<florian.henry@open-concept.pro>
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
 * 	\file		admin/admin_impexpproductprice.php
 * 	\ingroup	impexpproductprice
 * 	\brief		Setup impexpproductprice module
 */

// Dolibarr environment
$res = @include("../../main.inc.php"); // From htdocs directory
if ( ! $res)
		$res = @include("../../../main.inc.php"); // From "custom" directory

	
// Libraries
require_once DOL_DOCUMENT_ROOT . "/core/lib/admin.lib.php";
dol_include_once('/impexpproductprice/lib/impexpproductprice.lib.php');

// Translations
$langs->load("impexpproductprice@impexpproductprice");
$error=0;

// Access control
if ( ! $user->admin) accessforbidden();

// Parameters
$action = GETPOST('action', 'alpha');


/*
 * View
 */
$page_name = "SetupPage";
llxHeader('', $langs->trans($page_name));

// Subheader
$linkback = '<a href="' . DOL_URL_ROOT . '/admin/modules.php">'
	. $langs->trans("BackToModuleList") . '</a>';
print_fiche_titre($langs->trans($page_name), $linkback);

// Configuration header
$head = impexpproductpriceadmin_prepare_head();
dol_fiche_head($head, 'settings', $langs->trans("Module19997Name"), 0,
	"impexpproductprice@impexpproductprice");


print '<table class="noborder" width="100%">';
print '<tr><td>'.$langs->trans('ModelNothingToSet').'</td></tr>';
print '</table>';


llxFooter();
$db->close();