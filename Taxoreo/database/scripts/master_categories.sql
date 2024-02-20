CREATE TABLE `master_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(225) DEFAULT NULL,
  `remark` varchar(225) DEFAULT NULL,
  `is_active` int(1) DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
