--
-- PostgreSQL database dump
--

SET client_encoding = 'LATIN1';
SET check_function_bodies = false;
SET client_min_messages = warning;

--
-- Name: SCHEMA public; Type: COMMENT; Schema: -; Owner: postgres
--

COMMENT ON SCHEMA public IS 'Standard public schema';


--
-- Name: plpgsql; Type: PROCEDURAL LANGUAGE; Schema: -; Owner: 
--

CREATE PROCEDURAL LANGUAGE plpgsql;


SET search_path = public, pg_catalog;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- Name: atributo; Type: TABLE; Schema: public; Owner: sagui; Tablespace: 
--

CREATE TABLE atributo (
    id bigserial NOT NULL,
    nome character varying(20),
    obs text,
    idscript integer
);


ALTER TABLE public.atributo OWNER TO sagui;

--
-- Name: atributo_id_seq; Type: SEQUENCE SET; Schema: public; Owner: sagui
--

SELECT pg_catalog.setval(pg_catalog.pg_get_serial_sequence('atributo', 'id'), 23, true);


--
-- Name: coleta; Type: TABLE; Schema: public; Owner: sagui; Tablespace: 
--

CREATE TABLE coleta (
    id bigserial NOT NULL,
    idequipamento integer,
    idatributo integer,
    value character varying(1024),
    data timestamp without time zone DEFAULT now()
);


ALTER TABLE public.coleta OWNER TO sagui;

--
-- Name: coleta_id_seq; Type: SEQUENCE SET; Schema: public; Owner: sagui
--

SELECT pg_catalog.setval(pg_catalog.pg_get_serial_sequence('coleta', 'id'), 33597358, true);


--
-- Name: equipamento; Type: TABLE; Schema: public; Owner: sagui; Tablespace: 
--

CREATE TABLE equipamento (
    id bigserial NOT NULL,
    ip character varying(15) NOT NULL,
    mac character(17) NOT NULL,
    idunidade integer
);


ALTER TABLE public.equipamento OWNER TO sagui;

--
-- Name: equipamento_id_seq; Type: SEQUENCE SET; Schema: public; Owner: sagui
--

SELECT pg_catalog.setval(pg_catalog.pg_get_serial_sequence('equipamento', 'id'), 17517, true);


--
-- Name: evento; Type: TABLE; Schema: public; Owner: sagui; Tablespace: 
--

CREATE TABLE evento (
    id bigserial NOT NULL,
    idequipamento integer NOT NULL,
    idtipoevento integer NOT NULL,
    status integer,
    saida character varying(1024),
    visto boolean DEFAULT false,
    idscript integer,
    data timestamp without time zone DEFAULT now()
);


ALTER TABLE public.evento OWNER TO sagui;

--
-- Name: evento_id_seq; Type: SEQUENCE SET; Schema: public; Owner: sagui
--

SELECT pg_catalog.setval(pg_catalog.pg_get_serial_sequence('evento', 'id'), 2470247, true);


--
-- Name: ligou; Type: TABLE; Schema: public; Owner: sagui; Tablespace: 
--

CREATE TABLE ligou (
    id bigserial NOT NULL,
    idequipamento integer,
    data timestamp without time zone DEFAULT now()
);


ALTER TABLE public.ligou OWNER TO sagui;

--
-- Name: ligou_id_seq; Type: SEQUENCE SET; Schema: public; Owner: sagui
--

SELECT pg_catalog.setval(pg_catalog.pg_get_serial_sequence('ligou', 'id'), 2953101, true);


--
-- Name: log_atividade_scripts; Type: TABLE; Schema: public; Owner: sagui; Tablespace: 
--

CREATE TABLE log_atividade_scripts (
    id bigserial NOT NULL,
    idusuario integer,
    idscript integer,
    versao integer,
    status character varying(100),
    data timestamp without time zone DEFAULT now()
);


ALTER TABLE public.log_atividade_scripts OWNER TO sagui;

--
-- Name: log_atividade_scripts_id_seq; Type: SEQUENCE SET; Schema: public; Owner: sagui
--

SELECT pg_catalog.setval(pg_catalog.pg_get_serial_sequence('log_atividade_scripts', 'id'), 1704, true);


--
-- Name: logpatch; Type: TABLE; Schema: public; Owner: sagui; Tablespace: 
--

CREATE TABLE logpatch (
    id bigserial NOT NULL,
    sequencial integer,
    ip character varying(20),
    data timestamp without time zone DEFAULT now(),
    status character varying(30)
);


ALTER TABLE public.logpatch OWNER TO sagui;

--
-- Name: logpatch_id_seq; Type: SEQUENCE SET; Schema: public; Owner: sagui
--

SELECT pg_catalog.setval(pg_catalog.pg_get_serial_sequence('logpatch', 'id'), 742372, true);


--
-- Name: menu; Type: TABLE; Schema: public; Owner: sagui; Tablespace: 
--

CREATE TABLE menu (
    id bigserial NOT NULL,
    nome character varying(70),
    href character varying(200),
    target character varying(30),
    descricao text
);


ALTER TABLE public.menu OWNER TO sagui;

--
-- Name: menu_id_seq; Type: SEQUENCE SET; Schema: public; Owner: sagui
--

SELECT pg_catalog.setval(pg_catalog.pg_get_serial_sequence('menu', 'id'), 20, true);


--
-- Name: menusubmenu; Type: TABLE; Schema: public; Owner: sagui; Tablespace: 
--

CREATE TABLE menusubmenu (
    idmenu integer NOT NULL,
    idsubmenu integer NOT NULL
);


ALTER TABLE public.menusubmenu OWNER TO sagui;

--
-- Name: parametroslocais; Type: TABLE; Schema: public; Owner: sagui; Tablespace: 
--

CREATE TABLE parametroslocais (
    id serial NOT NULL,
    nome character varying(50),
    shellvar character varying(50)
);


ALTER TABLE public.parametroslocais OWNER TO sagui;

--
-- Name: parametroslocais_id_seq; Type: SEQUENCE SET; Schema: public; Owner: sagui
--

SELECT pg_catalog.setval(pg_catalog.pg_get_serial_sequence('parametroslocais', 'id'), 18, true);


--
-- Name: patch; Type: TABLE; Schema: public; Owner: sagui; Tablespace: 
--

CREATE TABLE patch (
    id bigserial NOT NULL,
    sequencial bigserial NOT NULL,
    titulo character varying(70),
    msg character varying(70),
    idusuario integer,
    data timestamp without time zone DEFAULT now(),
    idscript integer
);


ALTER TABLE public.patch OWNER TO sagui;

--
-- Name: patch_id_seq; Type: SEQUENCE SET; Schema: public; Owner: sagui
--

SELECT pg_catalog.setval(pg_catalog.pg_get_serial_sequence('patch', 'id'), 303, true);


--
-- Name: patch_sequencial_seq; Type: SEQUENCE SET; Schema: public; Owner: sagui
--

SELECT pg_catalog.setval(pg_catalog.pg_get_serial_sequence('patch', 'sequencial'), 296, true);


--
-- Name: patchequipamento; Type: TABLE; Schema: public; Owner: sagui; Tablespace: 
--

CREATE TABLE patchequipamento (
    id bigserial NOT NULL,
    idpatch integer,
    idequipamento integer,
    status character varying(30),
    resp character varying(1024),
    data timestamp without time zone DEFAULT now()
);


ALTER TABLE public.patchequipamento OWNER TO sagui;

--
-- Name: patchequipamento_id_seq; Type: SEQUENCE SET; Schema: public; Owner: sagui
--

SELECT pg_catalog.setval(pg_catalog.pg_get_serial_sequence('patchequipamento', 'id'), 636817, true);


--
-- Name: patchperfil; Type: TABLE; Schema: public; Owner: sagui; Tablespace: 
--

CREATE TABLE patchperfil (
    idpatch integer NOT NULL,
    idperfil integer NOT NULL
);


ALTER TABLE public.patchperfil OWNER TO sagui;

--
-- Name: patchunidade; Type: TABLE; Schema: public; Owner: sagui; Tablespace: 
--

CREATE TABLE patchunidade (
    idpatch integer,
    idunidade integer
);


ALTER TABLE public.patchunidade OWNER TO sagui;

--
-- Name: perfil; Type: TABLE; Schema: public; Owner: sagui; Tablespace: 
--

