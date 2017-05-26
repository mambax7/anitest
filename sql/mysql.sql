CREATE TABLE `eigenaar` (
  `ID`          INT(11)     NOT NULL AUTO_INCREMENT,
  `firstname`   VARCHAR(30) NOT NULL DEFAULT '',
  `lastname`    VARCHAR(30) NOT NULL DEFAULT '',
  `postcode`    VARCHAR(7)  NOT NULL DEFAULT '',
  `woonplaats`  VARCHAR(50) NOT NULL DEFAULT '',
  `streetname`  VARCHAR(40) NOT NULL DEFAULT '',
  `housenumber` VARCHAR(6)  NOT NULL DEFAULT '',
  `phonenumber` VARCHAR(14) NOT NULL DEFAULT '',
  `emailadres`  VARCHAR(40) NOT NULL DEFAULT '',
  `website`     VARCHAR(60) NOT NULL DEFAULT '',
  `user`        VARCHAR(20) NOT NULL DEFAULT '',
  PRIMARY KEY (`ID`),
  KEY `lastname` (`lastname`(5))
)
  ENGINE = MyISAM
  DEFAULT CHARSET = latin1
  COMMENT = 'eigenaar gegevens voor stamboom'
  AUTO_INCREMENT = 6196;

CREATE TABLE `stamboom` (
  `ID`           MEDIUMINT(7) UNSIGNED NOT NULL AUTO_INCREMENT,
  `NAAM`         VARCHAR(60)           NOT NULL DEFAULT '',
  `id_eigenaar`  SMALLINT(5)           NOT NULL DEFAULT '0',
  `id_fokker`    SMALLINT(5)           NOT NULL DEFAULT '0',
  `user`         VARCHAR(25)           NOT NULL DEFAULT '',
  `roft`         ENUM ('0', '1')       NOT NULL DEFAULT '0',
  `moeder`       INT(5)                NOT NULL DEFAULT '0',
  `vader`        INT(5)                NOT NULL DEFAULT '0',
  `foto`         VARCHAR(255)          NOT NULL DEFAULT '',
  `coi`          VARCHAR(10)           NOT NULL DEFAULT '',
  `user1`        VARCHAR(255)          NOT NULL DEFAULT '',
  `user2`        VARCHAR(255)          NOT NULL DEFAULT '',
  `user3`        VARCHAR(255)          NOT NULL DEFAULT '0',
  `user4`        VARCHAR(255)          NOT NULL DEFAULT '',
  `user5`        VARCHAR(255)          NOT NULL DEFAULT '',
  `addeddate`    TIMESTAMP             NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_date` DATETIME              NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `NAAM` (`NAAM`),
  KEY `moeder` (`moeder`),
  KEY `vader` (`vader`)
)
  ENGINE = MyISAM
  DEFAULT CHARSET = latin1
  AUTO_INCREMENT = 52902;

CREATE TABLE `stamboom_config` (
  `ID`                TINYINT(2)                                                                                    NOT NULL AUTO_INCREMENT,
  `isActive`          TINYINT(1)                                                                                    NOT NULL DEFAULT '0',
  `FieldName`         VARCHAR(50)                                                                                   NOT NULL DEFAULT '',
  `FieldType`         ENUM ('dateselect', 'textbox', 'selectbox', 'radiobutton', 'textarea', 'urlfield', 'Picture') NOT NULL DEFAULT 'dateselect',
  `LookupTable`       TINYINT(1)                                                                                    NOT NULL DEFAULT '0',
  `DefaultValue`      VARCHAR(50)                                                                                   NOT NULL DEFAULT '',
  `FieldExplenation`  TINYTEXT                                                                                      NOT NULL,
  `HasSearch`         TINYINT(1)                                                                                    NOT NULL DEFAULT '0',
  `SearchName`        VARCHAR(50)                                                                                   NOT NULL DEFAULT '',
  `SearchExplenation` TINYTEXT                                                                                      NOT NULL,
  `ViewInPedigree`    TINYINT(1)                                                                                    NOT NULL DEFAULT '0',
  `ViewInAdvanced`    TINYINT(1)                                                                                    NOT NULL DEFAULT '0',
  `ViewInPie`         TINYINT(1)                                                                                    NOT NULL DEFAULT '0',
  `ViewInList`        TINYINT(1)                                                                                    NOT NULL DEFAULT '0',
  `order`             TINYINT(3)                                                                                    NOT NULL DEFAULT '0',
  UNIQUE KEY `ID` (`ID`)
)
  ENGINE = MyISAM
  DEFAULT CHARSET = latin1
  AUTO_INCREMENT = 6;

CREATE TABLE `stamboom_lookup3` (
  `ID`    TINYINT(3)   NOT NULL DEFAULT '0',
  `value` VARCHAR(255) NOT NULL DEFAULT '',
  `order` TINYINT(3)            DEFAULT NULL
)
  ENGINE = MyISAM
  DEFAULT CHARSET = latin1;

CREATE TABLE `stamboom_temp` (
  `ID`          INT(11)      NOT NULL DEFAULT '0',
  `NAAM`        TINYTEXT     NOT NULL,
  `id_eigenaar` INT(11)      NOT NULL DEFAULT '0',
  `id_fokker`   INT(11)      NOT NULL DEFAULT '0',
  `user`        VARCHAR(25)  NOT NULL DEFAULT '',
  `roft`        TINYTEXT     NOT NULL,
  `moeder`      INT(5)       NOT NULL DEFAULT '0',
  `vader`       INT(5)       NOT NULL DEFAULT '0',
  `foto`        VARCHAR(255) NOT NULL DEFAULT '',
  `coi`         VARCHAR(10)  NOT NULL DEFAULT '',
  `user1`       VARCHAR(255) NOT NULL DEFAULT '',
  `user2`       VARCHAR(255) NOT NULL DEFAULT '',
  `user3`       VARCHAR(255) NOT NULL DEFAULT '0',
  `user4`       VARCHAR(255) NOT NULL DEFAULT '',
  `user5`       VARCHAR(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`ID`),
  KEY `moeder` (`moeder`),
  KEY `vader` (`vader`)
)
  ENGINE = MyISAM
  DEFAULT CHARSET = latin1
  COMMENT = 'tijdelijke stamboom tabel voor het aanmaken van honden gegev';


CREATE TABLE `stamboom_trash` (
  `ID`          INT(11)      NOT NULL DEFAULT '0',
  `NAAM`        TINYTEXT     NOT NULL,
  `id_eigenaar` INT(11)      NOT NULL DEFAULT '0',
  `id_fokker`   INT(11)      NOT NULL DEFAULT '0',
  `user`        VARCHAR(25)  NOT NULL DEFAULT '',
  `roft`        TINYTEXT     NOT NULL,
  `moeder`      INT(5)       NOT NULL DEFAULT '0',
  `vader`       INT(5)       NOT NULL DEFAULT '0',
  `foto`        VARCHAR(255) NOT NULL DEFAULT '',
  `coi`         VARCHAR(10)  NOT NULL DEFAULT '',
  `user1`       VARCHAR(255) NOT NULL DEFAULT '',
  `user2`       VARCHAR(255) NOT NULL DEFAULT '',
  `user3`       VARCHAR(255) NOT NULL DEFAULT '0',
  `user4`       VARCHAR(255) NOT NULL DEFAULT '',
  `user5`       VARCHAR(255) NOT NULL DEFAULT '',
  `addeddate`   DATETIME     NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `moeder` (`moeder`),
  KEY `vader` (`vader`)
)
  ENGINE = MyISAM
  DEFAULT CHARSET = latin1
  COMMENT = 'tijdelijke stamboom tabel voor het aanmaken van honden gegev';

CREATE TABLE `pius_stamboon` (
  `ID`          MEDIUMINT(7)    NOT NULL,
  `NAAM`        VARCHAR(60)     NOT NULL,
  `id_eigenaar` SMALLINT(5)     NOT NULL,
  `id_fokker`   SMALLINT(5)     NOT NULL,
  `user`        VARCHAR(25)     NOT NULL,
  `roft`        ENUM ('0', '1') NOT NULL,
  `moeder`      INT(5)          NOT NULL,
  `vader`       INT(5)          NOT NULL,
  `foto`        VARCHAR(255)    NOT NULL,
  `coi`         VARCHAR(10)     NOT NULL,
  `date`        TIMESTAMP       NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `user1`       VARCHAR(255)    NOT NULL,
  `user2`       VARCHAR(255)    NOT NULL,
  `user3`       VARCHAR(255)    NOT NULL,
  `user4`       VARCHAR(255)    NOT NULL,
  `user5`       VARCHAR(255)    NOT NULL,
  UNIQUE KEY `ID` (`ID`)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = latin1;

CREATE TABLE `ob_loginfo` (
  `id`                 INT(50)      NOT NULL AUTO_INCREMENT,
  `joeyid`             VARCHAR(100) NOT NULL,
  `id_eigenaar_before` INT(100)     NOT NULL,
  `id_eigenaar_after`  VARCHAR(100) NOT NULL,
  `id_fokker_before`   VARCHAR(100) NOT NULL,
  `id_fokker_after`    VARCHAR(100) NOT NULL,
  `deleted_joey`       INT(100)     NOT NULL,
  `status`             VARCHAR(100) NOT NULL,
  `date`               TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
)
  ENGINE = MyISAM
  DEFAULT CHARSET = latin1
  AUTO_INCREMENT = 938;

CREATE TABLE `tempdata` (
  `id`     INT(50) NOT NULL AUTO_INCREMENT,
  `id_eig` INT(11) NOT NULL,
  PRIMARY KEY (`id`)
)
  ENGINE = MyISAM
  DEFAULT CHARSET = latin1
  AUTO_INCREMENT = 1;


CREATE TABLE `tempdatas` (
  `id`  INT(50) NOT NULL AUTO_INCREMENT,
  `ins` INT(50) NOT NULL,
  PRIMARY KEY (`id`)
)
  ENGINE = MyISAM
  DEFAULT CHARSET = latin1
  AUTO_INCREMENT = 288;


CREATE TABLE `tempdatass` (
  `id`  INT(50) NOT NULL AUTO_INCREMENT,
  `ins` INT(50) NOT NULL,
  PRIMARY KEY (`id`)
)
  ENGINE = MyISAM
  DEFAULT CHARSET = latin1
  AUTO_INCREMENT = 294;
