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
tanggal timestamp without time zone,
schedule_id integer references t_schedule on update cascade on delete cascade
);

create table t_active_device(
kode_kapal varchar(10) references t_kapal on update cascade on delete cascade,
device_id varchar(30) not null
);

create table t_schedule
(
  id serial NOT NULL primary key,
  kode_kapal character varying(10) references t_kapal on update cascade on delete cascade,
  dari character varying(30) NOT NULL,
  ke character varying(30) NOT NULL,
  jadwal_berangkat timestamp without time zone DEFAULT now(),
  jadwal_datang timestamp without time zone DEFAULT now(),
  berangkat timestamp without time zone DEFAULT now(),
  datang timestamp without time zone DEFAULT now(),
  done boolean
);