CREATE TABLE perfil (
    id integer DEFAULT nextval(('perfil_id_seq'::text)::regclass) NOT NULL,
    nome character varying(30),
    adcionais text,
    legenda character varying(60)
);


ALTER TABLE public.perfil OWNER TO sagui;

--
-- Name: perfil_id_seq; Type: SEQUENCE; Schema: public; Owner: sagui
--

CREATE SEQUENCE perfil_id_seq
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.perfil_id_seq OWNER TO sagui;

--
-- Name: perfil_id_seq; Type: SEQUENCE SET; Schema: public; Owner: sagui
--

SELECT pg_catalog.setval('perfil_id_seq', 10, true);


--
-- Name: perfildeuso; Type: TABLE; Schema: public; Owner: sagui; Tablespace: 
--

CREATE TABLE perfildeuso (
    id bigserial NOT NULL,
    descricao character varying(70)
);


ALTER TABLE public.perfildeuso OWNER TO sagui;

--
-- Name: perfildeuso_id_seq; Type: SEQUENCE SET; Schema: public; Owner: sagui
--

SELECT pg_catalog.setval(pg_catalog.pg_get_serial_sequence('perfildeuso', 'id'), 10, true);


--
-- Name: perfildeusomenu; Type: TABLE; Schema: public; Owner: sagui; Tablespace: 
--

CREATE TABLE perfildeusomenu (
    idperfildeuso integer NOT NULL,
    idmenu integer NOT NULL
);


ALTER TABLE public.perfildeusomenu OWNER TO sagui;

--
-- Name: rede; Type: TABLE; Schema: public; Owner: sagui; Tablespace: 
--

CREATE TABLE rede (
    id bigserial NOT NULL,
    idunidade integer,
    ippart character varying(15)
);


ALTER TABLE public.rede OWNER TO sagui;

--
-- Name: rede_id_seq; Type: SEQUENCE SET; Schema: public; Owner: sagui
--

SELECT pg_catalog.setval(pg_catalog.pg_get_serial_sequence('rede', 'id'), 10, true);


--
-- Name: scriptpatch; Type: TABLE; Schema: public; Owner: sagui; Tablespace: 
--

CREATE TABLE scriptpatch (
    id bigserial NOT NULL,
    nome character varying(30),
    status character varying(30),
    tipo character varying(15)
);


ALTER TABLE public.scriptpatch OWNER TO sagui;

--
-- Name: scriptpatch_id_seq; Type: SEQUENCE SET; Schema: public; Owner: sagui
--

SELECT pg_catalog.setval(pg_catalog.pg_get_serial_sequence('scriptpatch', 'id'), 10, true);


--
-- Name: seq_perfil; Type: SEQUENCE; Schema: public; Owner: sagui
--

CREATE SEQUENCE seq_perfil
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.seq_perfil OWNER TO sagui;

--
-- Name: seq_perfil; Type: SEQUENCE SET; Schema: public; Owner: sagui
--

SELECT pg_catalog.setval('seq_perfil', 1, true);


--
-- Name: submenu; Type: TABLE; Schema: public; Owner: sagui; Tablespace: 
--

CREATE TABLE submenu (
    id bigserial NOT NULL,
    nome character varying(70),
    descricao text,
    href character varying(200),
    target character varying(30) DEFAULT 'dir'::character varying
);


ALTER TABLE public.submenu OWNER TO sagui;

--
-- Name: submenu_id_seq; Type: SEQUENCE SET; Schema: public; Owner: sagui
--

SELECT pg_catalog.setval(pg_catalog.pg_get_serial_sequence('submenu', 'id'), 10, true);


--
-- Name: tipoarquivo; Type: TABLE; Schema: public; Owner: sagui; Tablespace: 
--

CREATE TABLE tipoarquivo (
    id bigserial NOT NULL,
    tipo character varying(30),
    descricao character varying(60)
);


ALTER TABLE public.tipoarquivo OWNER TO sagui;

--
-- Name: tipoarquivo_id_seq; Type: SEQUENCE SET; Schema: public; Owner: sagui
--

SELECT pg_catalog.setval(pg_catalog.pg_get_serial_sequence('tipoarquivo', 'id'), 3, true);


--
-- Name: tipoevento; Type: TABLE; Schema: public; Owner: sagui; Tablespace: 
--

CREATE TABLE tipoevento (
    id bigserial NOT NULL,
    nome character varying(50)
);


ALTER TABLE public.tipoevento OWNER TO sagui;

--
-- Name: tipoevento_id_seq; Type: SEQUENCE SET; Schema: public; Owner: sagui
--

SELECT pg_catalog.setval(pg_catalog.pg_get_serial_sequence('tipoevento', 'id'), 10, true);


--
-- Name: unidade; Type: TABLE; Schema: public; Owner: sagui; Tablespace: 
--

CREATE TABLE unidade (
    id bigserial NOT NULL,
    nome character varying(50),
    codigoemb character varying(30)
);


ALTER TABLE public.unidade OWNER TO sagui;

--
-- Name: unidade_id_seq; Type: SEQUENCE SET; Schema: public; Owner: sagui
--

SELECT pg_catalog.setval(pg_catalog.pg_get_serial_sequence('unidade', 'id'), 10, true);


--
-- Name: unidadeparametroslocais; Type: TABLE; Schema: public; Owner: sagui; Tablespace: 
--

CREATE TABLE unidadeparametroslocais (
    idunidade integer,
    idparametro integer,
    valor character varying(100)
);


ALTER TABLE public.unidadeparametroslocais OWNER TO sagui;

--
-- Name: usuario; Type: TABLE; Schema: public; Owner: sagui; Tablespace: 
--

CREATE TABLE usuario (
    id bigserial NOT NULL,
    "login" character varying(30),
    nome character varying(60),
    senha character varying(60),
    status character varying(30) DEFAULT 'HABILITADO'::character varying,
    idperfildeuso integer,
    email character varying(100)
);


ALTER TABLE public.usuario OWNER TO sagui;

--
-- Name: usuario_id_seq; Type: SEQUENCE SET; Schema: public; Owner: sagui
--

SELECT pg_catalog.setval(pg_catalog.pg_get_serial_sequence('usuario', 'id'), 10, true);


--
-- Name: versaoscriptpatch; Type: TABLE; Schema: public; Owner: sagui; Tablespace: 
--

CREATE TABLE versaoscriptpatch (
    idscript integer NOT NULL,
    versao integer DEFAULT 1 NOT NULL,
    idusuario integer,
    conteudo text,
    status character varying(10) DEFAULT 'NOVO'::character varying,
    data timestamp without time zone DEFAULT now()
);


ALTER TABLE public.versaoscriptpatch OWNER TO sagui;

--
-- Name: vw_lista_atributos; Type: VIEW; Schema: public; Owner: sagui
--

CREATE VIEW vw_lista_atributos AS
    SELECT a.id, a.nome, s.nome AS script, s.status FROM atributo a, scriptpatch s WHERE (a.idscript = s.id);


ALTER TABLE public.vw_lista_atributos OWNER TO sagui;

--
-- Name: vw_lista_log_erro_patch; Type: VIEW; Schema: public; Owner: sagui
--

CREATE VIEW vw_lista_log_erro_patch AS
    SELECT p.id AS idpatch, l.ip, to_char(l.data, 'DD/MM/YYYY HH24:MI'::text) AS to_char FROM logpatch l, patch p WHERE (((l.status)::text = 'ERRO'::text) AND (p.sequencial = l.sequencial));


ALTER TABLE public.vw_lista_log_erro_patch OWNER TO sagui;

--
-- Name: vw_lista_log_erro_patch_last; Type: VIEW; Schema: public; Owner: sagui
--

CREATE VIEW vw_lista_log_erro_patch_last AS
    SELECT p.id AS idpatch, l.ip, to_char(max(l.data), 'DD/MM/YYYY HH24:MI'::text) AS to_char FROM logpatch l, patch p WHERE (((l.status)::text = 'ERRO'::text) AND (p.sequencial = l.sequencial)) GROUP BY p.id, l.ip;


ALTER TABLE public.vw_lista_log_erro_patch_last OWNER TO sagui;

--
-- Name: vw_lista_log_ok_patch; Type: VIEW; Schema: public; Owner: sagui
--

CREATE VIEW vw_lista_log_ok_patch AS
    SELECT p.id AS idpatch, l.ip, to_char(l.data, 'DD/MM/YYYY HH24:MI'::text) AS to_char FROM logpatch l, patch p WHERE (((l.status)::text = 'OK'::text) AND (p.sequencial = l.sequencial));


