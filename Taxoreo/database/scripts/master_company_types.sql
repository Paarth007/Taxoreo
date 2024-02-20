CREATE TABLE `master_company_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_type_name` varchar(225) DEFAULT NULL,
  `remark` varchar(225) DEFAULT NULL,
  `is_active` int(1) DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
