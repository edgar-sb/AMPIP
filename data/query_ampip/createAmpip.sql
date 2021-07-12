create table if not exists copomex
(
    id        int auto_increment

        primary key,
    colonia   text null,
    estado    text null,
    municipio text null,
    cp        text null
)
    charset = latin1;

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
)
    charset = latin1;

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
)
    charset = latin1;


create table if not exists espacio_disponible
(
    id             int auto_increment
        primary key,
    tipo           text collate utf8_unicode_ci null,
    uso            text collate utf8_unicode_ci null,
    precioPromedio float                        null,
    id_parque      text collate utf8_unicode_ci null,
    corporativo    text collate utf8_unicode_ci null,
    extras         text collate utf8_unicode_ci null
);

create table if not exists extras
(
    id        int auto_increment
        
        primary key,
    id_entity int  not null,
    dataExtra text null
)
    charset = latin1;

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
    sectorEmpresarial text         null,
    id_SCIAN          varchar(100) null,
    id_DENUE          varchar(100) null,
    antiguedad        int          null,
    isAmpip           tinyint(1)   null,
    medidaX           int          null,
    medidaY           int          null,
    medidaZ           int          null
)
    charset = latin1;

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
)
    charset = latin1;

create table if not exists nave
(
    id        int auto_increment
        
        primary key,
    name      varchar(100) not null,
    parque_id int          not null
);

create table if not exists parque
(
    id                      int auto_increment
        
        primary key,
    key_corp                int                          null,
    key_user                text collate utf8_unicode_ci null,
    nombre_es               text collate utf8_unicode_ci null,
    nombre_en               text collate utf8_unicode_ci null,
    adminParq               text collate utf8_unicode_ci null,
    parqProp                text collate utf8_unicode_ci null,
    parqIntoParq            text collate utf8_unicode_ci null,
    region                  text collate utf8_unicode_ci null,
    mercado                 text collate utf8_unicode_ci null,
    tipoDeIndustria         text collate utf8_unicode_ci null,
    superficieTotal         text collate utf8_unicode_ci null,
    superficieUrban         text collate utf8_unicode_ci null,
    superficieOcup          text collate utf8_unicode_ci null,
    superficieDisp          text collate utf8_unicode_ci null,
    tipoDePropiedad         text collate utf8_unicode_ci null,
    inicioOperaciones       text collate utf8_unicode_ci null,
    numEmpleados            text collate utf8_unicode_ci null,
    reconocimientoPracticas text collate utf8_unicode_ci null,
    ifraestructura          text collate utf8_unicode_ci null,
    numeroDeNaves           text collate utf8_unicode_ci null,
    observacion             text collate utf8_unicode_ci null,
    kmz                     text collate utf8_unicode_ci null,
    planMaestro             text collate utf8_unicode_ci null,
    contactName             text collate utf8_unicode_ci null,
    contactEmail            text collate utf8_unicode_ci null,
    edit                    text collate utf8_unicode_ci null,
    extras                  text collate utf8_unicode_ci null
);

create table if not exists parques_usuarios
(
    id        int auto_increment
        
        primary key,
    persona   int  not null,
    id_parque int  null,
    permiso   text null
)
    charset = latin1;

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
)
    charset = latin1;

create table if not exists role
(
    id           int auto_increment
        
        primary key,
    name         varchar(128)  null,
    description  varchar(1024) null,
    date_created datetime      null,
    constraint name_idx
        unique (name)
)
    charset = latin1;

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
)
    charset = latin1;

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
)
    charset = latin1;

