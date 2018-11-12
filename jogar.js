// JavaScript Document

var velocidade_lenta, velocidade_normal, velocidade_rapida, velocidade_hiper, velocidade_ultra;
velocidade_lenta 	= 1500;
velocidade_normal 	= 1000;
velocidade_rapida 	= 500;
velocidade_hiper 	= 250;
velocidade_ultra	= 50;

var quantidade_tempo;
quantidade_tempo 	= 2;

var tempo_normal, tempo_prorrogacao, velocidade;
tempo_normal 		= 15; 				// intervalo no tempo normal
tempo_prorrogacao 	= 5; 				// intervalo na prorrogação
velocidade 			= velocidade_ultra; // velocidade do jogo: 500 rápido; 1000 normal; 1500 devagar

var max_tempo_normal, max_prorrogacao;
max_tempo_normal 	= 45;
max_prorrogacao 	= 15;

var funcoes;
funcoes = ['Gol', 'Lat', 'Zag', 'Lib', 'Vol', 'Mec', 'Mea', 'Ala', 'Ata'];

var opcoes;
opcoes = ['Substituir', 'Trocar posição'];

var max_substituicao;
max_substituicao = 3;
function between(num, min, max){
	"use strict";
	return (num >= min && num <= max);
}

function randArray(array){
	"use strict";
    return array[Math.floor(Math.random() * array.length)];
}

function jogador(equipe, id){
	"use strict";
	return equipe.find('li[data-id=' + id + ']');
	
}
function get_jogador_id(jogador){
	"use strict";
	return jogador.attr('data-id');
}

function listar_jogador(equipe){
	"use strict";
	
	var lista = equipe.find('li');
	
	lista.each(function(){
		var jogador, nome;
		jogador = $(this);
		nome = jogador.attr('data-nome');
		
		jogador.html(nome);
	});
}

var evento_amarelo, evento_vermelho, evento_seg_amarelo, evento_contusao, evento_gol, evento_gol_contra, evento_entra, evento_sai;

evento_amarelo 		= '<div class="evento amarelo"></div>';
evento_vermelho 	= '<div class="evento vermelho"></div>';
evento_seg_amarelo 	= '<div class="evento seg_amarelo"></div>';
evento_contusao 	= '<div class="evento contusao"></div>';
evento_gol 			= '<div class="evento gol"></div>';
evento_gol_contra 	= '<div class="evento gol_contra"></div>';
evento_entra 		= '<div class="evento entra"></div>';
evento_sai		 	= '<div class="evento sai"></div>';

function tipo_evento(evento){
	"use strict";
	evento = evento.split('<div class="evento ');
	evento = evento[1].split('"></div>');
	return evento[0];
		
}

function get_funcao_area(funcao){
	"use strict";
	var goleiro, defesa, meio_campo, ataque;
	goleiro 	= ['Gol'];
	defesa 		= ['Zag', 'Lib', 'Lat'];
	meio_campo 	= ['Vol', 'Mec', 'Mea'];
	ataque 		= ['Pon', 'Ata'];
	
	if($.inArray(funcao, goleiro)){
		return 'goleiro';
	} else if($.inArray(funcao, defesa)){
		return 'defesa';
	} else if($.inArray(funcao, meio_campo)){
		return 'meio_campo';
	} else if($.inArray(funcao, ataque)){
		return 'ataque';
	}
	return false;
	
}

function mudar_funcao(jogador, funcao){
	"use strict";
	
	var jogador_funcao, funcao_area;
	funcao_area = get_funcao_area(funcao);
	jogador_funcao = get_jogador_funcao(jogador);
	
	jogador.removeClass(jogador_funcao).addClass(funcao_area);	
}

function abrir_menu_opcao(jogador){
	"use strict";
	var equipe, jogo, menu;
	equipe 	= get_equipe(jogador);
	jogo 	= get_jogo(equipe);
	

	menu = get_menu_opcao(jogo);
	if(jogador.find('ul.menu.opcao').length < 1){
		console.log('Verificando menu');
		jogador.append(menu);
	}
	menu.show();
}

function abrir_menu_funcao(jogador){
	"use strict";
	
	var equipe, jogo, menu;
	equipe 	= get_equipe(jogador);
	jogo 	= get_jogo(equipe);
	menu 	= get_menu_funcao(jogo);
	
	jogador.after(menu);
	menu.show();
}

function esconder_menu(menu){
	"use strict";
	menu.hide();
}

