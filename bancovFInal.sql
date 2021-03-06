-- MySQL Script generated by MySQL Workbench
-- 11/01/16 23:55:41
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema tcc_interface
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema tcc_interface
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `tcc_interface` DEFAULT CHARACTER SET utf8 ;
USE `tcc_interface` ;

-- -----------------------------------------------------
-- Table `tcc_interface`.`GLOBALPARAM`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `tcc_interface`.`GLOBALPARAM` (
  `AMOSTRAS` DECIMAL(10,0) NULL,
  `FREQUENCIA` DECIMAL(10,0) NULL,
  `TENSAO` DOUBLE NULL,
  `CORRENTE` DOUBLE NULL)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `tcc_interface`.`SENSOR`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `tcc_interface`.`SENSOR` (
  `SENSOR_COD` INT NOT NULL,
  `GANHO` DECIMAL(10,0) NOT NULL,
  `MAX_CORRENTE` DOUBLE NOT NULL,
  `MIN_CORRENTE` DOUBLE NOT NULL,
  PRIMARY KEY (`SENSOR_COD`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `tcc_interface`.`ULTIMOEVT`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `tcc_interface`.`ULTIMOEVT` (
  `ULTIMOEVTLIDO` DECIMAL(10,0) NULL,
  `ULTIMOEVTINSERIDO` DECIMAL(10,0) NULL)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `tcc_interface`.`COLETAPERIODICA`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `tcc_interface`.`COLETAPERIODICA` (
  `DATAHORA` DATETIME NOT NULL,
  `CORRENTE_RMS` DOUBLE NOT NULL,
  `TENSAO_RMS` DOUBLE NOT NULL,
  PRIMARY KEY (`DATAHORA`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `tcc_interface`.`TIPO_EVENTO`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `tcc_interface`.`TIPO_EVENTO` (
  `CODIGO_EVT` INT NOT NULL,
  `DESCRICAO` VARCHAR(100) NOT NULL,
  `MEDIDOR` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`CODIGO_EVT`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `tcc_interface`.`COLETA`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `tcc_interface`.`COLETA` (
  `COLETA_COD` INT NOT NULL AUTO_INCREMENT,
  `DATAHORA` DATETIME NOT NULL,
  `TENSAO_RMS` DOUBLE NOT NULL,
  `CORRENTE_RMS` DOUBLE NULL,
  `FI` DOUBLE NULL,
  `VAL_TENSAO` VARCHAR(512) NULL,
  `VAL_CORRENTE` VARCHAR(512) NULL,
  `SENSOR_SENSOR_COD` INT NOT NULL,
  `TIPO_EVENTO_CODIGO_EVT` INT NOT NULL,
  PRIMARY KEY (`COLETA_COD`),
  INDEX `fk_COLETA_SENSOR_idx` (`SENSOR_SENSOR_COD` ASC),
  INDEX `fk_COLETA_TIPO_EVENTO1_idx` (`TIPO_EVENTO_CODIGO_EVT` ASC),
  CONSTRAINT `fk_COLETA_SENSOR`
    FOREIGN KEY (`SENSOR_SENSOR_COD`)
    REFERENCES `tcc_interface`.`SENSOR` (`SENSOR_COD`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_COLETA_TIPO_EVENTO1`
    FOREIGN KEY (`TIPO_EVENTO_CODIGO_EVT`)
    REFERENCES `tcc_interface`.`TIPO_EVENTO` (`CODIGO_EVT`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `tcc_interface`.`USUARIO`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `tcc_interface`.`USUARIO` (
  `USUARIO_COD` INT NOT NULL AUTO_INCREMENT,
  `NOME` VARCHAR(100) NOT NULL,
  `CPF` VARCHAR(11) NOT NULL,
  `EMAIL` VARCHAR(100) NOT NULL,
  `SENHA` VARCHAR(20) NOT NULL,
  `NIVEL` CHAR(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`USUARIO_COD`),
  UNIQUE INDEX `CPF_UNIQUE` (`CPF` ASC),
  UNIQUE INDEX `EMAIL_UNIQUE` (`EMAIL` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `tcc_interface`.`MAGNITUDETENSAO`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `tcc_interface`.`MAGNITUDETENSAO` (
  `POS_VETOR` INT NOT NULL,
  `HARMONICA` DOUBLE NOT NULL,
  `TETHA` DOUBLE NOT NULL,
  `COLETA_COLETA_COD` INT NOT NULL,
  INDEX `fk_MAGNITUDETENSAO_COLETA1_idx` (`COLETA_COLETA_COD` ASC),
  CONSTRAINT `fk_MAGNITUDETENSAO_COLETA1`
    FOREIGN KEY (`COLETA_COLETA_COD`)
    REFERENCES `tcc_interface`.`COLETA` (`COLETA_COD`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `tcc_interface`.`MAGNITUDECORRENTE`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `tcc_interface`.`MAGNITUDECORRENTE` (
  `POS_VETOR` INT NOT NULL,
  `HARMONICA` DOUBLE NOT NULL,
  `TETHA` DOUBLE NULL,
  `COLETA_COLETA_COD` INT NOT NULL,
  INDEX `fk_MAGNITUDECORRENTE_COLETA1_idx` (`COLETA_COLETA_COD` ASC),
  CONSTRAINT `fk_MAGNITUDECORRENTE_COLETA1`
    FOREIGN KEY (`COLETA_COLETA_COD`)
    REFERENCES `tcc_interface`.`COLETA` (`COLETA_COD`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `tcc_interface`.`CONSUMOMES`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `tcc_interface`.`CONSUMOMES` (
  `MES` DATE NOT NULL,
  `KW` DOUBLE NOT NULL,
  `DETLA_T` DOUBLE NOT NULL,
  PRIMARY KEY (`MES`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `tcc_interface`.`CONSUMODIA`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `tcc_interface`.`CONSUMODIA` (
  `DIA` DATE NOT NULL,
  `KW` DOUBLE NOT NULL,
  `DELTA_T` DOUBLE NOT NULL,
  `CONSUMOMES_MES` DATE NOT NULL,
  PRIMARY KEY (`DIA`, `CONSUMOMES_MES`),
  INDEX `fk_CONSUMODIA_CONSUMOMES1_idx` (`CONSUMOMES_MES` ASC),
  CONSTRAINT `fk_CONSUMODIA_CONSUMOMES1`
    FOREIGN KEY (`CONSUMOMES_MES`)
    REFERENCES `tcc_interface`.`CONSUMOMES` (`MES`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `tcc_interface`.`CONSUMO`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `tcc_interface`.`CONSUMO` (
  `COLETA_COLETA_COD` INT NOT NULL AUTO_INCREMENT,
  `INICIO_EVENT` DATETIME NOT NULL,
  `FIM_EVENT` DATETIME NOT NULL,
  `KW` DOUBLE NOT NULL,
  `DELTA_T` DOUBLE NOT NULL,
  `CONSUMODIA_DIA` DATE NOT NULL,
  PRIMARY KEY (`COLETA_COLETA_COD`),
  INDEX `fk_CONSUMO_CONSUMODIA1_idx` (`CONSUMODIA_DIA` ASC),
  CONSTRAINT `fk_CONSUMO_COLETA1`
    FOREIGN KEY (`COLETA_COLETA_COD`)
    REFERENCES `tcc_interface`.`COLETA` (`COLETA_COD`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_CONSUMO_CONSUMODIA1`
    FOREIGN KEY (`CONSUMODIA_DIA`)
    REFERENCES `tcc_interface`.`CONSUMODIA` (`DIA`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
