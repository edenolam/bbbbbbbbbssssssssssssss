SELECT "Rémunération annuelles brutes" LB_TYPE, SUM(NB_TOTAL) NB_TOTAL
FROM (
	SELECT COALESCE(SUM(COALESCE(R_3111,0) + COALESCE(R_3112,0)),0) NB_TOTAL
	FROM ind_311 
	WHERE ID_BILASOCICONS = 1
	UNION
	SELECT COALESCE(SUM(COALESCE(R_3211,0) + COALESCE(R_3212,0)),0) NB_TOTAL
	FROM ind_321 
	WHERE ID_BILASOCICONS = 1
) aggr_remuneration_brute
UNION
SELECT "Primes et indemntés versées" LB_TYPE, SUM(NB_TOTAL) NB_TOTAL
FROM (
	SELECT COALESCE(SUM(COALESCE(R_3113,0) + COALESCE(R_3114,0) + COALESCE(R_3115,0) + COALESCE(R_3116,0)),0) NB_TOTAL
	FROM ind_311 
	WHERE ID_BILASOCICONS = 1
	UNION
	SELECT COALESCE(SUM(COALESCE(R_3213,0) + COALESCE(R_3214,0)),0) NB_TOTAL
	FROM ind_321 
	WHERE ID_BILASOCICONS = 1
) aggr_prime_indemnite
UNION
SELECT "heures supplémentaires/complémentaires versées" LB_TYPE, SUM(NB_TOTAL) NB_TOTAL
FROM (
	SELECT COALESCE(SUM(COALESCE(R_3119,0) + COALESCE(R_31110,0)),0) NB_TOTAL
	FROM ind_311 
	WHERE ID_BILASOCICONS = 1
	UNION
	SELECT COALESCE(SUM(COALESCE(R_3215,0) + COALESCE(R_3216,0)),0) NB_TOTAL
	FROM ind_321 
	WHERE ID_BILASOCICONS = 1
) aggr_heure_supplementaire
UNION
SELECT "Nouvelle Bonification Indiciaire (NBI)" LB_TYPE, SUM(NB_TOTAL) NB_TOTAL
FROM (
	SELECT COALESCE(SUM(COALESCE(R_3117,0) + COALESCE(R_3118,0)),0) NB_TOTAL
	FROM ind_311 
	WHERE ID_BILASOCICONS = 1
) aggr_nbi