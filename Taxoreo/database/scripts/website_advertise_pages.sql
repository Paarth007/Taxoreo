CREATE TABLE `website_advertise_pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `advertise_id` int(11) DEFAULT NULL,
  `page_name` varchar(225) DEFAULT NULL,
  `remark` varchar(225) DEFAULT NULL,
  `is_active` int(1) DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;
