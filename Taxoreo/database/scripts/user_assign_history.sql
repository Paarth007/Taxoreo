CREATE TABLE `user_assign_history` (
  `id` int(10) unsigned NOT NULL,
  `user_added_service_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `assigned_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
