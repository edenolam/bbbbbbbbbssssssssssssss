SELECT (
	SELECT COALESCE(SUM(COALESCE(R_1111,0) + COALESCE(R_1112,0) + COALESCE(R_1113,0) + COALESCE(R_1114,0)),0) NB_FONC
	FROM ind_111
	WHERE ID_BILASOCICONS = 87
) NB_FONC,(
	SELECT COALESCE(SUM(COALESCE(R_1211,0) + COALESCE(R_1212,0) + COALESCE(R_1213,0) + COALESCE(R_1214,0) + COALESCE(R_1215,0) + COALESCE(R_1216,0) + COALESCE(R_1217,0) + COALESCE(R_1218,0) + COALESCE(R_12118,0)),0) NB_CONT
	FROM ind_121
	WHERE ID_BILASOCICONS = 87
) NB_CONT,(
	SELECT COALESCE(SUM(COALESCE(R_1611,0) + COALESCE(R_1612,0) + COALESCE(R_1613,0) + COALESCE(R_1614,0)),0)
	FROM ind_161
	WHERE ID_BILASOCICONS = 87
) NB_HANDIEMPLPERM,(
	SELECT COALESCE(SUM(COALESCE(R_16121,0) + COALESCE(R_16122,0)),0)
	FROM ind_1612
	WHERE ID_BILASOCICONS = 87
) NB_HANDIEMPLNONPERM,(
	SELECT COALESCE(SUM(COALESCE(R_1611,0) + COALESCE(R_1612,0)),0)
	FROM ind_161
	WHERE ID_BILASOCICONS = 87
) NB_HANDIFONCT,(
	SELECT COALESCE(SUM(COALESCE(R_16211,0) + COALESCE(R_16212,0) + COALESCE(R_16213,0) + COALESCE(R_16214,0)),0)
	FROM bilan_social_consolide
	WHERE ID_BILASOCICONS = 87
) NM_HANDIDEPE