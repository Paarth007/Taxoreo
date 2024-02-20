CREATE TABLE `user_services` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `service_no` varchar(225) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `master_service_id` int(11) DEFAULT NULL,
  `assign_to` int(11) DEFAULT NULL,
  `assign_at` datetime DEFAULT NULL,
  `current_status` varchar(225) DEFAULT 'New',
  `status_changed_at` datetime DEFAULT NULL,
  `is_active` int(1) DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
