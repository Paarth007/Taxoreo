CREATE TABLE `master_services_documents` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `master_service_id` int(11) DEFAULT NULL,
  `master_company_type_id` int(11) DEFAULT NULL,
  `master_document_id` int(11) DEFAULT NULL,
  `remark` varchar(225) DEFAULT NULL,
  `is_active` int(1) DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=141 DEFAULT CHARSET=latin1;
