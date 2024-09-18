--
-- PostgreSQL database dump
--

-- Dumped from database version 16.1
-- Dumped by pg_dump version 16.1

-- Started on 2024-06-19 10:46:54

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
-- TOC entry 242 (class 1259 OID 41802)
-- Name: sdd100ds; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.sdd100ds (
    id bigint NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    sdd100d_cod_carr character(4) NOT NULL,
    sdd100d_cod_plan character(2) NOT NULL,
    sdd100d_lapso character(6) NOT NULL,
    sdd100d_status character(6) NOT NULL,
    sdd100d_total_uc integer,
    sdd100d_total_uc_tecnico integer,
    sdd100d_nivel character(1),
    sdd100d_total_electivas integer,
    "sdd100d_aplica_PID" character(1),
    sdd100d_aplica_tecnico character(1),
    sdd100d_pasantia_y_tg character(1),
    "sdd100d_aplica_EJE" character(1),
    "sdd100d_aplica_PASANTIA" character(1),
    sdd100d_nuevo character(1),
    sdd100d_total_nivel character(2)
);


ALTER TABLE public.sdd100ds OWNER TO postgres;

--
-- TOC entry 4907 (class 0 OID 0)
-- Dependencies: 242
-- Name: COLUMN sdd100ds.sdd100d_cod_carr; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN public.sdd100ds.sdd100d_cod_carr IS 'codigo de la carrera';


--
-- TOC entry 4908 (class 0 OID 0)
-- Dependencies: 242
-- Name: COLUMN sdd100ds.sdd100d_cod_plan; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN public.sdd100ds.sdd100d_cod_plan IS 'codigo del plan';


--
-- TOC entry 4909 (class 0 OID 0)
-- Dependencies: 242
-- Name: COLUMN sdd100ds.sdd100d_lapso; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN public.sdd100ds.sdd100d_lapso IS 'lapso academico de vigencia del plan';


--
-- TOC entry 4910 (class 0 OID 0)
-- Dependencies: 242
-- Name: COLUMN sdd100ds.sdd100d_status; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN public.sdd100ds.sdd100d_status IS 'Estado del pensum';


--
-- TOC entry 4911 (class 0 OID 0)
-- Dependencies: 242
-- Name: COLUMN sdd100ds.sdd100d_pasantia_y_tg; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN public.sdd100ds.sdd100d_pasantia_y_tg IS 'Determina si el estudiante debe cursar pasantia Y trabajo de grado';


--
-- TOC entry 4912 (class 0 OID 0)
-- Dependencies: 242
-- Name: COLUMN sdd100ds.sdd100d_nuevo; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN public.sdd100ds.sdd100d_nuevo IS 'indica si el plan es nuevo ( S )';


--
-- TOC entry 4913 (class 0 OID 0)
-- Dependencies: 242
-- Name: COLUMN sdd100ds.sdd100d_total_nivel; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN public.sdd100ds.sdd100d_total_nivel IS 'numero total de niveles a alcanzar para aprobar la carrera';


--
-- TOC entry 241 (class 1259 OID 41801)
-- Name: sdd100ds_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.sdd100ds_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.sdd100ds_id_seq OWNER TO postgres;

--
-- TOC entry 4914 (class 0 OID 0)
-- Dependencies: 241
-- Name: sdd100ds_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.sdd100ds_id_seq OWNED BY public.sdd100ds.id;


--
-- TOC entry 4754 (class 2604 OID 41805)
-- Name: sdd100ds id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sdd100ds ALTER COLUMN id SET DEFAULT nextval('public.sdd100ds_id_seq'::regclass);


