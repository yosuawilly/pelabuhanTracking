create table "admin"(
id_admin serial not null primary key,
username varchar(10),
"password" varchar(6)
);

create table t_kapal(
kode_kapal varchar(10) not null primary key,
nama_kapal varchar(30),
ukuran varchar(20),
mesin varchar(20)
);

create table t_lokasi_kapal(
kode_kapal varchar(10) references t_kapal on update cascade on delete cascade,
lat double precision,
lng double precision,
tanggal timestamp without time zone
);

create table t_active_device(
kode_kapal varchar(10) references t_kapal on update cascade on delete cascade,
device_id varchar(30) not null
);