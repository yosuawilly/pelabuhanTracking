package com.tracking.kapal.model;

import java.io.Serializable;
import java.text.ParseException;
import java.text.SimpleDateFormat;
import java.util.Date;

import com.tracking.kapal.util.Constant;

import android.annotation.SuppressLint;
import android.os.Parcel;
import android.os.Parcelable;

@SuppressLint("SimpleDateFormat")
public class Schedule implements Serializable, Parcelable {
	
	private static final long serialVersionUID = -5748613642973804478L;
	
	private long id;
	private String kode_kapal;
	private String dari;
	private String ke;
	private Date jadwal_berangkat;
	private Date jadwal_datang;
	private Date berangkat;
	private Date datang;
	private boolean done;
	
	public Schedule() {
		// TODO Auto-generated constructor stub
	}

	public long getId() {
		return id;
	}

	public void setId(long id) {
		this.id = id;
	}

	public String getKode_kapal() {
		return kode_kapal;
	}

	public void setKode_kapal(String kode_kapal) {
		this.kode_kapal = kode_kapal;
	}

	public String getDari() {
		return dari;
	}

	public void setDari(String dari) {
		this.dari = dari;
	}

	public String getKe() {
		return ke;
	}

	public void setKe(String ke) {
		this.ke = ke;
	}

	public Date getJadwal_berangkat() {
		return jadwal_berangkat;
	}

	public void setJadwal_berangkat(Date jadwal_berangkat) {
		this.jadwal_berangkat = jadwal_berangkat;
	}

	public Date getJadwal_datang() {
		return jadwal_datang;
	}

	public void setJadwal_datang(Date jadwal_datang) {
		this.jadwal_datang = jadwal_datang;
	}

	public Date getBerangkat() {
		return berangkat;
	}

	public void setBerangkat(Date berangkat) {
		this.berangkat = berangkat;
	}

	public Date getDatang() {
		return datang;
	}

	public void setDatang(Date datang) {
		this.datang = datang;
	}

	public boolean isDone() {
		return done;
	}

	public void setDone(boolean done) {
		this.done = done;
	}

	@Override
	public int describeContents() {
		// TODO Auto-generated method stub
		return 0;
	}
	
	public Schedule(Parcel in) throws ParseException {
		SimpleDateFormat dateFormat = new SimpleDateFormat(Constant.DATE_FORMAT);
		
		this.id = in.readLong();
		this.kode_kapal = in.readString();
		this.dari = in.readString();
		this.ke = in.readString();
		this.jadwal_berangkat = dateFormat.parse(in.readString());
		this.jadwal_datang = dateFormat.parse(in.readString());
		String berangkat = in.readString();
		this.berangkat = berangkat != null ? dateFormat.parse(berangkat) : null;
		String datang = in.readString();
		this.datang = datang != null ? dateFormat.parse(datang) : null;
		this.done = in.readInt() == 1 ? true:false;
	}

	@Override
	public void writeToParcel(Parcel dest, int flags) {
		SimpleDateFormat dateFormat = new SimpleDateFormat(Constant.DATE_FORMAT);
		
		dest.writeLong(id);
		dest.writeString(kode_kapal);
		dest.writeString(dari);
		dest.writeString(ke);
		dest.writeString(dateFormat.format(jadwal_berangkat));
		dest.writeString(dateFormat.format(jadwal_datang));
		dest.writeString(berangkat != null ? dateFormat.format(berangkat) : null);
		dest.writeString(datang != null ? dateFormat.format(datang) : null);
		dest.writeInt(done ? 1 : 0);
	}
	
	public static final Parcelable.Creator<Schedule> CREATOR = new Parcelable.Creator<Schedule>() {

		@Override
		public Schedule createFromParcel(Parcel source) {
			try {
				return new Schedule(source);
			} catch (ParseException e) {
				e.printStackTrace();
				return null;
			}
		}

		@Override
		public Schedule[] newArray(int size) {
			return new Schedule[size];
		}
	};

}
