--
-- PostgreSQL database dump
--

-- Dumped from database version 16.2
-- Dumped by pg_dump version 16.2

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- Name: categorias; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.categorias (
    id_categoria integer NOT NULL,
    nombre character varying(50) NOT NULL,
    descripcion text
);


ALTER TABLE public.categorias OWNER TO postgres;

--
-- Name: categorias_id_categoria_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.categorias_id_categoria_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.categorias_id_categoria_seq OWNER TO postgres;

--
-- Name: categorias_id_categoria_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.categorias_id_categoria_seq OWNED BY public.categorias.id_categoria;


--
-- Name: centros_logisticos; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.centros_logisticos (
    id_centro integer NOT NULL,
    nombre character varying(100) NOT NULL,
    id_categoria integer NOT NULL,
    longitud numeric(10,8),
    latitud numeric(10,8),
    horario_operacion character varying(100),
    capacidad integer,
    tipos_recursos character varying(200),
    zona_cobertura character varying(100),
    contacto character varying(100),
    descripcion text
);


ALTER TABLE public.centros_logisticos OWNER TO postgres;

--
-- Name: centros_logisticos_id_centro_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.centros_logisticos_id_centro_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.centros_logisticos_id_centro_seq OWNER TO postgres;

--
-- Name: centros_logisticos_id_centro_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.centros_logisticos_id_centro_seq OWNED BY public.centros_logisticos.id_centro;


--
-- Name: rutas; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.rutas (
    id_ruta integer NOT NULL,
    id_centro_origen integer NOT NULL,
    id_centro_destino integer NOT NULL,
    distancia real NOT NULL,
    tiempo_estimado time without time zone NOT NULL
);


ALTER TABLE public.rutas OWNER TO postgres;

--
-- Name: rutas_id_ruta_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.rutas_id_ruta_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.rutas_id_ruta_seq OWNER TO postgres;

--
-- Name: rutas_id_ruta_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.rutas_id_ruta_seq OWNED BY public.rutas.id_ruta;


--
-- Name: usuarios; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.usuarios (
    id_usuario integer NOT NULL,
    nombre character varying(100) NOT NULL,
    correo character varying(100) NOT NULL,
    contrasena character varying(255) NOT NULL,
    rol character varying(50) NOT NULL
);


ALTER TABLE public.usuarios OWNER TO postgres;

--
-- Name: usuarios_id_usuario_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.usuarios_id_usuario_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.usuarios_id_usuario_seq OWNER TO postgres;

--
-- Name: usuarios_id_usuario_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.usuarios_id_usuario_seq OWNED BY public.usuarios.id_usuario;


--
-- Name: categorias id_categoria; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.categorias ALTER COLUMN id_categoria SET DEFAULT nextval('public.categorias_id_categoria_seq'::regclass);


--
-- Name: centros_logisticos id_centro; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.centros_logisticos ALTER COLUMN id_centro SET DEFAULT nextval('public.centros_logisticos_id_centro_seq'::regclass);


--
-- Name: rutas id_ruta; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.rutas ALTER COLUMN id_ruta SET DEFAULT nextval('public.rutas_id_ruta_seq'::regclass);


--
-- Name: usuarios id_usuario; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.usuarios ALTER COLUMN id_usuario SET DEFAULT nextval('public.usuarios_id_usuario_seq'::regclass);


--
-- Data for Name: categorias; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.categorias (id_categoria, nombre, descripcion) FROM stdin;
2	Distribuidora	Empresa encargada de distribuir productos a tiendas y empresas
3	Comercializadora	Empresa encargada de la venta directa de productos
4	Fabrica	Lugar donde se producen bienes o productos
1	Importadora	Empresa encargada de traer productos del exteriorrrr
6	cerros	cerros
\.


