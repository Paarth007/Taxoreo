CREATE TABLE `user_service_documents` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_service_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `master_document_id` int(11) DEFAULT NULL,
  `document_name` varchar(225) DEFAULT NULL,
  `document_path` varchar(225) DEFAULT NULL,
  `document_extension` varchar(225) DEFAULT NULL,
  `document_status` varchar(225) DEFAULT NULL,
  `is_active` int(1) DEFAULT '1',
  `remark` varchar(225) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
