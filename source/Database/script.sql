CREATE TABLE IF NOT EXISTS `redstore`.`access_level` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `redstore`.`category` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `redstore`.`city` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(32) NOT NULL,
  `initials` VARCHAR(32) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `redstore`.`UF` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(32) NOT NULL,
  `id_city` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `id_city_fk_idx` (`id_city` ASC),
  CONSTRAINT `id_city_fk`
    FOREIGN KEY (`id_city`)
    REFERENCES `redstore`.`city` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `redstore`.`delivery_status` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `redstore`.`gender` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `redstore`.`user` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `cpf` VARCHAR(45) NOT NULL,
  `phone_number` VARCHAR(45) NOT NULL,
  `access_level_id` INT NOT NULL,
  `UF_id` INT NOT NULL,
  `gender_id` INT NOT NULL,
  `street` VARCHAR(255) NULL,
  `numer` INT NULL,
  `neighborhood` VARCHAR(255) NULL,
  `complement` VARCHAR(255) NULL,
  `receive_promotion` INT NOT NULL DEFAULT 1,
  `forget` VARCHAR(255) NOT NULL,
  `created_at` DATETIME NOT NULL,
  `updated_at` DATETIME NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `email_UNIQUE` (`email` ASC),
  INDEX `UF_id_fk_idx` (`UF_id` ASC),
  INDEX `access_level_id_fk_idx` (`access_level_id` ASC),
  INDEX `gender_id_fk_idx` (`gender_id` ASC),
  CONSTRAINT `UF_id_fk`
    FOREIGN KEY (`UF_id`)
    REFERENCES `redstore`.`UF` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `access_level_id_fk`
    FOREIGN KEY (`access_level_id`)
    REFERENCES `redstore`.`access_level` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `gender_id_fk`
    FOREIGN KEY (`gender_id`)
    REFERENCES `redstore`.`gender` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `redstore`.`payment_status` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `redstore`.`payment_type` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  `times` INT NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `redstore`.`payment_form` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  `payment_type_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `payment_type_id_fk_idx` (`payment_type_id` ASC),
  CONSTRAINT `payment_type_id_fk`
    FOREIGN KEY (`payment_type_id`)
    REFERENCES `redstore`.`payment_type` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `redstore`.`product` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `value` INT NOT NULL,
  `description` VARCHAR(255) NOT NULL,
  `avaliable` INT NOT NULL,
  `category_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `category_id_fk_idx` (`category_id` ASC),
  CONSTRAINT `category_id_fk`
    FOREIGN KEY (`category_id`)
    REFERENCES `redstore`.`category` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `redstore`.`sales` (
  `id` INT NOT NULL,
  `total_value` INT NOT NULL,
  `mail_code` VARCHAR(255) NULL,
  `payment_status_id` INT NOT NULL,
  `payment_form_id` INT NOT NULL,
  `product_id` INT NOT NULL,
  `delivery_status_id` INT NOT NULL,
  `bought_at` DATETIME NOT NULL,
  `paid_at` DATETIME NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `payment_status_id_fk_idx` (`payment_status_id` ASC),
  INDEX `payment_form_id_fk_idx` (`payment_form_id` ASC),
  INDEX `product_id_fk_idx` (`product_id` ASC),
  INDEX `delivery_status_id_fk_idx` (`delivery_status_id` ASC),
  CONSTRAINT `payment_status_id_fk`
    FOREIGN KEY (`payment_status_id`)
    REFERENCES `redstore`.`payment_status` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `payment_form_id_fk`
    FOREIGN KEY (`payment_form_id`)
    REFERENCES `redstore`.`payment_form` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `product_id_fk`
    FOREIGN KEY (`product_id`)
    REFERENCES `redstore`.`product` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `delivery_status_id_fk`
    FOREIGN KEY (`delivery_status_id`)
    REFERENCES `redstore`.`delivery_status` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;
