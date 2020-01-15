package se.tillber.FuelCalculator;

public enum FuelType {
	Unleaded98{
		@Override
		public String toString() {
			return "Unleaded 98";
		}
	},
	Unleaded95{
		@Override
		public String toString() {
			return "Unleaded 95";
		}
	},
	Diesel,
	Ethanol
}
