CREATE TABLE `user_added_service_comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `client_added_service_id` int(11) DEFAULT NULL,
  `comment_added_by` int(11) DEFAULT NULL,
  `comment` longtext,
  `show_to_client` int(1) DEFAULT '0',
  `is_active` int(1) DEFAULT '1',
  `remark` varchar(225) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
