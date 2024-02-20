CREATE TABLE `website_review` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `user_id` int(255) NOT NULL,
  `message` varchar(225) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_visible` int(1) DEFAULT '0',
  `is_active` int(1) DEFAULT '1',
  `remark` varchar(225) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `created_by` datetime DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `updated_by` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