ALTER TABLE public.vw_lista_log_ok_patch OWNER TO sagui;

--
-- Name: vw_lista_patchs; Type: VIEW; Schema: public; Owner: sagui
--

CREATE VIEW vw_lista_patchs AS
    SELECT p.id, p.titulo, p.sequencial, u.nome, s.status FROM patch p, usuario u, scriptpatch s WHERE ((p.idusuario = u.id) AND (p.idscript = s.id)) ORDER BY p.sequencial DESC;


ALTER TABLE public.vw_lista_patchs OWNER TO sagui;

--
-- Name: vw_lista_scripts; Type: VIEW; Schema: public; Owner: sagui
--

CREATE VIEW vw_lista_scripts AS
    SELECT scriptpatch.id, scriptpatch.nome, scriptpatch.status, scriptpatch.tipo FROM scriptpatch ORDER BY scriptpatch.id DESC;


ALTER TABLE public.vw_lista_scripts OWNER TO sagui;

--
-- Name: vw_patch_erro_lista; Type: VIEW; Schema: public; Owner: sagui
--

CREATE VIEW vw_patch_erro_lista AS
    SELECT pe.idequipamento, e.ip, pe.data, pe.idpatch, e.idunidade, substr((pe.resp)::text, 40, 0) AS substr FROM patchequipamento pe, equipamento e WHERE ((((pe.status)::text = 'ERRO'::text) AND (NOT (pe.id IN (SELECT max(patchequipamento.id) AS max FROM patchequipamento GROUP BY patchequipamento.idpatch, patchequipamento.idequipamento)))) AND (pe.idequipamento = e.id));


ALTER TABLE public.vw_patch_erro_lista OWNER TO sagui;

--
-- Name: vw_patch_ok_unidade; Type: VIEW; Schema: public; Owner: sagui
--

CREATE VIEW vw_patch_ok_unidade AS
    SELECT u.id AS idunidade, u.nome, count(DISTINCT pe.idequipamento) AS count, pe.idpatch FROM equipamento e, patchequipamento pe, unidade u WHERE (((e.id = pe.idequipamento) AND (e.idunidade = u.id)) AND ((pe.status)::text = 'OK'::text)) GROUP BY u.nome, u.id, pe.idpatch;


ALTER TABLE public.vw_patch_ok_unidade OWNER TO sagui;

--
-- Data for Name: atributo; Type: TABLE DATA; Schema: public; Owner: sagui
--

COPY atributo (id, nome, obs, idscript) FROM stdin;
\.


--
-- Data for Name: coleta; Type: TABLE DATA; Schema: public; Owner: sagui
--

COPY coleta (id, idequipamento, idatributo, value, data) FROM stdin;
\.


--
-- Data for Name: equipamento; Type: TABLE DATA; Schema: public; Owner: sagui
--

COPY equipamento (id, ip, mac, idunidade) FROM stdin;
\.


--
-- Data for Name: evento; Type: TABLE DATA; Schema: public; Owner: sagui
--

COPY evento (id, idequipamento, idtipoevento, status, saida, visto, idscript, data) FROM stdin;
\.


--
-- Data for Name: ligou; Type: TABLE DATA; Schema: public; Owner: sagui
--

COPY ligou (id, idequipamento, data) FROM stdin;
\.


--
-- Data for Name: log_atividade_scripts; Type: TABLE DATA; Schema: public; Owner: sagui
--

COPY log_atividade_scripts (id, idusuario, idscript, versao, status, data) FROM stdin;
1697	0	356	1	NOVO	2008-04-11 18:50:08.672831
1698	0	356	1	LIBERADO	2008-04-11 18:50:19.155412
1699	0	357	1	NOVO	2008-04-11 18:53:02.10263
1700	0	357	1	LIBERADO	2008-04-11 18:53:08.465631
1701	0	358	1	NOVO	2008-04-11 19:44:56.39049
1702	0	358	1	LIBERADO	2008-04-11 19:45:04.323881
1703	0	359	1	NOVO	2008-04-11 19:56:57.378129
1704	0	359	1	LIBERADO	2008-04-11 19:57:06.969089
\.


--
-- Data for Name: logpatch; Type: TABLE DATA; Schema: public; Owner: sagui
--

COPY logpatch (id, sequencial, ip, data, status) FROM stdin;
\.


--
-- Data for Name: menu; Type: TABLE DATA; Schema: public; Owner: sagui
--

COPY menu (id, nome, href, target, descricao) FROM stdin;
10	Menus	frame.php	main	Menu
11	Coleta	frame.php	main	Gerencia  todos os aspectos referentes a coleta de dados.
2	Sair	sair.php	_parent	menu de saida
12	Senha	frame.php	main	Gerenciamento de senha
18	Monitor	painel.php	main	Painel de monitoramento de eventos
17	Monitoramento	frame.php	main	Gerenciamento do sistema de monitoramento do SAGUI
14	Servidores	frame.php	main	Gerenciamento das atualizacoes e servidores
1	Corre&ccedil;&otilde;es	frame.php	main	menu de patches para o adm
16	Unidades	frame.php	main	Gereciamento de unidades
3	Cadastro	frame.php	main	menu de cadastros diversos  para o adm
\.


--
-- Data for Name: menusubmenu; Type: TABLE DATA; Schema: public; Owner: sagui
--

COPY menusubmenu (idmenu, idsubmenu) FROM stdin;
10	11
10	13
11	18
11	19
11	23
11	24
12	22
1	16
1	17
1	14
1	15
16	33
16	2
16	32
3	4
3	20
3	21
3	29
3	26
3	46
\.


--
-- Data for Name: parametroslocais; Type: TABLE DATA; Schema: public; Owner: sagui
--

COPY parametroslocais (id, nome, shellvar) FROM stdin;
\.


--
-- Data for Name: patch; Type: TABLE DATA; Schema: public; Owner: sagui
--

COPY patch (id, sequencial, titulo, msg, idusuario, data, idscript) FROM stdin;
\.


--
-- Data for Name: patchequipamento; Type: TABLE DATA; Schema: public; Owner: sagui
--

COPY patchequipamento (id, idpatch, idequipamento, status, resp, data) FROM stdin;
\.


--
-- Data for Name: patchperfil; Type: TABLE DATA; Schema: public; Owner: sagui
--

COPY patchperfil (idpatch, idperfil) FROM stdin;
\.


--
-- Data for Name: patchunidade; Type: TABLE DATA; Schema: public; Owner: sagui
--

COPY patchunidade (idpatch, idunidade) FROM stdin;
\.


--
-- Data for Name: perfil; Type: TABLE DATA; Schema: public; Owner: sagui
--

COPY perfil (id, nome, adcionais, legenda) FROM stdin;
\.


--
-- Data for Name: perfildeuso; Type: TABLE DATA; Schema: public; Owner: sagui
--

COPY perfildeuso (id, descricao) FROM stdin;
1	Administrador do sistema
3	basico
2	Editor de patches
4	adm coleta
\.


--
-- Data for Name: perfildeusomenu; Type: TABLE DATA; Schema: public; Owner: sagui
--

COPY perfildeusomenu (idperfildeuso, idmenu) FROM stdin;
1	10
1	11
4	11
1	2
2	2
4	2
1	12
2	12
3	12
4	12
1	18
2	18
3	17
3	14
1	1
2	1
1	16
1	3
\.



--
-- Data for Name: scriptpatch; Type: TABLE DATA; Schema: public; Owner: sagui
--

COPY scriptpatch (id, nome, status, tipo) FROM stdin;
356	script-coleta.sh	LIBERADO	COLETA
357	rc.v2.patch	LIBERADO	PATCH
358	script-atualiza.sh	LIBERADO	PATCH
359	coleta-mac-eth0.sh	LIBERADO	COLETA
\.


--
-- Data for Name: submenu; Type: TABLE DATA; Schema: public; Owner: sagui
--

