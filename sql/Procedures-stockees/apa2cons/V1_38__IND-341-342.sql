DELIMITER $$

DROP PROCEDURE IF EXISTS apa2cons_ind341_342
$$

CREATE PROCEDURE apa2cons_ind341_342(idBilaSociCons INT, idColl INT, idEnqu INT)
COMMENT ''
LANGUAGE SQL
NOT DETERMINISTIC
CONTAINS SQL
SQL SECURITY DEFINER
BEGIN

	declare vQ3411 tinyint(1);
	declare vQ3412 tinyint(1);
	
	declare vQ3421 tinyint(1);
	declare vQ3422 tinyint(1);
	declare vQ3423 tinyint(1);
	
	declare vR3411 int(11);
	declare vR3412 int(11);
	declare vR342 int(11);	
	
	SELECT BL_AUTOASSUSANSCONVTITU, BL_AUTOASSUAVECCONVTITU, BL_AUTOASSUAVECCONVCONT, BL_REGIASSUCHOM, 
		TITU_341, STAG_341, BL_AUTOASSUSANSCONVCONT, CONTRACTUEL_342
	INTO vQ3411, vQ3412, vQ3422, vQ3423, 
		vR3411, vR3412, vQ3421, vR342	
	FROM information_colectivite_agent
	WHERE ID_COLL = idColl
	AND ID_ENQU = idEnqu;
	
	UPDATE bilan_social_consolide SET Q_3411 = vQ3411, Q_3412 = vQ3412, Q_3421 = vQ3421, Q_3422 = vQ3422, Q_3423 = vQ3423,
		R_3411 = vR3411, R_3412 = vR3412, R_342 = vR342
	WHERE ID_BILASOCICONS = idBilaSociCons; 

	
END
$$
