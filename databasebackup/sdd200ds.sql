--
-- PostgreSQL database dump
--

-- Dumped from database version 16.1
-- Dumped by pg_dump version 16.1

-- Started on 2024-06-19 10:37:53

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
-- TOC entry 244 (class 1259 OID 41834)
-- Name: sdd200ds; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.sdd200ds (
    id bigint NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    sdd200d_plan_asignatura_id bigint NOT NULL,
    sdd200d_cod_carr character(4) NOT NULL,
    sdd200d_cod_asign character(8) NOT NULL,
    sdd200d_nom_asign character(40) NOT NULL,
    sdd200d_lapso_vigencia character(6) NOT NULL,
    sdd200d_inferior_asignado character(8),
    sdd200d_superior_asignado character(8) NOT NULL,
    sdd200d_estado character(2) NOT NULL,
    sdd200d_version smallint DEFAULT '1'::smallint NOT NULL
);


ALTER TABLE public.sdd200ds OWNER TO postgres;

--
-- TOC entry 4908 (class 0 OID 0)
-- Dependencies: 244
-- Name: COLUMN sdd200ds.sdd200d_plan_asignatura_id; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN public.sdd200ds.sdd200d_plan_asignatura_id IS 'id del plan de la asignatura presente en la tabla sdd090ds';


--
-- TOC entry 4909 (class 0 OID 0)
-- Dependencies: 244
-- Name: COLUMN sdd200ds.sdd200d_cod_carr; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN public.sdd200ds.sdd200d_cod_carr IS 'codigo de la carrera';


--
-- TOC entry 4910 (class 0 OID 0)
-- Dependencies: 244
-- Name: COLUMN sdd200ds.sdd200d_cod_asign; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN public.sdd200ds.sdd200d_cod_asign IS 'codigo de la asignatura';


--
-- TOC entry 4911 (class 0 OID 0)
-- Dependencies: 244
-- Name: COLUMN sdd200ds.sdd200d_nom_asign; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN public.sdd200ds.sdd200d_nom_asign IS 'nombre de la asignatura';


--
-- TOC entry 4912 (class 0 OID 0)
-- Dependencies: 244
-- Name: COLUMN sdd200ds.sdd200d_lapso_vigencia; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN public.sdd200ds.sdd200d_lapso_vigencia IS 'lapso de vigencia de codigo de asignatura';


--
-- TOC entry 4913 (class 0 OID 0)
-- Dependencies: 244
-- Name: COLUMN sdd200ds.sdd200d_inferior_asignado; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN public.sdd200ds.sdd200d_inferior_asignado IS 'Persona asignada, no puede reasignar plan';


--
-- TOC entry 4914 (class 0 OID 0)
-- Dependencies: 244
-- Name: COLUMN sdd200ds.sdd200d_superior_asignado; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN public.sdd200ds.sdd200d_superior_asignado IS 'Persona asignada, puede reasignar plan';


--
-- TOC entry 4915 (class 0 OID 0)
-- Dependencies: 244
-- Name: COLUMN sdd200ds.sdd200d_estado; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN public.sdd200ds.sdd200d_estado IS 'estado del plan';


--
-- TOC entry 4916 (class 0 OID 0)
-- Dependencies: 244
-- Name: COLUMN sdd200ds.sdd200d_version; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN public.sdd200ds.sdd200d_version IS 'Version del plan';


--
-- TOC entry 243 (class 1259 OID 41833)
-- Name: sdd200ds_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.sdd200ds_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.sdd200ds_id_seq OWNER TO postgres;

--
-- TOC entry 4917 (class 0 OID 0)
-- Dependencies: 243
-- Name: sdd200ds_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.sdd200ds_id_seq OWNED BY public.sdd200ds.id;


--
-- TOC entry 4754 (class 2604 OID 41837)
-- Name: sdd200ds id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sdd200ds ALTER COLUMN id SET DEFAULT nextval('public.sdd200ds_id_seq'::regclass);


--
-- TOC entry 4902 (class 0 OID 41834)
-- Dependencies: 244
-- Data for Name: sdd200ds; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.sdd200ds (id, created_at, updated_at, sdd200d_plan_asignatura_id, sdd200d_cod_carr, sdd200d_cod_asign, sdd200d_nom_asign, sdd200d_lapso_vigencia, sdd200d_inferior_asignado, sdd200d_superior_asignado, sdd200d_estado, sdd200d_version) FROM stdin;
35	2024-05-06 13:50:13	2024-05-06 13:50:42	2044	2072	1472101 	COMPRENSIÓN Y EXPRESIÓN LINGÜÍS         	201401	        	20789650	rj	1
\.


--
-- TOC entry 4918 (class 0 OID 0)
-- Dependencies: 243
-- Name: sdd200ds_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.sdd200ds_id_seq', 35, true);


--
-- TOC entry 4757 (class 2606 OID 41839)
-- Name: sdd200ds sdd200ds_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sdd200ds
    ADD CONSTRAINT sdd200ds_pkey PRIMARY KEY (id);


-- Completed on 2024-06-19 10:37:56

--
-- PostgreSQL database dump complete
--