COPY submenu (id, nome, descricao, href, target) FROM stdin;
3	Perfis de Instala&ccedil;&atilde;o	Cadastro de Perfis de instala&ccedil;&atilde;o	cadperfilinstalacao.php	dir
4	Perfis de uso	Cadastro de Perfis de uso	cadperfildeuso.php	dir
5	Menus do SAGUI	Cadastro de menus do sagui	cadmenu.php?acao=criarmenu	dir
16	Gerenciar Patches	Lista e altera patches	gerenciar.php	dir
18	Dados a Coletar	Adicionar um dado a ser coletado nos equipamentos	gerenciarcoleta.php	dir
20	Cadastro de usuario	Cadastro de usuarios	cadusuario.php?acao=criarusuario	dir
21	Gerenciar usuarios	Gerencia Usuarios	cadusuario.php	dir
22	Alterar senha	Alteracao de senha	senha.php	dir
17	Gerenciar Scripts	Lista, ativa e desativa scripts do tipo patch	gerenciarscript.php?lista=PATCH	dir
23	Gerenciar Scripts	Lista, ativa e desativa scripts do tipo coleta	gerenciarscript.php?lista=COLETA	dir
29	Gerenciar Categorias	Gerencia as categorias de instalacao ja criadas	gerenciainstalacao.php	dir
33	Gerenciar Unidades	Gerencia unidades criadas	gerenciaunidade.php	dir
2	Adicionar Unidades	Cadastro de unidades	gerenciaunidade.php?acao=adcionarunidade	dir
11	Adicionar Menu	Adiciona um menu ou um submenu	cadmenu.php?acao=criarmenu	dir
14	Adicionar Script	Adiciona um script patch a base  	patch.php?acao=adcionarscript&tiposcript=PATCH	dir
19	Adicionar Coleta	Adicionar algum dado para coleta	gerenciarcoleta.php?acao=criarcoleta	dir
24	Adiciona Script	Adicionar um script coleta a base	patch.php?acao=adcionarscript&tiposcript=COLETA	dir
32	Adicionar Parametro	Adiciona paramentros regionais de instalacao	gerenciainstalacao.php?acao=adcionarparametro	dir
15	Adicionar Patch	Adiciona um patch associando a um perfil e unidade	patch.php?acao=criarpatch	dir
13	Gerenciar	Gerencia Menus e Submenus	cadmenu.php?acao=operar	dir
26	Adicionar Categoria	Cadastra um Perfil de InstalaÃ§Ã£o	gerenciainstalacao.php?acao=adicionarcategoria	dir
1	Correcoes	menu de patches para o adm	frame.php	dir
46	Tipos de evento	Gerenciar tipos de eventos	cadtipoevento.php	dir
\.


--
-- Data for Name: tipoarquivo; Type: TABLE DATA; Schema: public; Owner: sagui
--

COPY tipoarquivo (id, tipo, descricao) FROM stdin;
1	installscript	scripts de instalação
2	patch	scripts de correção
3	arqtemplate	templates de arquivos de configuração
\.


--
-- Data for Name: tipoevento; Type: TABLE DATA; Schema: public; Owner: sagui
--

COPY tipoevento (id, nome) FROM stdin;
1	AGENTE
2	UPDATE
0	DESCONHECIDO
3	PATCH
5	ANTIVIRUS
\.


--
-- Data for Name: unidade; Type: TABLE DATA; Schema: public; Owner: sagui
--

COPY unidade (id, nome, codigoemb) FROM stdin;
\.


--
-- Data for Name: unidadeparametroslocais; Type: TABLE DATA; Schema: public; Owner: sagui
--

COPY unidadeparametroslocais (idunidade, idparametro, valor) FROM stdin;
\.


--
-- Data for Name: usuario; Type: TABLE DATA; Schema: public; Owner: sagui
--

COPY usuario (id, "login", nome, senha, status, idperfildeuso, email) FROM stdin;
0	sagui	adminstrador do sistema	ee63b6baf6cdb8119406bf46fbb9cbcf981bbb40	HABILITADO	1	\N
\.


--
-- Data for Name: versaoscriptpatch; Type: TABLE DATA; Schema: public; Owner: sagui
--

COPY versaoscriptpatch (idscript, versao, idusuario, conteudo, status, data) FROM stdin;
356	1	0	SSHELL=sh\r\nwhich ksh && SSHELL=ksh\r\nif ! [ -d /etc/coleta/ ] ; then \r\n\tmkdir -p /etc/coleta/md5s/\r\nfi\r\n\r\n[ -f /etc/coleta/chave ] && CHAVE=`cat /etc/coleta/chave`\r\n\r\nif [ -z "$CHAVE" ] ; then \r\n\tmac=`links --source "http://10.200.105.236/sagui/arquivos.php?arquivo=coleta-mac-eth0.sh" 2> /dev/null | dos2unix | $SSHELL`\r\n\tlinks --source "http://10.200.105.236/sagui/coleta.php?acao=getchave&mac=$mac" 2>/dev/null | dos2unix | $SSHELL > /etc/coleta/chave\r\n\r\nfi\r\nexport CHAVE=`cat /etc/coleta/chave`\r\n\r\nlinks --source "http://10.200.105.236/sagui/coleta.php" | dos2unix | $SSHELL\r\nrm -f /coleta.php?*	LIBERADO	2008-04-11 18:50:08.672831
357	1	0	touch /etc/patches\r\n. /etc/tipo\r\n. /etc/sagui/sagui_functions\r\nIP=`getIP`\r\nsagui_downpatches\r\n[ -f  /tmp/variaveis ] || exit 1\r\n. /tmp/variaveis\r\n\r\necho "Aplicando patches gerais:"\r\nfor SEQ in $NACIONAIS ; do\r\n\tfgrep -w $SEQ /etc/patches >> /dev/null 2>&1\r\n\tif [ "$?" == "1" ] ; then\r\n\t\tsagui-run-patch -r $SEQ  || continue\r\n\t\techo $SEQ >> /etc/patches\r\n\tfi\r\ndone\r\necho "Aplicando patches para a Regional $REGIONAL:"\r\nfor SEQ in $REGIONAIS ; do\r\n\tfgrep -w $SEQ /etc/patches >> /dev/null 2>&1\r\n\tif [ "$?" == "1" ] ; then\r\n                sagui-run-patch -r $SEQ || continue\r\n\t\techo $SEQ >> /etc/patches\r\n\tfi\r\ndone\r\n	LIBERADO	2008-04-11 18:53:02.10263
358	1	0	#Script de Atualizacao FC4\r\n. /etc/sysconfig/sagui-clients\r\n. /etc/sagui/sagui_functions\r\nyum clean all\r\nPKGS_TMP=`yum check-update`\r\n#REPORTAR ERRO NA CHECAGEM\r\nPKGS=`echo "$PKGS_TMP" | sed -n -e '/^$/,/^$/p' | awk '{print $1}'`\r\nif ! [  -z "$PKGS" ] ; then\r\n        i=0;\r\n        echo -n "Atualizando os pacotes"\r\n        for PK in $PKGS ; do\r\n                let i=$i+1\r\n                echo $i:$PK\r\n        done\r\nfi\r\nyum -y update\r\nif [ "$?" -ne 0 ] ; then\r\n  sagui_evento $CHAVE 1 $IDSCRIPT "ERRO" 2\r\nelse\r\n  sagui_evento $CHAVE 0 $IDSCRIPT "OK" 2\r\nfi\r\nyum clean all\r\n	LIBERADO	2008-04-11 19:44:56.39049
359	1	0	IF=`/sbin/route  | awk '/default/ {print $8}'`\r\n[ -z "$IF" ] && IF=eth0\r\n/sbin/ifconfig $IF | egrep -o '[[:alnum:]]{2}(:[[:alnum:]]{2}){5}'	LIBERADO	2008-04-11 19:56:57.378129
\.


--
-- Name: atributo_pkey; Type: CONSTRAINT; Schema: public; Owner: sagui; Tablespace: 
--

ALTER TABLE ONLY atributo
    ADD CONSTRAINT atributo_pkey PRIMARY KEY (id);


--
-- Name: coleta_pkey; Type: CONSTRAINT; Schema: public; Owner: sagui; Tablespace: 
--

ALTER TABLE ONLY coleta
    ADD CONSTRAINT coleta_pkey PRIMARY KEY (id);


--
-- Name: equipamento_pkey; Type: CONSTRAINT; Schema: public; Owner: sagui; Tablespace: 
--

ALTER TABLE ONLY equipamento
    ADD CONSTRAINT equipamento_pkey PRIMARY KEY (id);


--
-- Name: evento_pkey; Type: CONSTRAINT; Schema: public; Owner: sagui; Tablespace: 
--

