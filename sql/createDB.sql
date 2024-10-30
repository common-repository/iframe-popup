CREATE TABLE IF NOT EXISTS `iframepopup` (
  `id` INT unsigned NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(255) NOT NULL,
  `url` VARCHAR(255) NOT NULL,
  `width` VARCHAR(6) NOT NULL default '75%',
  `height` VARCHAR(6) NOT NULL default '75%',
  `transitionin` VARCHAR(10) NOT NULL default 'fade',
  `transitionout` VARCHAR(10) NOT NULL default 'fade',
  `centeronscroll` VARCHAR(6) NOT NULL default 'true',
  `titleshow` VARCHAR(6) NOT NULL default 'true',
  `expiration` datetime NOT NULL default '9999-12-31 00:00:00',
  `starttime` datetime NOT NULL default '2014-04-01 00:00:00',
  `overlaycolor` VARCHAR(10) NOT NULL default '#666666',
  `group` VARCHAR(10) NOT NULL default 'Category1',
  `timeout` VARCHAR(6) NOT NULL default '2000',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;