package server;

import java.io.FileNotFoundException;
import java.io.IOException;
import java.net.ServerSocket;
import java.net.Socket;

import server.controller.PlayerHandler;

public class Server {
	private int port = 8080;
	private static final int LINGER_TIME = 2000;
	private int handlerCount = 0;
	private ServerSocket socket;
	
	private void work() {
		try {
			socket = new ServerSocket(port);
			while(true) {
				Socket clientSocket = socket.accept();
				clientSocket.setSoLinger(true, LINGER_TIME);
				runHandler(clientSocket);
			}
		} catch (IOException e) {
			System.out.println("Server IOException");
			
			if(!socket.isClosed()) {
				try {
					socket.close();
				} catch (IOException socketException) {
					socketException.printStackTrace(System.err);
				}
			}
		}
	}
	
	private void runHandler(Socket clientSocket) {
		PlayerHandler handler = new PlayerHandler(clientSocket, ++handlerCount);
		Thread handlerThread = new Thread(handler);
		System.out.println("playerhandler " + handlerCount + " started");
		handlerThread.start();
	}
	
	public static void main(String[] args) throws FileNotFoundException {
		Server server = new Server();
		System.out.println("server started");
		server.work();
	}

}