ALTER TABLE ONLY evento
    ADD CONSTRAINT evento_pkey PRIMARY KEY (id);


--
-- Name: ligou_pkey; Type: CONSTRAINT; Schema: public; Owner: sagui; Tablespace: 
--

ALTER TABLE ONLY ligou
    ADD CONSTRAINT ligou_pkey PRIMARY KEY (id);


--
-- Name: menu_pkey; Type: CONSTRAINT; Schema: public; Owner: sagui; Tablespace: 
--

ALTER TABLE ONLY menu
    ADD CONSTRAINT menu_pkey PRIMARY KEY (id);


--
-- Name: menusubmenu_pkey; Type: CONSTRAINT; Schema: public; Owner: sagui; Tablespace: 
--

ALTER TABLE ONLY menusubmenu
    ADD CONSTRAINT menusubmenu_pkey PRIMARY KEY (idmenu, idsubmenu);


--
-- Name: parametroslocais_pkey; Type: CONSTRAINT; Schema: public; Owner: sagui; Tablespace: 
--

ALTER TABLE ONLY parametroslocais
    ADD CONSTRAINT parametroslocais_pkey PRIMARY KEY (id);


--
-- Name: patch_pkey; Type: CONSTRAINT; Schema: public; Owner: sagui; Tablespace: 
--

ALTER TABLE ONLY patch
    ADD CONSTRAINT patch_pkey PRIMARY KEY (id);


--
-- Name: patchequipamento_pkey; Type: CONSTRAINT; Schema: public; Owner: sagui; Tablespace: 
--

ALTER TABLE ONLY patchequipamento
    ADD CONSTRAINT patchequipamento_pkey PRIMARY KEY (id);


--
-- Name: patchperfil_pkey; Type: CONSTRAINT; Schema: public; Owner: sagui; Tablespace: 
--

ALTER TABLE ONLY patchperfil
    ADD CONSTRAINT patchperfil_pkey PRIMARY KEY (idpatch, idperfil);


--
-- Name: perfil_pkey; Type: CONSTRAINT; Schema: public; Owner: sagui; Tablespace: 
--

ALTER TABLE ONLY perfil
    ADD CONSTRAINT perfil_pkey PRIMARY KEY (id);


--
-- Name: perfildeuso_pkey; Type: CONSTRAINT; Schema: public; Owner: sagui; Tablespace: 
--

ALTER TABLE ONLY perfildeuso
    ADD CONSTRAINT perfildeuso_pkey PRIMARY KEY (id);


--
-- Name: perfildeusomenu_pkey; Type: CONSTRAINT; Schema: public; Owner: sagui; Tablespace: 
--

ALTER TABLE ONLY perfildeusomenu
    ADD CONSTRAINT perfildeusomenu_pkey PRIMARY KEY (idperfildeuso, idmenu);


--
-- Name: rede_pkey; Type: CONSTRAINT; Schema: public; Owner: sagui; Tablespace: 
--

ALTER TABLE ONLY rede
    ADD CONSTRAINT rede_pkey PRIMARY KEY (id);


--
-- Name: scriptpatch_pkey; Type: CONSTRAINT; Schema: public; Owner: sagui; Tablespace: 
--

ALTER TABLE ONLY scriptpatch
    ADD CONSTRAINT scriptpatch_pkey PRIMARY KEY (id);


--
-- Name: submenu_pkey; Type: CONSTRAINT; Schema: public; Owner: sagui; Tablespace: 
--

ALTER TABLE ONLY submenu
    ADD CONSTRAINT submenu_pkey PRIMARY KEY (id);


--
-- Name: tipoarquivo_pkey; Type: CONSTRAINT; Schema: public; Owner: sagui; Tablespace: 
--

ALTER TABLE ONLY tipoarquivo
    ADD CONSTRAINT tipoarquivo_pkey PRIMARY KEY (id);


--
-- Name: tipoevento_pkey; Type: CONSTRAINT; Schema: public; Owner: sagui; Tablespace: 
--

ALTER TABLE ONLY tipoevento
    ADD CONSTRAINT tipoevento_pkey PRIMARY KEY (id);


--
-- Name: unidade_pkey; Type: CONSTRAINT; Schema: public; Owner: sagui; Tablespace: 
--

ALTER TABLE ONLY unidade
    ADD CONSTRAINT unidade_pkey PRIMARY KEY (id);


--
-- Name: usuario_pkey; Type: CONSTRAINT; Schema: public; Owner: sagui; Tablespace: 
--

ALTER TABLE ONLY usuario
    ADD CONSTRAINT usuario_pkey PRIMARY KEY (id);


--
-- Name: versaoscriptpatch_pkey; Type: CONSTRAINT; Schema: public; Owner: sagui; Tablespace: 
--

ALTER TABLE ONLY versaoscriptpatch
    ADD CONSTRAINT versaoscriptpatch_pkey PRIMARY KEY (idscript, versao);


--
-- Name: $1; Type: FK CONSTRAINT; Schema: public; Owner: sagui
--

ALTER TABLE ONLY patch
    ADD CONSTRAINT "$1" FOREIGN KEY (idusuario) REFERENCES usuario(id);


--
-- Name: $1; Type: FK CONSTRAINT; Schema: public; Owner: sagui
--

ALTER TABLE ONLY patchperfil
    ADD CONSTRAINT "$1" FOREIGN KEY (idpatch) REFERENCES patch(id);


--
-- Name: $1; Type: FK CONSTRAINT; Schema: public; Owner: sagui
--

ALTER TABLE ONLY rede
    ADD CONSTRAINT "$1" FOREIGN KEY (idunidade) REFERENCES unidade(id);


--
-- Name: $1; Type: FK CONSTRAINT; Schema: public; Owner: sagui
--

ALTER TABLE ONLY patchunidade
    ADD CONSTRAINT "$1" FOREIGN KEY (idpatch) REFERENCES patch(id);


--
-- Name: $1; Type: FK CONSTRAINT; Schema: public; Owner: sagui
--

ALTER TABLE ONLY menusubmenu
    ADD CONSTRAINT "$1" FOREIGN KEY (idmenu) REFERENCES menu(id) ON DELETE CASCADE;


--
-- Name: $1; Type: FK CONSTRAINT; Schema: public; Owner: sagui
--

ALTER TABLE ONLY usuario
    ADD CONSTRAINT "$1" FOREIGN KEY (idperfildeuso) REFERENCES perfildeuso(id);


--
-- Name: $1; Type: FK CONSTRAINT; Schema: public; Owner: sagui
--

ALTER TABLE ONLY perfildeusomenu
    ADD CONSTRAINT "$1" FOREIGN KEY (idperfildeuso) REFERENCES perfildeuso(id) ON DELETE CASCADE;


--
-- Name: $1; Type: FK CONSTRAINT; Schema: public; Owner: sagui
--

ALTER TABLE ONLY equipamento
    ADD CONSTRAINT "$1" FOREIGN KEY (idunidade) REFERENCES unidade(id);


--
-- Name: $1; Type: FK CONSTRAINT; Schema: public; Owner: sagui
--

ALTER TABLE ONLY coleta
    ADD CONSTRAINT "$1" FOREIGN KEY (idatributo) REFERENCES atributo(id);


--
-- Name: $1; Type: FK CONSTRAINT; Schema: public; Owner: sagui
--

ALTER TABLE ONLY versaoscriptpatch
    ADD CONSTRAINT "$1" FOREIGN KEY (idscript) REFERENCES scriptpatch(id);


--
-- Name: $1; Type: FK CONSTRAINT; Schema: public; Owner: sagui
--

ALTER TABLE ONLY atributo
    ADD CONSTRAINT "$1" FOREIGN KEY (idscript) REFERENCES scriptpatch(id);


--
-- Name: $1; Type: FK CONSTRAINT; Schema: public; Owner: sagui
--

ALTER TABLE ONLY log_atividade_scripts
    ADD CONSTRAINT "$1" FOREIGN KEY (idusuario) REFERENCES usuario(id);


--
-- Name: $1; Type: FK CONSTRAINT; Schema: public; Owner: sagui
--

ALTER TABLE ONLY unidadeparametroslocais
    ADD CONSTRAINT "$1" FOREIGN KEY (idunidade) REFERENCES unidade(id);


--
-- Name: $1; Type: FK CONSTRAINT; Schema: public; Owner: sagui
--

ALTER TABLE ONLY ligou
    ADD CONSTRAINT "$1" FOREIGN KEY (idequipamento) REFERENCES equipamento(id);


