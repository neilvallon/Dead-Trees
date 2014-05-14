SET NAMES utf8;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `testUsers`
-- ----------------------------
DROP TABLE IF EXISTS `testUsers`;
CREATE TABLE `testUsers` (
  `UID` varchar(16) NOT NULL,
  `User_email` varchar(128) NOT NULL,
  `User_Password` varchar(60) NOT NULL,
  `User_RegDate` datetime NOT NULL,
  `User_LastLogin` datetime DEFAULT NULL,
  `User_LoginIP` varchar(16) DEFAULT '',
  `User_Agent` longtext,
  `initSessionToken` varchar(32) DEFAULT NULL,
  `cookieToken` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`UID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
--  Records of `testUsers`
-- ----------------------------
BEGIN;
INSERT INTO `testUsers` VALUES ('2jjpwv1twum1', 'me@neilvallon.com', '$2a$08$4o44M3kmSHTWqyLdxuF1ZO3NVvgv4ZSEAspnRe07r.5wURDJP8jGW', '2011-09-14 17:30:32', '2011-09-14 17:30:32', '', '', null, null);
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
