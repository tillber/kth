package server;

import java.rmi.RemoteException;
import java.rmi.server.UnicastRemoteObject;
import java.util.ArrayList;
import java.util.List;

import client.ClientCallbackService;
import common.File;
import common.User;
import server.integration.DatabaseHandler;

public class FileCatalogueServant extends UnicastRemoteObject implements FileCatalogueService {
	
	private List<ClientCallbackService> clients = new ArrayList<>();
	private DatabaseHandler dbhandler = new DatabaseHandler();
	
	protected FileCatalogueServant() throws RemoteException {
		super();
	}
	
	public void login(User user, ClientCallbackService client) throws RemoteException{
		if(dbhandler.verifyUser(user) && !loggedIn(client)) {
			clients.add(client);
			client.notifyLogin();
		}else {
			client.notifyFaultyLogin();
		}
	}
	
	public void logout(ClientCallbackService client) throws RemoteException {
		if(loggedIn(client)) {
			clients.remove(client);
			client.notifyLogout();
		}
	}

	public void register(User user, ClientCallbackService client) throws RemoteException {
		if(dbhandler.addUser(user)) {
			client.notifyRegistration();
		}else {
			client.notifyFaultyRegistration();
		}
	}	

	@Override
	public void upload(String filename, int size, ClientCallbackService client) throws RemoteException {
		if(loggedIn(client)) {
			if(dbhandler.uploadFile(new File(filename, client.getUsername(), size))) {
				client.notifyUpload(filename);
			}else {
				client.notifyFaultyUpload(filename);
			}
		}else {
			client.notifyDenied();
		}
	}
	
	public void showCatalogue(ClientCallbackService client) throws RemoteException{
		if(loggedIn(client)) {
			client.showCatalogue(dbhandler.getCatalogue());
		}else {
			client.notifyDenied();
		}
	}
	
	private boolean loggedIn(ClientCallbackService client) throws RemoteException {
		for(ClientCallbackService c : clients) {
			if(c.getUsername().equals(client.getUsername())) {
				return true;
			}
		}
		
		return false;
	}

	public void download(String filename, ClientCallbackService client) throws RemoteException {
		if(loggedIn(client)) {
			File file = dbhandler.getFile(filename);
			client.download(file);

			for(ClientCallbackService c : clients) {
				if(c.getUsername().equals(file.getOwner())) {
					c.notifyFileAccessed(client.getUsername(), file);
				}
			}
		}else {
			client.notifyDenied();
		}
	}
}
