DELIMITER $$

DROP PROCEDURE IF EXISTS apa2cons_ind514
$$

CREATE PROCEDURE apa2cons_ind514(idBilaSociCons INT, idColl INT, idEnqu INT)
COMMENT ''
LANGUAGE SQL
NOT DETERMINISTIC
CONTAINS SQL
SQL SECURITY DEFINER
BEGIN
	declare v5141 int(11);
	declare v5142 int(11);
	declare v5143 int(11);
	declare v5144 int(11);

	SELECT MT_CNFPTCOTIOBL, MT_CNFPTSUPCOTIOBL, MT_AUTRORGA, MT_FRAIDEPLA INTO v5141,v5142,v5143,v5144
	FROM information_colectivite_agent
	WHERE ID_COLL = idColl
	AND ID_ENQU = idEnqu;
	
	UPDATE bilan_social_consolide set R_5141 = v5141, R_5142 = v5142, R_5143 = v5143, R_5144 = v5144
	where ID_BILASOCICONS = idBilaSociCons;
	
END
$$
