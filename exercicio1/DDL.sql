CREATE TABLE `usuarios` (
	`name` VARCHAR(150) NOT NULL DEFAULT '' COLLATE 'utf8_general_ci',
	`userName` VARCHAR(150) NOT NULL DEFAULT '' COLLATE 'utf8_general_ci',
	`zipCode` VARCHAR(8) NOT NULL DEFAULT '' COLLATE 'utf8_general_ci',
	`email` VARCHAR(150) NOT NULL DEFAULT '' COLLATE 'utf8_general_ci',
	`password` VARCHAR(150) NOT NULL DEFAULT '' COLLATE 'utf8_general_ci',
	PRIMARY KEY (`Id`) USING BTREE
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB
;
