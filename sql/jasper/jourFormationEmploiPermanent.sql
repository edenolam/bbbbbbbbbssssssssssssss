SELECT SUM(NB_JOUR) NB_JOUR, NB_FONC, NB_CONT
FROM(
	SELECT COALESCE(SUM(COALESCE(R_51121,0) + COALESCE(R_51122,0) + COALESCE(R_51123,0) + COALESCE(R_51124,0)),0) NB_JOUR, "fonctionnaire" LB_TYPE
	FROM ind_5112
	WHERE ID_BILASOCICONS = 1
	UNION
	SELECT COALESCE(SUM(COALESCE(R_51131,0) + COALESCE(R_51132,0) + COALESCE(R_51133,0) + COALESCE(R_51134,0)),0) NB_JOUR, "contractuel" LB_TYPE
	FROM ind_5113
	WHERE ID_BILASOCICONS = 1
) aggr_jour_formation
JOIN (
	SELECT COALESCE(SUM(COALESCE(R_1111,0) + COALESCE(R_1112,0) + COALESCE(R_1113,0) + COALESCE(R_1114,0)),0) NB_FONC
	FROM ind_111
	WHERE ID_BILASOCICONS = 1
) aggr_nb_fonctionnaire
JOIN (
	SELECT COALESCE(SUM(COALESCE(R_1211,0) + COALESCE(R_1212,0) + COALESCE(R_1213,0) + COALESCE(R_1214,0) + COALESCE(R_1215,0) + COALESCE(R_1216,0) + COALESCE(R_1217,0) + COALESCE(R_1218,0) + COALESCE(R_12118,0)),0) NB_CONT
	FROM ind_121
	WHERE ID_BILASOCICONS = 1
) aggr_nb_fonctionnaire_contractuel