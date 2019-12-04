package server;
import java.rmi.RemoteException;
import java.rmi.registry.LocateRegistry;
import java.rmi.registry.Registry;

public class Startup {

	public static void main(String[] args) throws RemoteException {
		Registry registry = LocateRegistry.createRegistry(5099);
		registry.rebind("filecatalogue", new FileCatalogueServant());
		System.out.println("invoked filecatalogue-servant");
	}

}
