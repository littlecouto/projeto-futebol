function sortear(min, max){
    min = Math.min(min, max);
    max = Math.max(min, max);

    return Math.floor((Math.random() * max) + min);
}

function verForca(forca){
    var voltar;
    if(forca<=80){
        voltar = new Array(sortear(1,50));
    }else if(forca>80 && forca<=120){
        voltar = new Array(sortear(1,40), sortear(1,50));
    }else if(forca>120 && forca<=500){
        voltar = new Array(sortear(1,40), sortear(1,50), sortear(1,50));
    }else if(forca>1000){
        voltar = new Array(sortear(1,20), sortear(1,30), sortear(1,40), sortear(1,50));
    }
    return voltar;
}

function Jogar(jogoAtual, time1, time2, estadio, jog, jogo, idMan, idVis, forca1, forca2, penaltis) {

    var dados = {
        ACAO : 'TIMES',
        um   : time1,
        dois : time2
    }
    data = $(this).serialize() + "&" + $.param(dados);
    var retorna = $.post('retorna_time.php',data,function(retorna){
    });
//noprotect

    
    var i = 0,
        abr1 = $('.'+jogoAtual).find('.abr1').html(),
        abr2 = $('.'+jogoAtual).find('.abr2').html(),

        gol1 = 0,
        gol2 = 0,

        sub1 = 0,
        sub2 = 0,
        subs = 0,

        exp1 = 0,
        exp2 = 0,
        exps = 5,

        pos1 = 50,
        pos2 = 50,

        tempo = 1,
        tRel  = 2,
        atualizar = 0,
        time,

        //forca1 = Math.floor((Math.random() * 15) + 5),
        //forca2 = Math.floor((Math.random() * 15) + 5),

        amarelo = new Array(),
        vermelho = new Array(),
        substituido = new Array(),

        tipoJogo = 4,
        avisos = 0,
        intervalo = 0;
        
        if(penaltis === 1){
            tipoJogo = 4;
            i = 123;
        }
    var mandante, visitante;
    jog[0].forEach(function (value) {
        mandante += "<li>" + value + "</li>";
    });
    jog[1].forEach(function (value) {
        visitante += "<li>" + value + "</li>";
    });
    $('.'+jogoAtual+'.resumo .man .jogadores').html(mandante);
    $('.'+jogoAtual+'.resumo .vis .jogadores').html(visitante);

    mandante = '';
    visitante = '';
    var goleiro1 = jog[0][0], goleiro2 = jog[1][0];


    
    $('.'+jogoAtual).find('button.jogar').click(function(){
    var gols = setInterval(function () {
        if (i > 90) {
            i = 89;
        }

        time = i;
        
        var randE = sortear(1,50);
        var rand1 = sortear(1,forca1);
        var rand2 = sortear(1,forca2);
        var randJ = sortear(1,10);

        var jogador, sub;
        var rand  = sortear(1,25);
        
        var timeA, jogA;
        
        eventoF1 = verForca(forca1);
        eventoF2 = verForca(forca2);


        if(eventoF1.indexOf(rand)>-1){
            rand1 = rand;
            if(sortear(1,5)==1){
                randE = 1
            }
        }
        if(eventoF2.indexOf(rand)>-1){
            rand2 = rand;
            if(sortear(1,5)==1){
                randE = 1
            }
        }

        if(eventoF1.indexOf(rand)>-1 && eventoF2.indexOf(rand)>-1){
            randE = 0;
        }


        if(randE === 5){
            if(rand === rand1){
                rand1 = 0;
                rand2 = rand;
                tRel  = 1;
            }else if(rand === rand2){
                rand2 = 0;
                rand1 = rand;
                tRel  = 0;
            }
        }
        if(randE == 4){
            randE=0;
        }
        if (rand1 === rand) {
            jogA = 0;
            jogador = jog[0][randJ];
            timeA = time1;
            switch (randJ) {
                case 0:
                    sub = 'Wilder';
                    break;
                case 1:
                    sub = 'Centurion';
                    break;
                case 2:
                    sub = 'Hudson';
                    break;
                case 3:
                    sub = 'Rodrigo Caio';
                    break;
                case 4:
                    sub = 'Rodrigo Caio';
                    break;
                case 5:
                    sub = 'Hudson';
                    break;
                case 6:
                    sub = 'Wesley';
                    break;
                case 7:
                    sub = 'Edson Silva';
                    break;
                case 8:
                    sub = 'Rafael Toloi';
                    break;
                case 9:
                    sub = 'Wesley';
                    break;
                case 10:
                    sub = 'Renan Ribeiro';
                    break;
            }
        } else if (rand2 === rand) {
           switch (randJ) {
                case 0:
                    sub = 'Romero';
                    break;
                case 1:
                    sub = 'Malcom';
                    break;
                case 2:
                    sub = 'Rodriguinho';
                    break;
                case 3:
                    sub = 'Matheus Pereira';
                    break;
                case 4:
                    sub = 'Danilo';
                    break;
                case 5:
                    sub = 'Marciel';
                    break;
                case 6:
                    sub = 'Edílson';
                    break;
                case 7:
                    sub = 'Edu Dracena';
                    break;
                case 8:
                    sub = 'Yago';
                    break;
                case 9:
                    sub = 'Edílson';
                    break;
                case 10:
                    sub = 'Walter';
                    break;
            }
            jogA = 1;
            jogador = jog[1][randJ];
            timeA = time2;
        }
        var randP = sortear(1,3);
        
        if(intervalo >0 && intervalo !== 30){
            randP  = 3;
        }
        
        if(randP === 1){
            pos1++;
            pos2--;
        }else if(randP === 2){
            pos1--;
            pos2++;         
        }
        $('.'+jogoAtual+'.resumo .posse .man').html(pos1);
        $('.'+jogoAtual+'.resumo .posse .vis').html(pos2);

        var evento, index;
        
              if(randE===7  || randE===11 || randE===17 || randE===21 || randE===27 || randE===31 || randE===37 || randE===41 || randE===47){
            randE = 1;
        }else if(randE===12 || randE===18 || randE===22 || randE===28 || randE===32 || randE===38 || randE===42 || randE===48){
            randE = 2;
        }else if(randE===13 || randE===33){
            randE = 3;
        }else if(randE===14 || randE===34){
            randE = 4;
        }else if(randE===25 || randE===45){
            randE = 5;
        } 

        if(intervalo >0 && intervalo !== 30){
            randE  = 0;
        }

        if(randE === 5){
            jogador = jog[tRel][randJ];
        }
        switch (randE) {
            case 1:
                evento = '<div class="gol"></div>' + jogador;
                break;
            case 2:
                evento = '<div class="amarelo"></div>' + jogador;
                break;
            case 3:
                evento = '<div class="vermelho"></div>' + jogador;
                break;
            case 4:
                evento = '<div class="contusao"></div>' + jogador;
                break;
            case 5:
                evento = '<div class="contra"></div>' + jogador + ' (Contra) ';
                break;
            default: 
                evento = 0; 
                break;
        }
        
        if(intervalo >0 && intervalo !== 30){
            evento  = 0;
        }
        if (rand === rand1 && jogador !== undefined) {
            if (randE === 1 && jogador !== goleiro1) {
                gol1 += 1;
            }else if(randE === 1 && jogador === goleiro1){
                evento = 0;
            }else if (randE === 2) {
                index = amarelo.indexOf(jogador);
                amarelo.push(jogador);
                console.log(amarelo);
                if (index > -1) {
                    expulso = jog[0].indexOf(jogador);
                    evento = '<div class="seg-amarelo"></div>' + jogador;
                    jog[0].splice(expulso, 1);
                    vermelho.push(jogador);
                    console.log(vermelho);
                    forca1 = forca1-3;
                    forca2 = forca2+3;
                    exp1++;
                    if (exp1 === exps) {
                        //alert('FIM DE JOGO');
                        gol1 = 0;
                        gol2 = 3;
                        clearInterval(gols);
                    }
                }

            } else if (randE === 3) {
                index = jog[0].indexOf(jogador);
                if (index > -1) {
                    vermelho.push(jogador);
                    console.log(vermelho);
                    jog[0].splice(index, 1);
                    exp1++;
                    forca1 = forca1-3;
                    forca2 = forca2+3;
                    if (exp1 === exps) {
                        //alert('FIM DE JOGO');
                        gol1 = 0;
                        gol2 = 3;
                        clearInterval(gols);
                    }
                }

            } else if (randE === 4) {
                if (sub1 < subs) {
                    index = jog[0].indexOf(jogador);
                    substituto = jog[0].indexOf(jogador);
                    if (index > -1 && substituto > -1) {
                        substituido.push(jogador);
                        console.log(substituido);
                        jog[jogA][randJ] = sub;
                        evento = '<div class="substituto"></div>' + sub+'('+jogador+')';
                        sub1++;
                    }

                }else{
                    index = jog[0].indexOf(jogador);
                    if (index > -1) {
                        jog[0].splice(index, 1);
                    }
                }
            } else if (randE === 5 && goleiro1 !== jogador) {
                gol2++;
            }else if(randE === 5 && goleiro1 === jogador){
                evento = 0;
            }
            if(randE === 5){
                classe = 'vis';
                frase = evento + ' ' + i;
            }else{
                classe = 'man';
                frase = i + ' ' + evento;
            }
            
            if(evento !== 0){
                var dados = {
                    'ACAO' : 'EVENTO',
                    'jogo' : jogo,
                    'even' : randE,
                    'jgdr' : jogador,
                    'time' : idMan,
                    'temp' : i
                }
                data = $(this).serialize() + "&" + $.param(dados);
                var retorna = $.post('gravar_jogo.php',data,function(retorna){
                });
                $('.'+jogoAtual).find('.eventos').html('<div class="'+classe+'"><div>' + frase + '</div></div>');
                $('.'+jogoAtual+'.resumo .evento').append('<div class="'+classe+'"><div>' + frase + '</div></div>');
            }
        } else if (rand === rand2 && jogador !== undefined) {
            if (randE === 1 && goleiro2 !== jogador) {
                gol2++;
            }else if(randE === 1 && goleiro2 === jogador){
                evento = 0;
            } else if (randE === 2) {
                index = amarelo.indexOf(jogador);

                amarelo.push(jogador);
                console.log(amarelo);
                if (index > -1) {
                    expulso = jog[1].indexOf(jogador);
                    evento = '<div class="seg-amarelo"></div>' + jogador;
                    jog[1].splice(expulso, 1);
                    vermelho.push(jogador);
                    console.log(vermelho);
                    exp2++;
                    forca2 = forca2-3;
                    forca1 = forca1+3;
                    if (exp2 === exps) {
                        gol1 = 3;
                        gol2 = 0;
                        //alert('FIM DE JOGO');
                        clearInterval(gols);
                    }
                }

            } else if (randE === 3) {
                index = jog[1].indexOf(jogador);
                if (index > -1) {
                    jog[1].splice(index, 1);
                    vermelho.push(jogador);
                    console.log(vermelho);
                    exp2++;
                    forca2 = forca2-3;
                    forca1 = forca1+3;
                    if (exp2 === exps) {
                        gol1 = 3;
                        gol2 = 0;
                        //alert('FIM DE JOGO');
                        clearInterval(gols);
                    }
                }

            } else if (randE === 4) {
                if (sub2 < subs) {
                    index = jog[1].indexOf(jogador);
                    substituto = jog[1].indexOf(jogador);
                    if (index > -1 && substituto > -1) {
                        substituido.push(jogador);
                        console.log(substituido);
                        jog[jogA][randJ] = sub;
                        evento = '<div class="substituto"></div>' + sub+'('+jogador+')';
                        sub2++;
                    }

                }else{
                    index = jog[1].indexOf(jogador);
                    if (index > -1) {
                        jog[1].splice(index, 1);
                    }
                }
            } else if (randE === 5 && goleiro2 !== jogador) {
                gol1++;
            }else if(randE === 5 && goleiro2 === jogador){
                evento = 0;
            }

            if(randE === 5){
                classe = 'man';
                frase = i + ' ' + evento;
            }else{
                classe = 'vis';
                frase = evento + ' ' + i;
            }
            
            if(evento !== 0){
                $('.'+jogoAtual).find('.eventos').html('<div class="'+classe+'"><div>' + frase + '</div></div>');
                $('.'+jogoAtual+'.resumo .evento').append('<div class="'+classe+'"><div>' + frase + '</div></div>');
                var dados = {
                    'ACAO' : 'EVENTO',
                    'jogo' : jogo,
                    'even' : randE,
                    'jgdr' : jogador,
                    'time' : idVis,
                    'temp' : i
                }
                data = $(this).serialize() + "&" + $.param(dados);
                var retorna = $.post('gravar_jogo.php',data,function(retorna){
                });

            }

        }

        $('.'+jogoAtual).find('.tempo').html(i);
        $('.'+jogoAtual).find('.placar').html(gol1 + 'x' + gol2);

        //$('.'+jogoAtual).find('title').html(i+' - '+abr1 + ' ' + gol1 + 'x' + gol2 + ' ' + abr2);

        mandante = '';
        visitante = '';
        jog[0].forEach(function (value) {
            mandante += "<li>" + value + "</li>";
        });
        jog[1].forEach(function (value) {
            visitante += "<li>" + value + "</li>";
        });
        $('.'+jogoAtual+'.resumo .man .jogadores').html(mandante);
        $('.'+jogoAtual+'.resumo .vis .jogadores').html(visitante);
        
        if ((i === 45 || i === 105) && avisos === 1) {
            //alert('Continuar segundo tempo?');
        }
        if (i === 90 || i === 120) {
            if (gol1 === gol2) {
                var questao;
                if (i === 90 && (tipoJogo === 2 || tipoJogo === 4)) {
                    //questao = confirm('Jogo empatado!\n Ir para prorrogação?');
                    questao = false;
                    if (questao === false) {
                        $('.'+jogoAtual+'.resumo .evento').append('<div><div class="aviso">Fim de jogo</div></div>');
                        $('.'+jogoAtual+'.resumo .evento').append('<div><div class="aviso">'+time1+' '+gol1+'x'+gol2+' '+time2+'</div></div>');
                        clearInterval(gols);
                        var dados = {
                            'ACAO' : 'FIMJOGO',
                            'jogo' : jogo,
                            'gol1' : gol1,
                            'gol2' : gol2,
                            'stat' : '1'
                        }
                        data = $(this).serialize() + "&" + $.param(dados);
                        var retorna = $.post('gravar_jogo.php',data,function(retorna){
                        });
                    }

                } else if(tipoJogo > 2) {
                    if(avisos === 1){
                        //questao = confirm('Jogo empatado!\n Ir para pênaltis?');
                        questao = false;
                    }else {
                        questao = false;
                    }
                    if (questao === false) {
                        $('.'+jogoAtual+'.resumo .evento').append('<div><div class="aviso">Fim de jogo</div></div>');
                        $('.'+jogoAtual+'.resumo .evento').append('<div><div class="aviso">'+time1+' '+gol1+'x'+gol2+' '+time2+'</div></div>');
                        clearInterval(gols);
                        var dados = {
                            'ACAO' : 'FIMJOGO',
                            'jogo' : jogo,
                            'gol1' : gol1,
                            'gol2' : gol2,
                            'stat' : '1'
                        }
                        data = $(this).serialize() + "&" + $.param(dados);
                        var retorna = $.post('gravar_jogo.php',data,function(retorna){
                        });
                    } else {
                        $('.'+jogoAtual).find('p').css('display', 'block');
                        var j = m = v = 0;
                        var batedor;
                        var bater = 1;
                        var sit, gRand, bRand;
                        var golP1 = 0,
                            golP2 = 0;
                        var penaltis = setInterval(function () {
                            if (bater === 1) {
                                if(jog[1].length<=m){
                                    m = 0;
                                }
                                batedor = jog[0][m];
                                bRand = sortear(1,9);
                                gRand = sortear(1,6);

                                $('.'+jogoAtual).find('.narrar').html('O ' + batedor + ' vai para a bola');


                                switch (bRand) {
                                    case 1:
                                        sit = batedor + ' chutou forte no ângulo esquerdo';
                                        break;
                                    case 2:
                                        sit = batedor + ' chutou forte e alto no meio do gol';
                                        break;
                                    case 3:
                                        sit = batedor + ' chutou forte no ângulo direito';
                                        break;
                                    case 4:
                                        sit = batedor + ' chutou forte no canto esquerdo';
                                        break;
                                    case 5:
                                        sit = batedor + ' chutou forte no meio do gol';
                                        break;
                                    case 6:
                                        sit = batedor + ' chutou forte no canto direito';
                                        break;
                                    case 7:
                                        sit = batedor + ' chutou muito forte e a bola vai para fora, à esquerda do gol';
                                        break;
                                    case 8:
                                        sit = batedor + ' chutou muito forte a bola e isolou ela';
                                        break;
                                    case 9:
                                        sit = batedor + ' chutou muito forte e a bola vai para fora, à direita do gol';
                                        break;
                                }


                                if (bRand !== gRand && bRand <= 6) {
                                    $('.'+jogoAtual).find('.penaltis .man').append('<p style="color: #0F0">' + batedor + ': Gol</p>');
                                    $('.'+jogoAtual).find('.narrar').html(sit + '... GOL!!!');
                                    golP1 += 1;
                                    $('.'+jogoAtual).find('.timeM').append(' G ');
                                } else if (gRand === bRand) {
                                    $('.'+jogoAtual).find('.penaltis .man').append('<p style="color: #F00">' + batedor + ': Pega o goleiro</p>');
                                    $('.'+jogoAtual).find('.narrar').html(sit + '... PEGA O GOLEIRO!!!');
                                    $('.'+jogoAtual).find('.timeM').append(' X ');
                                } else if (gRand !== bRand && bRand >= 7) {
                                    $('.'+jogoAtual).find('.penaltis .man').append('<p style="color: #F00">' + batedor + ': Perdeu</p>');
                                    $('.'+jogoAtual).find('.narrar').html('PRA FORA!!! ' + sit);
                                    $('.'+jogoAtual).find('.timeM').append(' X ');
                                }
                                $('.'+jogoAtual).find('.timeM span').html(golP1);

                                m++; 
                                bater = 2;
                            } else {
                                if(jog[1].length<=v){
                                    v = 0;
                                }
                                batedor = jog[1][v];
                                bRand = sortear(1,9);
                                gRand = sortear(1,6);

                                switch (bRand) {
                                    case 1:
                                        sit = batedor + ' chutou forte no ângulo esquerdo';
                                        break;
                                    case 2:
                                        sit = batedor + ' chutou forte e alto no meio do gol';
                                        break;
                                    case 3:
                                        sit = batedor + ' chutou forte no ângulo direito';
                                        break;
                                    case 4:
                                        sit = batedor + ' chutou forte no canto esquerdo';
                                        break;
                                    case 5:
                                        sit = batedor + ' chutou forte no meio do gol';
                                        break;
                                    case 6:
                                        sit = batedor + ' chutou forte no canto direito';
                                        break;
                                    case 7:
                                        sit = batedor + ' chutou muito forte e a bola vai para fora, à esquerda do gol';
                                        break;
                                    case 8:
                                        sit = batedor + ' chutou muito forte e a bola vai pra fora, por cima do gol';
                                        break;
                                    case 9:
                                        sit = batedor + ' chutou muito forte e a bola vai para fora, à direita do gol';
                                        break;
                                }



                                if (bRand !== gRand && bRand <= 6) {
                                    $('.'+jogoAtual+' .penaltis .vis').append('<p style="color: #0F0">' + batedor + ': Gol</p>');

                                    $('.'+jogoAtual+' .narrar').html(sit + '... GOL!!!');
                                    golP2 += 1;
                                    $('.'+jogoAtual+' .timeV').append(' G ');
                                } else if (gRand === bRand) {
                                    $('.'+jogoAtual+' .penaltis .vis').append('<p style="color: #F00">' + batedor + ': Pega o goleiro</p>');
                                    $('.'+jogoAtual+' .narrar').html(sit + '... PEGA O GOLEIRO!!!');
                                    $('.'+jogoAtual+' .timeV').append(' X ');
                                } else if (gRand !== bRand && bRand >= 7) {
                                    $('.'+jogoAtual+' .penaltis .vis').append('<p style="color: #F00">' + batedor + ': Perdeu</p>');
                                    $('.'+jogoAtual+' .narrar').html('PRA FORA!!! ' + sit);
                                    $('.'+jogoAtual+' .timeV').append(' X ');
                                }
                                $('.'+jogoAtual+' .timeV span').html(golP2);


                                j++;
                                bater = 1;
                                v++;
                            }
                            var vitoria;
                            if (j > 2) {
                                if (golP1 !== golP2 && Math.max(golP1, golP2) - Math.min(golP1, golP2) > 2) {
                                    vitoria = golP1 > golP2 ? time1 : time2;
                                    $('.'+jogoAtual).find('.narrar').html('FIM DE JOGO! VITÓRIA DO ' + vitoria.toUpperCase());
                                    clearInterval(penaltis);
                                } else if (j > 4 && golP1 !== golP2 && bater === 1) {
                                    vitoria = golP1 > golP2 ? time1 : time2;
                                    $('.'+jogoAtual).find('.narrar').html('FIM DE JOGO! VITÓRIA DO ' + vitoria.toUpperCase());
                                    clearInterval(penaltis);
                                } else if (j > 3 && bater === 1 && Math.max(golP1, golP2) - Math.min(golP1, golP2) > 1) {
                                    vitoria = golP1 > golP2 ? time1 : time2;
                                    $('.'+jogoAtual).find('.narrar').html('FIM DE JOGO! VITÓRIA DO ' + vitoria.toUpperCase());
                                    clearInterval(penaltis);
                                } else if (golP1 === golP2) {

                                }
                            }



                        }, 2500);


                        clearInterval(gols);

                    }

                }else {
                    $('.'+jogoAtual+'.resumo .evento').append('<div><div class="aviso">Fim de jogo</div></div>');
                    $('.'+jogoAtual+'.resumo .evento').append('<div><div class="aviso">'+time1+' '+gol1+'x'+gol2+' '+time2+'</div></div>');
                    var dados = {
                        'ACAO' : 'FIMJOGO',
                        'jogo' : jogo,
                        'gol1' : gol1,
                        'gol2' : gol2,
                        'stat' : '1'
                    }
                    data = $(this).serialize() + "&" + $.param(dados);
                    var retorna = $.post('gravar_jogo.php',data,function(retorna){
                    });
                    clearInterval(gols);
                }
            } else {
                $('.'+jogoAtual+'.resumo .evento').append('<div><div class="aviso">Fim de jogo</div></div>');
                $('.'+jogoAtual+'.resumo .evento').append('<div><div class="aviso">'+time1+' '+gol1+'x'+gol2+' '+time2+'</div></div>');
                 var dados = {
                    'ACAO' : 'FIMJOGO',
                    'jogo' : jogo,
                    'gol1' : gol1,
                    'gol2' : gol2,
                    'stat' : '1'
                }
                data = $(this).serialize() + "&" + $.param(dados);
                var retorna = $.post('gravar_jogo.php',data,function(retorna){
                });
               clearInterval(gols);
            }


        }
        if(i === atualizar && intervalo === 0 && i <90){
            var dados = {
                'ACAO' : 'FIMJOGO',
                'jogo' : jogo,
                'gol1' : gol1,
                'gol2' : gol2,
                'stat' : '2'
            }
            data = $(this).serialize() + "&" + $.param(dados);
            var retorna = $.post('gravar_jogo.php',data,function(retorna){
            });

            atualizar = atualizar+5;
        }
        if(i === 45){
            intervalo++;
            $('.'+jogoAtual).find('.tempo').html(i +' ('+ (30-intervalo )+')');
            if(intervalo === 30){
                i++;
                intervalo = 0;
                 $('.'+jogoAtual+'.resumo .evento').append('<div><div class="aviso">2º</div></div>');
            }else if(intervalo === 1){
            }
        }else if(i === 105){
            intervalo++;
            $('.'+jogoAtual).find('.tempo').html(i +' ('+ (10-intervalo )+')');
            if(intervalo === 10){
                i++;
                intervalo = 0;
                 $('.'+jogoAtual+'.resumo .evento').append('<div><div class="aviso">Começa o segundo tempo</div></div>');
            }else if(intervalo === 1){
            }
        }else{
            i++;
        }

   }, 500);     
    $('.'+jogoAtual).find('button.pausar').click(function(){
        clearInterval(gols);
    });
    });
    $('.'+jogoAtual).find('.jogar').click();
}



