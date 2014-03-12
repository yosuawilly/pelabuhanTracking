package com.tracking.kapal.global;

import java.io.Serializable;

public class GlobalVar implements Serializable{
	
	private static final long serialVersionUID = 6668652291040678573L;
	
	private static GlobalVar instance;
	
	public GlobalVar() {
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
