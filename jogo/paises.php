<?php
session_start();
exit;
include_once 'include/classes/funcoes.php';
include_once 'include/php/config.php';

$admin = new admin;
$admin->base = 'futebol_novo';
$admin->conectar();

$array = array(0=> array('ordem'=>1,'nome'=>'Afeganist�o','sigla2'=>'AF','sigla3'=>'AFG','codigo'=>'004',),1=> array('ordem'=>2,'nome'=>'�frica do Sul','sigla2'=>'ZA','sigla3'=>'ZAF','codigo'=>'710',),2=> array('ordem'=>3,'nome'=>'Alb�nia','sigla2'=>'AL','sigla3'=>'ALB','codigo'=>'008',),3=> array('ordem'=>4,'nome'=>'Alemanha','sigla2'=>'DE','sigla3'=>'DEU','codigo'=>'276',),4=> array('ordem'=>5,'nome'=>'Andorra','sigla2'=>'AD','sigla3'=>'AND','codigo'=>'020',),5=> array('ordem'=>6,'nome'=>'Angola','sigla2'=>'AO','sigla3'=>'AGO','codigo'=>'024',),6=> array('ordem'=>7,'nome'=>'Anguilla','sigla2'=>'AI','sigla3'=>'AIA','codigo'=>'660',),7=> array('ordem'=>8,'nome'=>'Ant�rtida','sigla2'=>'AQ','sigla3'=>'ATA','codigo'=>'010',),8=> array('ordem'=>9,'nome'=>'Ant�gua e Barbuda','sigla2'=>'AG','sigla3'=>'ATG','codigo'=>'028',),9=> array('ordem'=>10,'nome'=>'Antilhas Holandesas','sigla2'=>'AN','sigla3'=>'ANT','codigo'=>'530',),10=> array('ordem'=>11,'nome'=>'Ar�bia Saudita','sigla2'=>'SA','sigla3'=>'SAU','codigo'=>'682',),11=> array('ordem'=>12,'nome'=>'Arg�lia','sigla2'=>'DZ','sigla3'=>'DZA','codigo'=>'012',),12=> array('ordem'=>13,'nome'=>'Argentina','sigla2'=>'AR','sigla3'=>'ARG','codigo'=>'032',),13=> array('ordem'=>14,'nome'=>'Arm�nia','sigla2'=>'AM','sigla3'=>'ARM','codigo'=>'51',),14=> array('ordem'=>15,'nome'=>'Aruba','sigla2'=>'AW','sigla3'=>'ABW','codigo'=>'533',),15=> array('ordem'=>16,'nome'=>'Austr�lia','sigla2'=>'AU','sigla3'=>'AUS','codigo'=>'036',),16=> array('ordem'=>17,'nome'=>'�ustria','sigla2'=>'AT','sigla3'=>'AUT','codigo'=>'040',),17=> array('ordem'=>18,'nome'=>'Azerbaij�o','sigla2'=>'AZ  ','sigla3'=>'AZE','codigo'=>'31',),18=> array('ordem'=>19,'nome'=>'Bahamas','sigla2'=>'BS','sigla3'=>'BHS','codigo'=>'044',),19=> array('ordem'=>20,'nome'=>'Bahrein','sigla2'=>'BH','sigla3'=>'BHR','codigo'=>'048',),20=> array('ordem'=>21,'nome'=>'Bangladesh','sigla2'=>'BD','sigla3'=>'BGD','codigo'=>'050',),21=> array('ordem'=>22,'nome'=>'Barbados','sigla2'=>'BB','sigla3'=>'BRB','codigo'=>'052',),22=> array('ordem'=>23,'nome'=>'Belarus','sigla2'=>'BY','sigla3'=>'BLR','codigo'=>'112',),23=> array('ordem'=>24,'nome'=>'B�lgica','sigla2'=>'BE','sigla3'=>'BEL','codigo'=>'056',),24=> array('ordem'=>25,'nome'=>'Belize','sigla2'=>'BZ','sigla3'=>'BLZ','codigo'=>'084',),25=> array('ordem'=>26,'nome'=>'Benin','sigla2'=>'BJ','sigla3'=>'BEN','codigo'=>'204',),26=> array('ordem'=>27,'nome'=>'Bermudas','sigla2'=>'BM','sigla3'=>'BMU','codigo'=>'060',),27=> array('ordem'=>28,'nome'=>'Bol�via','sigla2'=>'BO','sigla3'=>'BOL','codigo'=>'068',),28=> array('ordem'=>29,'nome'=>'B�snia-Herzeg�vina','sigla2'=>'BA','sigla3'=>'BIH','codigo'=>'070',),29=> array('ordem'=>30,'nome'=>'Botsuana','sigla2'=>'BW','sigla3'=>'BWA','codigo'=>'072',),30=> array('ordem'=>31,'nome'=>'Brasil','sigla2'=>'BR','sigla3'=>'BRA','codigo'=>'076',),31=> array('ordem'=>32,'nome'=>'Brunei','sigla2'=>'BN','sigla3'=>'BRN','codigo'=>'096',),32=> array('ordem'=>33,'nome'=>'Bulg�ria','sigla2'=>'BG','sigla3'=>'BGR','codigo'=>'100',),33=> array('ordem'=>34,'nome'=>'Burkina Fasso','sigla2'=>'BF','sigla3'=>'BFA','codigo'=>'854',),34=> array('ordem'=>35,'nome'=>'Burundi','sigla2'=>'BI','sigla3'=>'BDI','codigo'=>'108',),35=> array('ordem'=>36,'nome'=>'But�o','sigla2'=>'BT','sigla3'=>'BTN','codigo'=>'064',),36=> array('ordem'=>37,'nome'=>'Cabo Verde','sigla2'=>'CV','sigla3'=>'CPV','codigo'=>'132',),37=> array('ordem'=>38,'nome'=>'Camar�es','sigla2'=>'CM','sigla3'=>'CMR','codigo'=>'120',),38=> array('ordem'=>39,'nome'=>'Camboja','sigla2'=>'KH','sigla3'=>'KHM','codigo'=>'116',),39=> array('ordem'=>40,'nome'=>'Canad�','sigla2'=>'CA','sigla3'=>'CAN','codigo'=>'124',),40=> array('ordem'=>41,'nome'=>'Cazaquist�o','sigla2'=>'KZ','sigla3'=>'KAZ','codigo'=>'398',),41=> array('ordem'=>42,'nome'=>'Chade','sigla2'=>'TD','sigla3'=>'TCD','codigo'=>'148',),42=> array('ordem'=>43,'nome'=>'Chile','sigla2'=>'CL','sigla3'=>'CHL','codigo'=>'152',),43=> array('ordem'=>44,'nome'=>'China','sigla2'=>'CN','sigla3'=>'CHN','codigo'=>'156',),44=> array('ordem'=>45,'nome'=>'Chipre','sigla2'=>'CY','sigla3'=>'CYP','codigo'=>'196',),45=> array('ordem'=>46,'nome'=>'Cingapura','sigla2'=>'SG','sigla3'=>'SGP','codigo'=>'702',),46=> array('ordem'=>47,'nome'=>'Col�mbia','sigla2'=>'CO','sigla3'=>'COL','codigo'=>'170',),47=> array('ordem'=>48,'nome'=>'Congo','sigla2'=>'CG','sigla3'=>'COG','codigo'=>'178',),48=> array('ordem'=>49,'nome'=>'Cor�ia do Norte','sigla2'=>'KP','sigla3'=>'PRK','codigo'=>'408',),49=> array('ordem'=>50,'nome'=>'Cor�ia do Sul','sigla2'=>'KR','sigla3'=>'KOR','codigo'=>'410',),50=> array('ordem'=>51,'nome'=>'Costa do Marfim','sigla2'=>'CI','sigla3'=>'CIV','codigo'=>'384',),51=> array('ordem'=>52,'nome'=>'Costa Rica','sigla2'=>'CR','sigla3'=>'CRI','codigo'=>'188',),52=> array('ordem'=>53,'nome'=>'Cro�cia (Hrvatska)','sigla2'=>'HR','sigla3'=>'HRV','codigo'=>'191',),53=> array('ordem'=>54,'nome'=>'Cuba','sigla2'=>'CU','sigla3'=>'CUB','codigo'=>'192',),54=> array('ordem'=>55,'nome'=>'Dinamarca','sigla2'=>'DK','sigla3'=>'DNK','codigo'=>'208',),55=> array('ordem'=>56,'nome'=>'Djibuti','sigla2'=>'DJ','sigla3'=>'DJI','codigo'=>'262',),56=> array('ordem'=>57,'nome'=>'Dominica','sigla2'=>'DM','sigla3'=>'DMA','codigo'=>'212',),57=> array('ordem'=>58,'nome'=>'Egito','sigla2'=>'EG','sigla3'=>'EGY','codigo'=>'818',),58=> array('ordem'=>59,'nome'=>'El Salvador','sigla2'=>'SV','sigla3'=>'SLV','codigo'=>'222',),59=> array('ordem'=>60,'nome'=>'Emirados �rabes Unidos','sigla2'=>'AE','sigla3'=>'ARE','codigo'=>'784',),60=> array('ordem'=>61,'nome'=>'Equador','sigla2'=>'EC','sigla3'=>'ECU','codigo'=>'218',),61=> array('ordem'=>62,'nome'=>'Eritr�ia','sigla2'=>'ER','sigla3'=>'ERI','codigo'=>'232',),62=> array('ordem'=>63,'nome'=>'Eslov�quia','sigla2'=>'SK','sigla3'=>'SVK','codigo'=>'703',),63=> array('ordem'=>64,'nome'=>'Eslov�nia','sigla2'=>'SI','sigla3'=>'SVN','codigo'=>'705',),64=> array('ordem'=>65,'nome'=>'Espanha','sigla2'=>'ES','sigla3'=>'ESP','codigo'=>'724',),65=> array('ordem'=>66,'nome'=>'Estados Unidos','sigla2'=>'US','sigla3'=>'USA','codigo'=>'840',),66=> array('ordem'=>67,'nome'=>'Est�nia','sigla2'=>'EE','sigla3'=>'EST','codigo'=>'233',),67=> array('ordem'=>68,'nome'=>'Eti�pia','sigla2'=>'ET','sigla3'=>'ETH','codigo'=>'231',),68=> array('ordem'=>69,'nome'=>'Fiji','sigla2'=>'FJ','sigla3'=>'FJI','codigo'=>'242',),69=> array('ordem'=>70,'nome'=>'Filipinas','sigla2'=>'PH','sigla3'=>'PHL','codigo'=>'608',),70=> array('ordem'=>71,'nome'=>'Finl�ndia','sigla2'=>'FI','sigla3'=>'FIN','codigo'=>'246',),71=> array('ordem'=>72,'nome'=>'Fran�a','sigla2'=>'FR','sigla3'=>'FRA','codigo'=>'250',),72=> array('ordem'=>73,'nome'=>'Gab�o','sigla2'=>'GA','sigla3'=>'GAB','codigo'=>'266',),73=> array('ordem'=>74,'nome'=>'G�mbia','sigla2'=>'GM','sigla3'=>'GMB','codigo'=>'270',),74=> array('ordem'=>75,'nome'=>'Gana','sigla2'=>'GH','sigla3'=>'GHA','codigo'=>'288',),75=> array('ordem'=>76,'nome'=>'Ge�rgia','sigla2'=>'GE','sigla3'=>'GEO','codigo'=>'268',),76=> array('ordem'=>77,'nome'=>'Gibraltar','sigla2'=>'GI','sigla3'=>'GIB','codigo'=>'292',),77=> array('ordem'=>78,'nome'=>'Gr�-Bretanha (Reino Unido, UK)','sigla2'=>'GB','sigla3'=>'GBR','codigo'=>'826',),78=> array('ordem'=>79,'nome'=>'Granada','sigla2'=>'GD','sigla3'=>'GRD','codigo'=>'308',),79=> array('ordem'=>80,'nome'=>'Gr�cia','sigla2'=>'GR','sigla3'=>'GRC','codigo'=>'300',),80=> array('ordem'=>81,'nome'=>'Groel�ndia','sigla2'=>'GL','sigla3'=>'GRL','codigo'=>'304',),81=> array('ordem'=>82,'nome'=>'Guadalupe','sigla2'=>'GP','sigla3'=>'GLP','codigo'=>'312',),82=> array('ordem'=>83,'nome'=>'Guam (Territ�rio dos Estados Unidos)','sigla2'=>'GU','sigla3'=>'GUM','codigo'=>'316',),83=> array('ordem'=>84,'nome'=>'Guatemala','sigla2'=>'GT','sigla3'=>'GTM','codigo'=>'320',),84=> array('ordem'=>85,'nome'=>'Guernsey','sigla2'=>'G','sigla3'=>'GGY','codigo'=>'832',),85=> array('ordem'=>86,'nome'=>'Guiana','sigla2'=>'GY','sigla3'=>'GUY','codigo'=>'328',),86=> array('ordem'=>87,'nome'=>'Guiana Francesa','sigla2'=>'GF','sigla3'=>'GUF','codigo'=>'254',),87=> array('ordem'=>88,'nome'=>'Guin�','sigla2'=>'GN','sigla3'=>'GIN','codigo'=>'324',),88=> array('ordem'=>89,'nome'=>'Guin� Equatorial','sigla2'=>'GQ','sigla3'=>'GNQ','codigo'=>'226',),89=> array('ordem'=>90,'nome'=>'Guin�-Bissau','sigla2'=>'GW','sigla3'=>'GNB','codigo'=>'624',),90=> array('ordem'=>91,'nome'=>'Haiti','sigla2'=>'HT','sigla3'=>'HTI','codigo'=>'332',),91=> array('ordem'=>92,'nome'=>'Holanda','sigla2'=>'NL','sigla3'=>'NLD','codigo'=>'528',),92=> array('ordem'=>93,'nome'=>'Honduras','sigla2'=>'HN','sigla3'=>'HND','codigo'=>'340',),93=> array('ordem'=>94,'nome'=>'Hong Kong','sigla2'=>'HK','sigla3'=>'HKG','codigo'=>'344',),94=> array('ordem'=>95,'nome'=>'Hungria','sigla2'=>'HU','sigla3'=>'HUN','codigo'=>'348',),95=> array('ordem'=>96,'nome'=>'I�men','sigla2'=>'YE','sigla3'=>'YEM','codigo'=>'887',),96=> array('ordem'=>97,'nome'=>'Ilha Bouvet (Territ�rio da Noruega)','sigla2'=>'BV','sigla3'=>'BVT','codigo'=>'074',),97=> array('ordem'=>98,'nome'=>'Ilha do Homem','sigla2'=>'IM','sigla3'=>'IMN','codigo'=>'833',),98=> array('ordem'=>99,'nome'=>'Ilha Natal','sigla2'=>'CX','sigla3'=>'CXR','codigo'=>'162',),99=> array('ordem'=>100,'nome'=>'Ilha Pitcairn','sigla2'=>'PN','sigla3'=>'PCN','codigo'=>'612',),100=> array('ordem'=>101,'nome'=>'Ilha Reuni�o','sigla2'=>'RE','sigla3'=>'REU','codigo'=>'638',),101=> array('ordem'=>102,'nome'=>'Ilhas Aland','sigla2'=>'AX','sigla3'=>'ALA','codigo'=>'248',),102=> array('ordem'=>103,'nome'=>'Ilhas Cayman','sigla2'=>'KY','sigla3'=>'CYM','codigo'=>'136',),103=> array('ordem'=>104,'nome'=>'Ilhas Cocos','sigla2'=>'CC','sigla3'=>'CCK','codigo'=>'166',),104=> array('ordem'=>105,'nome'=>'Ilhas Comores','sigla2'=>'KM','sigla3'=>'COM','codigo'=>'174',),105=> array('ordem'=>106,'nome'=>'Ilhas Cook','sigla2'=>'CK','sigla3'=>'COK','codigo'=>'184',),106=> array('ordem'=>107,'nome'=>'Ilhas Faroes','sigla2'=>'FO','sigla3'=>'FRO','codigo'=>'234',),107=> array('ordem'=>108,'nome'=>'Ilhas Falkland (Malvinas)','sigla2'=>'FK','sigla3'=>'FLK','codigo'=>'238',),108=> array('ordem'=>109,'nome'=>'Ilhas Ge�rgia do Sul e Sandwich do Sul','sigla2'=>'GS','sigla3'=>'SGS','codigo'=>'239',),109=> array('ordem'=>110,'nome'=>'Ilhas Heard e McDonald (Territ�rio da Austr�lia)','sigla2'=>'HM','sigla3'=>'HMD','codigo'=>'334',),110=> array('ordem'=>111,'nome'=>'Ilhas Marianas do Norte','sigla2'=>'MP','sigla3'=>'MNP','codigo'=>'580',),111=> array('ordem'=>112,'nome'=>'Ilhas Marshall','sigla2'=>'MH','sigla3'=>'MHL','codigo'=>'584',),112=> array('ordem'=>113,'nome'=>'Ilhas Menores dos Estados Unidos','sigla2'=>'UM','sigla3'=>'UMI','codigo'=>'581',),113=> array('ordem'=>114,'nome'=>'Ilhas Norfolk','sigla2'=>'NF','sigla3'=>'NFK','codigo'=>'574',),114=> array('ordem'=>115,'nome'=>'Ilhas Seychelles','sigla2'=>'SC','sigla3'=>'SYC','codigo'=>'690',),115=> array('ordem'=>116,'nome'=>'Ilhas Solom�o','sigla2'=>'SB','sigla3'=>'SLB','codigo'=>'090',),116=> array('ordem'=>117,'nome'=>'Ilhas Svalbard e Jan Mayen','sigla2'=>'SJ','sigla3'=>'SJM','codigo'=>'744',),117=> array('ordem'=>118,'nome'=>'Ilhas Tokelau','sigla2'=>'TK','sigla3'=>'TKL','codigo'=>'772',),118=> array('ordem'=>119,'nome'=>'Ilhas Turks e Caicos','sigla2'=>'TC','sigla3'=>'TCA','codigo'=>'796',),119=> array('ordem'=>120,'nome'=>'Ilhas Virgens (Estados Unidos)','sigla2'=>'VI','sigla3'=>'VIR','codigo'=>'850',),120=> array('ordem'=>121,'nome'=>'Ilhas Virgens (Inglaterra)','sigla2'=>'VG','sigla3'=>'VGB','codigo'=>'092',),121=> array('ordem'=>122,'nome'=>'Ilhas Wallis e Futuna','sigla2'=>'WF','sigla3'=>'WLF','codigo'=>'876',),122=> array('ordem'=>123,'nome'=>'�ndia','sigla2'=>'IN','sigla3'=>'IND','codigo'=>'356',),123=> array('ordem'=>124,'nome'=>'Indon�sia','sigla2'=>'ID','sigla3'=>'IDN','codigo'=>'360',),124=> array('ordem'=>125,'nome'=>'Ir�','sigla2'=>'IR','sigla3'=>'IRN','codigo'=>'364',),125=> array('ordem'=>126,'nome'=>'Iraque','sigla2'=>'IQ','sigla3'=>'IRQ','codigo'=>'368',),126=> array('ordem'=>127,'nome'=>'Irlanda','sigla2'=>'IE','sigla3'=>'IRL','codigo'=>'372',),127=> array('ordem'=>128,'nome'=>'Isl�ndia','sigla2'=>'IS','sigla3'=>'ISL','codigo'=>'352',),128=> array('ordem'=>129,'nome'=>'Israel','sigla2'=>'IL','sigla3'=>'ISR','codigo'=>'376',),129=> array('ordem'=>130,'nome'=>'It�lia','sigla2'=>'IT','sigla3'=>'ITA','codigo'=>'380',),130=> array('ordem'=>131,'nome'=>'Jamaica','sigla2'=>'JM','sigla3'=>'JAM','codigo'=>'388',),131=> array('ordem'=>132,'nome'=>'Jap�o','sigla2'=>'JP','sigla3'=>'JPN','codigo'=>'392',),132=> array('ordem'=>133,'nome'=>'Jersey','sigla2'=>'JE','sigla3'=>'JEY','codigo'=>'832',),133=> array('ordem'=>134,'nome'=>'Jord�nia','sigla2'=>'JO','sigla3'=>'JOR','codigo'=>'400',),134=> array('ordem'=>135,'nome'=>'K�nia','sigla2'=>'KE','sigla3'=>'KEN','codigo'=>'404',),135=> array('ordem'=>136,'nome'=>'Kiribati','sigla2'=>'KI','sigla3'=>'KIR','codigo'=>'296',),136=> array('ordem'=>137,'nome'=>'Kuait','sigla2'=>'KW','sigla3'=>'KWT','codigo'=>'414',),137=> array('ordem'=>138,'nome'=>'Laos','sigla2'=>'LA','sigla3'=>'LAO','codigo'=>'418',),138=> array('ordem'=>139,'nome'=>'L�tvia','sigla2'=>'LV','sigla3'=>'LVA','codigo'=>'428',),139=> array('ordem'=>140,'nome'=>'Lesoto','sigla2'=>'LS','sigla3'=>'LSO','codigo'=>'426',),140=> array('ordem'=>141,'nome'=>'L�bano','sigla2'=>'LB','sigla3'=>'LBN','codigo'=>'422',),141=> array('ordem'=>142,'nome'=>'Lib�ria','sigla2'=>'LR','sigla3'=>'LBR','codigo'=>'430',),142=> array('ordem'=>143,'nome'=>'L�bia','sigla2'=>'LY','sigla3'=>'LBY','codigo'=>'434',),143=> array('ordem'=>144,'nome'=>'Liechtenstein','sigla2'=>'LI','sigla3'=>'LIE','codigo'=>'438',),144=> array('ordem'=>145,'nome'=>'Litu�nia','sigla2'=>'LT','sigla3'=>'LTU','codigo'=>'440',),145=> array('ordem'=>146,'nome'=>'Luxemburgo','sigla2'=>'LU','sigla3'=>'LUX','codigo'=>'442',),146=> array('ordem'=>147,'nome'=>'Macau','sigla2'=>'MO','sigla3'=>'MAC','codigo'=>'446',),147=> array('ordem'=>148,'nome'=>'Maced�nia (Rep�blica Yugoslava)','sigla2'=>'MK','sigla3'=>'MKD','codigo'=>'807',),148=> array('ordem'=>149,'nome'=>'Madagascar','sigla2'=>'MG','sigla3'=>'MDG','codigo'=>'450',),149=> array('ordem'=>150,'nome'=>'Mal�sia','sigla2'=>'MY','sigla3'=>'MYS','codigo'=>'458',),150=> array('ordem'=>151,'nome'=>'Malaui','sigla2'=>'MW','sigla3'=>'MWI','codigo'=>'454',),151=> array('ordem'=>152,'nome'=>'Maldivas','sigla2'=>'MV','sigla3'=>'MDV','codigo'=>'462',),152=> array('ordem'=>153,'nome'=>'Mali','sigla2'=>'ML','sigla3'=>'MLI','codigo'=>'466',),153=> array('ordem'=>154,'nome'=>'Malta','sigla2'=>'MT','sigla3'=>'MLT','codigo'=>'470',),154=> array('ordem'=>155,'nome'=>'Marrocos','sigla2'=>'MA','sigla3'=>'MAR','codigo'=>'504',),155=> array('ordem'=>156,'nome'=>'Martinica','sigla2'=>'MQ','sigla3'=>'MTQ','codigo'=>'474',),156=> array('ordem'=>157,'nome'=>'Maur�cio','sigla2'=>'MU','sigla3'=>'MUS','codigo'=>'480',),157=> array('ordem'=>158,'nome'=>'Maurit�nia','sigla2'=>'MR','sigla3'=>'MRT','codigo'=>'478',),158=> array('ordem'=>159,'nome'=>'Mayotte','sigla2'=>'YT','sigla3'=>'MYT','codigo'=>'175',),159=> array('ordem'=>160,'nome'=>'M�xico','sigla2'=>'MX','sigla3'=>'MEX','codigo'=>'484',),160=> array('ordem'=>161,'nome'=>'Micron�sia','sigla2'=>'FM','sigla3'=>'FSM','codigo'=>'583',),161=> array('ordem'=>162,'nome'=>'Mo�ambique','sigla2'=>'MZ','sigla3'=>'MOZ','codigo'=>'508',),162=> array('ordem'=>163,'nome'=>'Moldova','sigla2'=>'MD','sigla3'=>'MDA','codigo'=>'498',),163=> array('ordem'=>164,'nome'=>'M�naco','sigla2'=>'MC','sigla3'=>'MCO','codigo'=>'492',),164=> array('ordem'=>165,'nome'=>'Mong�lia','sigla2'=>'MN','sigla3'=>'MNG','codigo'=>'496',),165=> array('ordem'=>166,'nome'=>'Montenegro','sigla2'=>'ME','sigla3'=>'MNE','codigo'=>'499',),166=> array('ordem'=>167,'nome'=>'Montserrat','sigla2'=>'MS','sigla3'=>'MSR','codigo'=>'500',),167=> array('ordem'=>168,'nome'=>'Myanma','sigla2'=>'MM','sigla3'=>'MMR','codigo'=>'104',),168=> array('ordem'=>169,'nome'=>'Nam�bia','sigla2'=>'NA','sigla3'=>'NAM','codigo'=>'516',),169=> array('ordem'=>170,'nome'=>'Nauru','sigla2'=>'NR','sigla3'=>'NRU','codigo'=>'520',),170=> array('ordem'=>171,'nome'=>'Nepal','sigla2'=>'NP','sigla3'=>'NPL','codigo'=>'524',),171=> array('ordem'=>172,'nome'=>'Nicar�gua','sigla2'=>'NI','sigla3'=>'NIC','codigo'=>'558',),172=> array('ordem'=>173,'nome'=>'N�ger','sigla2'=>'NE','sigla3'=>'NER','codigo'=>'562',),173=> array('ordem'=>174,'nome'=>'Nig�ria','sigla2'=>'NG','sigla3'=>'NGA','codigo'=>'566',),174=> array('ordem'=>175,'nome'=>'Niue','sigla2'=>'NU','sigla3'=>'NIU','codigo'=>'570',),175=> array('ordem'=>176,'nome'=>'Noruega','sigla2'=>'NO','sigla3'=>'NOR','codigo'=>'578',),176=> array('ordem'=>177,'nome'=>'Nova Caled�nia','sigla2'=>'NC','sigla3'=>'NCL','codigo'=>'540',),177=> array('ordem'=>178,'nome'=>'Nova Zel�ndia','sigla2'=>'NZ','sigla3'=>'NZL','codigo'=>'554',),178=> array('ordem'=>179,'nome'=>'Om�','sigla2'=>'OM','sigla3'=>'OMN','codigo'=>'512',),179=> array('ordem'=>180,'nome'=>'Palau','sigla2'=>'PW','sigla3'=>'PLW','codigo'=>'585',),180=> array('ordem'=>181,'nome'=>'Panam�','sigla2'=>'PA','sigla3'=>'PAN','codigo'=>'591',),181=> array('ordem'=>182,'nome'=>'Papua-Nova Guin�','sigla2'=>'PG','sigla3'=>'PNG','codigo'=>'598',),182=> array('ordem'=>183,'nome'=>'Paquist�o','sigla2'=>'PK','sigla3'=>'PAK','codigo'=>'586',),183=> array('ordem'=>184,'nome'=>'Paraguai','sigla2'=>'PY','sigla3'=>'PRY','codigo'=>'600',),184=> array('ordem'=>185,'nome'=>'Peru','sigla2'=>'PE','sigla3'=>'PER','codigo'=>'604',),185=> array('ordem'=>186,'nome'=>'Polin�sia Francesa','sigla2'=>'PF','sigla3'=>'PYF','codigo'=>'258',),186=> array('ordem'=>187,'nome'=>'Pol�nia','sigla2'=>'PL','sigla3'=>'POL','codigo'=>'616',),187=> array('ordem'=>188,'nome'=>'Porto Rico','sigla2'=>'PR','sigla3'=>'PRI','codigo'=>'630',),188=> array('ordem'=>189,'nome'=>'Portugal','sigla2'=>'PT','sigla3'=>'PRT','codigo'=>'620',),189=> array('ordem'=>190,'nome'=>'Qatar','sigla2'=>'QA','sigla3'=>'QAT','codigo'=>'634',),190=> array('ordem'=>191,'nome'=>'Quirguist�o','sigla2'=>'KG','sigla3'=>'KGZ','codigo'=>'417',),191=> array('ordem'=>192,'nome'=>'Rep�blica Centro-Africana','sigla2'=>'CF','sigla3'=>'CAF','codigo'=>'140',),192=> array('ordem'=>193,'nome'=>'Rep�blica Democr�tica do Congo','sigla2'=>'CD','sigla3'=>'COD','codigo'=>'180',),193=> array('ordem'=>194,'nome'=>'Rep�blica Dominicana','sigla2'=>'DO','sigla3'=>'DOM','codigo'=>'214',),194=> array('ordem'=>195,'nome'=>'Rep�blica Tcheca','sigla2'=>'CZ','sigla3'=>'CZE','codigo'=>'203',),195=> array('ordem'=>196,'nome'=>'Rom�nia','sigla2'=>'RO','sigla3'=>'ROM','codigo'=>'642',),196=> array('ordem'=>197,'nome'=>'Ruanda','sigla2'=>'RW','sigla3'=>'RWA','codigo'=>'646',),197=> array('ordem'=>198,'nome'=>'R�ssia (antiga URSS) - Federa��o Russa','sigla2'=>'RU','sigla3'=>'RUS','codigo'=>'643',),198=> array('ordem'=>199,'nome'=>'Saara Ocidental','sigla2'=>'EH','sigla3'=>'ESH','codigo'=>'732',),199=> array('ordem'=>200,'nome'=>'Saint Vincente e Granadinas','sigla2'=>'VC','sigla3'=>'VCT','codigo'=>'670',),200=> array('ordem'=>201,'nome'=>'Samoa Americana','sigla2'=>'AS','sigla3'=>'ASM','codigo'=>'016',),201=> array('ordem'=>202,'nome'=>'Samoa Ocidental','sigla2'=>'WS','sigla3'=>'WSM','codigo'=>'882',),202=> array('ordem'=>203,'nome'=>'San Marino','sigla2'=>'SM','sigla3'=>'SMR','codigo'=>'674',),203=> array('ordem'=>204,'nome'=>'Santa Helena','sigla2'=>'SH','sigla3'=>'SHN','codigo'=>'654',),204=> array('ordem'=>205,'nome'=>'Santa L�cia','sigla2'=>'LC','sigla3'=>'LCA','codigo'=>'662',),205=> array('ordem'=>206,'nome'=>'S�o Bartolomeu','sigla2'=>'BL','sigla3'=>'BLM','codigo'=>'652',),206=> array('ordem'=>207,'nome'=>'S�o Crist�v�o e N�vis','sigla2'=>'KN','sigla3'=>'KNA','codigo'=>'659',),207=> array('ordem'=>208,'nome'=>'S�o Martim','sigla2'=>'MF','sigla3'=>'MAF','codigo'=>'663',),208=> array('ordem'=>209,'nome'=>'S�o Tom� e Pr�ncipe','sigla2'=>'ST','sigla3'=>'STP','codigo'=>'678',),209=> array('ordem'=>210,'nome'=>'Senegal','sigla2'=>'SN','sigla3'=>'SEN','codigo'=>'686',),210=> array('ordem'=>211,'nome'=>'Serra Leoa','sigla2'=>'SL','sigla3'=>'SLE','codigo'=>'694',),211=> array('ordem'=>212,'nome'=>'S�rvia','sigla2'=>'RS','sigla3'=>'SRB','codigo'=>'688',),212=> array('ordem'=>213,'nome'=>'S�ria','sigla2'=>'SY','sigla3'=>'SYR','codigo'=>'760',),213=> array('ordem'=>214,'nome'=>'Som�lia','sigla2'=>'SO','sigla3'=>'SOM','codigo'=>'706',),214=> array('ordem'=>215,'nome'=>'Sri Lanka','sigla2'=>'LK','sigla3'=>'LKA','codigo'=>'144',),215=> array('ordem'=>216,'nome'=>'St. Pierre and Miquelon','sigla2'=>'PM','sigla3'=>'SPM','codigo'=>'666',),216=> array('ordem'=>217,'nome'=>'Suazil�ndia','sigla2'=>'SZ','sigla3'=>'SWZ','codigo'=>'748',),217=> array('ordem'=>218,'nome'=>'Sud�o','sigla2'=>'SD','sigla3'=>'SDN','codigo'=>'736',),218=> array('ordem'=>219,'nome'=>'Su�cia','sigla2'=>'SE','sigla3'=>'SWE','codigo'=>'752',),219=> array('ordem'=>220,'nome'=>'Su��a','sigla2'=>'CH','sigla3'=>'CHE','codigo'=>'756',),220=> array('ordem'=>221,'nome'=>'Suriname','sigla2'=>'SR','sigla3'=>'SUR','codigo'=>'740',),221=> array('ordem'=>222,'nome'=>'Tadjiquist�o','sigla2'=>'TJ','sigla3'=>'TJK','codigo'=>'762',),222=> array('ordem'=>223,'nome'=>'Tail�ndia','sigla2'=>'TH','sigla3'=>'THA','codigo'=>'764',),223=> array('ordem'=>224,'nome'=>'Taiwan','sigla2'=>'TW','sigla3'=>'TWN','codigo'=>'158',),224=> array('ordem'=>225,'nome'=>'Tanz�nia','sigla2'=>'TZ','sigla3'=>'TZA','codigo'=>'834',),225=> array('ordem'=>226,'nome'=>'Territ�rio Brit�nico do Oceano �ndico','sigla2'=>'IO','sigla3'=>'IOT','codigo'=>'086',),226=> array('ordem'=>227,'nome'=>'Territ�rios do Sul da Fran�a','sigla2'=>'TF','sigla3'=>'ATF','codigo'=>'260',),227=> array('ordem'=>228,'nome'=>'Territ�rios Palestinos Ocupados','sigla2'=>'PS','sigla3'=>'PSE','codigo'=>'275',),228=> array('ordem'=>229,'nome'=>'Timor Leste','sigla2'=>'TP','sigla3'=>'TMP','codigo'=>'626',),229=> array('ordem'=>230,'nome'=>'Togo','sigla2'=>'TG','sigla3'=>'TGO','codigo'=>'768',),230=> array('ordem'=>231,'nome'=>'Tonga','sigla2'=>'TO','sigla3'=>'TON','codigo'=>'776',),231=> array('ordem'=>232,'nome'=>'Trinidad and Tobago','sigla2'=>'TT','sigla3'=>'TTO','codigo'=>'780',),232=> array('ordem'=>233,'nome'=>'Tun�sia','sigla2'=>'TN','sigla3'=>'TUN','codigo'=>'788',),233=> array('ordem'=>234,'nome'=>'Turcomenist�o','sigla2'=>'TM','sigla3'=>'TKM','codigo'=>'795',),234=> array('ordem'=>235,'nome'=>'Turquia','sigla2'=>'TR','sigla3'=>'TUR','codigo'=>'792',),235=> array('ordem'=>236,'nome'=>'Tuvalu','sigla2'=>'TV','sigla3'=>'TUV','codigo'=>'798',),236=> array('ordem'=>237,'nome'=>'Ucr�nia','sigla2'=>'UA','sigla3'=>'UKR','codigo'=>'804',),237=> array('ordem'=>238,'nome'=>'Uganda','sigla2'=>'UG','sigla3'=>'UGA','codigo'=>'800',),238=> array('ordem'=>239,'nome'=>'Uruguai','sigla2'=>'UY','sigla3'=>'URY','codigo'=>'858',),239=> array('ordem'=>240,'nome'=>'Uzbequist�o','sigla2'=>'UZ','sigla3'=>'UZB','codigo'=>'860',),240=> array('ordem'=>241,'nome'=>'Vanuatu','sigla2'=>'VU','sigla3'=>'VUT','codigo'=>'548',),241=> array('ordem'=>242,'nome'=>'Vaticano','sigla2'=>'VA','sigla3'=>'VAT','codigo'=>'336',),242=> array('ordem'=>243,'nome'=>'Venezuela','sigla2'=>'VE','sigla3'=>'VEN','codigo'=>'862',),243=> array('ordem'=>244,'nome'=>'Vietn�','sigla2'=>'VN','sigla3'=>'VNM','codigo'=>'704',),244=> array('ordem'=>245,'nome'=>'Z�mbia','sigla2'=>'ZM','sigla3'=>'ZMB','codigo'=>'894',),245=> array('ordem'=>246,'nome'=>'Zimb�bue','sigla2'=>'ZW','sigla3'=>'ZWE','codigo'=>'716',),);


