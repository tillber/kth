package client;
import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStreamReader;
import java.net.MalformedURLException;
import java.rmi.Naming;
import java.rmi.NotBoundException;
import java.rmi.RemoteException;

import common.User;
import server.FileCatalogueService;

public class Client{
	
	private static ClientCallbackService client;

	public static void main(String[] args) throws MalformedURLException, RemoteException, NotBoundException {
		FileCatalogueService service = (FileCatalogueService)Naming.lookup("rmi://localhost:5099/filecatalogue");
		client = new ClientImplementation();
		
		System.out.println("Welcome to the File Catalogue!");
		System.out.println("Register using: register <username> <password>");
		System.out.println("Login using: login <username> <password>");
		
		BufferedReader fromClient = new BufferedReader(new InputStreamReader(System.in));
		
		while (true) {
			try {
				String input = fromClient.readLine();
				if(input != null) {
					String[] arguments = input.split(" ");
					
					switch(arguments[0]) {
						case "close":
							System.out.println("client closed");
							System.exit(0);
							break;
						case "register":
							service.register(new User(arguments[1], arguments[2]), client);
							break;
						case "login":
							client = new ClientImplementation(arguments[1]);
							service.login(new User(arguments[1], arguments[2]), client);
							break;
						case "logout":
							service.logout(client);
							client = null;
							break;
						case "upload":
							java.io.File file = new java.io.File(arguments[1]);
							if(file.exists()) {
								service.upload(file.getName(), (int)file.length(), client);
							}else {
								System.err.println("the provided file does not exist!");
							}
							break;
						case "download":
							service.download(arguments[1], client);
							break;
						case "show":
							service.showCatalogue(client);
							break;
					}
				}
			} catch (IOException e) {
				e.printStackTrace();
			} catch(ArrayIndexOutOfBoundsException a) {
				System.err.println("you must provide arguments!");
			}
		}
		
	}
}
