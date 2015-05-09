/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50621
Source Host           : localhost:3306
Source Database       : encomiendas

Target Server Type    : MYSQL
Target Server Version : 50621
File Encoding         : 65001

Date: 2015-03-29 15:48:23
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for agencia
-- ----------------------------
DROP TABLE IF EXISTS `agencia`;
CREATE TABLE `agencia` (
  `idagencia` char(3) NOT NULL,
  `agencia` varchar(45) DEFAULT NULL,
  `idempresa` char(2) NOT NULL,
  PRIMARY KEY (`idagencia`),
  KEY `fk_agencia_empresa1_idx` (`idempresa`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='ES UNA OFICINA DESENTRALIZA DE LA EMPRESA DE TRANSPORTE, NO ES UN ITINERARIO';

-- ----------------------------
-- Records of agencia
-- ----------------------------
INSERT INTO `agencia` VALUES ('1', 'Yurimaguas', '1');
INSERT INTO `agencia` VALUES ('2', 'tarapoto', '1');
INSERT INTO `agencia` VALUES ('3', 'agencia nueva', '1');

-- ----------------------------
-- Table structure for asigna_ruta_b