function get_menu_opcao(jogo){
	"use strict";
	
	return jogo.find('ul.menu.opcao');
}

function get_menu_funcao(jogo){
	"use strict";
	
	return jogo.find('ul.menu.funcao');
}


function criar_menu_opcao(jogo){
	"use strict"; 
	var menu;
	menu = jogo.find('.menu.opcao');
	
	$.each(opcoes, function(key, value){
		menu.append('<li data-id="' + key + '" class="opcao">' + value + '</li>');
	});
}

function criar_menu_funcao(jogo){
	"use strict"; 
	var menu;
	menu = jogo.find('.menu.funcao');
	
	$.each(funcoes, function(key, value){
		menu.append('<li data-id="' + key + '" class="funcao">' + value + '</li>');
	});
}

function narracao(evento, jogo){
	"use strict";
	
	jogo.find('.listar.eventos .narracao').html(evento);
}

function get_jogo(div){
	"use strict";
	return div.parents('.jogo');
}

function get_evento(id, jogador){
	"use strict";
	var evento;
	
	switch(id){
		case 1: evento = amarelo(jogador); break;
		case 2: evento = expulso(jogador); break;
		case 3: evento = gol(jogador); break;
		case 4: evento = gol(jogador, true); break;
		case 5: evento = contusao(jogador); break;
	}
}

function alt_placar(placar, golM, golV){
	"use strict";
	var mandante, visitante;
	
	mandante = placar.find('span.mandante');
	visitante = placar.find('span.visitante');
	
	mandante.html(golM);
	visitante.html(golV);
}

function get_jogo(equipe){
	"use strict";
	return equipe.parents('.jogo');
}

function get_placar(equipe){
	"use strict";
	return get_jogo(equipe).find('.info.placar');
}

function alt_tempo(placar, minuto, segundo){
	"use strict";
	var m_tempo, m_min, m_seg;
	
	m_tempo = placar.find('span.m_tempo');
	m_min = m_tempo.find('.minuto');
	m_seg = m_tempo.find('.segundo');
	
	m_min.html(minuto);
	m_seg.html(segundo);
}

function get_jogador(equipe, local){
	"use strict";
	var jogadores, qtd_jogadores, este_jogador;
	
	// console.log(local);
	
	jogadores = get_equipe_jogadores(equipe, local);
	
	qtd_jogadores = jogadores.length;
	
	este_jogador = randArray(jogadores);
	return $(este_jogador).attr('data-id');
}

function is_set(variavel){
	"use strict";
	return (typeof variavel !== 'undefined');
}

function get_equipe_jogadores(equipe, tipo, ignorar){
	"use strict";
	
	if(!is_set(tipo)){
		tipo = '.jogador';
	}
	if(!is_set(ignorar)){
		ignorar = '.inativo';
	}
	// console.log(tipo);
	
	return equipe.find(tipo).not(ignorar);
	
}

function get_jogador_nome(jogador){
	"use strict";
	return jogador.attr('data-nome');
}

