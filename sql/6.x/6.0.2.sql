CREATE TABLE bsc_handitorial_inaptitude_et_reclassement (Q_A511 INT DEFAULT NULL, Q_A512 INT DEFAULT NULL, Q_A513 INT DEFAULT NULL, R_A9 INT DEFAULT NULL, R_A91 INT DEFAULT NULL, Q_A521 INT DEFAULT NULL, R_A101 INT DEFAULT NULL, Q_A522 INT DEFAULT NULL, Q_A523 INT DEFAULT NULL, Q_A62 INT DEFAULT NULL, Q_A72 INT DEFAULT NULL, Q_A8 TINYINT(1) DEFAULT NULL, Q_A82 INT DEFAULT NULL, FG_STAT VARCHAR(1) DEFAULT NULL, DT_CREA DATETIME DEFAULT NULL, CD_UTILCREA VARCHAR(50) DEFAULT NULL, DT_MODI DATETIME DEFAULT NULL, CD_UTILMODI VARCHAR(50) DEFAULT NULL, ID_BSC_HANDITORIAL_INAPTITUDE_ET_RECLASSEMENT INT AUTO_INCREMENT NOT NULL, ID_BILASOCICONS INT DEFAULT NULL, UNIQUE INDEX UNIQ_86013D7BFABDE790 (ID_BILASOCICONS), INDEX FK_BSC_HANDI_INAPTITUDE_ET_RECLASSEMENT_BILANSOCIALCONSOLIDE (ID_BILASOCICONS), PRIMARY KEY(ID_BSC_HANDITORIAL_INAPTITUDE_ET_RECLASSEMENT)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;

ALTER TABLE bilan_social_consolide ADD BL_INCO_HANDITORIAL_INAPTITUDE_ET_RECLASSEMENT INT DEFAULT NULL, ADD MOYENNE_HANDITORIAL_INAPTITUDE_ET_RECLASSEMENT NUMERIC(10, 1) DEFAULT NULL;

UPDATE pool SET LB_POOL = SUBSTRING(LB_POOL, 1,50);

ALTER TABLE pool CHANGE LB_POOL LB_POOL VARCHAR(50) NOT NULL COMMENT 'Nom de l''échantillon';

UPDATE export_admin SET TYPE = 20 WHERE TYPE = 0;
UPDATE export_admin SET TYPE = 10 WHERE TYPE = 1;