--
-- Data for Name: centros_logisticos; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.centros_logisticos (id_centro, nombre, id_categoria, longitud, latitud, horario_operacion, capacidad, tipos_recursos, zona_cobertura, contacto, descripcion) FROM stdin;
2	DISTRIBUIDORA E.L.R. Suc. 1	2	-64.74308375	-21.52014976	08:00-18:00	1000	Distrubuidora de Baterias Vehiculares	Zona Norte	contacto_elr@example.com	\N
3	Distribuidora DyM	2	-64.73113154	-21.53529138	09:00-19:00	800	Distrubuidora de Comercio	Zona Centro	contacto_dym@example.com	\N
4	Dimasur Ltda	2	-64.73705236	-21.53325270	07:30-18:30	500	Distribución y Marketing del Sur	Zona Sur	contacto_dimasur@example.com	\N
5	Distribuidora San Lucas	2	-64.73203244	-21.53503158	08:00-16:00	700	Distribuidora de Material Farmacéutico	Zona Este	contacto_sanlucas@example.com	\N
6	Importadora Jasel	1	-64.74439177	-21.55728892	08:00-18:00	1200	Importadora de Equipos y Accesorios Medicos	Zona Oeste	contacto_jasel@example.com	\N
7	Distribuidora Coca Cola	2	-64.69898084	-21.55269214	08:00-20:00	2000	Distribuidora de Bebidas de Coca Cola	Zona Sur	contacto_cocacola@example.com	\N
8	IMPORTADORA FALUMAR	1	-64.73715669	-21.51388354	09:00-17:00	1000	Importadora de Juguetes	Zona Centro	contacto_falumar@example.com	\N
9	Importadora MegaPisos	1	-64.73821199	-21.52484750	08:30-18:30	800	Importadora de Articulos para el Hogar	Zona Norte	contacto_megapisos@example.com	\N
10	Importadora “Jhon Marco” - Sucursal Tarija	1	-64.73701036	-21.51736186	10:00-16:00	600	Importadora de Prendas de Vestir	Zona Oeste	contacto_jhonmarco@example.com	\N
11	Importaciones Tarija	1	-64.73355221	-21.53119547	07:00-15:00	500	Importadora de Articulos Electrónicos	Zona Este	contacto_importaciones@example.com	\N
12	Importadora Casa Peavey	1	-64.73238130	-21.52967797	08:00-18:00	700	Importadora de Instrumentos Musicales	Zona Centro	contacto_peavey@example.com	\N
13	Importadora Grupo Gallardo	1	-64.73810386	-21.53385560	08:00-19:00	900	Empresa de importación y exportación	Zona Norte	contacto_gallardo@example.com	\N
14	Importadora Monterrey Suc 19 Tarija	1	-64.69881395	-21.54667325	08:30-17:30	1500	Importadora encargada de distribuidor de acero	Zona Sur	contacto_monterrey@example.com	\N
15	Importadora & Comercializadora DARELI	3	-64.75397905	-21.50016697	08:00-18:00	2000	Distribuidora de piezas y accesorios de vehículos, material de construcción, ferretería.	Zona Este	contacto_dareli@example.com	\N
16	DISTRIBUIDORA Morales Ltda.	2	-64.72501917	-21.54086812	07:00-15:00	1000	Distribuidora de materiales para la construcción	Zona Centro	contacto_morales@example.com	\N
17	Importaciones Cesar	1	-64.73937496	-21.51475307	08:00-18:00	700	Importadora de cerámica	Zona Oeste	contacto_cesar@example.com	\N
18	Importadora Yuli Tarija	1	-64.73710730	-21.52561881	09:00-17:00	900	Distribución de equipamiento y maquinaria industrial	Zona Norte	contacto_yuli@example.com	\N
19	Importadora El Circulo	1	-64.73358824	-21.53048923	08:00-18:00	1000	Distribución de lanas	Zona Este	contacto_circulo@example.com	\N
20	IMPORTACIONES PUMA	1	-64.73678412	-21.51419902	09:00-17:00	800	Distribuidor de materiales de construcción	Zona Oeste	contacto_puma@example.com	\N
21	Importadora Agencias Generales Tarija	1	-64.72233740	-21.52712455	07:00-15:00	600	Distribuidor de herramientas industriales	Zona Sur	contacto_generales@example.com	\N
22	Importadora Wasgab	1	-64.73556146	-21.52110756	08:30-17:30	1200	Importadora en general	Zona Centro	contacto_wasgab@example.com	\N
23	Importadora NISOL Michelin y BfGoodrich	1	-64.74371537	-21.51921119	08:00-19:00	1100	Distribuidor de llantas para vehículos	Zona Norte	contacto_nisol@example.com	\N
24	Importadora Campero - Chaco	1	-64.68000799	-21.55945593	07:30-16:30	1000	Distribuidor de materiales para la construcción	Zona Este	contacto_campero@example.com	\N
25	Mundo Industrial - Acero Inoxidable	4	-64.69069692	-21.55257521	08:00-18:00	1500	Fabrica de suministros industriales	Zona Sur	contacto_mundo@example.com	\N
26	SOBOLMA LTDA. Suc. 15	4	-64.72957305	-21.51885770	09:00-19:00	1300	Venta de madera	Zona Oeste	contacto_sobolma@example.com	\N
27	TABLENEX - TABLEROS Y MELAMINA	4	-64.73129148	-21.51168235	08:00-18:00	800	Fábrica de muebles	Zona Centro	contacto_tablenex@example.com	\N
28	Multicenter / Tarija	3	-64.73480544	-21.53429914	08:00-20:00	2000	Tienda de artículos para el hogar	Zona Norte	contacto_multicenter@example.com	\N
29	Berenice	3	-64.73217293	-21.53451040	10:00-18:00	700	Tienda de ropa	Zona Centro	contacto_berenice@example.com	\N
30	Comercializadora RuizMer	3	-64.73877534	-21.51622296	08:00-18:00	900	Tienda de herramientas	Zona Sur	contacto_ruizmer@example.com	\N
31	Comercial Bolívar	3	-64.72750826	-21.53301148	09:00-18:00	800	Tienda de electrodomésticos	Zona Oeste	contacto_bolivar@example.com	\N
32	Centro de Prueba	1	-64.73250000	-21.53210000	09:00-18:00	50	Recursos Humanos	Zona Norte	contacto@ejemplo.com	\N
34	o	3	-64.65927605	-21.52282636	00:00	0	0	0	0	o
35	f	2	-64.69275002	-21.51516095	2	2	f	f	f	f
36	c	2	-64.71231942	-21.51212662	2	2	c	c	c	c
37	cerro	6	-64.67472557	-21.52606540	8 a 9	100	Tierra	cerro	66666	cerro
\.


