CREATE TABLE `master_documents` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `document_type` enum('UPLOAD','DOWNLOAD','DOWNLOAD_UPLOAD') DEFAULT 'UPLOAD',
  `document_name` varchar(225) DEFAULT NULL,
  `additional_details` varchar(225) DEFAULT NULL,
  `accepted_format` varchar(225) DEFAULT NULL,
  `download_link` varchar(225) DEFAULT NULL,
  `min_size` int(11) DEFAULT '2',
  `min_size_type` enum('KB','MB','GB') DEFAULT 'KB',
  `max_size` int(11) DEFAULT '10000',
  `max_size_type` enum('KB','MB','GB') DEFAULT 'KB',
  `is_multiple` int(11) DEFAULT '0',
  `remark` varchar(225) DEFAULT NULL,
  `is_active` int(1) DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;