$array = array(
	5 => array(
		"BZ" => "Belize",
		"CR" => "Costa Rica",
		"SV" => "El Salvador",
		"GT" => "Guatemala",
		"HN" => "Honduras",
		"MX" => "M�xico",
		"NI" => "Nicar�gua",
		"PA" => "Panam�",
		"BM" => "Bermudas",
		"CA" => "Canad�",
		"US" => "Estados Unidos",
		"GL" => "Gro�nlandia",
		"PM" => "Saint Pierre e Miquelon",
		"AI" => "Anguilla",
		"AN" => "Antilhas Holandesas",
		"AG" => "Ant�gua e Barbuda",
		"AW" => "Aruba",
		"BS" => "Bahamas",
		"BB" => "Barbados",
		"CU" => "Cuba",
		"DM" => "Dominica",
		"GD" => "Granada",
		"GP" => "Guadalupe",
		"HT" => "Haiti",
		"KY" => "Ilhas Caiman",
		"TC" => "Ilhas Turks e Caicos",
		"VG" => "Ilhas Virgens Brit�nicas",
		"VI" => "Ilhas Virgens dos EUA",
		"JM" => "Jamaica",
		"MQ" => "Martinica",
		"MS" => "Montserrat",
		"PR" => "Porto Rico",
		"DO" => "Rep�blica Dominicana",
		"LC" => "Santa L�cia",
		"BL" => "S�o Bartolomeu",
		"KN" => "S�o Cristov�o e Nevis",
		"MF" => "S�o Martinho",
		"VC" => "S�o Vicente e Granadinas",
		"TT" => "Trinidad e Tobago",
	),
	2 => array(
		"AR" => "Argentina",
		"BO" => "Bol�via",
		"BR" => "Brasil",
		"CL" => "Chile",
		"CO" => "Col�mbia",
		"EC" => "Equador",
		"GY" => "Guiana",
		"GF" => "Guiana Francesa",
		"FK" => "Ilhas Malvinas",
		"PY" => "Paraguai",
		"PE" => "Peru",
		"SR" => "Suriname",
		"UY" => "Uruguai",
		"VE" => "Venezuela",
	),
	1 => array(
		"AM" => "Arm�nia",
		"AZ" => "Azerbaij�o",
		"BY" => "Belarus",
		"KZ" => "Casaquist�o",
		"GE" => "Ge�rgia",
		"MD" => "Mold�via",
		"KG" => "Quirguist�o",
		"RU" => "R�ssia",
		"TJ" => "Tadjiquist�o",
		"TM" => "Turcomenist�o",
		"UA" => "Ucr�nia",
		"UZ" => "Uzbequist�o",
		"DE" => "Alemanha",
		"BE" => "B�lgica",
		"FR" => "Fran�a",
		"NL" => "Holanda",
		"LI" => "Liechtenstein",
		"LU" => "Luxemburgo",
		"MC" => "M�naco",
		"CH" => "Su��a",
		"AT" => "�ustria",
		"BY" => "Belarus",
		"BG" => "Bulg�ria",
		"SK" => "Eslov�quia",
		"HU" => "Hungria",
		"MD" => "Mold�via",
		"PL" => "Pol�nia",
		"CZ" => "Rep�blica Tcheca",
		"RO" => "Rom�nia",
		"RU" => "R�ssia",
		"UA" => "Ucr�nia",
		"DK" => "Dinamarca",
		"EE" => "Est�nia",
		"FI" => "Finl�ndia",
		"GG" => "Guernsey",
		"IM" => "Ilha de Man",
		"AX" => "Ilhas Aland",
		"FO" => "Ilhas Faroe",
		"IE" => "Irlanda",
		"IS" => "Isl�ndia",
		"JE" => "Jersey",
		"LV" => "Let�nia",
		"LT" => "Litu�nia",
		"NO" => "Noruega",
		"GB" => "Reino Unido",
		"SE" => "Su�cia",
		"SJ" => "Svalbard e Jan Mayen",
		"AL" => "Alb�nia",
		"AD" => "Andorra",
		"BA" => "B�snia-Herzegovina",
		"HR" => "Cro�cia",
		"SI" => "Eslov�nia",
		"ES" => "Espanha",
		"GI" => "Gibraltar",
		"GR" => "Gr�cia",
		"IT" => "It�lia",
		"MK" => "Maced�nia",
		"MT" => "Malta",
		"ME" => "Montenegro",
		"PT" => "Portugal",
		"SM" => "San Marino",
		"RS" => "S�rvia",
		"CS" => "S�rvia e Montenegro",
		"VA" => "Vaticano",
		"GG" => "Guernsey",
		"JE" => "Jersey",
	),
	3 => array(
		"FJ" => "Fiji",
		"SB" => "Ilhas Salom�o",
		"NC" => "Nova Caled�nia",
		"PG" => "Papua-Nova Guin�",
		"VU" => "Vanuatu",
		"CK" => "Ilhas Cook",
		"NU" => "Niue",
		"PN" => "Pitcairn",
		"PF" => "Polin�sia Francesa",
		"WS" => "Samoa",
		"AS" => "Samoa Americana",
		"TK" => "Tokelau",
		"TO" => "Tonga",
		"TV" => "Tuvalu",
		"WF" => "Wallis e Futuna",
		"GU" => "Guam",
		"MP" => "Ilhas Marianas do Norte",
		"MH" => "Ilhas Marshall",
		"FM" => "Micron�sia",
		"NR" => "Nauru",
		"PW" => "Palau",
		"KI" => "Quiribati",
		"AU" => "Austr�lia",
		"NF" => "Ilha Norfolk",
		"NZ" => "Nova Zel�ndia",
	),
	4 => array(
		"BW" => "Botsuana",
		"LS" => "Lesoto",
		"NA" => "Nam�bia",
		"SZ" => "Suazil�ndia",
		"ZA" => "�frica do Sul",
		"AO" => "Angola",
		"TD" => "Chade",
		"CG" => "Congo",
		"CD" => "Congo-Kinshasa",
		"GA" => "Gab�o",
		"GQ" => "Guin� Equatorial",
		"CF" => "Rep�blica Centro-Africana",
		"CM" => "Rep�blica dos Camar�es",
		"ST" => "S�o Tom� e Pr�ncipe",
		"BJ" => "Benin",
		"BF" => "Burquina Faso",
		"CV" => "Cabo Verde",
		"CI" => "Costa do Marfim",
		"GH" => "Gana",
		"GN" => "Guin�",
		"GW" => "Guin� Bissau",
		"GM" => "G�mbia",
		"LR" => "Lib�ria",
		"ML" => "Mali",
		"MR" => "Maurit�nia",
		"NG" => "Nig�ria",
		"NE" => "N�ger",
		"SH" => "Santa Helena",
		"SN" => "Senegal",
		"SL" => "Serra Leoa",
		"TG" => "Togo",
		"BI" => "Burundi",
		"KM" => "Comores",
		"DJ" => "Djibuti",
		"ER" => "Eritreia",
		"ET" => "Eti�pia",
		"MG" => "Madagascar",
		"MW" => "Malawi",
		"MU" => "Maur�cio",
		"YT" => "Mayotte",
		"MZ" => "Mo�ambique",
		"KE" => "Qu�nia",
		"RE" => "Reuni�o",
		"RW" => "Ruanda",
		"SC" => "Seychelles",
		"SO" => "Som�lia",
		"TZ" => "Tanz�nia",
		"UG" => "Uganda",
		"ZW" => "Zimb�bue",
		"ZM" => "Z�mbia",
		"DZ" => "Arg�lia",
		"EG" => "Egito",
		"LY" => "L�bia",
		"MA" => "Marrocos",
		"EH" => "Saara Ocidental",
		"SD" => "Sud�o",
		"TN" => "Tun�sia",
	),
	7 => array(
		"KZ" => "Casaquist�o",
		"KG" => "Quirguist�o",
		"TJ" => "Tadjiquist�o",
		"TM" => "Turcomenist�o",
		"UZ" => "Uzbequist�o",
		"BN" => "Brunei",
		"KH" => "Camboja",
		"SG" => "Cingapura",
		"PH" => "Filipinas",
		"ID" => "Indon�sia",
		"MY" => "Mal�sia",
		"MM" => "Mianmar",
		"LA" => "Rep�blica Popular Democr�tica do Laos",
		"TH" => "Tail�ndia",
		"TL" => "Timor Leste",
		"VN" => "Vietn�",
		"AM" => "Arm�nia",
		"SA" => "Ar�bia Saudita",
		"AZ" => "Azerbaij�o",
		"BH" => "Bahrain",
		"QA" => "Catar",
		"CY" => "Chipre",
		"AE" => "Emirados �rabes Unidos",
		"GE" => "Ge�rgia",
		"IQ" => "Iraque",
		"IL" => "Israel",
		"YE" => "I�men",
		"JO" => "Jord�nia",
		"KW" => "Kuwait",
		"LB" => "L�bano",
		"OM" => "Om�",
		"SY" => "S�ria",
		"PS" => "Territ�rio da Palestina",
		"TR" => "Turquia",
		"CN" => "China",
		"KP" => "Coreia do Norte",
		"KR" => "Coreia do Sul",
		"HK" => "Hong Kong, Regi�o Admin. Especial da China",
		"JP" => "Jap�o",
		"MO" => "Macau, Regi�o Admin. Especial da China",
		"MN" => "Mong�lia",
		"TW" => "Taiwan",
		"AF" => "Afeganist�o",
		"BD" => "Bangladesh",
		"BT" => "But�o",
		"IR" => "Ir�",
		"MV" => "Maldivas",
		"NP" => "Nepal",
		"PK" => "Paquist�o",
		"LK" => "Sri Lanka",
		"IN" => "�ndia",
	),
);


foreach($array as $idCon => $continente){
	foreach($continente as $sigla => $pais){
		mysql_query("UPDATE pais SET idCon='$idCon' WHERE sigla_2='$sigla' LIMIT 1") or die(mysql_error());
	}
}

foreach($array as $valor){
	$paises[$valor['codigo']] = $valor;
}

foreach($paises as $pais){
	$nome = $pais['nome'];
	$sig2 = $pais['sigla2'];
	$sig3 = $pais['sigla3'];
	$cdgo = $pais['codigo'];
	$orde = $pais['ordem'];
	
	$rowPai = mysql_fetch_array(mysql_query("SELECT idPai FROM pais WHERE titulo='$nome'"));
	if($rowPai['idPai']>0){
		$sql = "UPDATE pais SET sigla_2='$sig2', sigla_3='$sig3', codigo='$cdgo', ordem='$orde' WHERE titulo='$nome'";
	}else{
		$sql = "INSERT INTO pais (titulo, sigla_2, sigla_3, codigo, ordem)VALUES('$nome', '$sig2', '$sig3', '$cdgo', '$orde')";
	}
	mysql_query($sql) or die(mysql_error());
	
}

?>