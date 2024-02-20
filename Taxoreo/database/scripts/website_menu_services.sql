CREATE TABLE `website_menu_services` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `menu_service_name` varchar(225) DEFAULT NULL,
  `redirection_url` varchar(225) DEFAULT NULL,
  `order_no` int(11) DEFAULT NULL,
  `is_active` int(1) DEFAULT '1',
  `remark` varchar(225) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
