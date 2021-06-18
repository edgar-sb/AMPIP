
create table if not exists datosDeUsuario
(
    id                  int auto_increment
        primary key,
    key_corp            int        null,
    cargo               text       null,
    telefonoOfficina    text       null,
    celular             text       null,
    direccionDeOfficina text       null,
    cumpleanios         text       null,
    compartirDatos      tinyint(1) null,
    habilitar           tinyint(1) null,
    idAmpip             int        null
);

create table if not exists datosDelCorporativo
(
    id                         int auto_increment
        primary key,
    corporativo                text     null,
    nombre_es                  text     null,
    nombre_en                  text     null,
    tipoDeSocio                text     null,
    rfc                        text     null,
    direccion                  text     null,
    cp                         int      null,
    colonia                    text     null,
    estado                     text     null,
    municipio                  text     null,
    celular                    text     null,
    logo                       text     null,
    inversionAnualSiguiente    text     null,
    inversionRealizadaActual   text     null,
    inversionRealizadaAnterior text     null,
    validadoPor                text     null,
    fechaDeValidacion          datetime null,
    fechaDeAlta                datetime null,
    fechaDeBaja                datetime null,
    status                     text     null,
    habilitar                  text     null,
    type                       text     null
);

create table if not exists espacio_disponible
(
    id             int auto_increment
        primary key,
    tipo           varchar(10)  null,
    tipoDeDispo    varchar(20)  null,
    uso            varchar(20)  null,
    contacto       varchar(100) null,
    precioPromedio float        null,
    id_parque      int          null,
    medidaX        int          null,
    medidaY        int          null,
    medidaZ        int          null
);

create table if not exists extras
(
    id        int auto_increment
        primary key,
    id_entity int  not null,
    dataExtra text null
);

create table if not exists inquilino_nave
(
    id                int auto_increment
        primary key,
    corporativo       varchar(100) null,
    tipoDeNave        char         null,
    nombre_es         varchar(100) null,
    nombre_en         varchar(100) null,
    propietario       varchar(100) null,
    id_nave           int          null,
    nombreEmpresa     varchar(100) null,
    numEmpleados      int          null,
    paisOrigen        varchar(100) null,
    productoInsignia  varchar(100) null,
    sectorEmpresarial varchar(20)  null,
    id_SCIAN          varchar(100) null,
    id_DENUE          varchar(100) null,
    antiguedad        int          null,
    isAmpip           tinyint(1)   null,
    medidaX           int          null,
    medidaY           int          null,
    medidaZ           int          null
);

create trigger setSpace
    before insert
    on inquilino_nave
    for each row
begin
    -- missing source code
end;

create trigger updateNave
    before update
    on inquilino_nave
    for each row
begin
    -- missing source code
end;

create table if not exists locations
(
    id      int auto_increment
        primary key,
    name    varchar(100) null,
    lat     float        null,
    lng     float        null,
    filters text         null
);

create table if not exists nave
(
    id        int auto_increment
        constraint `PRIMARY`
        primary key,
    name      varchar(100) not null,
    parque_id int          not null
);

create table if not exists parque
(
    id                      int auto_increment
        primary key,
    key_corp                int  null,
    key_user                int  null,
    nombre_es               text null,
    nombre_en               text null,
    adminParq               text null,
    parqProp                text null,
    parqIntoParq            text null,
    region                  text null,
    mercado                 text null,
    tipoDeIndustria         text null,
    superficieTotal         text null,
    superficieUrban         text null,
    superficieOcup          text null,
    superficieDisp          text null,
    tipoDePropiedad         text null,
    inicioOperaciones       date null,
    numEmpleados            text null,
    reconocimientoPracticas text null,
    ifraestructura          text null,
    numeroDeNaves           text null,
    observacion             text null,
    kmz                     text null,
    planMaestro             text null,
    contactName             text null,
    contactEmail            text null,
    edit                    date null
);

create table if not exists parques_usuarios
(
    id        int auto_increment
        primary key,
    persona   int  not null,
    id_parque int  null,
    permiso   text null
);

create trigger updateparque_usu
    before insert
    on parques_usuarios
    for each row
begin
    -- missing source code
end;

create table if not exists reclog
(
    id      int auto_increment
        primary key,
    user    varchar(200) null,
    message text         null,
    time    datetime     null
);

create table if not exists role
(
    id           int auto_increment
        primary key,
    name         varchar(128)  null,
    description  varchar(1024) null,
    date_created datetime      null,
    constraint name_idx
        unique (name)
);

create table if not exists user
(
    id                            int auto_increment
        primary key,
    email                         varchar(128)  null,
    full_name                     varchar(512)  null,
    password                      varchar(256)  null,
    status                        int           null,
    date_created                  datetime      null,
    pwd_reset_token               varchar(256)  null,
    pwd_reset_token_creation_date datetime      null,
    userForAmpip                  int           null,
    typeOfUser                    int default 1 null
);

create trigger set_data_user
    before insert
    on user
    for each row
begin
    -- missing source code
end;

create table if not exists user_role
(
    id      int auto_increment
        primary key,
    user_id int not null,
    role_id int not null,
    constraint user_role_role_id_fk
        foreign key (role_id) references role (id)
            on update cascade on delete cascade,
    constraint user_role_user_id_fk
        foreign key (user_id) references user (id)
            on update cascade on delete cascade
);

CREATE TABLE `copomex` (
  `id` int NOT NULL AUTO_INCREMENT,
  `colonia` text,
  `estado` text,
  `municipio` text,
  `cp` text,
  PRIMARY KEY (`id`)
) 