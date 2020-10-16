SELECT (
	SELECT COALESCE(SUM(COALESCE(R_21113,0) + COALESCE(R_21114,0)),0) NB_JOUR
	FROM ind_211_1
	JOIN ref_motif_absence r_m_a ON r_m_a.ID_MOTIABSE = ind_211_1.ID_MOTIABSE
	WHERE ID_BILASOCICONS = 87 
		AND r_m_a.CD_MOTIABSE IN ('ABS001','ABS002','ABS003','ABS004','ABS005','ABS009')
) NB_JOUR,(
	SELECT COALESCE(SUM(COALESCE(R_1111,0) + COALESCE(R_1112,0) + COALESCE(R_1113,0) + COALESCE(R_1114,0)),0) NB_FONC
	FROM ind_111
	WHERE ID_BILASOCICONS = 87
) NB_FONC,(
	SELECT COALESCE(SUM(COALESCE(R_1211,0) + COALESCE(R_1212,0) + COALESCE(R_1213,0) + COALESCE(R_1214,0) + COALESCE(R_1215,0) + COALESCE(R_1216,0) + COALESCE(R_1217,0) + COALESCE(R_1218,0) + COALESCE(R_12118,0)),0) NB_CONT
	FROM ind_121
	WHERE ID_BILASOCICONS = 87
) NB_CONT