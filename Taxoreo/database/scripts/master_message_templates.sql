CREATE TABLE `master_message_templates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `is_default` int(1) DEFAULT '0',
  `type` varchar(225) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `template_name` varchar(225) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `template_id` varchar(225) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `is_active` int(11) DEFAULT NULL,
  `remark` varchar(225) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
