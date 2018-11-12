// TABELA
select
    (select t.apelido FROM times t where t.idTim=time) as time,
    count(*) J, 
    sum(
          case when golM > golV then 3 else 0 end 
        + case when golM = golV then 1 else 0 end
    ) P, 
    count(case when golM > golV then 1 end) V, 
    count(case when golM = golV then 1 end) E, 
    count(case when golV> golM then 1 end) D, 
    sum(golM) GP, 
    sum(golV) GC, 
    sum(golM) - sum(golV) SG
from (
    select idMan time, golM, golV from jogo 
    
  union all
    select idVis, golV, golM from jogo
    
) a 
group by time
order by P DESC, V DESC, SG DESC, GP DESC



// ARTILHEIRO
SELECT J.apelido Jogador, COUNT(*) Gols FROM evento E, jogador J WHERE J.idJgd=E.idJgd AND temporada=(SELECT temporada FROM jogo ORDER BY temporada DESC LIMIT 1) AND idAca=1 GROUP BY E.idJgd ORDER BY Gols DESC


/*
select
    time, 
    count(*) J, 
    sum(
          case when golM > golV then 3 else 0 end 
        + case when golM = golV then 1 else 0 end
    ) P, 
    count(case when golM > golV then 1 end) V, 
    count(case when golV> golM then 1 end) D, 
    count(case when golM = golV then 1 end) E, 
    sum(golM) golM, 
    sum(golV) golV, 
    sum(golM) - sum(golV) SG
from (
    select idMan time, golM, golV from jogo 
  union all
    select idVis, golV, golM from jogo
) a 
group by time
order by P DESC, V DESC, SG DESC, golM DESC*/