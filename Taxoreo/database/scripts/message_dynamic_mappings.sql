
CREATE TABLE `message_dynamic_mappings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `source` varchar(225) DEFAULT NULL,
  `source_name` varchar(224) DEFAULT NULL,
  `table_columns` varchar(225) DEFAULT NULL,
  `selectors` varchar(225) DEFAULT NULL,
  `query` varchar(225) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
