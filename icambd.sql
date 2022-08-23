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
(3, 'Usuarios', 'Usuarios del sistema', 1);




create table rol(
idrol bigint not null auto_increment,
primary key (idrol),
nombrerol varchar(50),
descripcion text,
status int default 1
);

INSERT INTO `rol` (`idrol`, `nombrerol`, `descripcion`, `status`) VALUES
(1, 'Administrador', 'Acceso a todo el sistema', 1);


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
(1, 1, 1, 1, 1, 1, 1);

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

INSERT INTO `usuario` (`idusuario`, `fechad_creacion`, `nombres`, `apellidos`,  `pass`, `correo`, `telefono`, `celular`,  `rolid`, `status`) 
VALUES (1, '8/8/2022', 'Julio Cesar', 'Leon Martinez',  '3c9909afec25354d551dae21590bb26e38d53f2173b8d3dc3eee4c047e7ab1c1eb8b85103e3be7ba613b31bb5c9c36214dc9f14a42fd7a2fdb84856bca5c44c2', 'jcleon892@gmail.com', '6056208', '3105890481',  1, 1);


create table usuariobot(
idusuariobot bigint not null auto_increment,
primary key (idusuariobot),
nombre varchar (50),
tipo int 
);

create table conversacion(
idconversacion bigint not null auto_increment,
primary key (idconversacion),
idusuario bigint,
conversacion longtext,
tiempo datetime DEFAULT CURRENT_TIMESTAMP,
idmodelo bigint 
);