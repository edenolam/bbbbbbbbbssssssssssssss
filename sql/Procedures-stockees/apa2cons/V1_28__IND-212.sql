DELIMITER $$

DROP PROCEDURE IF EXISTS apa2cons_ind212
$$

CREATE PROCEDURE apa2cons_ind212(idBilaSociCons INT, idColl INT, idEnqu INT)
COMMENT ''
LANGUAGE SQL
NOT DETERMINISTIC
CONTAINS SQL
SQL SECURITY DEFINER
BEGIN


  ### Création et remplissage de la table temporaire
  DROP TEMPORARY TABLE IF EXISTS temp_apa2cons_ind212;
  CREATE TEMPORARY TABLE temp_apa2cons_ind212 (INDEX(Q1))
    ENGINE = MEMORY
    AS (
      SELECT        
        bsa.CD_SEXE AS Q1,
		CASE WHEN   TIMESTAMPDIFF(YEAR, CONVERT(CONCAT(SUBSTRING( bsa.lb_datenais  , 4, 4), CONCAT('-', CONCAT(SUBSTRING('05/1955', 1, 2), '-15'))), DATE ), CURDATE()) < 25 
				THEN 1
			 WHEN   TIMESTAMPDIFF(YEAR, CONVERT(CONCAT(SUBSTRING( bsa.lb_datenais  , 4, 4), CONCAT('-', CONCAT(SUBSTRING('05/1955', 1, 2), '-15'))), DATE ), CURDATE()) >= 25 
				AND TIMESTAMPDIFF(YEAR, CONVERT(CONCAT(SUBSTRING( bsa.lb_datenais  , 4, 4), CONCAT('-', CONCAT(SUBSTRING('05/1955', 1, 2), '-15'))), DATE ), CURDATE()) <= 29
				THEN 2
			 WHEN   TIMESTAMPDIFF(YEAR, CONVERT(CONCAT(SUBSTRING( bsa.lb_datenais  , 4, 4), CONCAT('-', CONCAT(SUBSTRING('05/1955', 1, 2), '-15'))), DATE ), CURDATE()) >= 30
				AND TIMESTAMPDIFF(YEAR, CONVERT(CONCAT(SUBSTRING( bsa.lb_datenais  , 4, 4), CONCAT('-', CONCAT(SUBSTRING('05/1955', 1, 2), '-15'))), DATE ), CURDATE()) <= 34
				THEN 3
			 WHEN   TIMESTAMPDIFF(YEAR, CONVERT(CONCAT(SUBSTRING( bsa.lb_datenais  , 4, 4), CONCAT('-', CONCAT(SUBSTRING('05/1955', 1, 2), '-15'))), DATE ), CURDATE()) >= 35 
				AND TIMESTAMPDIFF(YEAR, CONVERT(CONCAT(SUBSTRING( bsa.lb_datenais  , 4, 4), CONCAT('-', CONCAT(SUBSTRING('05/1955', 1, 2), '-15'))), DATE ), CURDATE()) <= 39
				THEN 4
			 WHEN   TIMESTAMPDIFF(YEAR, CONVERT(CONCAT(SUBSTRING( bsa.lb_datenais  , 4, 4), CONCAT('-', CONCAT(SUBSTRING('05/1955', 1, 2), '-15'))), DATE ), CURDATE()) >= 40 
				AND TIMESTAMPDIFF(YEAR, CONVERT(CONCAT(SUBSTRING( bsa.lb_datenais  , 4, 4), CONCAT('-', CONCAT(SUBSTRING('05/1955', 1, 2), '-15'))), DATE ), CURDATE()) <= 44
				THEN 5
			 WHEN   TIMESTAMPDIFF(YEAR, CONVERT(CONCAT(SUBSTRING( bsa.lb_datenais  , 4, 4), CONCAT('-', CONCAT(SUBSTRING('05/1955', 1, 2), '-15'))), DATE ), CURDATE()) >= 45 
				AND TIMESTAMPDIFF(YEAR, CONVERT(CONCAT(SUBSTRING( bsa.lb_datenais  , 4, 4), CONCAT('-', CONCAT(SUBSTRING('05/1955', 1, 2), '-15'))), DATE ), CURDATE()) <= 49
				THEN 6
			 WHEN   TIMESTAMPDIFF(YEAR, CONVERT(CONCAT(SUBSTRING( bsa.lb_datenais  , 4, 4), CONCAT('-', CONCAT(SUBSTRING('05/1955', 1, 2), '-15'))), DATE ), CURDATE()) >= 50 
				AND TIMESTAMPDIFF(YEAR, CONVERT(CONCAT(SUBSTRING( bsa.lb_datenais  , 4, 4), CONCAT('-', CONCAT(SUBSTRING('05/1955', 1, 2), '-15'))), DATE ), CURDATE()) <= 54
				THEN 7
			 WHEN   TIMESTAMPDIFF(YEAR, CONVERT(CONCAT(SUBSTRING( bsa.lb_datenais  , 4, 4), CONCAT('-', CONCAT(SUBSTRING('05/1955', 1, 2), '-15'))), DATE ), CURDATE()) >= 55 
				AND TIMESTAMPDIFF(YEAR, CONVERT(CONCAT(SUBSTRING( bsa.lb_datenais  , 4, 4), CONCAT('-', CONCAT(SUBSTRING('05/1955', 1, 2), '-15'))), DATE ), CURDATE()) <= 59
				THEN 8
			 WHEN   TIMESTAMPDIFF(YEAR, CONVERT(CONCAT(SUBSTRING( bsa.lb_datenais  , 4, 4), CONCAT('-', CONCAT(SUBSTRING('05/1955', 1, 2), '-15'))), DATE ), CURDATE()) >= 60 
				AND TIMESTAMPDIFF(YEAR, CONVERT(CONCAT(SUBSTRING( bsa.lb_datenais  , 4, 4), CONCAT('-', CONCAT(SUBSTRING('05/1955', 1, 2), '-15'))), DATE ), CURDATE()) <= 64
				THEN 9
			 ELSE 10 END AS ID_TRANAGE,
		aaa.ID_MOTIABSE,
		count(DISTINCT aaa.ID_BILASOCIAGEN) AS NB_FONC,
		sum(aaa.NB_ARRE) AS NB_ARRE,
		sum(aaa.NB_JOURABSE) AS NB_JOURABSE
      FROM bilan_social_agent AS bsa
        JOIN ref_statut AS rs ON bsa.ID_STAT = rs.ID_STAT  # Q2        
		JOIN absence_arret_agent AS aaa  ON bsa.ID_BILASOCIAGEN = aaa.ID_BILASOCIAGEN
      WHERE bsa.ID_COLL = idColl
        AND bsa.ID_ENQU = idEnqu
		AND aaa.NB_JOURABSE > 0
		AND rs.CD_STAT = 'CONTPERM'   # Q2
        AND bsa.BL_AGENABSE = 1       # Q20.1        
		AND bsa.LB_DATENAIS IS NOT NULL
	  GROUP BY Q1, bsa.lb_datenais, aaa.ID_MOTIABSE
		
    );
	

  ### Remplissage 
  INSERT INTO ind_212_1 (ID_BILASOCICONS, ID_MOTIABSE, R_21211, R_21212, R_21213, R_21214, R_21215, R_21216)
  SELECT idBilaSociCons, ma.ID_MOTIABSE, 
    SUM(CASE WHEN t.Q1 = 1 THEN t.NB_FONC ELSE 0 END) AS R_21211,
    SUM(CASE WHEN t.Q1 = 2 THEN t.NB_FONC ELSE 0 END) AS R_21212,
	SUM(CASE WHEN t.Q1 = 1 THEN t.NB_JOURABSE ELSE 0 END) AS R_21213,
	SUM(CASE WHEN t.Q1 = 2 THEN t.NB_JOURABSE ELSE 0 END) AS R_21214,
	SUM(CASE WHEN t.Q1 = 1 THEN t.NB_ARRE ELSE 0 END) AS R_21215,
	SUM(CASE WHEN t.Q1 = 2 THEN t.NB_ARRE ELSE 0 END) AS R_21216
  FROM ref_motif_absence ma 
  LEFT JOIN temp_apa2cons_ind212 t on t.ID_MOTIABSE = ma.ID_MOTIABSE
  GROUP BY idBilaSociCons, ma.ID_MOTIABSE
  ORDER BY ma.BL_ABSECOMP DESC,  ma.BL_ABSEMEDI DESC, ma.BL_ABSEAUTRRAIS DESC, ma.ID_MOTIABSE;
  
  
  
  INSERT INTO ind_212_2 (ID_BILASOCICONS, ID_MOTIABSE, R_21221, R_21222, R_21223, R_21224, R_21225, R_21226, R_21227, R_21228, R_21229, R_212210)
  SELECT idBilaSociCons, ma.ID_MOTIABSE, 
    SUM(CASE WHEN t.ID_TRANAGE = 1 THEN t.NB_FONC ELSE 0 END) AS R_21221,
	SUM(CASE WHEN t.ID_TRANAGE = 2 THEN t.NB_FONC ELSE 0 END) AS R_21222,
	SUM(CASE WHEN t.ID_TRANAGE = 3 THEN t.NB_FONC ELSE 0 END) AS R_21223,
	SUM(CASE WHEN t.ID_TRANAGE = 4 THEN t.NB_FONC ELSE 0 END) AS R_21224,
	SUM(CASE WHEN t.ID_TRANAGE = 5 THEN t.NB_FONC ELSE 0 END) AS R_21225,
	SUM(CASE WHEN t.ID_TRANAGE = 6 THEN t.NB_FONC ELSE 0 END) AS R_21226,
	SUM(CASE WHEN t.ID_TRANAGE = 7 THEN t.NB_FONC ELSE 0 END) AS R_21227,
	SUM(CASE WHEN t.ID_TRANAGE = 8 THEN t.NB_FONC ELSE 0 END) AS R_21228,
	SUM(CASE WHEN t.ID_TRANAGE = 9 THEN t.NB_FONC ELSE 0 END) AS R_21229,
	SUM(CASE WHEN t.ID_TRANAGE = 10 THEN t.NB_FONC ELSE 0 END) AS R_212210    
  FROM ref_motif_absence ma 
  LEFT JOIN temp_apa2cons_ind212 t on t.ID_MOTIABSE = ma.ID_MOTIABSE
  WHERE (ma.BL_ABSECOMP = 1 OR ma.BL_ABSEMEDI = 1)
  GROUP BY idBilaSociCons, ma.ID_MOTIABSE
  ORDER BY ma.BL_ABSECOMP DESC,  ma.BL_ABSEMEDI DESC, ma.ID_MOTIABSE;
  
  
  INSERT INTO ind_212_3 (ID_BILASOCICONS, ID_MOTIABSE, R_21231, R_21232, R_21233, R_21234, R_21235, R_21236, R_21237, R_21238, R_21239, R_212310)
  SELECT idBilaSociCons, ma.ID_MOTIABSE, 
    SUM(CASE WHEN t.ID_TRANAGE = 1 THEN t.NB_JOURABSE ELSE 0 END) AS R_21231,
	SUM(CASE WHEN t.ID_TRANAGE = 2 THEN t.NB_JOURABSE ELSE 0 END) AS R_21232,
	SUM(CASE WHEN t.ID_TRANAGE = 3 THEN t.NB_JOURABSE ELSE 0 END) AS R_21233,
	SUM(CASE WHEN t.ID_TRANAGE = 4 THEN t.NB_JOURABSE ELSE 0 END) AS R_21234,
	SUM(CASE WHEN t.ID_TRANAGE = 5 THEN t.NB_JOURABSE ELSE 0 END) AS R_21235,
	SUM(CASE WHEN t.ID_TRANAGE = 6 THEN t.NB_JOURABSE ELSE 0 END) AS R_21236,
	SUM(CASE WHEN t.ID_TRANAGE = 7 THEN t.NB_JOURABSE ELSE 0 END) AS R_21237,
	SUM(CASE WHEN t.ID_TRANAGE = 8 THEN t.NB_JOURABSE ELSE 0 END) AS R_21238,
	SUM(CASE WHEN t.ID_TRANAGE = 9 THEN t.NB_JOURABSE ELSE 0 END) AS R_21239,
	SUM(CASE WHEN t.ID_TRANAGE = 10 THEN t.NB_JOURABSE ELSE 0 END) AS R_212310    
  FROM ref_motif_absence ma 
  LEFT JOIN temp_apa2cons_ind212 t on t.ID_MOTIABSE = ma.ID_MOTIABSE
  WHERE (ma.BL_ABSECOMP = 1 OR ma.BL_ABSEMEDI = 1)
  GROUP BY idBilaSociCons, ma.ID_MOTIABSE
  ORDER BY ma.BL_ABSECOMP DESC,  ma.BL_ABSEMEDI DESC, ma.ID_MOTIABSE;
  
  
  
END
$$

