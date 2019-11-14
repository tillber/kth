package client;
import java.io.ByteArrayInputStream;
import java.io.DataInputStream;
import java.io.IOException;
import java.io.ObjectInputStream;
import java.net.Socket;

import common.Message;

//Client specific class that receives data from server
class Receiver implements Runnable{
	Socket socket;
	
	Receiver(Socket socket){
		this.socket = socket;
	}
	
	@Override
	public void run() {
		try {
			DataInputStream fromServer = new DataInputStream(socket.getInputStream());
			
			while(Thread.currentThread().isAlive()) {				
				int messageLength;
				if((messageLength = fromServer.read()) != -1) {
					byte[] messageInBytes = new byte[messageLength];
					int byteCount = 0;
					byte read = 0;
					
					while(byteCount < messageLength && (read = fromServer.readByte()) != -1) {
						messageInBytes[byteCount] = read;
						byteCount++;
					}
					
					ByteArrayInputStream byteInput = new ByteArrayInputStream(messageInBytes);
					ObjectInputStream objectInput = new ObjectInputStream(byteInput);
					Message message = (Message)objectInput.readObject();
					
					switch(message.getType()) {
					case WIN:
						System.out.println("You won the game! :)");
						System.out.println("The word was: " + message.getContent());
						System.out.println("Start a new game using 'start', or quit using 'quit'");
						break;
					case LOSS:
						System.out.println("You lost the game! :(");
						System.out.println("The word was: " + message.getContent());
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
			}
		} catch (IOException e) {
			System.out.println("Connection to server was disrupted");
		} catch (ClassNotFoundException e) {}
		
		Thread.currentThread().interrupt();
		return;
	}
}