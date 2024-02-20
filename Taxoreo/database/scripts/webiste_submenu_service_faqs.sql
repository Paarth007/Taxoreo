CREATE TABLE `webiste_submenu_service_faqs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `website_submenu_service_id` int(11) DEFAULT NULL,
  `question` varchar(225) DEFAULT NULL,
  `answer` varchar(225) DEFAULT NULL,
  `is_active` int(11) DEFAULT '1',
  `remark` varchar(225) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
