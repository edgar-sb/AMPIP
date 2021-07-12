drop trigger add_nave;
create trigger add_nave
    before insert on datosDelCorporativo for each row
        
        insert into parque(nombre_es,key_corp) value  ('Naves sin parques', new.id);
        
