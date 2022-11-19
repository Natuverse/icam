Drop database if exists icam;
create database icam;
use icam;

create table status(
idstatus int not null auto_increment,
primary key (idstatus),
status varchar(50) not null,
badge varchar(150)
);

insert into status (idstatus, status, badge)values
(1, 'En revisión', '<span class="badge bg-warning text-dark">En revisión</span>'),
(2, 'Actualizacion', '<span class="badge bg-info text-dark">Actualizacion</span>'),
(3, 'Aprobado', '<span class="badge bg-primary">Aprobado</span>'),
(4, 'Activo', '<span class="badge bg-success">Activo</span>'),
(5, 'Inactivo', '<span class="badge bg-secondary">Inactivo</span>'),
(6, 'No admitido', '<span class="badge bg-danger">No admitido</span>');

create table modulo (
idmodulo  int not null auto_increment,
primary key (idmodulo),
titulo varchar(50),
descripcion text,
status int default 1
);

INSERT INTO `modulo` (`idmodulo`, `titulo`, `descripcion`, `status`) VALUES
(1, 'Dashboard', 'Dashboard', 1),
(2, 'Roles', 'roles del sistema', 1),
(3, 'Usuarios', 'Usuarios del sistema', 1),
(4, 'Diccionario', 'Diccionario del bot',1),
(5, 'Analisi', 'analisis de datos',1),
(6, 'Emociones', "analisis de emociones", 1);




create table rol(
idrol bigint not null auto_increment,
primary key (idrol),
nombrerol varchar(50),
descripcion text,
status int default 1
);


INSERT INTO `rol` (`idrol`, `nombrerol`, `descripcion`, `status`) VALUES
(1, 'Administrador', 'Acceso a todo el sistema', 1),
(2, 'operativo', 'operativo', 1);


create table permisos (
idpermiso bigint not null auto_increment,
primary key (idpermiso),
rolid bigint not null,
moduloid bigint not null, 
r int default 0,
w int default 0,
u int default 0,
d int default 0
);


INSERT INTO `permisos` (`idpermiso`, `rolid`, `moduloid`, `r`, `w`, `u`, `d`) VALUES
(24, 2, 1, 0, 0, 0, 0),
(25, 2, 2, 0, 0, 0, 0),
(26, 2, 3, 0, 0, 0, 0),
(27, 2, 4, 1, 1, 1, 1),
(28, 1, 1, 1, 1, 1, 1),
(29, 1, 2, 1, 1, 1, 1),
(30, 1, 3, 1, 1, 1, 1),
(31, 1, 4, 1, 1, 1, 1),
(32, 1, 5, 1, 1, 1, 1),
(33, 1, 6, 1, 1, 1, 1);

create table usuario (
idusuario bigint not null auto_increment,
primary key (idusuario),
avatar varchar(255),
fechad_creacion varchar (20), 
id_tipo_documento int,
documento varchar (30),
pass varchar(255) not null ,
nombres varchar(150),
apellidos varchar (150),
celular varchar(60),
telefono varchar(60),
correo varchar(150),
rolid bigint(20) NOT NULL,
status int default 1,
token varchar (255),
tokenid varchar (255),
foreign key (rolid) references rol (idrol)
);

INSERT INTO `usuario` (`idusuario`, `avatar`, `fechad_creacion`, `id_tipo_documento`, `documento`, `pass`, `nombres`, `apellidos`, `celular`, `telefono`, `correo`, `rolid`, `status`, `token`, `tokenid`) VALUES
(1, NULL, '8/8/2022', NULL, NULL, '3c9909afec25354d551dae21590bb26e38d53f2173b8d3dc3eee4c047e7ab1c1eb8b85103e3be7ba613b31bb5c9c36214dc9f14a42fd7a2fdb84856bca5c44c2', 'Julio Cesar', 'Leon Martinez', '3105890481', '6056208', 'jcleon892@gmail.com', 1, 1, NULL, NULL),
(2, 'fotoRegistro.jpg', NULL, NULL, NULL, 'd5a0aacc8140a953d12712161e0dbfeedc4520194243c5beea10e8d70b0b9929fab512c630eaabbb030dd4213c4050efd0447a0a870ce68e6eff47112e073650', 'Arismendi', 'Rueda', '3107794734', NULL, 's.arismendi.rueda@gmail.com', 2, 1, NULL, NULL),
(3, 'fotoRegistro.jpg', NULL, NULL, NULL, '5bd7b41c7439d5fb38939b0786788ccd9000f71ed76d4c7f1a8439549e73d31fb1e317547d8281fc60b1a2bda8476112f4beb4545507502979655dd608409ec6', 'Fabian', 'Moya', '3186036909', NULL, 'fmoya868@gmail.com', 2, 1, NULL, NULL);


create table usuariobot(
idusuariobot bigint not null auto_increment,
primary key (idusuariobot),
nombre varchar (50),
tipo int 
);

create table log(
idlog bigint not null auto_increment,
primary key(idlog),
model bigint,
tipo int,
tiempo datetime default current_timestamp,
user bigint,
pregunta longtext,
respuesta longtext,
idemocion int 
);

create table conversacion(
idconversacion bigint not null auto_increment,
primary key (idconversacion),
idusuario bigint,
conversacion longtext,
tiempo datetime DEFAULT CURRENT_TIMESTAMP,
idmodelo bigint,
privado int default 0,
voz int default 0
);

drop table if exists diccionario;
create table diccionario(
iddiccionario bigint not null auto_increment,
primary key (iddiccionario),
palabra varchar (255),
significado_en longtext,
traduccion_es longtext,
significado_es  longtext,
image longtext
);











create table palabras(
idpalabra bigint not null auto_increment,
primary key (idpalabra),
palabra varchar(255),
cant int,
status int default 1
);

create table oracion (
idoracion bigint not null auto_increment,
primary key (idoracion),
oracion longtext,
cant int,
status int default 1
);

create table emocion(
idemocion int not null auto_increment,
primary key(idemocion),
emocion varchar (50), 
emocion_es varchar (50)
);

insert into emocion (idemocion, emocion, emocion_es) values
(1,"sadness", "sadness"),
(2, "joy", "alegría"),
(3, "love", "amor"),
(4, "anger", "enfado"),
(5, "fear", "miedo"),
(6, "surprise", "sorpresa");

create table emocion_image(
idemocion_image int not null auto_increment,
primary key (idemocion_image),
emocion_image varchar (255),
id_emocion int,
descripcion varchar(255)
);

create table abreviacion(
idabreviacion bigint not null auto_increment,
primary key (idabreviacion),
abreviacion varchar (100),
palabra varchar (100)
);




























