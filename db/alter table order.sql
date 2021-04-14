ALTER TABLE `tbl_order_items`
	ADD COLUMN `total_weight` INT NOT NULL AFTER `delivery_charge`;
ALTER TABLE `tbl_order_details`
	ADD COLUMN `id_mst_courier` INT NOT NULL AFTER `address_type`,
	ADD COLUMN `no_resi` VARCHAR(100) NOT NULL AFTER `id_mst_courier`;