function jogador_evento(equipe, evento_id){
	"use strict";
	var este_jogador, evento, jogo, info;
	
	
	jogo = get_jogo(equipe);
	info = jogo.find('.info.placar');
	
	var fala_narrador, este_jgd, jogador_nome;
	
	var chance_lance, max_chance, ini_margem_chance, porcentagem_dividida, chance_dividida, porcentagem_falta, chance_falta, chance_chute, rigor_juiz, max_nivel, nivel_rigor, porcentagem_amarelo, chance_amarelo, porcentagem_vermelho, chance_vermelho;
	
	chance_lance 			= parseInt(info.attr('data-chance-lance'));
	max_chance 				= parseInt(info.attr('data-max-chance'));
	ini_margem_chance 		= parseInt(info.attr('data-ini-margem-chance'));
	porcentagem_dividida 	= parseInt(info.attr('data-porcentagem-dividida'));
	chance_dividida 		= parseInt(info.attr('data-chance-dividida'));
	porcentagem_falta 		= parseInt(info.attr('data-porcentagem-falta'));
	chance_falta 			= parseInt(info.attr('data-chance-falta'));
	chance_chute 			= parseInt(info.attr('data-chance-chute'));
	rigor_juiz 				= parseInt(info.attr('data-rigor-juiz'));
	max_nivel 				= parseInt(info.attr('data-max-nivel'));
	nivel_rigor 			= parseInt(info.attr('data-nivel-rigor'));
	porcentagem_amarelo 	= parseInt(info.attr('data-porcentagem-lance'));
	chance_amarelo 			= parseInt(info.attr('data-chance-amarelo'));
	porcentagem_vermelho 	= parseInt(info.attr('data-porcentagem-lance'));
	chance_vermelho 		= parseInt(info.attr('data-chance-vermelho'));
	
	
	var max_chance_dividida, chance_desarme, ini_margem_falta, ini_margem_cartao, ini_chance_expulso;
	max_chance_dividida 	= ini_margem_chance + chance_dividida;
	chance_desarme 			= max_chance_dividida - chance_falta;
	ini_margem_falta 		= ini_margem_chance + chance_falta;
	ini_margem_cartao 		= max_chance_dividida - chance_amarelo;
	ini_chance_expulso		= max_chance_dividida - chance_vermelho;
	
	var ini_margem_chute, max_chance_chute;
	ini_margem_chute = max_chance_dividida;
	max_chance_chute = max_chance_dividida + chance_chute;
	
	
	// console.log('Máximo de chances para dividida: ' + max_chance_dividida);
	// console.log('Lances de gol', ini_margem_chute, max_chance_chute);
	
	if(between(evento_id, ini_margem_chance, max_chance_dividida)){ // Dividida
		// console.log('Dividida');
	
		este_jogador = get_jogador(equipe, '.ataque, .meio_campo, .defesa');
		este_jgd = jogador(equipe, este_jogador);
		jogador_nome = get_jogador_nome(este_jgd);
		
		
		// console.log('Máximo de chances para desarme: ' + chance_desarme);
		if(between(evento_id, ini_margem_chance, chance_desarme)){ // Desarme
			// console.log('Desarme');
			desarme(este_jogador);
		}else{ // Jogador cometeu falta
			// console.log('Falta');
			
			falta(este_jogador);
			
			fala_narrador = jogador_nome + ' cometeu falta';
			
			// console.log('Chance de cartão amarelo: ' + ini_margem_cartao + ' > ' + ini_chance_expulso);
			if(between(evento_id, ini_margem_cartao, ini_chance_expulso)){
				fala_narrador += ' e recebeu amarelo';
				evento = 1;
			} else if(between(evento_id, ini_chance_expulso, max_chance_dividida)){
				fala_narrador += ' violenta e foi expulso';
				evento = 2;
			}else{
				// console.log('Desarme');
			}
			narracao(fala_narrador, jogo);
			
		}
	}else if(between(evento_id, ini_margem_chute, max_chance_chute)){
	
		este_jogador = get_jogador(equipe, '.meio_campo, .ataque');
		// console.log('Lance de perigo');
		este_jgd = jogador(equipe, este_jogador);
		jogador_nome = get_jogador_nome(este_jgd);
		

		fala_narrador = jogador_nome + " chutou";
		var goleiro, nome_goleiro, adversario, adversario_nome, equipe_nome;
		
		goleiro = get_goleiro(equipe, true);
		nome_goleiro = goleiro.attr('data-nome');

		adversario = get_adversario(equipe);
		adversario_nome = get_equipe_nome(adversario);

		equipe_nome = get_equipe_nome(equipe);
		
		var max_chance_porcentagem;
		max_chance_porcentagem = Math.round((max_chance_chute - ini_margem_chute) / 4);
		
		var max_chance_chutou;
		max_chance_chutou = ini_margem_chute + max_chance_porcentagem;
		
		
		// console.log('max_chance_porcentagem:', ini_margem_chute , max_chance_chute);
		
		// console.log('evento id: ', evento_id, 'Chances de chute: ', ini_margem_chute, ' > ', max_chance_chutou);
		if(between(evento_id, ini_margem_chute, max_chance_chutou)){
			// console.log('Gol');
			gol(este_jgd);
		}else{
			
		}

		switch(evento_id){
			case 41 : 
				fala_narrador += ' fraco e o goleiro ' + nome_goleiro + ' ficou com a bola';
				defesa(equipe, 1); 
				break;
			case 42 : 
				fala_narrador += ' forte... GOOOOOL!';
				evento = 3; 
				break;
			case 43 : 
				fala_narrador += ' chutou muito forte, pra fora';
				//escanteio(equipe); 
				break;
			case 44 : 
				fala_narrador += ' forte e o goleiro ' + nome_goleiro + ' fez a defesa';
				defesa(equipe, 2); 
				break;
			case 45 : 
				fala_narrador += ', a bola bateu na defesa e ficou com a equipe do ' + adversario_nome;
				desarme(jogador); 
				break;
			case 46 : 
				fala_narrador += ' e a bola bateu na mão do adversário. Penalty para o ' + equipe_nome;
				// Penalty 
				break;
			case 47 : 
				fala_narrador += ', a bola desviou no adversário e foi para o gol';
				evento = 4; 
				break;
			case 48 : 
				fala_narrador += ', a bola desviou no adversário e foi para fora. Escanteio.';
				escanteio(equipe); 
				break;
			case 49 : 
				fala_narrador += ', a bola bateu na defesa, voltou para ele e no rebote a bola vai para fora. Tiro de meta';
				// Tiro de meta
				break;
			case 50 : 
				fala_narrador += ', a bola bateu na defesa, voltou para ele e no rebote... GOOOOL!';
				evento = 3; 
				break;
			
		}
		narracao(fala_narrador, jogo);
	}
	
	
	este_jogador = jogador(equipe, este_jogador);
	
	get_evento(evento, este_jogador);
	
}

