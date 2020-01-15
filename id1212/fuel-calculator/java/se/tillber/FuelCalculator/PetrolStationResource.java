package se.tillber.FuelCalculator;

import java.util.ArrayList;
import java.util.List;

import javax.ws.rs.Consumes;
import javax.ws.rs.FormParam;
import javax.ws.rs.GET;
import javax.ws.rs.POST;
import javax.ws.rs.Path;
import javax.ws.rs.PathParam;
import javax.ws.rs.Produces;
import javax.ws.rs.QueryParam;
import javax.ws.rs.core.MediaType;

@Path("stations")
public class PetrolStationResource {
	
	StationRepository repository = new StationRepository();
	
	@GET
	@Produces(MediaType.APPLICATION_JSON)
	public List<PetrolStation> getAllStations() {
		List<PetrolStation> stations = new ArrayList<>();
		stations = repository.getAllStations();
		return stations;
	}
	
	@GET
	@Path("{id}")
	@Produces(MediaType.APPLICATION_JSON)
	public PetrolStation getStationById(@PathParam("id") int id){
		PetrolStation station = repository.getStationById(id);
		return station;
	}
	
	@POST
	@Produces(MediaType.APPLICATION_JSON)
	public List<FuelComparison> calculateCheapest(@FormParam("ps1") int ps1, @FormParam("ps2") int ps2, 
			@FormParam("distance") int distance, @FormParam("consumption") double consumption) {
		
		PetrolStation firstStation = repository.getStationById(ps1);
		PetrolStation secondStation = repository.getStationById(ps2);
		
		double liters = (distance * consumption) / 10;
		
		List<FuelComparison> result = new ArrayList<>();
		
		result.add(new FuelComparison(firstStation.getUnleaded95(), secondStation.getUnleaded95(), firstStation.getCompany(), secondStation.getCompany(), liters));
		result.add(new FuelComparison(firstStation.getUnleaded98(), secondStation.getUnleaded98(), firstStation.getCompany(), secondStation.getCompany(), liters));
		result.add(new FuelComparison(firstStation.getDiesel(), secondStation.getDiesel(), firstStation.getCompany(), secondStation.getCompany(), liters));
		result.add(new FuelComparison(firstStation.getEthanol(), secondStation.getEthanol(), firstStation.getCompany(), secondStation.getCompany(), liters));
		
		return result;
	}
	
	@POST
	@Path("add")
	public void addStation(@FormParam("addCompanyName") String company, @FormParam("addUnleaded95") double unleaded95, @FormParam("addUnleaded98") double unleaded98,
			@FormParam("addDiesel") double diesel, @FormParam("addEthanol") double ethanol) {
		PetrolStation station = new PetrolStation(company, new Fuel(FuelType.Unleaded95, unleaded95), new Fuel(FuelType.Unleaded98, unleaded98),
				new Fuel(FuelType.Diesel, diesel), new Fuel(FuelType.Ethanol, ethanol));
		
		repository.addStation(station);
	}
}