--
-- Name: $1; Type: FK CONSTRAINT; Schema: public; Owner: sagui
--

ALTER TABLE ONLY evento
    ADD CONSTRAINT "$1" FOREIGN KEY (idtipoevento) REFERENCES tipoevento(id);


--
-- Name: $1; Type: FK CONSTRAINT; Schema: public; Owner: sagui
--

ALTER TABLE ONLY patchequipamento
    ADD CONSTRAINT "$1" FOREIGN KEY (idpatch) REFERENCES patch(id);


--
-- Name: $2; Type: FK CONSTRAINT; Schema: public; Owner: sagui
--

ALTER TABLE ONLY patchperfil
    ADD CONSTRAINT "$2" FOREIGN KEY (idperfil) REFERENCES perfil(id);


--
-- Name: $2; Type: FK CONSTRAINT; Schema: public; Owner: sagui
--

ALTER TABLE ONLY patchunidade
    ADD CONSTRAINT "$2" FOREIGN KEY (idunidade) REFERENCES unidade(id);


--
-- Name: $2; Type: FK CONSTRAINT; Schema: public; Owner: sagui
--

ALTER TABLE ONLY menusubmenu
    ADD CONSTRAINT "$2" FOREIGN KEY (idsubmenu) REFERENCES submenu(id) ON DELETE CASCADE;


--
-- Name: $2; Type: FK CONSTRAINT; Schema: public; Owner: sagui
--

ALTER TABLE ONLY perfildeusomenu
    ADD CONSTRAINT "$2" FOREIGN KEY (idmenu) REFERENCES menu(id) ON DELETE CASCADE;


--
-- Name: $2; Type: FK CONSTRAINT; Schema: public; Owner: sagui
--

ALTER TABLE ONLY coleta
    ADD CONSTRAINT "$2" FOREIGN KEY (idequipamento) REFERENCES equipamento(id);


--
-- Name: $2; Type: FK CONSTRAINT; Schema: public; Owner: sagui
--

ALTER TABLE ONLY versaoscriptpatch
    ADD CONSTRAINT "$2" FOREIGN KEY (idusuario) REFERENCES usuario(id);


--
-- Name: $2; Type: FK CONSTRAINT; Schema: public; Owner: sagui
--

ALTER TABLE ONLY log_atividade_scripts
    ADD CONSTRAINT "$2" FOREIGN KEY (idscript) REFERENCES scriptpatch(id);


--
-- Name: $2; Type: FK CONSTRAINT; Schema: public; Owner: sagui
--

ALTER TABLE ONLY unidadeparametroslocais
    ADD CONSTRAINT "$2" FOREIGN KEY (idparametro) REFERENCES parametroslocais(id);


--
-- Name: $2; Type: FK CONSTRAINT; Schema: public; Owner: sagui
--

ALTER TABLE ONLY evento
    ADD CONSTRAINT "$2" FOREIGN KEY (idequipamento) REFERENCES equipamento(id);


--
-- Name: $2; Type: FK CONSTRAINT; Schema: public; Owner: sagui
--

ALTER TABLE ONLY patchequipamento
    ADD CONSTRAINT "$2" FOREIGN KEY (idequipamento) REFERENCES equipamento(id);


--
-- Name: $2; Type: FK CONSTRAINT; Schema: public; Owner: sagui
--

ALTER TABLE ONLY patch
    ADD CONSTRAINT "$2" FOREIGN KEY (idscript) REFERENCES scriptpatch(id);


--
-- Name: $3; Type: FK CONSTRAINT; Schema: public; Owner: sagui
--

ALTER TABLE ONLY evento
    ADD CONSTRAINT "$3" FOREIGN KEY (idscript) REFERENCES scriptpatch(id);


--
-- Name: public; Type: ACL; Schema: -; Owner: postgres
--

REVOKE ALL ON SCHEMA public FROM PUBLIC;
REVOKE ALL ON SCHEMA public FROM postgres;
GRANT ALL ON SCHEMA public TO postgres;
GRANT ALL ON SCHEMA public TO PUBLIC;


--
-- Name: atributo; Type: ACL; Schema: public; Owner: sagui
--

REVOKE ALL ON TABLE atributo FROM PUBLIC;
REVOKE ALL ON TABLE atributo FROM sagui;
GRANT ALL ON TABLE atributo TO sagui;
GRANT ALL ON TABLE atributo TO apache;


--
-- Name: atributo_id_seq; Type: ACL; Schema: public; Owner: sagui
--

REVOKE ALL ON TABLE atributo_id_seq FROM PUBLIC;
REVOKE ALL ON TABLE atributo_id_seq FROM sagui;
GRANT ALL ON TABLE atributo_id_seq TO sagui;
GRANT ALL ON TABLE atributo_id_seq TO apache;


--
-- Name: coleta; Type: ACL; Schema: public; Owner: sagui
--

REVOKE ALL ON TABLE coleta FROM PUBLIC;
REVOKE ALL ON TABLE coleta FROM sagui;
GRANT ALL ON TABLE coleta TO sagui;
GRANT ALL ON TABLE coleta TO apache;
GRANT TRIGGER ON TABLE coleta TO PUBLIC;


--
-- Name: coleta_id_seq; Type: ACL; Schema: public; Owner: sagui
--

REVOKE ALL ON TABLE coleta_id_seq FROM PUBLIC;
REVOKE ALL ON TABLE coleta_id_seq FROM sagui;
GRANT ALL ON TABLE coleta_id_seq TO sagui;
GRANT ALL ON TABLE coleta_id_seq TO apache;


--
-- Name: equipamento; Type: ACL; Schema: public; Owner: sagui
--

REVOKE ALL ON TABLE equipamento FROM PUBLIC;
REVOKE ALL ON TABLE equipamento FROM sagui;
GRANT ALL ON TABLE equipamento TO sagui;
GRANT ALL ON TABLE equipamento TO apache;


--
-- Name: equipamento_id_seq; Type: ACL; Schema: public; Owner: sagui
--

REVOKE ALL ON TABLE equipamento_id_seq FROM PUBLIC;
REVOKE ALL ON TABLE equipamento_id_seq FROM sagui;
GRANT ALL ON TABLE equipamento_id_seq TO sagui;
GRANT ALL ON TABLE equipamento_id_seq TO apache;


--
-- Name: evento; Type: ACL; Schema: public; Owner: sagui
--

REVOKE ALL ON TABLE evento FROM PUBLIC;
REVOKE ALL ON TABLE evento FROM sagui;
GRANT ALL ON TABLE evento TO sagui;
GRANT ALL ON TABLE evento TO apache;


--
-- Name: evento_id_seq; Type: ACL; Schema: public; Owner: sagui
--

REVOKE ALL ON TABLE evento_id_seq FROM PUBLIC;
REVOKE ALL ON TABLE evento_id_seq FROM sagui;
GRANT ALL ON TABLE evento_id_seq TO sagui;
GRANT ALL ON TABLE evento_id_seq TO apache;


--
-- Name: ligou; Type: ACL; Schema: public; Owner: sagui
--

REVOKE ALL ON TABLE ligou FROM PUBLIC;
REVOKE ALL ON TABLE ligou FROM sagui;
GRANT ALL ON TABLE ligou TO sagui;
GRANT ALL ON TABLE ligou TO apache;


--
-- Name: ligou_id_seq; Type: ACL; Schema: public; Owner: sagui
--

REVOKE ALL ON TABLE ligou_id_seq FROM PUBLIC;
REVOKE ALL ON TABLE ligou_id_seq FROM sagui;
GRANT ALL ON TABLE ligou_id_seq TO sagui;
GRANT ALL ON TABLE ligou_id_seq TO apache;


--
-- Name: log_atividade_scripts; Type: ACL; Schema: public; Owner: sagui
--

REVOKE ALL ON TABLE log_atividade_scripts FROM PUBLIC;
REVOKE ALL ON TABLE log_atividade_scripts FROM sagui;
GRANT ALL ON TABLE log_atividade_scripts TO sagui;
GRANT ALL ON TABLE log_atividade_scripts TO apache;


--
-- Name: log_atividade_scripts_id_seq; Type: ACL; Schema: public; Owner: sagui
--

