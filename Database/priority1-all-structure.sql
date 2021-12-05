-- 
-- REDSTORE
--

CREATE DATABASE IF NOT EXISTS redstore /*!40100 DEFAULT CHARACTER SET utf8 */;
USE redstore;

DROP TABLE IF EXISTS gender;
CREATE TABLE gender (
  id INT(2) NOT NULL AUTO_INCREMENT,
  name VARCHAR(30) NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS access_level;
CREATE TABLE access_level (
  id INT(2) NOT NULL AUTO_INCREMENT,
  name VARCHAR(30) NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS user;
CREATE TABLE user (
  id INT(11) NOT NULL AUTO_INCREMENT,
  gender_id INT(11) NOT NULL DEFAULT 3,
  access_level_id INT(11) NOT NULL DEFAULT 5,
  first_name VARCHAR(255) NOT NULL,
  last_name VARCHAR(255) NOT NULL,
  password VARCHAR(255) NOT NULL,
  email VARCHAR(255) NOT NULL,
  cpf INT(11) NOT NULL,
  birth_date TIMESTAMP NOT NULL,
  photo VARCHAR(255) DEFAULT NULL,
  status VARCHAR(50) NOT NULL DEFAULT 'registered',
  forget VARCHAR(255) DEFAULT NULL,
  receive_promotion BIT(1) DEFAULT 0,
  created_at TIMESTAMP NOT NULL,
  updated_at TIMESTAMP NOT NULL,
  CONSTRAINT users_unique UNIQUE (email, CPF),
  PRIMARY KEY (id),
  KEY user_gender_id_fk_idx (gender_id),
  CONSTRAINT user_gender_id_fk FOREIGN KEY (gender_id) REFERENCES gender(id) ON DELETE CASCADE ON UPDATE NO ACTION,
  KEY user_access_level_id_fk_idx (access_level_id),
  CONSTRAINT user_access_level_id_fk FOREIGN KEY (access_level_id) REFERENCES access_level(id) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS phone_type;
CREATE TABLE phone_type (
  id INT(2) NOT NULL AUTO_INCREMENT,
  name VARCHAR(255) NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS phone;
CREATE TABLE phone (
  id INT(11) NOT NULL AUTO_INCREMENT,
  user_id INT(11) NOT NULL,
  phone_type_id INT(11) NOT NULL,
  number INT(11) NOT NULL,
  PRIMARY KEY (id),
  KEY phone_user_id_fk_idx (user_id),
  CONSTRAINT phone_user_id_fk FOREIGN KEY (user_id) REFERENCES user(id) ON DELETE CASCADE ON UPDATE NO ACTION,
  KEY phone_phone_type_id_fk_idx (phone_type_id),
  CONSTRAINT phone_phone_type_id_fk FOREIGN KEY (phone_type_id) REFERENCES phone_type(id) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS state;
CREATE TABLE state (
  id INT(2) NOT NULL AUTO_INCREMENT,
  name VARCHAR(255) NOT NULL,
  acronym VARCHAR(2) NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS city;
CREATE TABLE city (
  id INT(11) NOT NULL AUTO_INCREMENT,
  state_id INT(11) NOT NULL,
  ibge INT(11) NOT NULL,
  name VARCHAR(255) NOT NULL,
  PRIMARY KEY (id),
  KEY city_state_id_fk_idx (state_id),
  CONSTRAINT city_state_id_fk FOREIGN KEY (state_id) REFERENCES state(id) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS address;
CREATE TABLE address (
  id INT(11) NOT NULL AUTO_INCREMENT,
  city_id INT(11) NOT NULL,
  street VARCHAR(255) NOT NULL,
  complement VARCHAR(255) DEFAULT NULL,
  cep VARCHAR(255) NOT NULL,
  number INT(11) NOT NULL,
  PRIMARY KEY (id),
  KEY address_city_id_fk_idx (city_id),
  CONSTRAINT address_city_id_fk FOREIGN KEY (city_id) REFERENCES city(id) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS user_address;
CREATE TABLE user_address (
  user_id INT(11) NOT NULL,
  address_id INT(11) NOT NULL,
  created_by INT(11) NOT NULL,
  created_at TIMESTAMP NOT NULL,
  updated_at TIMESTAMP NOT NULL,
  PRIMARY KEY (user_id, address_id),
  KEY user_address_user_id_fk_idx (user_id),
  CONSTRAINT user_address_user_id_fk FOREIGN KEY (user_id) REFERENCES user(id) ON DELETE CASCADE ON UPDATE NO ACTION,
  KEY user_address_address_id_fk_idx (address_id),
  CONSTRAINT user_address_address_id_fk FOREIGN KEY (address_id) REFERENCES address(id) ON DELETE CASCADE ON UPDATE NO ACTION,
  KEY user_address_created_by_fk_idx (created_by),
  CONSTRAINT user_address_created_by_fk FOREIGN KEY (created_by) REFERENCES user(id) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS faq_channels;
CREATE TABLE faq_channels (
  id INT(3) NOT NULL AUTO_INCREMENT,
  name VARCHAR(255) NOT NULL,
  description VARCHAR(255) DEFAULT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS faq_questions;
CREATE TABLE faq_questions (
  id INT(3) NOT NULL AUTO_INCREMENT,
  faq_channels_id INT(3) NOT NULL,
  question VARCHAR(255) NOT NULL,
  response TEXT NOT NULL,
  created_at TIMESTAMP NOT NULL,
  updated_at TIMESTAMP NOT NULL,
  PRIMARY KEY (id),
  KEY faq_questions_faq_channels_id_fk_idx (faq_channels_id),
  CONSTRAINT faq_questions_faq_channels_id_fk FOREIGN KEY (faq_channels_id) REFERENCES faq_channels(id) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS payment_type;
CREATE TABLE payment_type (
  id INT(3) NOT NULL AUTO_INCREMENT,
  name VARCHAR(255) NOT NULL,
  times INT(2) NOT NULL DEFAULT 1,
  PRIMARY KEY (id)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS payment_form;
CREATE TABLE payment_form (
  id INT(3) NOT NULL AUTO_INCREMENT,
  name VARCHAR(255) NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS payment_status;
CREATE TABLE payment_status (
  id INT(3) NOT NULL AUTO_INCREMENT,
  name VARCHAR(255) NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS sales;
CREATE TABLE sales (
  id INT(11) NOT NULL AUTO_INCREMENT,
  user_id INT(11) NOT NULL,
  payment_status_id INT(11) NOT NULL,
  payment_form_id INT(11) NOT NULL,
  payment_type_id INT(11) NOT NULL,
  total_value VARCHAR(255) NOT NULL,
  bought_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  paid_at TIMESTAMP NOT NULL,
  PRIMARY KEY (id),
  KEY sales_user_id_fk_idx (user_id),
  CONSTRAINT sales_user_id_fk FOREIGN KEY (user_id) REFERENCES user(id) ON DELETE CASCADE ON UPDATE NO ACTION,
  KEY sales_payment_status_id_fk_idx (payment_status_id),
  CONSTRAINT sales_payment_status_id_fk FOREIGN KEY (payment_status_id) REFERENCES payment_status(id) ON DELETE CASCADE ON UPDATE NO ACTION,
  KEY sales_payment_form_id_fk_idx (payment_form_id),
  CONSTRAINT sales_payment_form_id_fk FOREIGN KEY (payment_form_id) REFERENCES payment_form(id) ON DELETE CASCADE ON UPDATE NO ACTION,
  KEY sales_payment_type_id_fk_idx (payment_type_id),
  CONSTRAINT sales_payment_type_id_fk FOREIGN KEY (payment_type_id) REFERENCES payment_type(id) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS product_type;
CREATE TABLE product_type (
  id INT(11) NOT NULL AUTO_INCREMENT,
  name VARCHAR(255) NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS collection;
CREATE TABLE collection (
  id INT(11) NOT NULL AUTO_INCREMENT,
  name VARCHAR(255) NOT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS product;
CREATE TABLE product (
  id INT(11) NOT NULL AUTO_INCREMENT,
  product_type_id INT(11) DEFAULT NULL,
  collection_id INT(11) DEFAULT NULL,
  name VARCHAR(255) NOT NULL,
  value VARCHAR(255) NOT NULL,
  description VARCHAR(255) NOT NULL,
  available INT(11) NOT NULL DEFAULT 0,
  rate FLOAT(2, 1) default 0,
  PRIMARY KEY (id),
  KEY product_product_type_id_fk_idx (product_type_id),
  CONSTRAINT product_product_type_id_fk FOREIGN KEY (product_type_id) REFERENCES product_type(id) ON DELETE SET NULL ON UPDATE CASCADE,
  KEY product_collection_id_fk_idx (collection_id),
  CONSTRAINT product_collection_id_fk FOREIGN KEY (collection_id) REFERENCES collection(id) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS product_sale;
CREATE TABLE product_sale (
  product_id INT(11) NOT NULL,
  sale_id INT(11) NOT NULL,
  quantity INT(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (product_id, sale_id),
  KEY product_sale_product_id_fk_idx (product_id),
  CONSTRAINT product_sale_product_id_fk FOREIGN KEY (product_id) REFERENCES product(id) ON DELETE NO ACTION ON UPDATE NO ACTION,
  KEY product_sale_sale_id_fk_idx (sale_id),
  CONSTRAINT product_sale_sale_id_fk FOREIGN KEY (sale_id) REFERENCES sales(id) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS product_image;
CREATE TABLE product_image (
  id INT(11) NOT NULL AUTO_INCREMENT,
  product_id INT(11) NOT NULL,
  url_slug VARCHAR(255) NOT NULL,
  image MEDIUMBLOB NOT NULL,
  PRIMARY KEY (id),
  KEY product_image_product_id_fk_idx (product_id),
  CONSTRAINT product_image_product_id_fk_idx FOREIGN KEY (product_id) REFERENCES product(id) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;
