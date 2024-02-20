CREATE TABLE `website_blogs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `blog_title` varchar(225) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `blog_slug` varchar(225) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `seo` varchar(225) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `attachment_url` varchar(225) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `is_active` int(11) DEFAULT '1',
  `remark` varchar(225) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
