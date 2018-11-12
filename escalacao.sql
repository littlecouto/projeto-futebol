
SELECT 
	(SELECT apelido FROM jogador J WHERE idPos=1 AND (SELECT idTim FROM jogador_time C WHERE J.idJgd=C.idJgd LIMIT 1)=6 ORDER BY forca DESC LIMIT 1) GOL,
	(SELECT apelido FROM jogador J WHERE idPos=3 AND (SELECT idTim FROM jogador_time C WHERE J.idJgd=C.idJgd LIMIT 1)=6 ORDER BY forca DESC, idPe DESC LIMIT 1,1) LTD,
	(SELECT apelido FROM jogador J WHERE idPos=2 AND (SELECT idTim FROM jogador_time C WHERE J.idJgd=C.idJgd LIMIT 1)=6 ORDER BY forca DESC, idPe DESC LIMIT 2,1) ZGD,
	(SELECT apelido FROM jogador J WHERE idPos=2 AND (SELECT idTim FROM jogador_time C WHERE J.idJgd=C.idJgd LIMIT 1)=6 ORDER BY forca DESC, idPe  ASC LIMIT 3,1) ZGE,
	(SELECT apelido FROM jogador J WHERE idPos=3 AND (SELECT idTim FROM jogador_time C WHERE J.idJgd=C.idJgd LIMIT 1)=6 ORDER BY forca DESC, idPe  ASC LIMIT 3,1) LTE,
    
	(SELECT apelido FROM jogador J WHERE idPos=4 AND (SELECT idTim FROM jogador_time C WHERE J.idJgd=C.idJgd LIMIT 1)=6 ORDER BY forca DESC, idPe DESC LIMIT 1,1) MDD,
	(SELECT apelido FROM jogador J WHERE idPos=4 AND (SELECT idTim FROM jogador_time C WHERE J.idJgd=C.idJgd LIMIT 1)=6 ORDER BY forca DESC, idPe  ASC LIMIT 2,1) MDE,
	(SELECT apelido FROM jogador J WHERE idPos=4 AND (SELECT idTim FROM jogador_time C WHERE J.idJgd=C.idJgd LIMIT 1)=6 ORDER BY forca DESC, idPe DESC LIMIT 3,1) AS 'MOD',
	(SELECT apelido FROM jogador J WHERE idPos=4 AND (SELECT idTim FROM jogador_time C WHERE J.idJgd=C.idJgd LIMIT 1)=6 ORDER BY forca DESC, idPe  ASC LIMIT 4,1) MOE,
	
	(SELECT apelido FROM jogador J WHERE idPos=5 AND (SELECT idTim FROM jogador_time C WHERE J.idJgd=C.idJgd LIMIT 1)=6 ORDER BY forca DESC, idPe DESC LIMIT 1,1) ATD,
	(SELECT apelido FROM jogador J WHERE idPos=5 AND (SELECT idTim FROM jogador_time C WHERE J.idJgd=C.idJgd LIMIT 1)=6 ORDER BY forca DESC, idPe  ASC LIMIT 2,1) ATE
    
FROM jogador

LIMIT 1