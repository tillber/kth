package se.tillber.FuelCalculator;

public class Fuel {
	private FuelType type;
	private double price;
	
	public Fuel(FuelType type, double price) {
		this.type = type;
		this.price = price;
	}
	
	public FuelType getType() {
		return type;
	}

	public void setType(FuelType type) {
		this.type = type;
	}

	public double getPrice() {
		return price;
	}

	public void setPrice(double price) {
		this.price = price;
	}
	
	
}
