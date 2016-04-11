package com.tracking.kapal.global;

import java.io.Serializable;

import com.tracking.kapal.model.Kapal;

public class GlobalVar implements Serializable{
	
	private static final long serialVersionUID = 6668652291040678573L;
	
	private static GlobalVar instance;
	private Kapal kapal;
	
	public GlobalVar() {
	}
	
	public Kapal getKapal() {
		return kapal;
	}
	
	public void setKapal(Kapal kapal) {
		this.kapal = kapal;
	}
	
	static {
		instance = new GlobalVar();
	}
	
	public static GlobalVar getInstance() {
		return GlobalVar.instance;
	}
	
	public void clearAllObject(){
		//getInstance().setSiswa(null);
	}

}
