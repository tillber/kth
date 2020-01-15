package se.tillber.FuelCalculator;

import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Statement;
import java.util.ArrayList;
import java.util.List;

public class StationRepository {
	private Connection connection;
	
	public StationRepository() {
		try {
			Class.forName("org.sqlite.JDBC");
			connection = DriverManager.getConnection("jdbc:sqlite:C:\\Users\\marti\\eclipse-workspace\\FuelCalculator\\src\\main\\resources\\fuel-calculator.sqlite");
		} catch (ClassNotFoundException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		} catch (SQLException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
	}
	
	public List<PetrolStation> getAllStations(){
		List<PetrolStation> stations = new ArrayList<>();
		try {
			PreparedStatement preparedStatement = connection.prepareStatement("SELECT * FROM prices");
			ResultSet resultSet = preparedStatement.executeQuery();
			while(resultSet.next()) {
				stations.add(new PetrolStation(resultSet.getInt(1), resultSet.getString(2), resultSet.getString(3), 
						new Fuel(FuelType.Unleaded95, resultSet.getDouble(4)), new Fuel(FuelType.Unleaded98, resultSet.getDouble(5)), 
						new Fuel(FuelType.Diesel, resultSet.getDouble(6)), new Fuel(FuelType.Ethanol, resultSet.getDouble(7))));
			}
		} catch (SQLException e) {
			e.printStackTrace();
		}
		
		return stations;
	}
	
	public PetrolStation getStationById(int id) {
		try {
			PreparedStatement preparedStatement = connection.prepareStatement("SELECT * FROM prices WHERE id=?");
			preparedStatement.setInt(1, id);
			ResultSet resultSet = preparedStatement.executeQuery();
			if(resultSet.next()) {
				return new PetrolStation(resultSet.getInt(1), resultSet.getString(2), resultSet.getString(3), 
						new Fuel(FuelType.Unleaded95, resultSet.getDouble(4)), new Fuel(FuelType.Unleaded98, resultSet.getDouble(5)), 
						new Fuel(FuelType.Diesel, resultSet.getDouble(6)), new Fuel(FuelType.Ethanol, resultSet.getDouble(7)));
			}
		} catch (SQLException e) {
			e.printStackTrace();
		}
		
		return null;
	}
	
	public void addStation(PetrolStation station) {
		try {
			PreparedStatement preparedStatement = connection.prepareStatement("INSERT INTO prices (company, pricePetrol95, pricePetrol98, priceDiesel, priceEthanol)"
					+ " VALUES (?,?,?,?,?)");
			preparedStatement.setString(1, station.getCompany());
			preparedStatement.setDouble(2, station.getUnleaded95().getPrice());
			preparedStatement.setDouble(3, station.getUnleaded98().getPrice());
			preparedStatement.setDouble(4, station.getDiesel().getPrice());
			preparedStatement.setDouble(5, station.getEthanol().getPrice());
			
			preparedStatement.executeUpdate();
		} catch (SQLException e) {
			e.printStackTrace();
		}
	}
}
