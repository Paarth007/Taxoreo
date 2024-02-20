CREATE TABLE `website_submenu_service_reviews` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `website_submenu_service_id` int(11) DEFAULT NULL,
  `name` varchar(225) DEFAULT NULL,
  `review` varchar(225) DEFAULT NULL,
  `remark` varchar(225) DEFAULT NULL,
  `is_active` int(1) DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
