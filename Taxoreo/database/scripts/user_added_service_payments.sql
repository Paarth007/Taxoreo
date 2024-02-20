CREATE TABLE `user_added_service_payments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_added_service_id` int(11) DEFAULT NULL,
  `payment_log_id` int(11) DEFAULT NULL,
  `payment_type` varchar(225) DEFAULT NULL,
  `payable_amount` decimal(10,2) DEFAULT '0.00',
  `paid_amount` decimal(10,2) DEFAULT '0.00',
  `payment_status` varchar(225) DEFAULT NULL,
  `transaction_at` varchar(225) DEFAULT NULL,
  `is_active` int(1) DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
