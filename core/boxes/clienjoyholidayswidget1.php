<?php
/* Copyright (C) 2004-2017  Laurent Destailleur <eldy@users.sourceforge.net>
 * Copyright (C) 2018-2021  Frédéric France     <frederic.france@netlogic.fr>
 * Copyright (C) 2023 SuperAdmin
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
 * \file    clienjoyholidays/core/boxes/clienjoyholidayswidget1.php
 * \ingroup clienjoyholidays
 * \brief   Widget provided by CliEnjoyHolidays
 *
 * Put detailed description here.
 */

include_once DOL_DOCUMENT_ROOT."/core/boxes/modules_boxes.php";


/**
 * Class to manage the box
 *
 * Warning: for the box to be detected correctly by dolibarr,
 * the filename should be the lowercase classname
 */
class clienjoyholidayswidget1 extends ModeleBoxes
{
	/**
	 * @var string Alphanumeric ID. Populated by the constructor.
	 */
	public $boxcode = "clienjoyholidaysbox";

	/**
	 * @var string Box icon (in configuration page)
	 * Automatically calls the icon named with the corresponding "object_" prefix
	 */
	public $boximg = "clienjoyholidays@clienjoyholidays";

	/**
	 * @var string Box label (in configuration page)
	 */
	public $boxlabel;

	/**
	 * @var string[] Module dependencies
	 */
	public $depends = array('clienjoyholidays');

	/**
	 * @var DoliDb Database handler
	 */
	public $db;

	/**
	 * @var mixed More parameters
	 */
	public $param;

	/**
	 * @var array Header informations. Usually created at runtime by loadBox().
	 */
	public $info_box_head = array();

	/**
	 * @var array Contents informations. Usually created at runtime by loadBox().
	 */
	public $info_box_contents = array();

	/**
	 * @var string 	Widget type ('graph' means the widget is a graph widget)
	 */
	public $widgettype = 'graph';


	/**
	 * Constructor
	 *
	 * @param DoliDB $db Database handler
	 * @param string $param More parameters
	 */
	public function __construct(DoliDB $db, $param = '')
	{
		global $user, $conf, $langs;
		// Translations
		$langs->loadLangs(array("boxes", "clienjoyholidays@clienjoyholidays"));

		parent::__construct($db, $param);

		$this->boxlabel = $langs->transnoentitiesnoconv("MyWidget");

		$this->param = $param;

		//$this->enabled = $conf->global->FEATURES_LEVEL > 0;         // Condition when module is enabled or not
		//$this->hidden = ! ($user->rights->clienjoyholidays->myobject->read);   // Condition when module is visible by user (test on permission)
	}

	/**
	 * Load data into info_box_contents array to show array later. Called by Dolibarr before displaying the box.
	 *
	 * @param int $max Maximum number of records to load
	 * @return void
	 */
	public function loadBox($max = 5)
	{
		global $langs, $user;

		// Use configuration value for max lines count
		$this->max = $max;


		include_once DOL_DOCUMENT_ROOT . '/custom/clienjoyholidays/class/voyage.class.php';

		$voyagebox = new Voyage($this->db);

		// Populate the head at runtime
		$text = $langs->trans("CliEnjoyHolidaysBoxDescription", $max);
		$this->info_box_head = array(
			// Title text
			'text' => $text,
			// Add a link
			'sublink' => 'http://example.com',
			// Sublink icon HTML alt text
			'subtext' => '',
			// Sublink HTML target
			'target' => '',
			// HTML class attached to the picto and link
			'subclass' => 'center',
			// Limit and truncate with "…" the displayed text lenght, 0 = disabled
			'limit' => 0,
			// Adds translated " (Graph)" to a hidden form value's input (?)
			'graph' => false
		);

		$sql = " SELECT rowid, ref, label, amount, date_creation, status";
		$sql .= " FROM " . MAIN_DB_PREFIX . "clienjoyholidays_voyage";
		$sql .= " ORDER BY date_creation DESC";

		$result = $this->db->query($sql);

		if ($result) {
			$num = $this->db->num_rows($result);

			$line = 0;
			while ($line < $num) {
				$objp = $this->db->fetch_object($result);

				$voyagebox->id = $objp->rowid;
				$voyagebox->ref = $objp->ref;
				$voyagebox->label = $objp->label;
				$voyagebox->amount = $objp->amount;
				$voyagebox->status = $objp->status;

				$this->info_box_contents[$line][] = array(
					'td' => 'class="tdoverflowmax150"',
					'text' => $voyagebox->getNomUrl(1),
					'asis' => 1,
				);

				$this->info_box_contents[$line][] = array(
					'td' => 'class="tdoverflowmax150"',
					'text' => $voyagebox->label,
				);

				$this->info_box_contents[$line][] = array(
					'td' => 'class="right" width="18"',
					'text' => $voyagebox->amount,
				);

				$this->info_box_contents[$line][] = array(
					'td' => 'class="right" width="18"',
					'text' => $voyagebox->LibStatut($objp->status, 3)
				);

				$line++;
			}
			}
		}

	/**
	 * Method to show box. Called by Dolibarr eatch time it wants to display the box.
	 *
	 * @param array $head       Array with properties of box title
	 * @param array $contents   Array with properties of box lines
	 * @param int   $nooutput   No print, only return string
	 * @return string
	 */
	public function showBox($head = null, $contents = null, $nooutput = 0)
	{
		// You may make your own code here…
		// … or use the parent's class function using the provided head and contents templates
		return parent::showBox($this->info_box_head, $this->info_box_contents, $nooutput);
	}
}
