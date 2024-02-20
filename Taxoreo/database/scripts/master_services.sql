CREATE TABLE `master_services` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `master_category_id` int(11) DEFAULT NULL,
  `service_name` varchar(225) DEFAULT NULL,
  `display_amount` decimal(10,0) DEFAULT NULL,
  `actual_amount` decimal(10,0) DEFAULT NULL,
  `show_on_website` int(1) DEFAULT '0',
  `remark` varchar(225) DEFAULT NULL,
  `is_active` int(1) DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;
