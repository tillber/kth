package client;

import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStreamReader;
import java.io.ObjectInputStream;
import java.io.ObjectOutputStream;
import java.net.Socket;
import java.net.UnknownHostException;
import common.Message;
import common.MessageType;

public class PlayerClient {
	
	static String host;
	static int port;
	
	public static void main(String[] args) throws UnknownHostException, IOException {
		try {
			host = "localhost";
			port = 8080;
		} catch (ArrayIndexOutOfBoundsException e) {
			System.out.println("Please enter ip-address (1) and port number (2) as arguments");
			System.exit(0);
		}
		
		Socket socket = new Socket(host, port);
		BufferedReader fromClient = new BufferedReader(new InputStreamReader(System.in));
		ObjectOutputStream toServer = new ObjectOutputStream(socket.getOutputStream());
		
		ServerReader fromServer = new ServerReader(socket);
		Thread listener = new Thread(fromServer);
		listener.start();
		
		String input;
		while ((input = fromClient.readLine()) != null) {
			if("quit".equalsIgnoreCase(input)) {
				socket.close();
				break;
			}else{
				toServer.writeObject(new Message(MessageType.INPUT, input));
			}
		}
		
		Thread.currentThread().interrupt();
		return;
	}
}

class ServerReader implements Runnable{
	Socket socket;
	
	ServerReader(Socket socket){
		this.socket = socket;
	}
	
	@Override
	public void run() {
		try {
			ObjectInputStream fromServer = new ObjectInputStream(socket.getInputStream());
			Message message;
			while ((message = (Message) fromServer.readObject()) != null) {
				switch(message.getType()) {
				case WIN:
					System.out.println("You won the game! :)");
					System.out.println("Start a new game using 'start', or quit using 'quit'");
					break;
				case LOSS:
					System.out.println("You lost the game! :(");
					System.out.println("Start a new game using 'start', or quit using 'quit'");
					break;
				case ATTEMPTS:
					if(Integer.parseInt(message.getContent()) > 1) {
						System.out.println("(" + message.getContent() + " attempts left)");
					}else {
						System.out.println("(" + message.getContent() + " attempt left)");
					}
					break;
				case SCORE:
					System.out.println("Your current score is: " + message.getContent());
					break;
				case INVALID:
					System.out.println("Invalid input, try again.");
					break;
				case START:
					System.out.println("Hangman game started");
					System.out.println("Make a guess by using 'guess' followed by your guess, or 'quit' to quit the game");
					break;
				case GUESSED:
					System.out.print(message.getContent());
					break;
				default:
					break;
				}
			}
			fromServer.close();
		} catch (IOException e) {
			System.out.println("Connection closed");
		} catch (ClassNotFoundException e) {}
		
		Thread.currentThread().interrupt();
		return;
	}
	
}