function get_adversario(equipe){
	"use strict";
	var adversario, jogo;
	jogo = get_jogo(equipe);
	
	if(equipe.is('.mandante')){
		adversario = jogo.find('.visitante');
	} else {
		adversario = jogo.find('.mandante');
	}
	
	return adversario;
	
}

function get_equipe_nome(equipe){
	"use strict";
	return equipe.find('.info h3.equipe');
}

function defesa(equipe, nivel){
	"use strict";
	var goleiro, nome, dificuldade;
	
	// console.log('Defesa');

	goleiro = get_goleiro(equipe, true);
	nome = goleiro.attr('data-nome');

	if(nivel <= 1){
		dificuldade = 'Defesa fácil';
	} else if(nivel === 2){
		dificuldade = 'Uma difícil defesa';
	} else {
		dificuldade = 'Um milagre';
	}
	
	// console.log(dificuldade + ' do goleiro ' + nome);
	
}

function get_goleiro(equipe, do_adversario){
	"use strict";
	var goleiro, adversario;
	
	if(!do_adversario){
		goleiro = equipe.find('li.jogador.goleiro').not('.inativo');
	} else {
		adversario = get_adversario(equipe);
		goleiro = adversario.find('li.jogador.goleiro').not('.inativo');
	}
	return goleiro;
}

function escanteio(equipe){
	"use strict";
	var nome;

	nome = equipe.parent('.equipe').find('.info h3.equipe').html();

	// console.log('Escanteio para o ' + nome);
	
}



function ver_equipe(jogador){
	"use strict";
	
	return jogador.parents('div.equipe');
	
}

function get_jogadores(jogador){
	"use strict";
	
	var equipe;
	
	equipe = ver_equipe(jogador);
	return equipe.find('ul.jogadores');
}

function falta(jogador){
	"use strict";
}

function desarme(jogador){
	"use strict";
}

function get_tempo(jogo, html){
	"use strict";
	jogo = jogo.find('.info.placar .tempo');
	if(html){
		jogo = jogo.html();
	}
	return jogo;
}

function get_tempo_jogo(jogo, html){
	"use strict";
	var tempo;
	tempo = get_tempo(jogo);
	
	tempo = tempo.find('.j_tempo');
	if(html){
		tempo = tempo.html();
	}
	return tempo;
}

function get_minuto(tempo, html){
	"use strict";
	tempo = tempo.find('.minuto');
	if(html){
		tempo = tempo.html();
	}
	return tempo;
}

function get_segundo(tempo, html){
	"use strict";
	tempo = tempo.find('.segundo');
	if(html){
		tempo = tempo.html();
	}
	return tempo;
}

function fazer_evento(evento, jogador, antes){
	"use strict";
	
	var t_evento, equipe;
	t_evento = tipo_evento(evento);
	
	equipe = get_equipe(jogador);
	if(t_evento === 'gol'){
		var quantidade;
		quantidade = quantidade_gol(jogador);
		
		if(quantidade > 0){
			quantidade++;
			jogador.find('.' + t_evento).attr('data-quantidade', quantidade);
		}else{
			jogador.append(evento);
		}
		
	} else {
		if(antes){
			jogador.prepend(evento);
		}else{
			jogador.append(evento);
		}
	}
	
	listar_evento(t_evento, jogador);
	
}

