--
-- PostgreSQL database dump
--

-- Dumped from database version 16.1
-- Dumped by pg_dump version 16.1

-- Started on 2024-06-19 10:33:27

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
-- TOC entry 246 (class 1259 OID 41853)
-- Name: sdd210ds; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.sdd210ds (
    id bigint NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    sdd210d_cod_carr character(4) NOT NULL,
    sdd210d_cod_asign character(8) NOT NULL,
    sdd210d_lapso_vigencia character(40) NOT NULL,
    sdd210ds_as_proposito text,
    sdd210ds_as_competencias_genericas text,
    sdd210ds_a_competencias_profesionales text,
    sdd210ds_s_competencias_profesionales_basicas text,
    sdd210ds_s_competencias_profesionales_especificas text,
    sdd210ds_a_competencias_unidad_curricular text,
    sdd210ds_a_valores_actitudes text,
    sdd210ds_as_estrategias_didacticas text,
    sdd210ds_as_estrategias_docentes text,
    sdd210ds_as_estrategias_aprendizajes text,
    sdd210ds_as_bibliografia text,
    sdd210ds_version smallint DEFAULT '1'::smallint NOT NULL,
    sdd210ds_r_capacidades_profesionales text,
    sdd210ds_r_capacidades text,
    sdd210ds_r_habilidades text,
    sdd210ds_r_red_tematica text,
    sdd210ds_r_red_tematica_foto text,
    sdd210ds_r_descripcion_red_tematica text,
    sdd210ds_estado character(2) DEFAULT ''::bpchar NOT NULL
);


ALTER TABLE public.sdd210ds OWNER TO postgres;

--
-- TOC entry 4909 (class 0 OID 0)
-- Dependencies: 246
-- Name: COLUMN sdd210ds.sdd210d_cod_carr; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN public.sdd210ds.sdd210d_cod_carr IS 'codigo de la carrera';


--
-- TOC entry 4910 (class 0 OID 0)
-- Dependencies: 246
-- Name: COLUMN sdd210ds.sdd210d_cod_asign; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN public.sdd210ds.sdd210d_cod_asign IS 'codigo de la asignatura';


--
-- TOC entry 4911 (class 0 OID 0)
-- Dependencies: 246
-- Name: COLUMN sdd210ds.sdd210d_lapso_vigencia; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN public.sdd210ds.sdd210d_lapso_vigencia IS 'nombre de la asignatura';


--
-- TOC entry 4912 (class 0 OID 0)
-- Dependencies: 246
-- Name: COLUMN sdd210ds.sdd210ds_as_proposito; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN public.sdd210ds.sdd210ds_as_proposito IS 'Proposito de la asignatura. Compartido por plan analitico y sinoptico.';


--
-- TOC entry 4913 (class 0 OID 0)
-- Dependencies: 246
-- Name: COLUMN sdd210ds.sdd210ds_version; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN public.sdd210ds.sdd210ds_version IS 'Version del plan';


--
-- TOC entry 4914 (class 0 OID 0)
-- Dependencies: 246
-- Name: COLUMN sdd210ds.sdd210ds_estado; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN public.sdd210ds.sdd210ds_estado IS 'Estado del plan';


--
-- TOC entry 245 (class 1259 OID 41852)
-- Name: sdd210ds_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.sdd210ds_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.sdd210ds_id_seq OWNER TO postgres;

--
-- TOC entry 4915 (class 0 OID 0)
-- Dependencies: 245
-- Name: sdd210ds_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.sdd210ds_id_seq OWNED BY public.sdd210ds.id;


--
-- TOC entry 4754 (class 2604 OID 41856)
-- Name: sdd210ds id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sdd210ds ALTER COLUMN id SET DEFAULT nextval('public.sdd210ds_id_seq'::regclass);


--
-- TOC entry 4903 (class 0 OID 41853)
-- Dependencies: 246
-- Data for Name: sdd210ds; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.sdd210ds (id, created_at, updated_at, sdd210d_cod_carr, sdd210d_cod_asign, sdd210d_lapso_vigencia, sdd210ds_as_proposito, sdd210ds_as_competencias_genericas, sdd210ds_a_competencias_profesionales, sdd210ds_s_competencias_profesionales_basicas, sdd210ds_s_competencias_profesionales_especificas, sdd210ds_a_competencias_unidad_curricular, sdd210ds_a_valores_actitudes, sdd210ds_as_estrategias_didacticas, sdd210ds_as_estrategias_docentes, sdd210ds_as_estrategias_aprendizajes, sdd210ds_as_bibliografia, sdd210ds_version, sdd210ds_r_capacidades_profesionales, sdd210ds_r_capacidades, sdd210ds_r_habilidades, sdd210ds_r_red_tematica, sdd210ds_r_red_tematica_foto, sdd210ds_r_descripcion_red_tematica, sdd210ds_estado) FROM stdin;
29	2024-05-06 13:03:06	2024-05-06 13:44:29	2072	1472101 	201401                                  	version 1 modi	\N	\N	\N	\N	\N	{"time":1715000610389,"blocks":[],"version":"2.29.1"}	\N	{"time":1715000610389,"blocks":[],"version":"2.29.1"}	{"time":1715000610389,"blocks":[],"version":"2.29.1"}	\N	1	{"time":1715000610389,"blocks":[],"version":"2.29.1"}	{"time":1715000610388,"blocks":[],"version":"2.29.1"}	{"time":1715000610389,"blocks":[],"version":"2.29.1"}	{"time":1715000610389,"blocks":[],"version":"2.29.1"}	\N	\N	v 
30	2024-05-06 13:07:15	2024-05-06 13:44:29	2072	1472101 	201401                                  	version 1 modi	\N	\N	\N	\N	\N	{"time":1715003069164,"blocks":[],"version":"2.29.1"}	\N	{"time":1715003069164,"blocks":[],"version":"2.29.1"}	{"time":1715003069164,"blocks":[],"version":"2.29.1"}	\N	2	{"time":1715003069164,"blocks":[],"version":"2.29.1"}	{"time":1715003069163,"blocks":[],"version":"2.29.1"}	{"time":1715003069164,"blocks":[],"version":"2.29.1"}	{"time":1715003069164,"blocks":[],"version":"2.29.1"}	\N	\N	a 
31	2024-05-06 13:49:55	2024-05-06 13:50:42	2072	1472101 	201401                                  	version 3 modi	\N	\N	\N	\N	\N	{"time":1715003442125,"blocks":[],"version":"2.29.1"}	\N	{"time":1715003442125,"blocks":[],"version":"2.29.1"}	{"time":1715003442125,"blocks":[],"version":"2.29.1"}	\N	3	{"time":1715003442125,"blocks":[],"version":"2.29.1"}	{"time":1715003442125,"blocks":[],"version":"2.29.1"}	{"time":1715003442125,"blocks":[],"version":"2.29.1"}	{"time":1715003442125,"blocks":[],"version":"2.29.1"}	\N	\N	rj
\.


--
-- TOC entry 4916 (class 0 OID 0)
-- Dependencies: 245
-- Name: sdd210ds_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.sdd210ds_id_seq', 31, true);


--
-- TOC entry 4758 (class 2606 OID 41861)
-- Name: sdd210ds sdd210ds_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sdd210ds
    ADD CONSTRAINT sdd210ds_pkey PRIMARY KEY (id);


-- Completed on 2024-06-19 10:33:31

--
-- PostgreSQL database dump complete
--

