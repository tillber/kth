package common;

import java.io.Serializable;

public class File implements Serializable{
	private String name;
	private String owner;
	private int size;
	
	public File(String name, String owner, int size) {
		this.name = name;
		this.owner = owner;
		this.size = size;
	}
	
	public String getName() {
		return name;
	}
	
	public String getOwner() {
		return owner;
	}
	
	public int getSize() {
		return size;
	}
	
	@Override
	public String toString() {
		return "File '" + name + "' uploaded by " + owner + ", " + (size/8) + " bytes";
	}
}