function listar_evento(evento, este_jogador){
	"use strict";
	var classe, jogo, div_evento, equipe, tempo_jogo, tempo, minuto, jogador_nome;

	equipe = get_equipe(este_jogador);
	
	if(equipe.is('.mandante')){
		classe = 'mandante';
	}else{
		classe = 'visitante';
	}
	
	jogo 			= get_jogo(equipe);
	tempo_jogo		= get_tempo_jogo(jogo, true);
	tempo 			= get_tempo(jogo);
	minuto 			= get_minuto(tempo, true);
	jogador_nome 	= get_jogador_nome(este_jogador);
	
		
	div_evento 	= jogo.find('.info .listar.eventos .eventos');
	div_evento.append('<div class="lista_evento '+ classe + '"><div class="evento '+ evento + '"></div><span class="tempo">' + minuto + '-' + tempo_jogo + '</span> <span class="jogador">' + jogador_nome + '</span></div>');
	
}

function inativo(jogador){
	"use strict";
	jogador.addClass('inativo');
}

function amarelo(jogador){
	"use strict";
	
	var qtd_cartao;
	
	qtd_cartao = jogador.find('.evento.amarelo').length;
	if(qtd_cartao > 0){
		expulso(jogador, 1);
	} else {
		fazer_evento(evento_amarelo, jogador);
	}
	
}


function expulso(jogador, seg_amarelo){
	"use strict";
	var evento;
	
	if(typeof seg_amarelo !== 'undefined'){
		evento = evento_seg_amarelo;
	} else {
		evento = evento_vermelho;
	}
	
	inativo(jogador);
	fazer_evento(evento, jogador);
}


function contusao(jogador){
	"use strict";
	
	fazer_evento(evento_contusao, jogador);
}

function gol(este_jogador, contra){
	"use strict";
	
	var equipe, placar, golM, golV, evento;
	
	equipe = ver_equipe(este_jogador);

	placar = get_placar(equipe);
	golM = placar.find('.mandante').html();
	golV = placar.find('.visitante').html();
	
	if(equipe.is('.mandante')){
		golM++;
	}else{
		golV++;
	}
			
	alt_placar(placar, golM, golV);
	if(typeof contra === 'undefined'){
		evento = evento_gol;
	} else {
		evento = evento_gol_contra;
		
		var jogo;
		jogo = equipe.parents('.jogo');
		
		if(equipe.is('.mandante')){
			// console.log('Gol contra mandante');
			equipe = jogo.find('.equipe.visitante ul.jogadores');
		}else{
			// console.log('Gol contra visitante');
			equipe = jogo.find('.equipe.mandante ul.jogadores');
		}
		// console.log(equipe);

		este_jogador = get_jogador(equipe);
		// console.log(este_jogador);

		este_jogador = jogador(equipe, este_jogador);
		// console.log(este_jogador);
	}
	// console.log(este_jogador);
	// console.log(evento);
		
	
	fazer_evento(evento, este_jogador);
}


function quantidade_gol(jogador){
	"use strict";
	
	var evento, quantidade;
	evento = jogador.find('.evento.gol');
	
	quantidade = evento.length;
	if(evento.attr('data-quantidade') > 0){
		quantidade = evento.attr('data-quantidade');
	}
	
	return quantidade;
}

function substituicao(jogador_entra, jogador_sai){
	"use strict";
	inativo(jogador_sai);
	
	var equipe;
	equipe = get_equipe(jogador_sai);
	
	
	jogador_sai.attr('data-link', get_jogador_id(jogador_entra));
	jogador_entra.attr('data-link', get_jogador_id(jogador_sai));
	
	fazer_evento(evento_sai, jogador_sai, true);
	fazer_evento(evento_entra, jogador_entra, true);
	
	jogador_sai.after(jogador_entra);
}

function sortear(min, max){
	"use strict";
	var t_min, t_max;
    t_min = Math.min(min, max);
    t_max = Math.max(min, max);
	
	

    return Math.floor(Math.random() * ( t_max - t_min + 1 ) + t_min);
}

function create_data_attr(array_attr, array_value){
	"use strict";
	var attr_length, array_return;
	attr_length = array_attr.length;
	
	array_return = "";
	
	for(var i = 0; i < attr_length; i++){
		var atributo, valor;
		atributo = array_attr[i];
		valor = array_value[i];
		
		if(!is_set(valor)){
			valor = '';
		}
		
		array_return += 'data-' + atributo + '="' + valor + '"';
	}
	return array_return;
}

function iniciar_tempo(funcao){
	"use strict";
	return setInterval(funcao, velocidade);
}