--
-- TOC entry 4901 (class 0 OID 41802)
-- Dependencies: 242
-- Data for Name: sdd100ds; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.sdd100ds (id, created_at, updated_at, sdd100d_cod_carr, sdd100d_cod_plan, sdd100d_lapso, sdd100d_status, sdd100d_total_uc, sdd100d_total_uc_tecnico, sdd100d_nivel, sdd100d_total_electivas, "sdd100d_aplica_PID", sdd100d_aplica_tecnico, sdd100d_pasantia_y_tg, "sdd100d_aplica_EJE", "sdd100d_aplica_PASANTIA", sdd100d_nuevo, sdd100d_total_nivel) FROM stdin;
1	2024-04-02 23:55:05	2024-04-02 23:55:05	1335	1 	9701  	A     	100	100	S	0	S	S	N	S	S	S	6 
2	2024-04-02 23:56:45	2024-04-02 23:56:45	1335	2 	201503	A     	100	100	S	0	S	S	N	S	S	S	6 
3	2024-04-02 23:56:45	2024-04-02 23:56:45	2072	1 	8802  	A     	139	80	S	0	S	S	N	S	S	N	10
4	2024-04-02 23:56:45	2024-04-02 23:56:45	2072	5 	201401	A     	174	174	S	3	N	N	S	S	S	S	9 
5	2024-04-02 23:56:45	2024-04-02 23:56:45	2115	1 	8802  	A     	151	87	S	0	S	S	N	S	S	N	10
6	2024-04-02 23:56:45	2024-04-02 23:56:45	2115	6 	201401	A     	165	165	S	3	N	N	S	S	S	S	9 
7	2024-04-02 23:56:45	2024-04-02 23:56:45	3024	1 	8802  	A     	165	105	S	0	S	S	N	S	S	N	10
8	2024-04-02 23:56:45	2024-04-02 23:56:45	3024	6 	201401	A     	179	179	S	3	N	N	S	S	S	S	9 
9	2024-04-02 23:56:45	2024-04-02 23:56:45	3025	1 	200701	A     	150	75	N	3	N	N	N	N	S	S	10
10	2024-04-02 23:56:45	2024-04-02 23:56:45	3025	2 	201603	A     	149	75	N	3	N	N	N	N	S	S	10
11	2024-04-02 23:56:45	2024-04-02 23:56:45	5245	3 	9202  	A     	171	104	S	0	S	S	N	S	N	N	10
12	2024-04-02 23:56:45	2024-04-02 23:56:45	5245	4 	200701	A     	151	151	N	3	N	N	N	S	S	S	9 
13	2024-04-02 23:56:45	2024-04-02 23:56:45	5246	2 	201403	A     	144	144	 	3	 	N	N	S	S	S	8 
14	2024-04-02 23:56:45	2024-04-02 23:56:45	5246	1 	201103	A     	136	136	N	3	N	N	S	S	S	S	8 
15	2024-04-02 23:56:45	2024-04-02 23:56:45	5247	1 	201103	A     	131	131	N	3	N	N	S	S	S	S	8 
16	2024-04-02 23:56:45	2024-04-02 23:56:45	5247	2 	201501	A     	130	130	S	3	N	N	N	S	S	S	8 
17	2024-04-02 23:56:45	2024-04-02 23:56:45	5248	2 	201401	A     	140	140	N	3	N	N	N	S	S	S	8 
18	2024-04-02 23:56:45	2024-04-02 23:56:45	5248	1 	201103	A     	138	138	N	3	N	N	S	S	S	N	8 
19	2024-04-02 23:56:45	2024-04-02 23:56:45	6173	1 	200501	A     	97	97	S	0	S	S	N	S	S	N	6 
20	2024-04-02 23:56:45	2024-04-02 23:56:45	6173	2 	201301	A     	95	95	S	0	S	S	N	S	S	S	6 
21	2024-04-02 23:56:45	2024-04-02 23:56:45	6174	1 	201201	A     	99	99	S	0	N	S	N	S	S	S	6 
22	2024-04-02 23:56:45	2024-04-02 23:56:45	6350	4 	200801	A     	139	139	N	4	N	N	S	S	S	S	9 
23	2024-04-02 23:56:45	2024-04-02 23:56:45	6350	1 	8802  	A     	138	80	S	0	S	S	N	S	S	N	10
24	2024-04-02 23:56:45	2024-04-02 23:56:45	6355	1 	8802  	A     	142	80	S	0	S	S	N	S	S	N	10
25	2024-04-02 23:56:45	2024-04-02 23:56:45	6355	2 	200801	A     	136	136	N	3	N	N	S	S	S	S	9 
26	2024-04-02 23:56:45	2024-04-02 23:56:45	6365	1 	201103	A     	144	144	N	3	N	N	S	S	S	S	0 
27	2024-04-02 23:56:45	2024-04-02 23:56:45	6366	1 	201103	A     	145	145	N	3	N	N	S	S	S	S	0 
28	2024-04-02 23:56:45	2024-04-02 23:56:45	2072	3 	9801  	I     	0	0	 	0	 	 	 	 	 	 	0 
29	2024-04-02 23:56:45	2024-04-02 23:56:45	2072	2 	9702  	I     	0	0	 	0	 	 	 	 	 	 	0 
30	2024-04-02 23:56:45	2024-04-02 23:56:45	2072	4 	201203	I     	217	217	S	3	N	N	S	S	S	 	0 
31	2024-04-02 23:56:45	2024-04-02 23:56:45	2072	8 	8802  	I     	139	80	S	0	N	S	N	N	N	N	0 
32	2024-04-02 23:56:45	2024-04-02 23:56:45	2115	3 	200001	I     	0	0	 	0	 	 	 	 	 	 	0 
33	2024-04-02 23:56:45	2024-04-02 23:56:45	2115	4 	200102	I     	0	0	 	0	 	 	 	 	 	 	0 
34	2024-04-02 23:56:45	2024-04-02 23:56:45	2115	2 	9902  	A     	0	0	 	0	 	 	 	 	 	 	0 
35	2024-04-02 23:56:45	2024-04-02 23:56:45	2115	5 	201203	I     	196	196	S	3	N	N	S	S	S	 	0 
36	2024-04-02 23:56:45	2024-04-02 23:56:45	3024	4 	200201	A     	0	0	 	0	 	 	 	 	 	 	0 
37	2024-04-02 23:56:45	2024-04-02 23:56:45	3024	2 	9801  	I     	0	0	 	0	 	 	 	 	 	 	0 
38	2024-04-02 23:56:45	2024-04-02 23:56:45	3024	3 	200002	I     	0	0	 	0	 	 	 	 	 	 	0 
39	2024-04-02 23:56:45	2024-04-02 23:56:45	3024	5 	201203	I     	199	199	S	3	N	N	S	S	S	 	0 
40	2024-04-02 23:56:45	2024-04-02 23:56:45	5245	1 	8802  	I     	0	0	 	0	 	 	 	 	 	 	0 
41	2024-04-02 23:56:45	2024-04-02 23:56:45	5245	2 	9002  	I     	0	0	 	0	 	 	 	 	 	 	0 
42	2024-04-02 23:56:45	2024-04-02 23:56:45	5248	3 	201401	I     	140	140	N	2	N	N	N	S	S	S	0 
43	2024-04-02 23:56:45	2024-04-02 23:56:45	6250	1 	200801	I     	0	0	 	0	 	 	 	 	 	 	0 
44	2024-04-02 23:56:45	2024-04-02 23:56:45	6255	1 	200801	I     	0	0	 	0	 	 	 	 	 	 	0 
45	2024-04-02 23:56:45	2024-04-02 23:56:45	6350	2 	9801  	I     	0	0	 	0	 	 	 	 	 	 	0 
46	2024-04-02 23:56:45	2024-04-02 23:56:45	6350	3 	200002	I     	0	0	 	0	 	 	 	 	 	 	0 
47	2024-04-02 23:56:45	2024-04-02 23:56:45	2220	1 	202001	A     	158	158	S	1	N	N	N	S	S	S	10
48	2024-04-02 23:56:45	2024-04-02 23:56:45	3027	1 	201803	A     	149	75	N	3	N	N	S	N	S	S	10
49	2024-04-02 23:56:45	2024-04-02 23:56:45	2225	1 	202003	A     	158	158	S	3	N	N	N	S	S	S	10
50	2024-04-02 23:56:45	2024-04-02 23:56:45	5250	1 	202201	A     	143	143	S	2	N	N	N	S	N	S	8 
51	2024-04-02 23:56:45	2024-04-02 23:56:45	6176	1 	202201	A     	128	128	S	3	N	N	N	S	N	S	8 
\.


--
-- TOC entry 4915 (class 0 OID 0)
-- Dependencies: 241
-- Name: sdd100ds_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.sdd100ds_id_seq', 1, false);


--
-- TOC entry 4756 (class 2606 OID 41807)
-- Name: sdd100ds sdd100ds_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sdd100ds
    ADD CONSTRAINT sdd100ds_pkey PRIMARY KEY (id);


-- Completed on 2024-06-19 10:46:56

--
-- PostgreSQL database dump complete
--

