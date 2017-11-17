SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';


CREATE SCHEMA IF NOT EXISTS `xcompany_test_dev` DEFAULT CHARACTER SET utf8 ;
USE `xcompany_test_dev`;

CREATE TABLE IF NOT EXISTS `xcompany_test_dev`.`photos` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` CHAR(36) NOT NULL,
  `name_preview` CHAR(36) NOT NULL,
  `name_origin` VARCHAR(255) NULL,
  `title` VARCHAR(255) NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `name_UNIQUE` (`name` ASC),
  UNIQUE INDEX `preview_name_UNIQUE` (`name_preview` ASC))
  ENGINE = MyISAM
  DEFAULT CHARACTER SET = utf8;

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

#######################################################################################################################
#######################################################################################################################
#######################################################################################################################

SET NAMES 'utf8';
SET collation_connection = "utf8_unicode_ci";
