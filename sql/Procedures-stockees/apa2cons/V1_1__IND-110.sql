DELIMITER $$

DROP PROCEDURE IF EXISTS apa2cons_ind110
$$

CREATE PROCEDURE apa2cons_ind110(idBilaSociCons INT, idColl INT, idEnqu INT)
COMMENT ''
LANGUAGE SQL
NOT DETERMINISTIC
CONTAINS SQL
SQL SECURITY DEFINER
BEGIN
  ### Création et remplissage de la table temporaire
  DROP TEMPORARY TABLE IF EXISTS temp_apa2cons_ind110;
  CREATE TEMPORARY TABLE temp_apa2cons_ind110 (INDEX(Q2, Q9_2))
    ENGINE = MEMORY
    AS (
      SELECT
        bsa.ID_EMPLFONC AS Q8_3,
        bsa.CD_SEXE AS Q1,
        rs.CD_STAT AS Q2,         # Titulaire=TITU, Stagiaire=STAG, Contractuel sur emploi permanent=CONTPERM, Contractuel sur emploi non permanent=CONTNONPERM
        rfp.CD_FONCPUBL AS Q9_2,  # FPT, FPE, FPH
        rce.CD_CADREMPL AS Q2_8   # Administrateur=CE001, Attaché=CE002, Ingénieurs en chef=CE006, Ingenieur=CE007
      FROM bilan_social_agent AS bsa
        JOIN ref_statut AS rs ON bsa.ID_STAT = rs.ID_STAT  # Q2
        LEFT OUTER JOIN ref_fonction_publique AS rfp ON bsa.ID_FONCPUBL = rfp.ID_FONCPUBL # Q9.2
        LEFT OUTER JOIN ref_cadre_emploi AS rce ON bsa.ID_CADREMPL = rce.ID_CADREMPL # Q2.8
      WHERE bsa.ID_COLL = idColl
        AND bsa.ID_ENQU = idEnqu
        AND bsa.BL_AGENREMU3112 = 1   # Q4.1
        AND bsa.BL_EMPLFONC = 1       # Q8.1
    );

  ### Remplissage de 1.1.0.1
  INSERT INTO ind_110_1 (ID_BILASOCICONS, ID_EMPLFONC, R_1101, R_1102, R_1103, R_1104, R_1105, R_1106, R_1107, R_1108, R_1109, R_1110)
  SELECT idBilaSociCons, ef.ID_EMPLFONC,
    SUM(CASE WHEN t.Q2_8 = 'CE001' AND t.Q1 = 1 AND t.Q2 IN ('TITU', 'STAG') AND t.Q9_2 = 'FPT' THEN 1 ELSE 0 END) AS R_1101,
    SUM(CASE WHEN t.Q2_8 = 'CE001' AND t.Q1 = 2 AND t.Q2 IN ('TITU', 'STAG') AND t.Q9_2 = 'FPT' THEN 1 ELSE 0 END) AS R_1102,
    SUM(CASE WHEN t.Q2_8 = 'CE002' AND t.Q1 = 1 AND t.Q2 IN ('TITU', 'STAG') AND t.Q9_2 = 'FPT' THEN 1 ELSE 0 END) AS R_1103,
    SUM(CASE WHEN t.Q2_8 = 'CE002' AND t.Q1 = 2 AND t.Q2 IN ('TITU', 'STAG') AND t.Q9_2 = 'FPT' THEN 1 ELSE 0 END) AS R_1104,
    SUM(CASE WHEN t.Q2_8 = 'CE006' AND t.Q1 = 1 AND t.Q2 IN ('TITU', 'STAG') AND t.Q9_2 = 'FPT' THEN 1 ELSE 0 END) AS R_1105,
    SUM(CASE WHEN t.Q2_8 = 'CE006' AND t.Q1 = 2 AND t.Q2 IN ('TITU', 'STAG') AND t.Q9_2 = 'FPT' THEN 1 ELSE 0 END) AS R_1106,
    SUM(CASE WHEN t.Q2_8 = 'CE007' AND t.Q1 = 1 AND t.Q2 IN ('TITU', 'STAG') AND t.Q9_2 = 'FPT' THEN 1 ELSE 0 END) AS R_1107,
    SUM(CASE WHEN t.Q2_8 = 'CE007' AND t.Q1 = 2 AND t.Q2 IN ('TITU', 'STAG') AND t.Q9_2 = 'FPT' THEN 1 ELSE 0 END) AS R_1108,
    SUM(CASE WHEN LOCATE(t.Q2_8, 'CE001|CE002|CE006|CE007') = 0 AND t.Q1 = 1 AND t.Q2 IN ('TITU', 'STAG') AND t.Q9_2 = 'FPT' THEN 1 ELSE 0 END) AS R_1109,
    SUM(CASE WHEN LOCATE(t.Q2_8, 'CE001|CE002|CE006|CE007') = 0 AND t.Q1 = 2 AND t.Q2 IN ('TITU', 'STAG') AND t.Q9_2 = 'FPT' THEN 1 ELSE 0 END) AS R_1110
  FROM ref_emploi_fonctionnel ef
	LEFT JOIN temp_apa2cons_ind110 t ON ef.ID_EMPLFONC = t.Q8_3
  WHERE  ef.bl_vali = 0
  GROUP BY idBilaSociCons, ef.ID_EMPLFONC
  ORDER BY ef.ID_EMPLFONC;

  ### Remplissage de 1.1.0.2
  INSERT INTO ind_110_2 (ID_BILASOCICONS, ID_EMPLFONC, R_1101, R_1102, R_1103, R_1104, R_1105, R_1106, R_1107, R_1108, R_1109, R_1110)
  SELECT idBilaSociCons, ef.ID_EMPLFONC,
    SUM(CASE WHEN t.Q2_8 = 'CE001' AND t.Q1 = 1 AND t.Q2 IN ('TITU', 'STAG') AND t.Q9_2 IN ('FPE', 'FPH') THEN 1 ELSE 0 END) AS R_1101,
    SUM(CASE WHEN t.Q2_8 = 'CE001' AND t.Q1 = 2 AND t.Q2 IN ('TITU', 'STAG') AND t.Q9_2 IN ('FPE', 'FPH') THEN 1 ELSE 0 END) AS R_1102,
    SUM(CASE WHEN t.Q2_8 = 'CE002' AND t.Q1 = 1 AND t.Q2 IN ('TITU', 'STAG') AND t.Q9_2 IN ('FPE', 'FPH') THEN 1 ELSE 0 END) AS R_1103,
    SUM(CASE WHEN t.Q2_8 = 'CE002' AND t.Q1 = 2 AND t.Q2 IN ('TITU', 'STAG') AND t.Q9_2 IN ('FPE', 'FPH') THEN 1 ELSE 0 END) AS R_1104,
    SUM(CASE WHEN t.Q2_8 = 'CE006' AND t.Q1 = 1 AND t.Q2 IN ('TITU', 'STAG') AND t.Q9_2 IN ('FPE', 'FPH') THEN 1 ELSE 0 END) AS R_1105,
    SUM(CASE WHEN t.Q2_8 = 'CE006' AND t.Q1 = 2 AND t.Q2 IN ('TITU', 'STAG') AND t.Q9_2 IN ('FPE', 'FPH') THEN 1 ELSE 0 END) AS R_1106,
    SUM(CASE WHEN t.Q2_8 = 'CE007' AND t.Q1 = 1 AND t.Q2 IN ('TITU', 'STAG') AND t.Q9_2 IN ('FPE', 'FPH') THEN 1 ELSE 0 END) AS R_1107,
    SUM(CASE WHEN t.Q2_8 = 'CE007' AND t.Q1 = 2 AND t.Q2 IN ('TITU', 'STAG') AND t.Q9_2 IN ('FPE', 'FPH') THEN 1 ELSE 0 END) AS R_1108,
    SUM(CASE WHEN LOCATE(t.Q2_8, 'CE001|CE002|CE006|CE007') = 0 AND t.Q1 = 1 AND t.Q2 IN ('TITU', 'STAG') AND t.Q9_2 IN ('FPE', 'FPH') THEN 1 ELSE 0 END) AS R_1109,
    SUM(CASE WHEN LOCATE(t.Q2_8, 'CE001|CE002|CE006|CE007') = 0 AND t.Q1 = 2 AND t.Q2 IN ('TITU', 'STAG') AND t.Q9_2 IN ('FPE', 'FPH') THEN 1 ELSE 0 END) AS R_1110
  FROM ref_emploi_fonctionnel ef
	LEFT JOIN temp_apa2cons_ind110 t ON ef.ID_EMPLFONC = t.Q8_3
  WHERE ef.bl_vali = 0
  GROUP BY idBilaSociCons, ef.ID_EMPLFONC
  ORDER BY ef.ID_EMPLFONC;

  ### Remplissage de 1.1.0.3
  INSERT INTO ind_110_3 (ID_BILASOCICONS, ID_EMPLFONC, R_1101, R_1102)
  SELECT idBilaSociCons,  ef.ID_EMPLFONC,
    SUM(CASE WHEN t.Q2_8 = 'CE001' AND t.Q1 = 1 AND t.Q2 = 'CONTPERM' THEN 1 ELSE 0 END) AS R_1101,
    SUM(CASE WHEN t.Q2_8 = 'CE001' AND t.Q1 = 2 AND t.Q2 = 'CONTPERM' THEN 1 ELSE 0 END) AS R_1102
  FROM ref_emploi_fonctionnel ef
	LEFT JOIN temp_apa2cons_ind110 t ON ef.ID_EMPLFONC = t.Q8_3
  WHERE ef.bl_vali = 0
  GROUP BY idBilaSociCons, ef.ID_EMPLFONC
  ORDER BY ef.ID_EMPLFONC;
END
$$
