SELECT COALESCE(NB_ARRI,0) NB_ARRI, COALESCE(NB_DEPA,0) NB_DEPA, LB_TYPE
FROM(
	SELECT * 
	FROM (
		SELECT NB_ARRI, "fonctionnaires" LB_TYPE, 
		SUM(COALESCE(R_15011,0) + COALESCE(R_15012,0)+ COALESCE(R_15013,0)+ COALESCE(R_15014,0)+ COALESCE(R_15015,0)+ COALESCE(R_15016,0)+ COALESCE(R_15017,0)+ COALESCE(R_15018,0)) NB_DEPA
		FROM ind_150_1
		JOIN (
			SELECT SUM(COALESCE(R_1521,0) + COALESCE(R_1522,0)+ COALESCE(R_1523,0)+ COALESCE(R_1524,0)+ COALESCE(R_1525,0)+ COALESCE(R_1526,0)+ COALESCE(R_1527,0)+ COALESCE(R_1528,0)+ COALESCE(R_1528,0)+ COALESCE(R_1529,0)+ COALESCE(R_15210,0)+ COALESCE(R_15211,0)+ COALESCE(R_15213,0)+ COALESCE(R_15214,0)+ COALESCE(R_15219,0)+ COALESCE(R_15220,0)) NB_ARRI
			FROM ind_152
			WHERE ind_152.ID_BILASOCICONS = 7
		) aggr_arrive_fonctionnaires
		JOIN ref_motif_depart r_m_d ON r_m_d.ID_MOTIDEPA = ind_150_1.ID_MOTIDEPA
		JOIN statut_Motif_Depart s_m_d ON s_m_d.Motif_depart_id = r_m_d.ID_MOTIDEPA
		JOIN ref_statut r_s ON r_s.ID_STAT = s_m_d.Status_id
		WHERE ind_150_1.ID_BILASOCICONS = 7
		AND r_s.CD_STAT IN ('TITU','STAG')
	) aggr_depart_arrive_fonctionnaire
	UNION(
		SELECT NB_ARRI, "contractuels" LB_TYPE, 
		SUM(COALESCE(R_15021,0) + COALESCE(R_15022,0)+ COALESCE(R_15023,0)+ COALESCE(R_15024,0)+ COALESCE(R_15025,0)+ COALESCE(R_15026,0)+ COALESCE(R_15027,0)+ COALESCE(R_15028,0)) NB_DEPA
		FROM ind_150_2
		JOIN (
			SELECT SUM(COALESCE(R_15311,0) + COALESCE(R_15312,0)+ COALESCE(R_15313,0)+ COALESCE(R_15314,0)+ COALESCE(R_15321,0)+ COALESCE(R_15322,0)+ COALESCE(R_15323,0)+ COALESCE(R_15324,0)) NB_ARRI
			FROM ind_153_1
			JOIN ind_1532 
			WHERE ind_153_1.ID_BILASOCICONS = 7 AND ind_1532.ID_BILASOCICONS
		) aggr_arrive_contractuel
		JOIN ref_motif_depart r_m_d ON r_m_d.ID_MOTIDEPA = ind_150_2.ID_MOTIDEPA
		JOIN statut_Motif_Depart s_m_d ON s_m_d.Motif_depart_id = r_m_d.ID_MOTIDEPA
		JOIN ref_statut r_s ON r_s.ID_STAT = s_m_d.Status_id
		WHERE ind_150_2.ID_BILASOCICONS = 7
		AND r_s.CD_STAT IN ('CONTPERM')
	) UNION(
		SELECT 0 NB_DEPA, "contractuels titularisés" LB_TYPE, 
		SUM(COALESCE(R_1541,0) + COALESCE(R_1542,0)) NB_ARRI
		FROM ind_154
		JOIN ref_stage_titularisation r_s_t ON r_s_t.ID_STAGTITU = ind_154.ID_STAGTITU
		WHERE ind_154.ID_BILASOCICONS = 7
		AND r_s_t.CD_STAGTITU IN ('TS003','TS004','TS006')
	)
) aggr_arri_depa