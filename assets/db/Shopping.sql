-- Creating products table
CREATE TABLE IF NOT EXISTS `ICT1004_Project`.`products` (
  `products_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `item_name` VARCHAR(60) NOT NULL,
  `price` FLOAT NOT NULL,
  `quantity` INT NOT NULL,
  `summary` TINYTEXT NULL,
  `image_path` VARCHAR(45) NULL,
  `image_alt_text` VARCHAR(45) NULL,
  `last_updated` VARCHAR(45) NOT NULL,
  `category` VARCHAR(45) NOT NULL,
  `sub_category` VARCHAR(45) NULL,
  PRIMARY KEY (`products_id`),
  UNIQUE INDEX `idProducts_UNIQUE` (`products_id` ASC) VISIBLE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;



-- Creating order table
CREATE TABLE IF NOT EXISTS `ICT1004_Project`.`orders` (
  `order_id` INT NOT NULL AUTO_INCREMENT,
  `cust_id` VARCHAR(45) NOT NULL,
  `order_date` VARCHAR(45) NOT NULL,
  `order_time` VARCHAR(45) NOT NULL,
  `status` VARCHAR(45) NOT NULL,
  `payment_status` VARCHAR(45) NOT NULL,
  `payment_mode` VARCHAR(45) NOT NULL,
  `price_before_disc` FLOAT NOT NULL,
  `discount` FLOAT NULL,
  `gst` FLOAT NOT NULL,
  `grandTotal` FLOAT NOT NULL,
  `cust_name` VARCHAR(45) NOT NULL,
  `cust_email` VARCHAR(45) NOT NULL,
  `cust_mobile` VARCHAR(45) NULL,
  `order_type` VARCHAR(45) NOT NULL COMMENT 'Immediate collection(walk-in) or Pre-order(po)\n',
  `collect_date` VARCHAR(45) NULL,
  `collect_time` VARCHAR(45) NULL,
  `remarks` VARCHAR(500) NULL,
  PRIMARY KEY (`order_id`),
  UNIQUE INDEX `id_UNIQUE` (`order_id` ASC) VISIBLE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- Creating order status log table
CREATE TABLE IF NOT EXISTS `ICT1004_Project`.`order_status_log` (
  `order_status_id` INT NOT NULL AUTO_INCREMENT,
  `status_from` VARCHAR(45) NOT NULL,
  `status_to` VARCHAR(45) NOT NULL,
  `order_id` VARCHAR(45) NOT NULL,
  `status_date` VARCHAR(45) NOT NULL,
  `status_time` VARCHAR(45) NOT NULL,
  `changed_by` VARCHAR(45) NOT NULL,
  `orders_order_id` INT NOT NULL,
  PRIMARY KEY (`order_status_id`),
  UNIQUE INDEX `order_status_id_UNIQUE` (`order_status_id` ASC) VISIBLE,
  INDEX `fk_order_status_log_orders1_idx` (`orders_order_id` ASC) VISIBLE,
  CONSTRAINT `fk_order_status_log_orders1`
    FOREIGN KEY (`orders_order_id`)
    REFERENCES `ICT1004_Project`.`orders` (`order_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- Creating cart table
CREATE TABLE IF NOT EXISTS `ICT1004_Project`.`cart` (
  `cart_id` INT NOT NULL AUTO_INCREMENT,
  `cust_id` VARCHAR(45) NOT NULL,
  `created_date` VARCHAR(45) NOT NULL,
  `status` VARCHAR(45) NOT NULL,
  `order_id` VARCHAR(45) NULL,
  `orders_order_id` INT NOT NULL,
  PRIMARY KEY (`cart_id`),
  UNIQUE INDEX `cart_id_UNIQUE` (`cart_id` ASC) VISIBLE,
  UNIQUE INDEX `order_id_UNIQUE` (`order_id` ASC) VISIBLE,
  INDEX `fk_cart_orders1_idx` (`orders_order_id` ASC) VISIBLE,
  CONSTRAINT `fk_cart_orders1`
    FOREIGN KEY (`orders_order_id`)
    REFERENCES `ICT1004_Project`.`orders` (`order_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- Creating cart items table
CREATE TABLE IF NOT EXISTS `ICT1004_Project`.`cart_items` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `cart_id` INT NOT NULL,
  `products_id` INT UNSIGNED NOT NULL,
  `quantity` INT NOT NULL,
  `remarks` VARCHAR(45) NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_Cart_Items_Cart1_idx` (`cart_id` ASC) VISIBLE,
  INDEX `fk_Cart_Items_Products1_idx` (`products_id` ASC) VISIBLE,
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) VISIBLE,
  CONSTRAINT `fk_Cart_Items_Cart1`
    FOREIGN KEY (`cart_id`)
    REFERENCES `ICT1004_Project`.`cart` (`cart_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Cart_Items_Products1`
    FOREIGN KEY (`products_id`)
    REFERENCES `ICT1004_Project`.`products` (`products_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;
