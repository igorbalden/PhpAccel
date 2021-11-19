-- Adminer 4.8.0 SQLite 3 3.31.1 dump

DROP TABLE IF EXISTS `contactus`;
CREATE TABLE `contactus` (
	`id`	INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	`email`	VARCHAR(255) UNIQUE
);

INSERT INTO `contactus` (`id`, `email`) VALUES (1, 'igor@demo.com');
INSERT INTO `contactus` (`id`, `email`) VALUES (2, 'user@domain.com');
INSERT INTO `contactus` (`id`, `email`) VALUES (3, 'user@domain.loc');

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
	`id`	INT PRIMARY KEY AUTO_INCREMENT,
	`email`	VARCHAR(255) NOT NULL UNIQUE,
	`password`	VARCHAR(255) NOT NULL,
	`active`	INT NOT NULL DEFAULT 1,
	`user_group_id`	INT NOT NULL,
	`created`	DATETIME NOT NULL
);

INSERT INTO `users` (`id`, `email`, `password`, `active`, `user_group_id`, `created`) VALUES (1,	'admin@demo.com',	'$2y$10$wwVfE5ANU5/hRh.6o8/czOSExKG80euFv574LVGPfCd1g89NdChSa',	1,	2,	'2021-11-14 21:33:31');
INSERT INTO `users` (`id`, `email`, `password`, `active`, `user_group_id`, `created`) VALUES (2,	'user1@demo.com',	'$2y$10$cQjJbMnJnwXocNX9BmavjOW8HxdHO7zl4m/W9FyHt8kWz44TDtlj6',	1,	1,	'2021-11-16 11:44:11');

DROP TABLE IF EXISTS `users_groups`;
CREATE TABLE `users_groups` (
	`id`	INT PRIMARY KEY AUTO_INCREMENT,
	`descr`	VARCHAR(255)
);

INSERT INTO `users_groups` (`id`, `descr`) VALUES (1,	'user');
INSERT INTO `users_groups` (`id`, `descr`) VALUES (2,	'admin');

