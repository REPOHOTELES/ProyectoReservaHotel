-- PROCEDIMIENTO ALMACENADO SERIE FACTURA

DELIMITER $

	CREATE PROCEDURE proc_serie(IN nid_reserva INT(8), IN nfecha_factura DATE, IN ntotalBill INT(8), IN nresponsable INT(8))
	BEGIN
		DECLARE maximo VARCHAR(10);
		DECLARE num INT;
		DECLARE letter INT;
		DECLARE codigo VARCHAR(10);

   	 	SET letter = (SELECT MAX(ASCII(LEFT(serie_factura,1))) FROM facturas);
		SET num = (SELECT MAX(CAST(SUBSTRING(serie_factura,2) AS INT)) FROM facturas WHERE ASCII(LEFT(serie_factura,1))=letter);

   	 	IF num>=1 AND num<=8 THEN
    		SET num=num+1;
     		SET codigo = (SELECT CONCAT(CONCAT(CHAR(letter),'00'), CAST(num AS CHAR)));
    	ELSEIF num>=9 AND num<=98 THEN
    		SET num=num+1;
        	SET codigo = (SELECT CONCAT(CONCAT(CHAR(letter),'0'), CAST(num AS CHAR)));
    	ELSEIF num>=98 AND num<=998 THEN
    		SET num=num+1;
        	SET codigo = (SELECT CONCAT(CHAR(letter), CAST(num AS CHAR)));
       	ELSEIF num=999 THEN
       		SET codigo = (SELECT CONCAT(CHAR(letter), '1000'));
    	ELSE 
    		IF num=1000 THEN
    			SET letter = letter+1; 
    			SET codigo = (SELECT CONCAT(CHAR(letter), '001'));
    		ELSE
    			SET codigo = (SELECT 'A001');
    		END IF;
    	END IF;

    	INSERT INTO facturas (serie_factura, id_reserva, fecha_factura, tipo_factura, total_factura, id_responsable) VALUES (codigo, nid_reserva, nfecha_factura, 'N', ntotalBill, nresponsable);
END $


-- PROCEDIMIENTO ALMACENADO SERIE ORDEN SERVICIO
DELIMITER $

    CREATE PROCEDURE proc_orden_servicio(IN nid_reserva INT(8), IN nfecha_factura DATE, IN ntotalBill INT(8), IN nresponsable INT(8))
    BEGIN
        DECLARE num INT;
        DECLARE codigo VARCHAR(10);

        SET num = (SELECT MAX(CAST(serie_factura AS INT)) FROM facturas WHERE tipo_factura='O');

        IF num>=0 AND num<=8 THEN
            SET num=num+1;
            SET codigo = (SELECT CONCAT('00', CAST(num AS CHAR)));
        ELSEIF num>=9 AND num<=98 THEN
            SET num=num+1;
            SET codigo = (SELECT CONCAT('0', CAST(num AS CHAR)));
        ELSEIF num>=98 AND num<=998 THEN
            SET num=num+1;
            SET codigo = (SELECT CAST(num AS CHAR));
        ELSE 
            SET codigo = (SELECT '000');
        END IF;

        INSERT INTO facturas (serie_factura, id_reserva, fecha_factura, tipo_factura, total_factura, id_responsable) VALUES (codigo, nid_reserva, nfecha_factura, 'O', ntotalBill, nresponsable);
END $
