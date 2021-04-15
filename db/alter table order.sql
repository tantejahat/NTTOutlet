ALTER TABLE `tbl_order_details`
	ADD COLUMN `no_resi` VARCHAR(100) NOT NULL AFTER `id_mst_courier`;
	ALTER TABLE `tbl_settings`
	ADD COLUMN `manual_transfer_status` VARCHAR(50) NOT NULL DEFAULT 'true' AFTER `app_home_recent_opt`;
	
	

CREATE TABLE `tbl_manual_tranfer` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`bank_name` VARCHAR(100) NOT NULL DEFAULT '0',
	`account_number` VARCHAR(30) NOT NULL DEFAULT '0',
	`account_name` VARCHAR(100) NOT NULL DEFAULT '0',
	`created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
	`modified_at` DATETIME NULL DEFAULT NULL,
	PRIMARY KEY (`id`)
)
COLLATE='utf8mb4_general_ci'
ENGINE=InnoDB
;
