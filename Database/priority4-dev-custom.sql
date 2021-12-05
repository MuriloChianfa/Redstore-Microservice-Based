-- 
-- REDSTORE
--

USE redstore;

LOCK TABLES user WRITE;
INSERT INTO user VALUES
(1, 3, 1, 'super', 'admin', '$2y$10$/gQmH6955Prb.czCsmXHuODOZtJb8FAgCZAaPnOzS6DZ/0QwZUFK6', 'admin@hotmail.com', 0, '2021-12-04 23:36:30', NULL, 'registered', NULL, '\0', NOW(), NOW());
UNLOCK TABLES;
