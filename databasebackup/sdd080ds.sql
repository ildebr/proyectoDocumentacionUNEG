--
-- PostgreSQL database dump
--

-- Dumped from database version 16.1
-- Dumped by pg_dump version 16.1

-- Started on 2024-06-19 10:48:02

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
-- TOC entry 240 (class 1259 OID 41793)
-- Name: sdd080ds; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.sdd080ds (
    id bigint NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    sdd080d_cod_carr character(4) NOT NULL,
    sdd080d_nom_carr character(70) NOT NULL,
    sdd080d_correlativo character(2) NOT NULL,
    sdd080d_titulo_tecnico character(70) NOT NULL,
    sdd080d_titulo_profesional character(70) NOT NULL,
    sdd080d_prog_cnu character(10) NOT NULL,
    sdd080d_nombre_corto character(50) NOT NULL,
    sdd080d_total_uc integer NOT NULL,
    sdd080d_uc_tecn integer NOT NULL,
    sdd080d_nombre character(50) NOT NULL,
    sdd080d_uc_1er_semestre integer NOT NULL,
    sdd080d_code_area character(2) NOT NULL,
    sdd080d_ordern_tecnicos character(1) NOT NULL,
    sdd080d_orden_profesional character(1) NOT NULL,
    sdd080d_nro_electivas integer NOT NULL,
    sdd080d_tipo_carr character(1) NOT NULL,
    sdd080d_nom_carr_tipo_titulo character(70) NOT NULL,
    sdd080d_orden_acto_solmen character(2) NOT NULL,
    sdd080d_titulo_tec_femenino character(70) NOT NULL,
    sdd080d_prof_femenino character(70) NOT NULL,
    sdd080d_iniciales character(4) NOT NULL
);


ALTER TABLE public.sdd080ds OWNER TO postgres;

--
-- TOC entry 4907 (class 0 OID 0)
-- Dependencies: 240
-- Name: COLUMN sdd080ds.sdd080d_cod_carr; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN public.sdd080ds.sdd080d_cod_carr IS 'codigo de la carrera';


--
-- TOC entry 4908 (class 0 OID 0)
-- Dependencies: 240
-- Name: COLUMN sdd080ds.sdd080d_nom_carr; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN public.sdd080ds.sdd080d_nom_carr IS 'nombre de la carrera';


--
-- TOC entry 4909 (class 0 OID 0)
-- Dependencies: 240
-- Name: COLUMN sdd080ds.sdd080d_correlativo; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN public.sdd080ds.sdd080d_correlativo IS 'numero correlativo a usar en las actas de evaluacion';


--
-- TOC entry 4910 (class 0 OID 0)
-- Dependencies: 240
-- Name: COLUMN sdd080ds.sdd080d_titulo_tecnico; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN public.sdd080ds.sdd080d_titulo_tecnico IS 'nombre del titulo de la carrea a nivel tecnico';


--
-- TOC entry 4911 (class 0 OID 0)
-- Dependencies: 240
-- Name: COLUMN sdd080ds.sdd080d_titulo_profesional; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN public.sdd080ds.sdd080d_titulo_profesional IS 'nombre del titulo de la carrera a nivel profesional';


--
-- TOC entry 4912 (class 0 OID 0)
-- Dependencies: 240
-- Name: COLUMN sdd080ds.sdd080d_prog_cnu; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN public.sdd080ds.sdd080d_prog_cnu IS 'codigo de progrma (carrera) asignado por el CNU';


--
-- TOC entry 4913 (class 0 OID 0)
-- Dependencies: 240
-- Name: COLUMN sdd080ds.sdd080d_nombre_corto; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN public.sdd080ds.sdd080d_nombre_corto IS 'nombre corto (abreviado) de la carrera';


--
-- TOC entry 4914 (class 0 OID 0)
-- Dependencies: 240
-- Name: COLUMN sdd080ds.sdd080d_total_uc; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN public.sdd080ds.sdd080d_total_uc IS 'total de las unidades de creditos del pensum de la carrera';


