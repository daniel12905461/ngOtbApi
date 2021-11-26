insert into members (name, dad_last_name, mom_last_name, ci,phone,birth_date,enabled) value
('daniel','delgado','camacho','123','123','1999-10-19',1),
('julian','delgado','mamani','123','123','1999-10-19',1);

insert into parcels(latitude,length,enabled,member_id) value
('123','321',1,1),
('123','321',1,2);

insert into mes(name,year,enabled) value
('enero','2021',1);

insert into ingresos (fecha, concepto, pagado, mes_id, parcel_id) value
('1999-10-19','sdfsd',0,1,1),
('1999-10-19','sdfsd',0,1,1),
('1999-10-19','sdfsd',1,1,1),
('1999-10-19','sdfsd',1,1,1),
('1999-10-19','sdfsd',1,1,2),
('1999-10-19','sdfsd',1,1,2),
('1999-10-19','sdfsd',0,1,2);

insert into parcels(latitude,length,ultimalectura,enabled,member_id) value
('123','321',123,1,2);

insert into member_parcels(parcel_id,member_id) value
(1,1),
(2,2);

insert into servicios(nombre,price,cubos_exeso,enabled) value
('agua',1,10,1);

insert into parcel_servicios(parcel_id,servicio_id) value
(1,1),
(2,1);
