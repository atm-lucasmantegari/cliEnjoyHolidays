-- Copyright (C) 2023 SuperAdmin
--
-- This program is free software: you can redistribute it and/or modify
-- it under the terms of the GNU General Public License as published by
-- the Free Software Foundation, either version 3 of the License, or
-- (at your option) any later version.
--
-- This program is distributed in the hope that it will be useful,
-- but WITHOUT ANY WARRANTY; without even the implied warranty of
-- MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
-- GNU General Public License for more details.
--
-- You should have received a copy of the GNU General Public License
-- along with this program.  If not, see https://www.gnu.org/licenses/.


CREATE TABLE llx_clienjoyholidays_voyage(
	-- BEGIN MODULEBUILDER FIELDS
	rowid integer AUTO_INCREMENT PRIMARY KEY NOT NULL, 
	ref varchar(128) DEFAULT '(VOY)' NOT NULL, 
	label varchar(255) NOT NULL, 
	amount double DEFAULT NULL NOT NULL, 
	date_creation datetime NOT NULL, 
	status integer NOT NULL, 
	fk_pays integer NOT NULL, 
	datedepart datetime, 
	datearrivee datetime, 
	fk_transport integer
	-- END MODULEBUILDER FIELDS
) ENGINE=innodb;
