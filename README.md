# Laravel0 <br />
**Fecha de Creacion:** _17 de Agosto del 2023_ <br />
**Descripción:** proyecto que tiene la finalidad de servir de base para otros.<br />
**Version del laravel:** _9.52.15_ <br />
**Version del PHP:** _PHP 8.1.13 (cli) (built: Nov 22 2022 15:49:14)_ <br />

# Base de Datos # <br />
**Tabla:** _users_ <br />
**Estructura de la tabla users** <br />
CREATE TABLE `users` ( <br />
  `id` bigint NOT NULL AUTO_INCREMENT, <br />
  `user_login` varchar(60) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '', <br />
  `name` varchar(60) COLLATE utf8mb4_unicode_520_ci NULL DEFAULT '', <br />
  `surname` varchar(60) COLLATE utf8mb4_unicode_520_ci NULL DEFAULT '', <br />
  `role_user`varchar(20) COLLATE utf8mb4_unicode_520_ci NULL DEFAULT '', <br />
  `user_pass` varchar(255) COLLATE utf8mb4_unicode_520_ci NULL DEFAULT '', <br />
  `user_nicename` varchar(50) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '', <br />
  `user_email` varchar(100) COLLATE utf8mb4_unicode_520_ci NULL DEFAULT '', <br />
  `image` varchar(255) COLLATE utf8mb4_unicode_520_ci NULL DEFAULT '', <br />
  `description` text COLLATE utf8mb4_unicode_520_ci NULL DEFAULT '', <br />
  `user_url` varchar(100) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '', <br />
  `user_registered` datetime NOT NULL DEFAULT '0000-00-00 00:00:00', <br />
  `user_activation_key` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '', <br />
  `user_status` int NOT NULL DEFAULT '0', <br />
  `display_name` varchar(250) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '', <br />
  `created_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00', <br />
  `updated_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00', <br />
  PRIMARY KEY (`ID`), <br />
  KEY `user_login_key` (`user_login`), <br />
  KEY `user_nicename` (`user_nicename`), <br />
  KEY `user_email` (`user_email`) <br />
) ENGINE=InnoDB  AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci; <br />