function alt_tempo_jogo(placar, tempo){
	"use strict";
	var m_tempo;
	
	m_tempo = placar.find('span.j_tempo');

	m_tempo.html(tempo);
}

function get_equipe(jogador){
	"use strict";
	return jogador.parents('.equipe');
}

jQuery.fn.trocar_jogador = function(alvo) {
	"use strict";
    return this.each(function() {
		
		
        var elem_jog1, elem_jog2, clone1, clone2;
		
        elem_jog1 = $(this);
        elem_jog2 = $(alvo);
		
		clone1 = elem_jog1.clone(true);
		clone2 = elem_jog2.clone(true);

		
		var equipe;
		equipe = get_equipe(elem_jog1);
		
		// console.log(elem_jog1, elem_jog2);
		
		if(elem_jog1.attr('data-link') > 0){
			var link1, jog_link1;
			
			link1 = elem_jog1.attr('data-link');
			jog_link1 = jogador(equipe, link1);
			
			// console.log("Jog 1: " + jog_link1);

			elem_jog2.after(jog_link1);
		}
		
		if(elem_jog2.attr('data-link') > 0){
			var link2, jog_link2;
			
			link2 = elem_jog2.attr('data-link');
			jog_link2 = jogador(equipe, link2);
			
			// console.log("Jog 2: " + jog_link2);
			
			elem_jog1.after(jog_link2);
			
		}
		
        elem_jog1.replaceWith(clone2);
        elem_jog2.replaceWith(clone1);
		
    });
};

function is_titular(jogador){
	"use strict";
	
	return (jogador.parent('ul').is('.jogadores'));
}

function is_suplente(jogador){
	"use strict";
	
	return (jogador.parent('ul').is('.suplentes'));
}

function get_the_titular(jogador1, jogador2){
	"use strict";
	
	if(jogador1.parent('ul').is('.jogadores')){
		return jogador1;	
	}else{
		return jogador2;
	}
}

function get_the_suplente(jogador1, jogador2){
	"use strict";
	
	if(jogador1.parent('ul').is('.suplentes')){
		return jogador1;	
	}else{
		return jogador2;
	}
}

function get_jogador_funcao(jogador){
	"use strict";
	var classe;
	classe = jogador.attr('class').replace('jogador', '');
	classe = classe.replace('inativo');
	return classe;
}

