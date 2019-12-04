package client;
import java.rmi.Remote;
import java.rmi.RemoteException;
import java.util.List;

import common.File;

public interface ClientCallbackService extends Remote {
	public void notifyFileAccessed(String username, File file) throws RemoteException;
	
	public String getUsername() throws RemoteException;
	
	public void notifyLogin() throws RemoteException;
	
	public void notifyFaultyLogin() throws RemoteException;
	
	public void notifyDenied() throws RemoteException;
	
	public void notifyLogout() throws RemoteException;
	
	public void notifyRegistration() throws RemoteException;
	
	public void notifyFaultyRegistration() throws RemoteException;
	
	public void notifyUpload(String filename) throws RemoteException;
	
	public void notifyFaultyUpload(String filename) throws RemoteException;
	
	public void showCatalogue(List<File> files) throws RemoteException;
	
	public void download(File file) throws RemoteException;
}
