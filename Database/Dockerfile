FROM mysql:5.5.60

MAINTAINER Murilo Chianfa <github.com/murilochianfa>

# password for the root password
ENV MYSQL_ROOT_PASSWORD simple-server

# the basic schema and permissions
COPY *.sql /docker-entrypoint-initdb.d/

# enable run these scripts
RUN chown -R mysql:mysql /docker-entrypoint-initdb.d/

# add repo to install rsyslog
RUN echo "deb http://us.archive.ubuntu.com/ubuntu/ precise main universe" >> /etc/apt/source.list

# installing components
RUN apt-get update && apt-get install -o Acquire::ForceIPv4=true -y wget git gcc make automake pkg-config libbsd-dev librabbitmq4 librabbitmq-dev default-libmysqlclient-dev rsyslog net-tools

# enable rsyslog output send to a log container
ADD ./outlogs.conf /etc/rsyslog.d/outlogs.conf

RUN wget https://raw.githubusercontent.com/mysqludf/lib_mysqludf_sys/master/lib_mysqludf_sys.c -P /usr/lib/

RUN cd /usr/lib/; gcc -DMYSQL_DYNAMIC_PLUGIN -fPIC -Wall -m64 -I/usr/local/mysql/include/ -I. -shared lib_mysqludf_sys.c -o /usr/local/mysql/lib/plugin/lib_mysqludf_sys.so

RUN mkdir /amqp/ && wget https://github.com/ssimicro/lib_mysqludf_amqp/releases/download/v2.0.0/lib_mysqludf_amqp-2.0.0.tar.gz -P /amqp/

RUN cd /amqp/; tar xzvf lib_mysqludf_amqp-2.0.0.tar.gz

RUN cd /amqp/lib_mysqludf_amqp-2.0.0/; ./configure; make && make install

RUN mv /usr/lib/x86_64-linux-gnu/mariadb18/plugin/lib_mysqludf_amqp.so /usr/local/mysql/lib/plugin/lib_mysqludf_amqp.so

# binding to global access
RUN echo "bind-address = 0.0.0.0" >> /etc/mysql/my.cnf

# forward the port 3306/tcp
EXPOSE 3306/tcp
