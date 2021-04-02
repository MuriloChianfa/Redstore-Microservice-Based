CREATE USER 'simple-server'@'%' IDENTIFIED BY 'simple-server';

GRANT ALL PRIVILEGES ON *.* TO 'simple-server'@'%' WITH GRANT OPTION;

CREATE FUNCTION lib_mysqludf_amqp_info RETURNS STRING SONAME 'lib_mysqludf_amqp.so';

CREATE FUNCTION lib_mysqludf_amqp_sendjson RETURNS STRING SONAME 'lib_mysqludf_amqp.so';

CREATE FUNCTION lib_mysqludf_amqp_sendstring RETURNS STRING SONAME 'lib_mysqludf_amqp.so';