--
-- Data for Name: rutas; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.rutas (id_ruta, id_centro_origen, id_centro_destino, distancia, tiempo_estimado) FROM stdin;
1	29	28	2	00:30:00
44	5	2	3.5	00:10:00
45	5	3	6	00:15:00
46	5	4	8	00:20:00
47	2	15	3.5	00:10:00
48	2	3	2.5	00:08:00
49	2	5	10	00:25:00
50	3	15	6	00:15:00
51	3	4	4.5	00:12:00
52	3	6	12	00:30:00
53	4	2	8	00:20:00
54	4	3	4.5	00:12:00
55	4	7	15	00:35:00
56	5	15	10	00:25:00
57	5	6	5	00:15:00
58	5	8	20	00:50:00
59	13	2	25	01:00:00
60	13	3	18.5	00:45:00
61	13	9	22	00:55:00
62	30	15	3	00:08:00
63	30	2	2	00:05:00
64	30	10	8.5	00:20:00
65	31	28	78	10:15:00
66	15	28	0	00:00:00
\.


--
-- Data for Name: usuarios; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.usuarios (id_usuario, nombre, correo, contrasena, rol) FROM stdin;
5	operador	operador@example.com	123456789	operador
3	administrador	admin@example.com	12345	admin
\.


--
-- Name: categorias_id_categoria_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.categorias_id_categoria_seq', 6, true);


--
-- Name: centros_logisticos_id_centro_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.centros_logisticos_id_centro_seq', 37, true);


--
-- Name: rutas_id_ruta_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.rutas_id_ruta_seq', 67, true);


--
-- Name: usuarios_id_usuario_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.usuarios_id_usuario_seq', 4, true);


--
-- Name: categorias categorias_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.categorias
    ADD CONSTRAINT categorias_pkey PRIMARY KEY (id_categoria);


--
-- Name: centros_logisticos centros_logisticos_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.centros_logisticos
    ADD CONSTRAINT centros_logisticos_pkey PRIMARY KEY (id_centro);


--
-- Name: rutas rutas_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.rutas
    ADD CONSTRAINT rutas_pkey PRIMARY KEY (id_ruta);


--
-- Name: usuarios usuarios_correo_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.usuarios
    ADD CONSTRAINT usuarios_correo_key UNIQUE (correo);


--
-- Name: usuarios usuarios_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.usuarios
    ADD CONSTRAINT usuarios_pkey PRIMARY KEY (id_usuario);


--
-- Name: centros_logisticos fk_categoria; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.centros_logisticos
    ADD CONSTRAINT fk_categoria FOREIGN KEY (id_categoria) REFERENCES public.categorias(id_categoria) ON DELETE CASCADE;


--
-- Name: rutas fk_centro_destino; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.rutas
    ADD CONSTRAINT fk_centro_destino FOREIGN KEY (id_centro_destino) REFERENCES public.centros_logisticos(id_centro) ON DELETE CASCADE;


--
-- Name: rutas fk_centro_origen; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.rutas
    ADD CONSTRAINT fk_centro_origen FOREIGN KEY (id_centro_origen) REFERENCES public.centros_logisticos(id_centro) ON DELETE CASCADE;


--
-- PostgreSQL database dump complete
--

