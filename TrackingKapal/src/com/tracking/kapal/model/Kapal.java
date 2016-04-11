package com.tracking.kapal.model;

import java.io.Serializable;

public class Kapal implements Serializable{
	
	private static final long serialVersionUID = -6839612824021100645L;
	
	private String kode_kapal;
	private String nama_kapal;
	private String ukuran;
	private String mesin;
	
	public Kapal() {
		// TODO Auto-generated constructor stub
	}

	public String getKode_kapal() {
		return kode_kapal;
	}

	public void setKode_kapal(String kode_kapal) {
		this.kode_kapal = kode_kapal;
	}

	public String getNama_kapal() {
		return nama_kapal;
	}

	public void setNama_kapal(String nama_kapal) {
		this.nama_kapal = nama_kapal;
	}

	public String getUkuran() {
		return ukuran;
	}

	public void setUkuran(String ukuran) {
		this.ukuran = ukuran;
	}

	public String getMesin() {
		return mesin;
	}

	public void setMesin(String mesin) {
		this.mesin = mesin;
	}
	
}
