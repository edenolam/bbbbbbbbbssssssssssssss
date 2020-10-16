DELIMITER $$


DROP PROCEDURE IF EXISTS traitementAllDoublons_ind123
$$

DROP PROCEDURE IF EXISTS traitementDoublons_ind123
$$

CREATE PROCEDURE traitementDoublons_ind123(idBilaSociCons INT)
COMMENT ''
LANGUAGE SQL
NOT DETERMINISTIC
CONTAINS SQL
SQL SECURITY DEFINER
BEGIN

	DECLARE vid123 INT;
	DECLARE vkey varchar(50);
	DECLARE vkeyPrevious varchar(50);
	DECLARE cursDone INT DEFAULT FALSE;

    DEClARE ind123_cursor CURSOR FOR
		select id_123, concat(id_cate, fg_genr) as vkey  from ind_123
		where id_bilasocicons = idBilaSociCons
		order by id_cate, fg_genr, id_123 desc;

	DECLARE CONTINUE HANDLER FOR NOT FOUND SET cursDone = TRUE;

	DROP TEMPORARY TABLE IF EXISTS temp_ind_123_delete;
	CREATE TEMPORARY TABLE temp_ind_123_delete (
		id123 int
	);

	SET vkeyPrevious = '-';

	OPEN ind123_cursor;
    ind_loop: LOOP

		FETCH ind123_cursor INTO vid123, vkey;

		IF cursDone THEN
			LEAVE ind_loop;
		END IF;

		IF vkeyPrevious = vkey THEN

			INSERT INTO temp_ind_123_delete (id123)
			VALUES (vid123);

		END IF;

		SET vkeyPrevious = vkey;

    END LOOP;

    CLOSE ind123_cursor;

	DELETE FROM ind_123
	WHERE id_bilasocicons = idBilaSociCons
	AND EXISTS (SELECT 1 FROM temp_ind_123_delete t WHERE t.id123 = ind_123.id_123);

END
$$


CREATE PROCEDURE traitementAllDoublons_ind123()
COMMENT ''
LANGUAGE SQL
NOT DETERMINISTIC
CONTAINS SQL
SQL SECURITY DEFINER
BEGIN

    DECLARE vid_bilasocicons INT;
    DECLARE cursDone INT DEFAULT FALSE;

    DECLARE ind_cursor CURSOR FOR
            select distinct req.id_bilasocicons
            from
            (select id_bilasocicons, FG_GENR,ID_CATE, count(*)
            from ind_123
            group by id_bilasocicons, FG_GENR, ID_CATE
            having count(*)>1
            order by id_bilasocicons, ID_CATE,FG_GENR) req;

    DECLARE CONTINUE HANDLER FOR NOT FOUND SET cursDone = TRUE;

    OPEN ind_cursor;
    ind_loop: LOOP

        FETCH ind_cursor INTO vid_bilasocicons;

        IF cursDone THEN
                LEAVE ind_loop;
        END IF;

        #select vid_bilasocicons;

        call traitementDoublons_ind123(vid_bilasocicons);

    END LOOP;

    CLOSE ind_cursor;

END
$$
