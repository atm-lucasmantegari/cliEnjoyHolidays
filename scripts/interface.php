<?php
/**
 * Copyright (C) 2020 Laurent Destailleur <eldy@users.sourceforge.net>
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <https://www.gnu.org/licenses/>.
 */

/**
 *	\file       htdocs/bom/ajax/ajax.php
 *	\brief      Ajax component for BOM.
 */

if (!defined('NOTOKENRENEWAL')) define('NOTOKENRENEWAL', 1); // Disables token renewal
if (!defined('NOCSRFCHECK')) define('NOCSRFCHECK', 1);

global $db, $user, $conf, $langs;

// Include and load Dolibarr environment variables
$res = 0;

// Les Users sont chargés avec main.inc. pas avec master.inc
$res = @include ("../../main.inc.php"); // For root directory
if (! $res)
	$res = @include ("../../../main.inc.php"); // For "custom" directory
if (!$res) die("Include of master fails");

require_once DOL_DOCUMENT_ROOT . '/core/lib/ajax.lib.php';
require_once DOL_DOCUMENT_ROOT.'/core/class/cunits.class.php';


$action = GETPOST('action', 'aZ09');
$countryid = GETPOST('countryid', 'int');


/**
 * FIN BACKPORT TK2208-1823 - Consommation d'OF, amélioration des selects d'équipement et d'entrepôts
 */

/*
 * View
 */

if ($action == 'updateamountcountry') {

	$sql = " SELECT amount";
	$sql .= " FROM " . MAIN_DB_PREFIX . "clienjoyholidays_c_amountdefcountry";
	$sql .= " WHERE active = 1 AND country =" . $countryid;

	$resql = $db->query($sql);
	if ($resql) {
		$obj = $db->fetch_object($resql);
		if ($obj) {
			$data = $obj->amount;
		}else{
			$data = $conf->global->CLIENJOYHOLIDAYS_GLOBALAMOUNT;
		}
	}else{
		echo json_encode($db->error);
	}
	echo json_encode($data);
	exit();
}


