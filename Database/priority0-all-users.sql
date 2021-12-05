SET old_passwords = 0;

CREATE USER 'simple-server'@'%' IDENTIFIED BY 'simple-server';
GRANT ALL PRIVILEGES ON *.* TO 'simple-server'@'%';

CREATE USER 'healthy'@'127.0.0.1' IDENTIFIED BY '';

FLUSH PRIVILEGES;

SET sql_safe_updates = OFF;
SET GLOBAL sql_safe_updates = OFF;
SET GLOBAL event_scheduler = ON;
