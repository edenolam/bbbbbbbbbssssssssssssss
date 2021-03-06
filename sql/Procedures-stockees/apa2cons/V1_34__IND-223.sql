DELIMITER $$

DROP PROCEDURE IF EXISTS apa2cons_ind223
$$

CREATE PROCEDURE apa2cons_ind223(idBilaSociCons INT, idColl INT, idEnqu INT)
COMMENT ''
LANGUAGE SQL
NOT DETERMINISTIC
CONTAINS SQL
SQL SECURITY DEFINER
BEGIN
	
	### Création et remplissage de la table temporaire
	DROP TEMPORARY TABLE IF EXISTS temp_apa2cons_ind223;
	CREATE TEMPORARY TABLE temp_apa2cons_ind223 (INDEX(Q1))
		ENGINE = MEMORY
	AS (
		SELECT        
			bsa.CD_SEXE AS Q1,
			bsa.BL_CETOUVERT AS Q26_1,
			bsa.NB_JOURCUMU3112 AS Q26_2,
			bsa.NB_JOURVERS3112 AS Q26_3,
			bsa.NB_JOURDEPE3112 AS Q26_4,
			bsa.NB_JOURINDE3112 AS Q26_5,
			bsa.NB_JOURPRISRAFP3112 AS Q26_6,
			bsa.NB_JOURDONNEBENEF AS Q26_7,
			bsa.ID_CATE AS Q3bis
		FROM bilan_social_agent AS bsa   	
			JOIN ref_statut AS rs ON bsa.ID_STAT = rs.ID_STAT  # Q2			
		WHERE bsa.ID_COLL = idColl 
			AND bsa.ID_ENQU = idEnqu 
			AND rs.CD_STAT IN ('TITU', 'STAG', 'CONTPERM')  # Q2
			AND bsa.BL_AGENREMU3112 = 1         # Q4.1        
			AND bsa.BL_CET = 1            		# Q26 
			AND bsa.ID_CATE is not null
	);	
	
	### Remplissage 
	INSERT INTO ind_2231 (ID_BILASOCICONS, ID_CATE, R_22311, R_22312, R_22313, R_22314)
	SELECT idBilaSociCons, c.ID_CATE, 
		SUM(CASE WHEN t.Q1 = 1 THEN 1 ELSE 0 END) AS R_22311,
		SUM(CASE WHEN t.Q1 = 2 THEN 1 ELSE 0 END) AS R_22312,			
		SUM(CASE WHEN t.Q1 = 1 AND t.Q26_1 = 1 THEN 1 ELSE 0 END) AS R_22313,
		SUM(CASE WHEN t.Q1 = 2 AND t.Q26_1 = 1 THEN 1 ELSE 0 END) AS R_22314
	FROM ref_categorie c 
		LEFT JOIN temp_apa2cons_ind223 t on t.Q3bis = c.ID_CATE 
	WHERE c.BL_VALI = 0
	GROUP BY idBilaSociCons, c.ID_CATE
	ORDER BY c.ID_CATE;
	
	
	### Remplissage 
	INSERT INTO ind_2232 (ID_BILASOCICONS, ID_CATE, R_22321, R_22322, R_22323, R_22324)
	SELECT idBilaSociCons, c.ID_CATE, 
		SUM(CASE WHEN t.Q1 = 1 THEN t.Q26_2 ELSE 0 END) AS R_22321,
		SUM(CASE WHEN t.Q1 = 2 THEN t.Q26_2 ELSE 0 END) AS R_22322,			
		SUM(CASE WHEN t.Q1 = 1 THEN t.Q26_3 ELSE 0 END) AS R_22323,
		SUM(CASE WHEN t.Q1 = 2 THEN t.Q26_3 ELSE 0 END) AS R_22324
	FROM ref_categorie c 
		LEFT JOIN temp_apa2cons_ind223 t on t.Q3bis = c.ID_CATE 
	WHERE c.BL_VALI = 0
	GROUP BY idBilaSociCons, c.ID_CATE
	ORDER BY c.ID_CATE;
		
	
	### Remplissage 
	INSERT INTO ind_2233 (ID_BILASOCICONS, ID_CATE, R_22331, R_22332, R_22333, R_22334, R_22335, R_22336, R_22337, R_22338)
	SELECT idBilaSociCons, c.ID_CATE, 
		SUM(CASE WHEN t.Q1 = 1 THEN t.Q26_4 ELSE 0 END) AS R_22321,
		SUM(CASE WHEN t.Q1 = 2 THEN t.Q26_4 ELSE 0 END) AS R_22322,			
		SUM(CASE WHEN t.Q1 = 1 THEN t.Q26_5 ELSE 0 END) AS R_22323,
		SUM(CASE WHEN t.Q1 = 2 THEN t.Q26_5 ELSE 0 END) AS R_22324,
		SUM(CASE WHEN t.Q1 = 1 THEN t.Q26_6 ELSE 0 END) AS R_22325,
		SUM(CASE WHEN t.Q1 = 2 THEN t.Q26_6 ELSE 0 END) AS R_22326,
		SUM(CASE WHEN t.Q1 = 1 THEN t.Q26_7 ELSE 0 END) AS R_22327,
		SUM(CASE WHEN t.Q1 = 2 THEN t.Q26_7 ELSE 0 END) AS R_22328
	FROM ref_categorie c 
		LEFT JOIN temp_apa2cons_ind223 t on t.Q3bis = c.ID_CATE 
	WHERE c.BL_VALI = 0
	GROUP BY idBilaSociCons, c.ID_CATE
	ORDER BY c.ID_CATE;
		
  
END
$$

