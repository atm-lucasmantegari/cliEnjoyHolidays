<?php
/* Copyright (C) 2023 SuperAdmin
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
 * along with this program.  If not, see <https://www.gnu.org/licenses/>.
 */

/**
 * \file    clienjoyholidays/class/actions_clienjoyholidays.class.php
 * \ingroup clienjoyholidays
 * \brief   Example hook overload.
 *
 * Put detailed description here.
 */

/**
 * Class ActionsCliEnjoyHolidays
 */
class ActionsCliEnjoyHolidays
{
	/**
	 * @var DoliDB Database handler.
	 */
	public $db;

	/**
	 * @var string Error code (or message)
	 */
	public $error = '';

	/**
	 * @var array Errors
	 */
	public $errors = array();


	/**
	 * @var array Hook results. Propagated to $hookmanager->resArray for later reuse
	 */
	public $results = array();

	/**
	 * @var string String displayed by executeHook() immediately after return
	 */
	public $resprints;

	/**
	 * @var int		Priority of hook (50 is used if value is not defined)
	 */
	public $priority;


	/**
	 * Constructor
	 *
	 *  @param		DoliDB		$db      Database handler
	 */
	public function __construct($db)
	{
		$this->db = $db;
	}


	/**
	 * Execute action
	 *
	 * @param	array			$parameters		Array of parameters
	 * @param	CommonObject    $object         The object to process (an invoice if you are in invoice module, a propale in propale's module, etc...)
	 * @param	string			$action      	'add', 'update', 'view'
	 * @return	int         					<0 if KO,
	 *                           				=0 if OK but we want to process standard actions too,
	 *                            				>0 if OK and we want to replace standard actions.
	 */
	public function getNomUrl($parameters, &$object, &$action)
	{
		global $db, $langs, $conf, $user;
		$this->resprints = '';
		return 0;
	}

	/**
	 *
	 * Add button
	 *
	 */
	public function addMoreActionsButtons($parameters, &$object, &$action, $hookmanager)
	{
		global $langs, $params, $permissiontoadd;
		if ($object->status == $object::STATUS_VALIDATED && $parameters['currentcontext']== 'propalcard') {
			print dolGetButtonAction('', $langs->trans("CreateVoyage"), 'default', '../../custom/clienjoyholidays/voyage_card.php?action=create&origin=propal&originid=' . $object->id . '&token=' . newToken(), 'create', $permissiontoadd, $params);
		}
	}

	/**
	 *
	 * Set link object source / target type
	 *
	 */
	public function setLinkedObjectSourceTargetType($parameters, $object, &$action, $hookmanager)
	{
        if ($parameters['targettype'] == '' && $parameters['currentcontext'] == 'voyagecard'){
            $hookmanager->resArray['targettype'] = 'clienjoyholidays_voyage';
            return 1;
        }
        return 0;
    }

}
