SELECT NB_JOUR, LB_ORGA, (
	SELECT SUM(NB_JOUR)
	FROM(
		SELECT COALESCE(SUM(COALESCE(R_51121,0) + COALESCE(R_51122,0) + COALESCE(R_51123,0) + COALESCE(R_51124,0)),0) NB_JOUR, 'fonctionnaire' LB_TYPE
		FROM ind_5112
		WHERE ID_BILASOCICONS = 1
		UNION
		SELECT COALESCE(SUM(COALESCE(R_51131,0) + COALESCE(R_51132,0) + COALESCE(R_51133,0) + COALESCE(R_51134,0)),0) NB_JOUR, 'contractuel' LB_TYPE
		FROM ind_5113
		WHERE ID_BILASOCICONS = 1
	) aggr_jour_formation
) NB_TOTAL
FROM(
	SELECT SUM(NB_JOUR) NB_JOUR, LB_ORGA
	FROM(
		SELECT NB_JOUR, LB_ORGA, LB_TYPE
		FROM(
			SELECT COALESCE(SUM(COALESCE(R_51121,0) + COALESCE(R_51122,0)),0) NB_JOUR, 'fonctionnaire' LB_TYPE, 'CNFPT' LB_ORGA
			FROM ind_5112
			WHERE ID_BILASOCICONS = 1 
			UNION
			SELECT COALESCE(SUM(COALESCE(R_51131,0) + COALESCE(R_51132,0)),0) NB_JOUR, 'contractuel' LB_TYPE, 'CNFPT' LB_ORGA
			FROM ind_5113
			WHERE ID_BILASOCICONS = 1
		) aggr_formation_fonctionnarie_contractuel_CNFPT
		UNION
		SELECT NB_JOUR, 'Autres organismes' LB_ORGA, LB_TYPE
		FROM(
			SELECT COALESCE(SUM(COALESCE(R_51124,0)),0) NB_JOUR, 'fonctionnaire' LB_TYPE
			FROM ind_5112
			WHERE ID_BILASOCICONS = 1 
			UNION
			SELECT COALESCE(SUM(COALESCE(R_51134,0)),0) NB_JOUR, 'contractuel' LB_TYPE
			FROM ind_5113
			WHERE ID_BILASOCICONS = 1
		) aggr_formation_fonctionnarie_contractuel_autre
		UNION
		SELECT NB_JOUR, 'En interne' LB_ORGA, LB_TYPE
		FROM(
			SELECT COALESCE(SUM(COALESCE(R_51123,0)),0) NB_JOUR, 'fonctionnaire' LB_TYPE
			FROM ind_5112
			WHERE ID_BILASOCICONS = 1 
			UNION
			SELECT COALESCE(SUM(COALESCE(R_51133,0)),0) NB_JOUR, 'contractuel' LB_TYPE
			FROM ind_5113
			WHERE ID_BILASOCICONS = 1
		) aggr_formation_fonctionnarie_contractuel_autre
	) aggr_intermediaire
	GROUP BY LB_ORGA
) aggr_formation_by_orga