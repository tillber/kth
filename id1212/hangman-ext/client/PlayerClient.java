package client;

import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStreamReader;
import java.net.Socket;
import java.net.UnknownHostException;
import common.Message;
import common.MessageType;
import common.Sender;

public class PlayerClient {
	
	private static String host;
	private static int port;
	
	public static void main(String[] args) {
		try {
			host = "localhost";
			port = 8080;
		} catch (ArrayIndexOutOfBoundsException e) {
			System.out.println("Please enter ip-address (1) and port number (2) as arguments");
			System.exit(0);
		}
		
		try {
			Socket serverSocket = new Socket(host, port);
			BufferedReader fromClient = new BufferedReader(new InputStreamReader(System.in));
			Sender toServer = new Sender(serverSocket);
			
			Receiver fromServer = new Receiver(serverSocket);
			Thread listener = new Thread(fromServer);
			listener.start();
			
			while (Thread.currentThread().isAlive()) {
				String input;
				if((input = fromClient.readLine()) != null) {
					if("quit".equalsIgnoreCase(input)) {
						System.out.println("You quit the game");
						serverSocket.close();
						break;
					}else{
						toServer.sendMessage(new Message(MessageType.INPUT, input));
						toServer.flush();
					}
				}
			}
		} catch (UnknownHostException e) {
			System.out.println("Unknown host");
		} catch (IOException e) {
			System.out.println("Connection to server was disrupted");
		}
		
		Thread.currentThread().interrupt();
		return;
	}	
}