--
-- TOC entry 4915 (class 0 OID 0)
-- Dependencies: 240
-- Name: COLUMN sdd080ds.sdd080d_nombre; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN public.sdd080ds.sdd080d_nombre IS 'nombre corto';


--
-- TOC entry 4916 (class 0 OID 0)
-- Dependencies: 240
-- Name: COLUMN sdd080ds.sdd080d_orden_acto_solmen; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN public.sdd080ds.sdd080d_orden_acto_solmen IS 'orden generico para acta de grado solemne';


--
-- TOC entry 239 (class 1259 OID 41792)
-- Name: sdd080ds_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.sdd080ds_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.sdd080ds_id_seq OWNER TO postgres;

--
-- TOC entry 4917 (class 0 OID 0)
-- Dependencies: 239
-- Name: sdd080ds_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.sdd080ds_id_seq OWNED BY public.sdd080ds.id;


--
-- TOC entry 4754 (class 2604 OID 41796)
-- Name: sdd080ds id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sdd080ds ALTER COLUMN id SET DEFAULT nextval('public.sdd080ds_id_seq'::regclass);


--
-- TOC entry 4901 (class 0 OID 41793)
-- Dependencies: 240
-- Data for Name: sdd080ds; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.sdd080ds (id, created_at, updated_at, sdd080d_cod_carr, sdd080d_nom_carr, sdd080d_correlativo, sdd080d_titulo_tecnico, sdd080d_titulo_profesional, sdd080d_prog_cnu, sdd080d_nombre_corto, sdd080d_total_uc, sdd080d_uc_tecn, sdd080d_nombre, sdd080d_uc_1er_semestre, sdd080d_code_area, sdd080d_ordern_tecnicos, sdd080d_orden_profesional, sdd080d_nro_electivas, sdd080d_tipo_carr, sdd080d_nom_carr_tipo_titulo, sdd080d_orden_acto_solmen, sdd080d_titulo_tec_femenino, sdd080d_prof_femenino, sdd080d_iniciales) FROM stdin;
1	2024-03-28 14:34:32	2024-03-28 14:34:32	1335	Tecnología en Producción Agropecuaria                                 	7 	 Tecnólogo en Producción Agropecuaria                                 	 Tecnólogo en Producción Agropecuaria                                 	8114003680	 Tgía. Prod. Agropecuaria                         	100	100	 AGROPECUARIA                                     	16	4 	0	9	0	T	Tecnología En Producción Agropecuaria                                 	13	 Tecnólogo en Producción Agropecuaria                                 	 Tecnólogo en Producción Agropecuaria                                 	    
2	2024-03-28 15:14:16	2024-03-28 15:14:16	2072	Ingeniería en Informática                                             	1 	 Tecnólogo en Computación                                             	Ingeniero en Informática                                              	8114002072	 Ing. en Informática                              	139	80	 INFORMÁTICA                                      	14	1 	0	1	4	P	Ingeniería En Informática                                             	10	 Tecnólogo en Computación                                             	Ingeniera en Informática                                              	    
3	2024-03-28 15:14:16	2024-03-28 15:14:16	2115	Ingeniería Industrial                                                 	2 	 Tecnólogo  Industrial                                                	Ingeniero Industrial                                                  	8114002115	 Ing. Industrial                                  	151	87	 INDUSTRIAL                                       	11	1 	0	2	4	P	Ingeniería Industrial                                                 	11	 Tecnólogo  Industrial                                                	Ingeniera Industrial                                                  	    
4	2024-03-28 15:14:16	2024-03-28 15:14:16	3024	Ingeniería en Industrias Forestales                                   	3 	 Tecnólogo en Industrias Forestales                                   	Ingeniero en Industrias Forestales                                    	8114003161	 Ing. Ind. Forestales                             	164	105	 FORESTAL                                         	18	4 	0	3	3	P	Ingeniería En Industrias Forestales                                   	12	 Tecnólogo en Industrias Forestales                                   	Ingeniera en Industrias Forestales                                    	    
5	2024-03-28 15:14:16	2024-03-28 15:14:16	3025	Ingeniería de Producción Animal                                       	9 	                                                                      	Ingeniero en Producción Animal                                        	          	 Ing. Prod. Animal                                	174	30	 PROD.ANIMAL                                      	16	4 	0	0	0	P	Ingeniería de Producción Animal                                       	14	                                                                      	Ingeniera en Producción Animal                                        	    
6	2024-03-28 15:14:16	2024-03-28 15:14:16	5245	Educación Integral                                                    	4 	 Tecnólogo en Educación Integral                                      	Licenciado en Educación Integral                                      	8114005245	Lic. Educación Integral                           	171	104	 EDUCACIÓN                                        	18	3 	0	7	10	P	Educación Integral                                                    	5 	 Tecnólogo en Educación Integral                                      	Licenciada en Educación Integral                                      	    
7	2024-03-28 15:30:35	2024-03-28 15:30:35	5246	Educación Mención Lengua y Literatura                                 	12	                                                                      	Licenciado en Educación Mención Lengua Y Literatura                   	          	Lic. Educ. Lengua y Literatura                    	136	0	 LENGUA Y LIT.                                    	17	3 	0	8	0	P	Educación Mención Lengua y Literatura                                 	7 	                                                                      	Licenciada en Educación Mención Lengua Y Literatura                   	    
8	2024-03-28 15:30:35	2024-03-28 15:30:35	5247	Educación Mención Matemáticas                                         	13	                                                                      	Licenciado en Educación Mención Matemáticas                           	          	Lic. Educ. Matemática                             	131	0	MATEMÁTICAS                                       	18	3 	0	6	0	P	Educación Mención Matemáticas                                         	8 	                                                                      	Licenciada en Educación Mención Matemáticas                           	    
9	2024-03-28 15:30:35	2024-03-28 15:30:35	5248	Educación Mención Educación Física Deporte y Recreación               	14	                                                                      	Licenciado en Educación Mención Educación Física Deporte y Recreación 	          	Lic. Educ. Educación Física Deporte y Recreación  	138	0	EDUC. FISÍCA                                      	17	3 	0	5	0	P	Educación Mención Educación Física Deporte Y Recreación               	6 	                                                                      	Licenciada en Educación Mención Educación Física Deporte y Recreación 	    
10	2024-03-28 15:30:35	2024-03-28 15:30:35	6173	Turismo                                                               	8 	 Técnico Superior Universitario en Turismo                            	 Técnico Superior Universitario en Turismo                            	8114006173	 Tsu en Turismo                                   	103	103	 TURISMO                                          	16	2 	0	0	2	T	Turismo                                                               	15	 Técnico Superior Universitario en Turismo                            	 Técnico Superior Universitario en Turismo                            	    
11	2024-03-28 15:30:35	2024-03-28 15:30:35	6174	Empresa de Alojamiento Turístico                                      	15	 Técnico Superior Universitario en Empresa de Alojamiento Turistico   	 Técnico Superior Universitario en Empresa de Alojamiento Turistico   	          	 Tsu en Empresa de Aojamiento Turístico           	97	0	EMP. ALOJAMIENTO                                  	19	2 	0	0	0	T	Empresa De Alojamiento Turístico                                      	16	 Técnico Superior Universitario en Empresa de Alojamiento Turistico   	 Técnico Superior Universitario en Empresa de Alojamiento Turistico   	    
12	2024-03-28 15:30:35	2024-03-28 15:30:35	6350	Contaduría Pública                                                    	5 	 Tecnólogo en Administración y Contaduría                             	Licenciado en Contaduría Pública                                      	8114006350	Lic. Contaduría Pública                           	138	80	 CONTADURÍA                                       	16	2 	0	0	2	P	Contaduría Pública                                                    	3 	 Tecnólogo en Administración y Contaduría                             	Licenciada en Contaduría Pública                                      	    
13	2024-03-28 15:30:35	2024-03-28 15:30:35	6366	Ciencias Fiscales                                                     	11	                                                                      	Licenciado en Ciencias Fiscales                                       	          	Lic. Ciencias Fiscales                            	148	0	CS. FISCALES                                      	19	2 	0	0	0	P	Ciencias Fiscales                                                     	4 	                                                                      	Licenciada en Ciencias Fiscales                                       	    
14	2024-03-28 15:30:35	2024-03-28 15:30:35	6355	Administración de Empresas                                            	6 	 Tecnólogo en Administración y Contaduría                             	Licenciado en Administración de Empresas                              	8114006354	Lic. Admon. de Empresas                           	142	80	 ADMINISTRACIÓN                                   	16	2 	0	0	2	P	Administración De Empresas                                            	1 	 Tecnólogo en Administración y Contaduría                             	Licenciada en Administración de Empresas                              	    
15	2024-03-28 15:30:35	2024-03-28 15:30:35	6365	Administración Mención Banca y  Finanzas                              	10	                                                                      	Licenciado en Administración, Mención: Banca y  Finanzas              	          	Lic. Admon. Mención: Banca y Finanzas             	144	0	BANCA Y FINANZA                                   	19	2 	0	0	0	P	Administración Mención Banca y  Finanzas                              	2 	                                                                      	Licenciada en Administración, Mención: Banca y  Finanzas              	    
16	2024-03-28 15:30:35	2024-03-28 15:30:35	2225	Ingeniería en Materiales                                              	18	                                                                      	Ingeniero en Materiales                                               	          	Ing. en Materiales                                	0	0	MATERIALES                                        	0	1 	0	0	0	P	Ingeniería en Materiales                                              	0 	                                                                      	                                                                      	    
17	2024-03-28 15:30:35	2024-03-28 15:30:35	3027	Ingeniería de Producción Animal UNEG                                  	16	                                                                      	Ingeniero en Producción Animal                                        	          	 Ing. Prod. Animal                                	174	30	 PROD.ANIMAL                                      	16	4 	0	4	0	P	Ingeniería de Producción Animal                                       	14	                                                                      	Ingeniera en Producción Animal                                        	    
18	2024-03-28 15:30:35	2024-03-28 15:30:35	2220	Licenciatura en Ciencias Ambientales                                  	17	                                                                      	Licenciado en Ciencias Ambientales                                    	          	 Lic. Ccs. Ambientales                            	0	0	 CCS AMBIENTALES                                  	0	1 	0	0	0	P	Ciencias Ambientales                                                  	0 	                                                                      	                                                                      	    
19	2024-03-28 15:47:11	2024-03-28 15:47:11	5250	Licenciatura en Educación en Ciencias Química, Física y Biología      	20	                                                                      	                                                                      	          	Lic. en Educ. Ciencias Química, Físicay Biologia  	0	0	QUIMICA, FISICA Y BIOLOGIA                        	0	3 	0	0	0	 	                                                                      	  	                                                                      	                                                                      	    
20	2024-03-28 15:47:11	2024-03-28 15:47:11	6176	Licenciatura en Gestión de Alojamiento Turístico                      	19	                                                                      	                                                                      	          	Lic. Gestión de Alojamiento Turístico             	0	0	LIC.ALOJAMIENTO                                   	0	2 	0	0	0	 	                                                                      	  	                                                                      	                                                                      	    
\.


--
-- TOC entry 4918 (class 0 OID 0)
-- Dependencies: 239
-- Name: sdd080ds_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.sdd080ds_id_seq', 1, false);


--
-- TOC entry 4756 (class 2606 OID 41800)
-- Name: sdd080ds sdd080ds_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sdd080ds
    ADD CONSTRAINT sdd080ds_pkey PRIMARY KEY (id);


-- Completed on 2024-06-19 10:48:05

--
-- PostgreSQL database dump complete
--

