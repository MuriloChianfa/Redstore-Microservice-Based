FROM mysql:5.5.60

MAINTAINER Murilo Chianfa <https://github.com/murilochianfa>

COPY *.sql /docker-entrypoint-initdb.d/

ENV MYSQL_ROOT_PASSWORD simple-server

RUN apt-get update

RUN apt-get install -y wget git gcc make automake pkg-config libbsd-dev librabbitmq4 librabbitmq-dev default-libmysqlclient-dev

RUN wget https://raw.githubusercontent.com/mysqludf/lib_mysqludf_sys/master/lib_mysqludf_sys.c -P /usr/lib/

RUN cd /usr/lib/; gcc -DMYSQL_DYNAMIC_PLUGIN -fPIC -Wall -m64 -I/usr/local/mysql/include/ -I. -shared lib_mysqludf_sys.c -o /usr/local/mysql/lib/plugin/lib_mysqludf_sys.so

RUN mkdir /amqp/

RUN wget https://github.com/ssimicro/lib_mysqludf_amqp/releases/download/v2.0.0/lib_mysqludf_amqp-2.0.0.tar.gz -P /amqp/

RUN cd /amqp/; tar xzvf lib_mysqludf_amqp-2.0.0.tar.gz

RUN cd /amqp/lib_mysqludf_amqp-2.0.0/; ./configure; make && make install

RUN mv /usr/lib/x86_64-linux-gnu/mariadb18/plugin/lib_mysqludf_amqp.so /usr/local/mysql/lib/plugin/lib_mysqludf_amqp.so

RUN echo "bind-address = 0.0.0.0" >> /etc/mysql/my.cnf

EXPOSE 3306/tcp