$(document).ready(function() {
	"use strict";
	
	var rodada = $('.rodada');
	var jogos = rodada.find('.jogo');
	
	
	var escudo_url = "img/time/";
	
	
	jogos.each(function() {
		var jogo, idJogo, estadio, estadio_popular, mandante, man_forca, visitante, vis_forca, tipo_jogo, primeiro_jogo, man_pri_jogo, vis_pri_jogo, man_formacao, man_escalacao, vis_formacao, vis_escalacao;

		jogo = $(this);
		idJogo = jogo.attr('data-jogo');
		estadio = jogo.attr('data-estadio');
		estadio_popular = jogo.attr('data-estadio-popular');
		
		mandante = jogo.attr('data-mandante');
		visitante = jogo.attr('data-visitante');
		man_forca = parseInt(jogo.attr('data-mandante-forca'));
		vis_forca = parseInt(jogo.attr('data-visitante-forca'));
		
		tipo_jogo = jogo.attr('data-tipo');
		primeiro_jogo = jogo.attr('data-primeiro-jogo');
		
		man_pri_jogo = jogo.attr('data-primeiro-jogo-mandante');
		vis_pri_jogo = jogo.attr('data-primeiro-jogo-visitante');
		
		man_formacao = jogo.attr('data-mandante-formacao');
		man_escalacao = jogo.attr('data-mandante-escalacao');
		
		vis_formacao = jogo.attr('data-visitante-formacao');
		vis_escalacao = jogo.attr('data-visitante-escalacao');
		
		var div_mandante, div_visitante, formacao_mandante, formacao_visitante, suplentes_mandante, suplentes_visitante;
		
		div_mandante = jogo.find('div.mandante');
		div_visitante = jogo.find('div.visitante');
		
		var chance_lance, max_chance, ini_margem_chance;
		chance_lance = sortear(30, 120);
		max_chance = 1000;
		ini_margem_chance = max_chance - chance_lance;

		var porcentagem_dividida, chance_dividida, porcentagem_falta, chance_falta;
		
		porcentagem_dividida = sortear(50, 70);
		chance_dividida = Math.ceil(chance_lance * ( porcentagem_dividida / 100 ) );
		
		var chance_chute;
		chance_chute = chance_lance - chance_dividida;
		
		porcentagem_falta = sortear(60, 80);
		chance_falta = Math.ceil(chance_dividida * ( porcentagem_falta / 100 ) );
		
		var rigor_juiz, max_nivel, nivel_rigor, porcentagem_amarelo, chance_amarelo, porcentagem_vermelho, chance_vermelho;
		rigor_juiz = 4;
		max_nivel = 10;
		nivel_rigor = rigor_juiz / max_nivel;
		
		porcentagem_amarelo = 40 * nivel_rigor;
		chance_amarelo = Math.ceil(chance_falta * ( porcentagem_amarelo / 100 ) );
		porcentagem_vermelho = 5 * nivel_rigor;
		chance_vermelho = Math.ceil(chance_amarelo * ( porcentagem_vermelho / 100 ) );
		
		var mandante_subs, visitante_subs;
		mandante_subs = visitante_subs = 0;

		// console.log(chance_chute, chance_dividida, chance_falta, chance_amarelo, chance_vermelho);

		var ad_info, info_data_attr, info_data_valor, info_data;
		
		info_data_attr = ['chance-lance', 'max-chance', 'ini-margem-chance', 'porcentagem-dividida', 'chance-dividida', 'porcentagem-falta', 'chance-falta', 'chance-chute', 'rigor-juiz', 'max-nivel', 'nivel-rigor', 'porcentagem-amarelo', 'chance-amarelo', 'porcentagem-vermelho', 'chance-vermelho'];
		info_data_valor = [chance_lance, max_chance, ini_margem_chance, porcentagem_dividida, chance_dividida, porcentagem_falta, chance_falta, chance_chute, rigor_juiz, max_nivel, nivel_rigor, porcentagem_amarelo, chance_amarelo, porcentagem_vermelho, chance_vermelho];
		
		info_data = create_data_attr(info_data_attr, info_data_valor);
		
		ad_info = 	'<div class="info placar" ' + info_data + '>' +
					'<span class="mandante">0</span>' + 
					'<p class="tempo">' + 
					'<span class="m_tempo">' + 
					'<span class="minuto">0</span>:' + 
					'<span class="segundo">0</span>' + 
					'</span>' + 
					'<span class="j_tempo">1</span>&deg;' + 
					'</p>' + 
					'<span class="visitante">0</span>' + 
					'<div class="listar eventos">' +
					'<div class="narracao">Começa o jogo</div>'+
					'<div class="eventos"></div>'+
					'</div>' +
					'</div>';
		
		div_mandante.after(ad_info);
		
		var bola_rolando;
		
		var placar;
		placar = jogo.find('.info.placar');
		
		listar_jogador(div_mandante);
		listar_jogador(div_visitante);
		
		formacao_mandante = div_mandante.find('ul.jogadores');
		formacao_visitante = div_visitante.find('ul.jogadores');
		
		suplentes_mandante = div_mandante.find('ul.suplentes');
		suplentes_visitante = div_visitante.find('ul.suplentes');
		
		function equipe_evento(){
			var probabilidade, equipe_1, equipe_2;
			probabilidade = man_forca + vis_forca;
			// console.log(probabilidade, man_forca, vis_forca);
			
			equipe_1 = Math.min(man_forca, vis_forca);
			equipe_2 = Math.max(man_forca, vis_forca);
			
			var sorteio, mandante, visitante;
			sorteio = sortear(0, probabilidade);
			
			if(equipe_1 === man_forca){
				mandante 	= formacao_mandante;
				visitante 	= formacao_visitante;
			}else{
				visitante 	= formacao_mandante;
				mandante 	= formacao_visitante;
			}
			
			if(between(sorteio, 0, equipe_1)){
				return mandante;
			}else{
				return visitante;
			}
			
		}

		var info_mandante, info_visitante;
		info_mandante = div_mandante.find('.info');
		info_visitante = div_visitante.find('.info');
		
		info_mandante.find('h3.equipe').html(mandante);
		
		var escudo_mandante = info_mandante.find('div.escudo');
		
		escudo_mandante.css('background-image', 'url(' + escudo_url + escudo_mandante.attr('data-background') + ')');

		info_visitante.find('h3.equipe').html(visitante);
		
		var escudo_visitante = info_visitante.find('div.escudo');
		
		escudo_visitante.css('background-image', 'url(' + escudo_url + escudo_visitante.attr('data-background') + ')');
				
	
		criar_menu_funcao(jogo);
		criar_menu_opcao(jogo);
		var menu_opcao, menu_funcao;
		menu_funcao = get_menu_funcao(jogo);
		menu_funcao.hide();
		menu_opcao = get_menu_opcao(jogo);
		menu_opcao.hide();
		
		
		
		var i_min, i_seg;
		i_min = i_seg = 0;

		var jogando, h_intervalo, tempo, int;
		tempo = 1;
		
		var selecionado, substituir;
		selecionado = substituir = false;
		div_mandante.find('li.jogador').click(function(e) {
			e.preventDefault();
			
			var elem_jogador, id_jogador, equipe;
			elem_jogador = $(this);
			
			id_jogador = get_jogador_id(elem_jogador);
			
			abrir_menu_opcao(elem_jogador);
			
			equipe = get_equipe(elem_jogador);

			if(!elem_jogador.is('.selecionado')){

				console.log('Substituir');
				selecionado = true;
				elem_jogador.addClass('selecionado menu');
				clearInterval(jogando);
			}else if(selecionado){
				
				var jogador_selecionado;
				jogador_selecionado = equipe.find('li.jogador.selecionado');
				jogador_selecionado.removeClass('selecionado menu');
				
				var pos1, pos2, class1, class2, jgd_id1, jgd_id2;
				
				pos1 = elem_jogador.attr('data-posicao');
				pos2 = jogador_selecionado.attr('data-posicao');
				
				class1 = get_jogador_funcao(elem_jogador);
				class2 = get_jogador_funcao(jogador_selecionado);
				
				jgd_id1 = get_jogador_id(elem_jogador); 
				jgd_id2 = get_jogador_id(jogador_selecionado);
				
				 console.log(jgd_id1, jgd_id2);
				 if(jgd_id1 === jgd_id2){
					if(bola_rolando){
						jogando = iniciar_tempo(jogar);
					}
					 
				 }else{
					if((is_titular(elem_jogador) && is_suplente(jogador_selecionado)) || (is_suplente(elem_jogador) && is_titular(jogador_selecionado))){
						
						var titular, suplente;
						titular = get_the_titular(elem_jogador, jogador_selecionado);
						suplente = get_the_suplente(elem_jogador, jogador_selecionado);
						
						if(!titular.is('.inativo')){
							if(equipe.is('.mandante') && mandante_subs < max_substituicao ){
								mandante_subs++;
								substituicao(suplente, titular);
							}else if(equipe.is('.visitante') && visitante_subs < max_substituicao ){
								visitante_subs++;
								substituicao(suplente, titular);
							}
						}
						
						
					}else{
						elem_jogador.attr('data-posicao', pos2).removeClass(class1).addClass(class2);
						jogador_selecionado.attr('data-posicao', pos1).removeClass(class2).addClass(class1);
						elem_jogador.trocar_jogador(jogador_selecionado);
					}
	
					
					selecionado = false;
					if(bola_rolando){
						jogando = iniciar_tempo(jogar);
					}
				 }
				
			}
			
		});
		
		var jogar, intervalo;
		jogar = function(){
			bola_rolando = true;
			var sorteio, ter_evento, jog_evento;
			
			sorteio = sortear(1, 5);
			
			ter_evento = sortear(1, max_chance);
			
			// console.log(ter_evento);
			
			if(between(ter_evento, ini_margem_chance, max_chance)){
				// console.log('Chance de evento');
				jog_evento = jogador_evento(equipe_evento(), ter_evento);
			}
			
			if(i_seg >= 60){
				i_min++;
				i_seg = 0;
			}
			
			if(i_min >= max_tempo_normal){
				
				if(tempo === 1){
					tempo = 2;
					alt_tempo_jogo(placar, 'int');
					h_intervalo = iniciar_tempo(intervalo);
					i_min = 0;
					i_seg = 0;
				}
				bola_rolando = false;
				clearInterval(jogando);
			}
			alt_tempo(placar, i_min, i_seg);
			
			i_seg += 10;
		};
		
		int = 0;
		intervalo = function (){
			
			alt_tempo(placar, int);
			if(int >= tempo_normal){

				alt_tempo_jogo(placar, tempo);
				jogando = iniciar_tempo(jogar);

				clearInterval(h_intervalo);
			}
			int++;
			
		};

		jogando = iniciar_tempo(jogar);
		
		
		int = 1;
		
	});

	
});