# DBProtect V1.2 par DB DBProtect@borrat.net
# SQL Dump
# 
# Base de données: `dbprotect`
#
# --------------------------------------------------------
#
# Structure de la table `utilisateurs`
#
CREATE TABLE `utilisateurs` (
  `id_user` int(10) unsigned NOT NULL auto_increment,
  `login` varchar(50) NOT NULL default '',
  `pass` varchar(50) NOT NULL default '',
  `nom` varchar(50) NOT NULL default '',
  `prenom` varchar(50) NOT NULL default '',
  `privilege` varchar(50) NOT NULL default '',
  PRIMARY KEY  (`id_user`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2;
#
# Contenu de la table `utilisateurs`
#
INSERT INTO `utilisateurs` (`id_user`, `login`, `pass`, `nom`, `prenom`, `privilege`) VALUES (1, 'toto', 'aa36dc6e81e2ac7ad03e12fedcb6a2c0', 'TUTU', 'Turlu', 'admin');