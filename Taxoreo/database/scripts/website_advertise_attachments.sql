CREATE TABLE `website_advertise_attachments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `advertise_id` int(11) DEFAULT NULL,
  `attachment_name` varchar(225) DEFAULT NULL,
  `attachment_url` varchar(225) DEFAULT NULL,
  `attachment_extension` varchar(20) DEFAULT NULL,
  `remark` varchar(225) DEFAULT NULL,
  `is_active` int(1) DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
