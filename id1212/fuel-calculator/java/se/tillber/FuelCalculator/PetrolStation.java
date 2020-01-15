package se.tillber.FuelCalculator;

public class PetrolStation {
	private int id;
	
	public int getId() {
		return id;
	}

	public void setId(int id) {
		this.id = id;
	}

	private String company;
	private String location;
	
	private Fuel unleaded95;
	private Fuel unleaded98;
	private Fuel diesel;
	private Fuel ethanol;
	
	public PetrolStation() {}
	
	public PetrolStation(String company, String location) {
		this.company = company;
		this.location = location;
	}
	
	public PetrolStation(String company, Fuel unleaded95, Fuel unleaded98, Fuel diesel, Fuel ethanol) {
		this.company = company;
		this.unleaded95 = unleaded95;
		this.unleaded98 = unleaded98;
		this.diesel = diesel;
		this.ethanol = ethanol;
	}
	
	public PetrolStation(int id, String company, String location, Fuel unleaded95, Fuel unleaded98, Fuel diesel, Fuel ethanol) {
		this.id = id;
		this.company = company;
		this.location = location;
		this.unleaded95 = unleaded95;
		this.unleaded98 = unleaded98;
		this.diesel = diesel;
		this.ethanol = ethanol;
	}
	
	public String getCompany() {
		return company;
	}

	public void setCompany(String company) {
		this.company = company;
	}

	public String getLocation() {
		return location;
	}

	public void setLocation(String location) {
		this.location = location;
	}
	
	public Fuel getUnleaded95() {
		return unleaded95;
	}

	public void setUnleaded95(Fuel unleaded95) {
		this.unleaded95 = unleaded95;
	}

	public Fuel getUnleaded98() {
		return unleaded98;
	}

	public void setUnleaded98(Fuel unleaded98) {
		this.unleaded98 = unleaded98;
	}

	public Fuel getDiesel() {
		return diesel;
	}

	public void setDiesel(Fuel diesel) {
		this.diesel = diesel;
	}

	public Fuel getEthanol() {
		return ethanol;
	}

	public void setEthanol(Fuel ethanol) {
		this.ethanol = ethanol;
	}

	public String toString() {
		return "Company: " + this.company + ", Location: " + this.location + ", " + this.unleaded95.getType() + ": " + this.unleaded95.getPrice() + ", " + this.unleaded98.getType() + ": " + this.unleaded98.getPrice() + ", " + this.diesel.getType() + ": " + this.diesel.getPrice() + ", " + this.ethanol.getType() + ": " + this.ethanol.getPrice();
	}
}
