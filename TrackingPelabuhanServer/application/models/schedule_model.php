<?php

/**
 * Created by IntelliJ IDEA.
 * User: yosuawilly
 * Date: 1/12/16
 * Time: 4:53 PM
 */
class Schedule_model extends Super_model
{
    public $id = 'id';
    public $kode_kapal = 'kode_kapal';
    public $dari = 'dari';
    public $ke = 'ke';
    public $jadwal_berangkat = 'jadwal_berangkat';
    public $jadwal_datang = 'jadwal_datang';
    public $berangkat = 'berangkat';
    public $datang = 'datang';
    public $done = 'done';

    public function __construct() {
        parent::__construct();
    }

    public function getByKodeKapal($kodeKapal) {
        $this->db->where($this->kode_kapal, $kodeKapal);
        $this->db->limit(1);
        $query = $this->db->get($this->table);
        return $query->result_array();
    }

    public function getAktifByKodeKapal($kodeKapal) {
        $this->db->where([$this->kode_kapal => $kodeKapal, $this->done => 'false']);
        $this->db->where($this->berangkat . ' is NULL');
        $this->db->limit(1);
        $query = $this->db->get($this->table);
        return $query->result_array();
    }

    public function getRunningByKodeKapal($kodeKapal) {
        $this->db->where([
            $this->kode_kapal => $kodeKapal,
            $this->done => 'false'
        ]);
        $this->db->where($this->berangkat . ' is not NULL');
        $this->db->limit(1);
        $query = $this->db->get($this->table);
        return $query->result_array();
    }

    public function getLateScheduleByNamaKapal($namaKapalStr) {
        $strSQL = "select DISTINCT k.nama_kapal,(case when d.id is not null then true else false end) as late from t_kapal k left join
(
select * from t_schedule where
(done = false and datang is null and now() > jadwal_datang) or
(done = true and datang > jadwal_datang)
) as d
on k.kode_kapal=d.kode_kapal
where nama_kapal in ( $namaKapalStr )";

        $query = $this->db->query($strSQL);
        return $query->result();
    }

    public function getLateScheduleByScheduleId($scheduleIdStr) {
        $strSQL = "select s.id,
(case when d.id is not null then true else false end) as late
from t_schedule s left join
(
select * from t_schedule where
(done = false and berangkat is not null and datang is null and now() > jadwal_datang) or
(done = true and berangkat is not null and datang > jadwal_datang)
) as d
on s.id=d.id
where s.id in ( $scheduleIdStr )";

        $query = $this->db->query($strSQL);
        return $query->result();
    }

    public function getStatusSchedule($kodeKapal, $per_page, $offset) {
        $result = array();
        $strSQL = "select *,(case when berangkat is null then 'n'
when berangkat is not null and datang is null and done = false and now() > jadwal_datang then 'l'
when berangkat is not null and datang is null and done = false then 'o'
when berangkat is not null and datang is not null and done = true and datang > jadwal_datang then 'l'
when berangkat is not null and datang is not null and done = true then 'a' end) as status from t_schedule where kode_kapal = ? ";
        $query = $this->db->query($strSQL, array($kodeKapal));
        $result['num_rows'] = $query->num_rows();

        $strSQL = "select *,(case when berangkat is null then 'n'
when berangkat is not null and datang is null and done = false and now() > jadwal_datang then 'l'
when berangkat is not null and datang is null and done = false then 'o'
when berangkat is not null and datang is not null and done = true and datang > jadwal_datang then 'l'
when berangkat is not null and datang is not null and done = true then 'a' end) as status from t_schedule where kode_kapal = ?
limit ? offset ? ";
        $query = $this->db->query($strSQL, array($kodeKapal, $per_page, $offset));
        $result['rows'] = $query->result_array();

        return $result;
    }

    public function get_primary_column() {
        return $this->id;
    }

    public function get_table_name() {
        return 't_schedule';
    }
}