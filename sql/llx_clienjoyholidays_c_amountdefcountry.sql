CREATE TABLE llx_clienjoyholidays_c_amountdefcountry(
    -- BEGIN MODULEBUILDER FIELDS
           rowid integer AUTO_INCREMENT PRIMARY KEY NOT NULL,
           country varchar(255) NOT NULL,
           amount DOUBLE,
           active integer
    -- END MODULEBUILDER FIELDS
) ENGINE=innodb;