REVOKE ALL ON TABLE log_atividade_scripts_id_seq FROM PUBLIC;
REVOKE ALL ON TABLE log_atividade_scripts_id_seq FROM sagui;
GRANT ALL ON TABLE log_atividade_scripts_id_seq TO sagui;
GRANT ALL ON TABLE log_atividade_scripts_id_seq TO apache;


--
-- Name: logpatch; Type: ACL; Schema: public; Owner: sagui
--

REVOKE ALL ON TABLE logpatch FROM PUBLIC;
REVOKE ALL ON TABLE logpatch FROM sagui;
GRANT ALL ON TABLE logpatch TO sagui;
GRANT ALL ON TABLE logpatch TO apache;


--
-- Name: logpatch_id_seq; Type: ACL; Schema: public; Owner: sagui
--

REVOKE ALL ON TABLE logpatch_id_seq FROM PUBLIC;
REVOKE ALL ON TABLE logpatch_id_seq FROM sagui;
GRANT ALL ON TABLE logpatch_id_seq TO sagui;
GRANT ALL ON TABLE logpatch_id_seq TO apache;


--
-- Name: menu; Type: ACL; Schema: public; Owner: sagui
--

REVOKE ALL ON TABLE menu FROM PUBLIC;
REVOKE ALL ON TABLE menu FROM sagui;
GRANT ALL ON TABLE menu TO sagui;
GRANT ALL ON TABLE menu TO apache;


--
-- Name: menu_id_seq; Type: ACL; Schema: public; Owner: sagui
--

REVOKE ALL ON TABLE menu_id_seq FROM PUBLIC;
REVOKE ALL ON TABLE menu_id_seq FROM sagui;
GRANT ALL ON TABLE menu_id_seq TO sagui;
GRANT ALL ON TABLE menu_id_seq TO apache;


--
-- Name: menusubmenu; Type: ACL; Schema: public; Owner: sagui
--

REVOKE ALL ON TABLE menusubmenu FROM PUBLIC;
REVOKE ALL ON TABLE menusubmenu FROM sagui;
GRANT ALL ON TABLE menusubmenu TO sagui;
GRANT ALL ON TABLE menusubmenu TO apache;


--
-- Name: parametroslocais; Type: ACL; Schema: public; Owner: sagui
--

REVOKE ALL ON TABLE parametroslocais FROM PUBLIC;
REVOKE ALL ON TABLE parametroslocais FROM sagui;
GRANT ALL ON TABLE parametroslocais TO sagui;
GRANT ALL ON TABLE parametroslocais TO apache;


--
-- Name: parametroslocais_id_seq; Type: ACL; Schema: public; Owner: sagui
--

REVOKE ALL ON TABLE parametroslocais_id_seq FROM PUBLIC;
REVOKE ALL ON TABLE parametroslocais_id_seq FROM sagui;
GRANT ALL ON TABLE parametroslocais_id_seq TO sagui;
GRANT ALL ON TABLE parametroslocais_id_seq TO apache;


--
-- Name: patch; Type: ACL; Schema: public; Owner: sagui
--

REVOKE ALL ON TABLE patch FROM PUBLIC;
REVOKE ALL ON TABLE patch FROM sagui;
GRANT ALL ON TABLE patch TO sagui;
GRANT ALL ON TABLE patch TO apache;


--
-- Name: patch_id_seq; Type: ACL; Schema: public; Owner: sagui
--

REVOKE ALL ON TABLE patch_id_seq FROM PUBLIC;
REVOKE ALL ON TABLE patch_id_seq FROM sagui;
GRANT ALL ON TABLE patch_id_seq TO sagui;
GRANT ALL ON TABLE patch_id_seq TO apache;


--
-- Name: patch_sequencial_seq; Type: ACL; Schema: public; Owner: sagui
--

REVOKE ALL ON TABLE patch_sequencial_seq FROM PUBLIC;
REVOKE ALL ON TABLE patch_sequencial_seq FROM sagui;
GRANT ALL ON TABLE patch_sequencial_seq TO sagui;
GRANT ALL ON TABLE patch_sequencial_seq TO apache;


--
-- Name: patchequipamento; Type: ACL; Schema: public; Owner: sagui
--

REVOKE ALL ON TABLE patchequipamento FROM PUBLIC;
REVOKE ALL ON TABLE patchequipamento FROM sagui;
GRANT ALL ON TABLE patchequipamento TO sagui;
GRANT ALL ON TABLE patchequipamento TO apache;


--
-- Name: patchequipamento_id_seq; Type: ACL; Schema: public; Owner: sagui
--

REVOKE ALL ON TABLE patchequipamento_id_seq FROM PUBLIC;
REVOKE ALL ON TABLE patchequipamento_id_seq FROM sagui;
GRANT ALL ON TABLE patchequipamento_id_seq TO sagui;
GRANT ALL ON TABLE patchequipamento_id_seq TO apache;


--
-- Name: patchperfil; Type: ACL; Schema: public; Owner: sagui
--

REVOKE ALL ON TABLE patchperfil FROM PUBLIC;
REVOKE ALL ON TABLE patchperfil FROM sagui;
GRANT ALL ON TABLE patchperfil TO sagui;
GRANT ALL ON TABLE patchperfil TO apache;


--
-- Name: patchunidade; Type: ACL; Schema: public; Owner: sagui
--

REVOKE ALL ON TABLE patchunidade FROM PUBLIC;
REVOKE ALL ON TABLE patchunidade FROM sagui;
GRANT ALL ON TABLE patchunidade TO sagui;
GRANT ALL ON TABLE patchunidade TO apache;


--
-- Name: perfil; Type: ACL; Schema: public; Owner: sagui
--

REVOKE ALL ON TABLE perfil FROM PUBLIC;
REVOKE ALL ON TABLE perfil FROM sagui;
GRANT ALL ON TABLE perfil TO sagui;
GRANT ALL ON TABLE perfil TO apache;


--
-- Name: perfil_id_seq; Type: ACL; Schema: public; Owner: sagui
--

REVOKE ALL ON TABLE perfil_id_seq FROM PUBLIC;
REVOKE ALL ON TABLE perfil_id_seq FROM sagui;
GRANT ALL ON TABLE perfil_id_seq TO sagui;
GRANT ALL ON TABLE perfil_id_seq TO apache;


--
-- Name: perfildeuso; Type: ACL; Schema: public; Owner: sagui
--

REVOKE ALL ON TABLE perfildeuso FROM PUBLIC;
REVOKE ALL ON TABLE perfildeuso FROM sagui;
GRANT ALL ON TABLE perfildeuso TO sagui;
GRANT ALL ON TABLE perfildeuso TO apache;


--
-- Name: perfildeuso_id_seq; Type: ACL; Schema: public; Owner: sagui
--

REVOKE ALL ON TABLE perfildeuso_id_seq FROM PUBLIC;
REVOKE ALL ON TABLE perfildeuso_id_seq FROM sagui;
GRANT ALL ON TABLE perfildeuso_id_seq TO sagui;
GRANT ALL ON TABLE perfildeuso_id_seq TO apache;


--
-- Name: perfildeusomenu; Type: ACL; Schema: public; Owner: sagui
--

REVOKE ALL ON TABLE perfildeusomenu FROM PUBLIC;
REVOKE ALL ON TABLE perfildeusomenu FROM sagui;
GRANT ALL ON TABLE perfildeusomenu TO sagui;
GRANT ALL ON TABLE perfildeusomenu TO apache;


--
-- Name: rede; Type: ACL; Schema: public; Owner: sagui
--

REVOKE ALL ON TABLE rede FROM PUBLIC;
REVOKE ALL ON TABLE rede FROM sagui;
GRANT ALL ON TABLE rede TO sagui;
GRANT ALL ON TABLE rede TO apache;


--
-- Name: rede_id_seq; Type: ACL; Schema: public; Owner: sagui
--

REVOKE ALL ON TABLE rede_id_seq FROM PUBLIC;
REVOKE ALL ON TABLE rede_id_seq FROM sagui;
GRANT ALL ON TABLE rede_id_seq TO sagui;
GRANT ALL ON TABLE rede_id_seq TO apache;


--
-- Name: scriptpatch; Type: ACL; Schema: public; Owner: sagui
--

REVOKE ALL ON TABLE scriptpatch FROM PUBLIC;
REVOKE ALL ON TABLE scriptpatch FROM sagui;
GRANT ALL ON TABLE scriptpatch TO sagui;
GRANT ALL ON TABLE scriptpatch TO apache;


