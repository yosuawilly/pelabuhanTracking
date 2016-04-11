package com.tracking.kapal.util;

import java.util.Random;

public class DeviceUtil {
	
	public static String getDeviceIdCdma(String imei){
			    
	    String charDeviceId = "";
		String subStringDeviceId = "";
		for (int i = 0; i < imei.length(); i++) {
			subStringDeviceId = imei.substring(i, i+1);

			if (validate(subStringDeviceId)){
				if(subStringDeviceId.equalsIgnoreCase("A")) subStringDeviceId = "0";
				else if(subStringDeviceId.equalsIgnoreCase("B")) subStringDeviceId = "1";
				else if(subStringDeviceId.equalsIgnoreCase("C")) subStringDeviceId = "2";
				else if(subStringDeviceId.equalsIgnoreCase("D")) subStringDeviceId = "3";
				else if(subStringDeviceId.equalsIgnoreCase("E")) subStringDeviceId = "4";
				else if(subStringDeviceId.equalsIgnoreCase("F")) subStringDeviceId = "5";
			}
			
			charDeviceId += subStringDeviceId;
		}
		
		String imeiCdma = charDeviceId;
		
		if(imeiCdma.length() >= 15){
			imeiCdma = charDeviceId.substring(0, 15);
		}else{
			imeiCdma = charDeviceId + charDeviceId.substring(0, 1);
		}
		
		return imeiCdma;
	}
	
	public static boolean isMEID(String deviceId){
		
		for (int i = 0; i < deviceId.length(); i++) {
			if (validate(deviceId.substring(i, i+1))){
				return true;
			}
		}
		
		return false;
	}
	
	
	private static boolean validate(String c) {
		String validChars = "QWERTYUIOPASDFGHJKLZXCVBNMqwertyuiopasdfghjklzxcvbnm";
		if(validChars.indexOf(c) != -1){
			return true;
		}
		return false;
	}
	
	@SuppressWarnings("unused")
	private static String replace(String str, int index, char replace){     
	    if(str==null){
	        return str;
	    }else if(index<0 || index>=str.length()){
	        return str;
	    }
	    char[] chars = str.toCharArray();
	    chars[index] = replace;
	    return String.valueOf(chars);       
	}
	
	@SuppressWarnings("unused")
	private static String addRandomNumber(String imeiCdma, int difCharDeviceId){
		Random randomGenerator = new Random();
        int randomInt = randomGenerator.nextInt(getDiferentRandomNumber(difCharDeviceId));
		return imeiCdma+String.valueOf(randomInt);
	}
	
	private static int getDiferentRandomNumber(int difCharDeviceId){
		
		int diferentRandomNumber = 10;
		
		if(difCharDeviceId == 1){
			diferentRandomNumber = 10;
		}else if(difCharDeviceId == 2){
			diferentRandomNumber = 100;
		}else if(difCharDeviceId == 3){
			diferentRandomNumber = 1000;
		}else if(difCharDeviceId == 4){
			diferentRandomNumber = 10000;
		}else if(difCharDeviceId == 5){
			diferentRandomNumber = 100000;
		}else if(difCharDeviceId == 6){
			diferentRandomNumber = 1000000;
		}
		
		return diferentRandomNumber;
	}



}
