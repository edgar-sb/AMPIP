truncate table  ampip.datosDelCorporativo;
truncate table ampip.parque;
truncate table ampip.inquilino_nave;
truncate table ampip.parques_usuarios;
truncate table ampip.space;
delete from ampip.user where id != 1;
delete from ampip.datosDeUsuario where id != 1;

/* seccion de contraseñas */
select * from ampip.user;
update ampip.user set password = 'saG9uaE=' where id = 27;