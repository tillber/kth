package server;

import java.io.FileNotFoundException;
import java.io.IOException;
import java.net.ServerSocket;
import java.net.Socket;
import java.nio.file.Files;
import java.nio.file.Paths;
import java.util.ArrayList;
import java.util.List;

public class Server {
	private int port = 8080;
	private static final int LINGER_TIME = 2000;
	private static List<String> words = new ArrayList<>();
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
		PlayerHandler handler = new PlayerHandler(clientSocket, words, ++handlerCount);
		Thread handlerThread = new Thread(handler);
		System.out.println("PlayerHandler " + handlerCount + " started");
		handlerThread.start();
	}
	
	private static void readWords() throws FileNotFoundException {
		try {
			words = Files.readAllLines(Paths.get("../words.txt"));
		} catch (IOException e) {
			System.out.println("Could not read words file, terminating...");
			System.exit(0);
		}
	}
	
	public static void main(String[] args) throws FileNotFoundException {
		Server server = new Server();
		System.out.println("Server started");
		readWords();
		server.work();
	}

}
