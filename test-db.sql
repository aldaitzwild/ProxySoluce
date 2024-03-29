-- MySQL Script generated by MySQL Workbench
-- ven. 29 oct. 2021 14:16:02
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema proxysoluce
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema proxysoluce
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `proxysoluce` ;
USE `proxysoluce` ;


-- -----------------------------------------------------
-- Table `proxysoluce`.`person`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `proxysoluce`.`person` (
  `id` int NOT NULL AUTO_INCREMENT,
  `firstname` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `lastname` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `mail` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `birth` date NOT NULL,
  `user` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `pass` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `adress` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `postal` int NOT NULL,
  `town` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `picture` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `proxysoluce`.`skill`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `proxysoluce`.`skill` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(300) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `proxysoluce`.`doing`
-- -----------------------------------------------------
CREATE TABLE `user_skill` (
  `person_id` int DEFAULT NULL,
  `skill_id` int DEFAULT NULL,
  KEY `person_id` (`person_id`),
  KEY `skill_id` (`skill_id`),
  CONSTRAINT `user_skill_ibfk_3` FOREIGN KEY (`person_id`) REFERENCES `person` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `user_skill_ibfk_4` FOREIGN KEY (`skill_id`) REFERENCES `skill` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


-- -----------------------------------------------------
-- Table `proxysoluce`.`category`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `proxysoluce`.`category` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `proxysoluce`.`offering`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `proxysoluce`.`offering` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(300) NOT NULL,
  `city` VARCHAR(100) NOT NULL,
  `description` LONGTEXT NOT NULL,
  `person_id` INT NULL,
  `category_id` INT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_offering_person1_idx` (`person_id` ASC) VISIBLE,
  INDEX `fk_offering_category1_idx` (`category_id` ASC) VISIBLE,
  CONSTRAINT `fk_offering_person1`
    FOREIGN KEY (`person_id`)
    REFERENCES `proxysoluce`.`person` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_offering_category1`
    FOREIGN KEY (`category_id`)
    REFERENCES `proxysoluce`.`category` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

INSERT INTO skill (name) VALUES ('jardinage'), ('maconnerie'), ('mecanique'), ('menuiserie'), ('montage-meuble'), ('plomberie'), ('electricite'), ('carrelage'), ('carrosserie'), ('electronique'), ('informatique'), ('menage'), ('repassage');
INSERT INTO category (name) VALUES ('plomberie'), ('bricolage'), ('demenagement'), ('pose cuisine'), ('peinture'), ('jardinage');


INSERT INTO person (`firstname` , `lastname`, `mail`, `birth`, `user`,`pass`, `adress`,`postal`, `town`) VALUES ('Jérémy', 'Gautrais', 'j.gautrais@compagnies.com', '1990-05-09', 'jeremy', 'root', '17 rue du Test', '69002', 'Lyon');

INSERT INTO person (`firstname` , `lastname`, `mail`, `birth`, `user`,`pass`, `adress`,`postal`, `town`) VALUES ('Valentin ', 'Gaudin', 'v.gaudin@compagnies.com', '1990-05-09', 'valentin', 'root', '17 rue du Test', '38000', 'Grenoble');

INSERT INTO person (`firstname` , `lastname`, `mail`, `birth`, `user`,`pass`, `adress`,`postal`, `town`) VALUES ('Anthony ', 'Verchere', 'a.verchere@compagnies.com', '1990-05-09', 'anthony', 'root', '17 rue du Test', '69000', 'Lyon');

INSERT INTO person (`firstname` , `lastname`, `mail`, `birth`, `user`,`pass`, `adress`,`postal`, `town`) VALUES ('Michel ', 'Hoffman', 'm.hoffman@compagnies.com', '1990-05-09', 'michel', 'root', '17 rue du Test', '69000', 'Lyon');

INSERT INTO user_skill (`person_id`, `skill_id`) VALUES (2, 1), (2, 2), (1, 6), (1, 7), (1, 9), (3, 3), (3, 4), (4, 13), (4, 10), (4, 11);

INSERT INTO offering (title, city, description, person_id, category_id) VALUES ("Réparation d'éviers", 'Lyon', 'Je vous propose mes services pour réparer des éviers.', (SELECT id FROM person WHERE lastname="Gautrais"), (SELECT id FROM category WHERE name="plomberie"));

INSERT INTO offering (title, city, description, person_id, category_id) VALUES ("Réparation de chaudière", 'Lyon', 'Je vous propose mes services pour réparer des chaudières.', (SELECT id FROM person WHERE lastname="Gautrais"), (SELECT id FROM category WHERE name="plomberie"));

INSERT INTO offering (title, city, description, person_id, category_id) VALUES ("Pose de planchers", 'Lyon', 'Je vous propose mes services pour poser des planchers en bois massif.', (SELECT id FROM person WHERE lastname="Hoffman"), (SELECT id FROM category WHERE name="bricolage"));

INSERT INTO offering (title, city, description, person_id, category_id) VALUES ("Pose de carrelage", 'Lyon', 'Je vous propose mes services pour poser des carrelages.', (SELECT id FROM person WHERE lastname="Hoffman"), (SELECT id FROM category WHERE name="bricolage"));

INSERT INTO offering (title, city, description, person_id, category_id) VALUES ("Pose d'étagères", 'Lyon', 'Je vous propose mes services pour installer des étagères murales.', (SELECT id FROM person WHERE lastname="Hoffman"), (SELECT id FROM category WHERE name="bricolage"));

INSERT INTO offering (title, city, description, person_id, category_id) VALUES ("Pose de cuisine", 'Lyon', 'Je vous propose mes services pour installer des cuisines.', (SELECT id FROM person WHERE lastname="Hoffman"), (SELECT id FROM category WHERE name="pose cuisine"));

INSERT INTO offering (title, city, description, person_id, category_id) VALUES ("Débrousaillage", 'Grenoble', 'Je vous propose mes services pour débroussailler.', (SELECT id FROM person WHERE lastname="Gaudin"), (SELECT id FROM category WHERE name="jardinage"));

INSERT INTO offering (title, city, description, person_id, category_id) VALUES ("Taille de haie", 'Grenoble', 'Je vous propose mes services pour tailler des haies avec ma tronçonneuse.', (SELECT id FROM person WHERE lastname="Gaudin"), (SELECT id FROM category WHERE name="jardinage"));

INSERT INTO offering (title, city, description, person_id, category_id) VALUES ("Rénovation murale", 'Lyon', 'Je vous propose mes services pour repeindre vos murs et plafonds.', (SELECT id FROM person WHERE lastname="Verchere"), (SELECT id FROM category WHERE name="peinture"));

INSERT INTO offering (title, city, description, person_id, category_id) VALUES ("Réalisation de portraits", 'Lyon', 'Je vous propose mes services pour vous tirer le portrait.', (SELECT id FROM person WHERE lastname="Verchere"), (SELECT id FROM category WHERE name="peinture"));














