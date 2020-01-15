package se.tillber.FuelCalculator;

public class FuelComparison {
	private Fuel firstFuel;
	private Fuel secondFuel;
	private String firstStation;
	private String secondStation;
	private double liters;
	private double cheaper;
	private double save;
	private double cost;
	
	public FuelComparison(Fuel firstFuel, Fuel secondFuel, String firstStation, String secondStation, double liters) {
		this.firstFuel = firstFuel;
		this.secondFuel = secondFuel;
		this.firstStation = firstStation;
		this.secondStation = secondStation;
		this.liters = Math.round(liters*100.0)/100.0;
		
		this.cheaper = Math.round((firstFuel.getPrice() - secondFuel.getPrice())*100.0)/100.0;
		System.out.println(cheaper);
		
		if(cheaper < 0) {
			System.out.println("cheaper is less than 0");
			Fuel tempFuel = firstFuel;
			this.firstFuel = secondFuel;
			this.secondFuel = tempFuel;
			
			String tempStation = firstStation;
			this.firstStation = secondStation;
			this.secondStation = tempStation;
			
			this.cheaper = this.cheaper * (-1);
		}
		
		System.out.println("new cheaper: " + cheaper);		
		this.save = Math.round((cheaper * liters)*100.0)/100.0;
		this.cost = Math.round((liters * firstFuel.getPrice())*100.0)/100.0;
	}

	public Fuel getFirstFuel() {
		return firstFuel;
	}

	public void setFirstFuel(Fuel firstFuel) {
		this.firstFuel = firstFuel;
	}

	public Fuel getSecondFuel() {
		return secondFuel;
	}

	public void setSecondFuel(Fuel secondFuel) {
		this.secondFuel = secondFuel;
	}

	public String getFirstStation() {
		return firstStation;
	}

	public void setFirstStation(String firstStation) {
		this.firstStation = firstStation;
	}

	public String getSecondStation() {
		return secondStation;
	}

	public void setSecondStation(String secondStation) {
		this.secondStation = secondStation;
	}

	public double getLiters() {
		return liters;
	}

	public void setLiters(int liters) {
		this.liters = liters;
	}

	public double getCheaper() {
		return cheaper;
	}

	public void setCheaper(double cheaper) {
		this.cheaper = cheaper;
	}

	public double getSave() {
		return save;
	}

	public void setSave(double save) {
		this.save = save;
	}

	public double getCost() {
		return cost;
	}

	public void setCost(double cost) {
		this.cost = cost;
	}
}
