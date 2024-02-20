CREATE TABLE `user_added_services_temp` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `session_id` varchar(225) DEFAULT NULL,
  `service_id` int(11) DEFAULT NULL,
  `actual_amount` decimal(10,2) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
