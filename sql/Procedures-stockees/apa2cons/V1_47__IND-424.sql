DELIMITER $$

DROP PROCEDURE IF EXISTS apa2cons_ind424
$$

CREATE PROCEDURE apa2cons_ind424(idBilaSociCons INT, idColl INT, idEnqu INT)
COMMENT ''
LANGUAGE SQL
NOT DETERMINISTIC
CONTAINS SQL
SQL SECURITY DEFINER
BEGIN
  
  ### Création et remplissage de la table temporaire
  DROP TEMPORARY TABLE IF EXISTS temp_apa2cons_ind424;
  CREATE TEMPORARY TABLE temp_apa2cons_ind424 (INDEX(Q1))
    ENGINE = MEMORY
    AS (
      SELECT        
        bsa.CD_SEXE AS Q1,
		rs.CD_STAT AS Q2,
		bsa.NB_ALLOTEMPINVTRAV AS Q20_3,
		bsa.NB_ALLOTEMPINVAPRO AS Q20_4,
        bsa.NB_ALLOTEMPINVAAUTRECAS AS Q20_5
      FROM bilan_social_agent AS bsa
        JOIN ref_statut AS rs ON bsa.ID_STAT = rs.ID_STAT  # Q2        
      WHERE bsa.ID_COLL = idColl
        AND bsa.ID_ENQU = idEnqu        
        AND rs.CD_STAT IN ('TITU', 'STAG', 'CONTPERM')  # Q2        
    );

  ### Remplissage de
  INSERT INTO ind_424 (ID_BILASOCICONS, R_TS4241,R_TS4242,R_TS4243,R_TS4244,R_TS4245,R_TS4246  , R_EMP4241, R_EMP4242, R_EMP4243, R_EMP4244, R_EMP4245, R_EMP4246)
  SELECT idBilaSociCons, 
    SUM(CASE WHEN Q1 = 1 AND Q2 in ('TITU','STAG') THEN Q20_3 ELSE 0 END) AS R_TS4241,
    SUM(CASE WHEN Q1 = 2 AND Q2 in ('TITU','STAG') THEN Q20_3 ELSE 0 END) AS R_TS4242,
	SUM(CASE WHEN Q1 = 1 AND Q2 in ('TITU','STAG') THEN Q20_4 ELSE 0 END) AS R_TS4243,
	SUM(CASE WHEN Q1 = 2 AND Q2 in ('TITU','STAG') THEN Q20_4 ELSE 0 END) AS R_TS4244,
	SUM(CASE WHEN Q1 = 1 AND Q2 in ('TITU','STAG') THEN Q20_5 ELSE 0 END) AS R_TS4245,
	SUM(CASE WHEN Q1 = 2 AND Q2 in ('TITU','STAG') THEN Q20_5 ELSE 0 END) AS R_TS4246,
	SUM(CASE WHEN Q1 = 1 AND Q2 = 'CONTPERM' THEN Q20_3 ELSE 0 END) AS R_EMP4241,
    SUM(CASE WHEN Q1 = 2 AND Q2 = 'CONTPERM' THEN Q20_3 ELSE 0 END) AS R_EMP4242,
	SUM(CASE WHEN Q1 = 1 AND Q2 = 'CONTPERM' THEN Q20_4 ELSE 0 END) AS R_EMP4243,
	SUM(CASE WHEN Q1 = 2 AND Q2 = 'CONTPERM' THEN Q20_4 ELSE 0 END) AS R_EMP4244,
	SUM(CASE WHEN Q1 = 1 AND Q2 = 'CONTPERM' THEN Q20_5 ELSE 0 END) AS R_EMP4245,
	SUM(CASE WHEN Q1 = 2 AND Q2 = 'CONTPERM' THEN Q20_5 ELSE 0 END) AS R_EMP4246
  FROM temp_apa2cons_ind424;
  
  
END
$$