package client;
import java.io.FileNotFoundException;
import java.io.IOException;
import java.io.RandomAccessFile;
import java.rmi.RemoteException;
import java.rmi.server.UnicastRemoteObject;
import java.util.List;

import common.File;

public class ClientImplementation extends UnicastRemoteObject implements ClientCallbackService{
	
	private String username;
	
	protected ClientImplementation() throws RemoteException {
		super();
	}
	
	protected ClientImplementation(String username) throws RemoteException {
		super();
		this.username = username;
	}
	
	public void notifyFileAccessed(String username, File file) throws RemoteException {
		System.out.println("User " + username + " accessed your file '" + file.getName() + "'!");
	}

	@Override
	public String getUsername() {
		return username;
	}

	@Override
	public void notifyLogin() throws RemoteException {
		System.out.println("you successfully logged in to the server!");
	}

	@Override
	public void notifyFaultyLogin() throws RemoteException {
		System.err.println("unsuccessful login");
	}

	@Override
	public void notifyLogout() throws RemoteException {
		System.out.println("you was logged out from the file catalogue!");
	}

	@Override
	public void notifyRegistration() throws RemoteException {
		System.out.println("user is now registered!");
	}

	@Override
	public void notifyFaultyRegistration() throws RemoteException {
		System.err.println("could not register user!");
	}

	@Override
	public void notifyUpload(String filename) throws RemoteException {
		System.out.println("your file '" + filename + "' was successfully uploaded");
	}

	@Override
	public void notifyFaultyUpload(String filename) throws RemoteException {
		System.err.println("could not upload file '" + filename + "'");
	}

	@Override
	public void showCatalogue(List<File> files) throws RemoteException {
		for(File file : files) {
			System.out.println(file);
		}
	}
	
	public void download(File downloadedFile) throws RemoteException{
		try {
			java.io.File file = new java.io.File("./" + downloadedFile.getName());
			RandomAccessFile raFile = new RandomAccessFile(file, "rw");
			raFile.setLength(downloadedFile.getSize());
			System.out.println("you downloaded: " + downloadedFile);
		} catch (FileNotFoundException e) {
			e.printStackTrace();
		} catch (IOException e) {
			e.printStackTrace();
		}
	}
	
	public void notifyDenied() throws RemoteException{
		System.err.println("access denied, please login!");
	}
}
