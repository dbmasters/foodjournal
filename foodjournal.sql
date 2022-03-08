CREATE TABLE `meal` (
  `meal_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `datetime_served` datetime NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ingredients` text COLLATE utf8_unicode_ci NOT NULL,
  `calories` int(11) NOT NULL DEFAULT '0',
  `added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `meal` (`meal_id`, `user_id`, `datetime_served`, `title`, `ingredients`, `calories`, `added`, `updated`) VALUES
(2, 1, '2022-03-06 07:00:00', 'Pancakes', 'Flours, Eggs', 100, '2022-03-06 15:35:52', NULL),
(3, 1, '2022-03-05 17:00:00', 'Hambuger Helper', 'Beef, Cheese, Noodles', 300, '2022-03-06 15:37:08', NULL),
(7, 1, '2022-03-06 11:00:00', 'agargaerg2', 'aergaergaerg', 100, '2022-03-06 17:25:03', '2022-03-06 23:45:40');

CREATE TABLE `user` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `username` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `userpass` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `user` (`user_id`, `username`, `userpass`, `email`, `added`, `updated`) VALUES
(1, 'testuser', '179ad45c6ce2cb97cf1029e212046e81', 'danball@gmail.com', '2022-03-05 17:26:30', NULL);