--
-- Name: scriptpatch_id_seq; Type: ACL; Schema: public; Owner: sagui
--

REVOKE ALL ON TABLE scriptpatch_id_seq FROM PUBLIC;
REVOKE ALL ON TABLE scriptpatch_id_seq FROM sagui;
GRANT ALL ON TABLE scriptpatch_id_seq TO sagui;
GRANT ALL ON TABLE scriptpatch_id_seq TO apache;


--
-- Name: seq_perfil; Type: ACL; Schema: public; Owner: sagui
--

REVOKE ALL ON TABLE seq_perfil FROM PUBLIC;
REVOKE ALL ON TABLE seq_perfil FROM sagui;
GRANT ALL ON TABLE seq_perfil TO sagui;
GRANT ALL ON TABLE seq_perfil TO apache;


--
-- Name: submenu; Type: ACL; Schema: public; Owner: sagui
--

REVOKE ALL ON TABLE submenu FROM PUBLIC;
REVOKE ALL ON TABLE submenu FROM sagui;
GRANT ALL ON TABLE submenu TO sagui;
GRANT ALL ON TABLE submenu TO apache;


--
-- Name: submenu_id_seq; Type: ACL; Schema: public; Owner: sagui
--

REVOKE ALL ON TABLE submenu_id_seq FROM PUBLIC;
REVOKE ALL ON TABLE submenu_id_seq FROM sagui;
GRANT ALL ON TABLE submenu_id_seq TO sagui;
GRANT ALL ON TABLE submenu_id_seq TO apache;


--
-- Name: tipoarquivo; Type: ACL; Schema: public; Owner: sagui
--

REVOKE ALL ON TABLE tipoarquivo FROM PUBLIC;
REVOKE ALL ON TABLE tipoarquivo FROM sagui;
GRANT ALL ON TABLE tipoarquivo TO sagui;
GRANT ALL ON TABLE tipoarquivo TO apache;


--
-- Name: tipoarquivo_id_seq; Type: ACL; Schema: public; Owner: sagui
--

REVOKE ALL ON TABLE tipoarquivo_id_seq FROM PUBLIC;
REVOKE ALL ON TABLE tipoarquivo_id_seq FROM sagui;
GRANT ALL ON TABLE tipoarquivo_id_seq TO sagui;
GRANT ALL ON TABLE tipoarquivo_id_seq TO apache;


--
-- Name: tipoevento; Type: ACL; Schema: public; Owner: sagui
--

REVOKE ALL ON TABLE tipoevento FROM PUBLIC;
REVOKE ALL ON TABLE tipoevento FROM sagui;
GRANT ALL ON TABLE tipoevento TO sagui;
GRANT ALL ON TABLE tipoevento TO apache;


--
-- Name: tipoevento_id_seq; Type: ACL; Schema: public; Owner: sagui
--

REVOKE ALL ON TABLE tipoevento_id_seq FROM PUBLIC;
REVOKE ALL ON TABLE tipoevento_id_seq FROM sagui;
GRANT ALL ON TABLE tipoevento_id_seq TO sagui;
GRANT ALL ON TABLE tipoevento_id_seq TO apache;


--
-- Name: unidade; Type: ACL; Schema: public; Owner: sagui
--

REVOKE ALL ON TABLE unidade FROM PUBLIC;
REVOKE ALL ON TABLE unidade FROM sagui;
GRANT ALL ON TABLE unidade TO sagui;
GRANT ALL ON TABLE unidade TO apache;


--
-- Name: unidade_id_seq; Type: ACL; Schema: public; Owner: sagui
--

REVOKE ALL ON TABLE unidade_id_seq FROM PUBLIC;
REVOKE ALL ON TABLE unidade_id_seq FROM sagui;
GRANT ALL ON TABLE unidade_id_seq TO sagui;
GRANT ALL ON TABLE unidade_id_seq TO apache;


--
-- Name: unidadeparametroslocais; Type: ACL; Schema: public; Owner: sagui
--

REVOKE ALL ON TABLE unidadeparametroslocais FROM PUBLIC;
REVOKE ALL ON TABLE unidadeparametroslocais FROM sagui;
GRANT ALL ON TABLE unidadeparametroslocais TO sagui;
GRANT ALL ON TABLE unidadeparametroslocais TO apache;


--
-- Name: usuario; Type: ACL; Schema: public; Owner: sagui
--

REVOKE ALL ON TABLE usuario FROM PUBLIC;
REVOKE ALL ON TABLE usuario FROM sagui;
GRANT ALL ON TABLE usuario TO sagui;
GRANT ALL ON TABLE usuario TO apache;


--
-- Name: usuario_id_seq; Type: ACL; Schema: public; Owner: sagui
--

REVOKE ALL ON TABLE usuario_id_seq FROM PUBLIC;
REVOKE ALL ON TABLE usuario_id_seq FROM sagui;
GRANT ALL ON TABLE usuario_id_seq TO sagui;
GRANT ALL ON TABLE usuario_id_seq TO apache;


--
-- Name: versaoscriptpatch; Type: ACL; Schema: public; Owner: sagui
--

REVOKE ALL ON TABLE versaoscriptpatch FROM PUBLIC;
REVOKE ALL ON TABLE versaoscriptpatch FROM sagui;
GRANT ALL ON TABLE versaoscriptpatch TO sagui;
GRANT ALL ON TABLE versaoscriptpatch TO apache;


--
-- Name: vw_lista_atributos; Type: ACL; Schema: public; Owner: sagui
--

REVOKE ALL ON TABLE vw_lista_atributos FROM PUBLIC;
REVOKE ALL ON TABLE vw_lista_atributos FROM sagui;
GRANT ALL ON TABLE vw_lista_atributos TO sagui;
GRANT ALL ON TABLE vw_lista_atributos TO apache;


--
-- Name: vw_lista_log_erro_patch; Type: ACL; Schema: public; Owner: sagui
--

REVOKE ALL ON TABLE vw_lista_log_erro_patch FROM PUBLIC;
REVOKE ALL ON TABLE vw_lista_log_erro_patch FROM sagui;
GRANT ALL ON TABLE vw_lista_log_erro_patch TO sagui;
GRANT ALL ON TABLE vw_lista_log_erro_patch TO apache;


--
-- Name: vw_lista_log_erro_patch_last; Type: ACL; Schema: public; Owner: sagui
--

REVOKE ALL ON TABLE vw_lista_log_erro_patch_last FROM PUBLIC;
REVOKE ALL ON TABLE vw_lista_log_erro_patch_last FROM sagui;
GRANT ALL ON TABLE vw_lista_log_erro_patch_last TO sagui;
GRANT ALL ON TABLE vw_lista_log_erro_patch_last TO apache;


--
-- Name: vw_lista_log_ok_patch; Type: ACL; Schema: public; Owner: sagui
--

REVOKE ALL ON TABLE vw_lista_log_ok_patch FROM PUBLIC;
REVOKE ALL ON TABLE vw_lista_log_ok_patch FROM sagui;
GRANT ALL ON TABLE vw_lista_log_ok_patch TO sagui;
GRANT ALL ON TABLE vw_lista_log_ok_patch TO apache;


--
-- Name: vw_lista_patchs; Type: ACL; Schema: public; Owner: sagui
--

REVOKE ALL ON TABLE vw_lista_patchs FROM PUBLIC;
REVOKE ALL ON TABLE vw_lista_patchs FROM sagui;
GRANT ALL ON TABLE vw_lista_patchs TO sagui;
GRANT ALL ON TABLE vw_lista_patchs TO apache;


--
-- Name: vw_lista_scripts; Type: ACL; Schema: public; Owner: sagui
--

REVOKE ALL ON TABLE vw_lista_scripts FROM PUBLIC;
REVOKE ALL ON TABLE vw_lista_scripts FROM sagui;
GRANT ALL ON TABLE vw_lista_scripts TO sagui;
GRANT ALL ON TABLE vw_lista_scripts TO apache;


--
-- Name: vw_patch_ok_unidade; Type: ACL; Schema: public; Owner: sagui
--

REVOKE ALL ON TABLE vw_patch_ok_unidade FROM PUBLIC;
REVOKE ALL ON TABLE vw_patch_ok_unidade FROM sagui;
GRANT ALL ON TABLE vw_patch_ok_unidade TO sagui;
GRANT ALL ON TABLE vw_patch_ok_unidade TO apache;


--
-- PostgreSQL database dump complete
--

