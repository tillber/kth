package server;
import java.rmi.Remote;
import java.rmi.RemoteException;

import client.ClientCallbackService;
import common.User;

public interface FileCatalogueService extends Remote{	
	public void login(User user, ClientCallbackService client) throws RemoteException;
	
	public void register(User user, ClientCallbackService client) throws RemoteException;
	
	public void logout(ClientCallbackService client) throws RemoteException;
	
	public void showCatalogue(ClientCallbackService client) throws RemoteException;
		
	public void upload(String filename, int size, ClientCallbackService client) throws RemoteException;
	
	public void download(String filename, ClientCallbackService client) throws RemoteException;
	
}
