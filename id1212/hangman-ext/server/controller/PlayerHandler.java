package server.controller;
import java.io.ByteArrayInputStream;
import java.io.DataInputStream;
import java.io.IOException;
import java.io.ObjectInputStream;
import java.net.Socket;
import java.util.Arrays;
import common.Message;
import common.MessageType;
import common.Sender;
import server.model.Game;
import server.model.GameStatus;

public class PlayerHandler implements Runnable{
	
	private DataInputStream fromPlayer;
	private Sender toPlayer;
	
	private final int id;
	private int score = 0;
	private Game currentGame;
	
	public PlayerHandler(Socket playerSocket, int id) {
		try {
			this.fromPlayer = new DataInputStream(playerSocket.getInputStream());
			this.toPlayer = new Sender(playerSocket);
		} catch (IOException e) {
			System.out.println("Player #" + id + " Handler> Could not get input stream from client socket!");
			Thread.currentThread().interrupt();
		}
		
		this.id = id;
	}

	@Override
	public void run() {	
		startNewGame();
		
		while(true) {			
			try {	
				int messageLength = fromPlayer.read();
				if(messageLength != -1) {
					byte[] messageInBytes = new byte[messageLength];
					int byteCount = 0;
					byte read = 0;
					
					while(byteCount < messageLength && (read = fromPlayer.readByte()) != -1) {
						messageInBytes[byteCount] = read;
						byteCount++;
					}
					
					ByteArrayInputStream byteInput = new ByteArrayInputStream(messageInBytes);
					ObjectInputStream objectInput = new ObjectInputStream(byteInput);
					Message message = (Message)objectInput.readObject();
					
					String[] input = message.getContent().split(" ");
					
					if(input[0].equals("guess")) {
						try {
							char[] guess = input[1].toUpperCase().toCharArray();
							currentGame.guess(guess);
							
							if(currentGame.getStatus().equals(GameStatus.LOSS)) {
								toPlayer.sendMessage(new Message(MessageType.LOSS, Arrays.toString(currentGame.getWord())));
								toPlayer.sendMessage(new Message(MessageType.SCORE, String.valueOf(--score)));
								toPlayer.flush();
								currentGame = null;
							}else if(currentGame.getStatus().equals(GameStatus.WIN)) {
								toPlayer.sendMessage(new Message(MessageType.WIN, Arrays.toString(currentGame.getWord())));
								toPlayer.sendMessage(new Message(MessageType.SCORE, String.valueOf(++score)));
								toPlayer.flush();
								currentGame = null;
							}else{
								toPlayer.sendMessage(new Message(MessageType.GUESSED, Arrays.toString(currentGame.getGuessed())));
								toPlayer.sendMessage(new Message(MessageType.ATTEMPTS, String.valueOf(currentGame.getAttempts())));
								toPlayer.flush();
							}
							
						} catch (ArrayIndexOutOfBoundsException e) {}
					}else if(input[0].equals("start")) {
						if(currentGame == null) {
							startNewGame();
						}
					}else {
						toPlayer.sendMessage(new Message(MessageType.INVALID));
						toPlayer.flush();
					}
				}
			} catch (IOException ioe) {
				System.out.println("playerhandler" + id + " lost connection to player");
				break;
			} catch (ClassNotFoundException cnfe) {}
			
			
		}
		
		Thread.currentThread().interrupt();
		return;
	}
	
	private void startNewGame() {
		currentGame = new Game();		
		toPlayer.sendMessage(new Message(MessageType.START));
		toPlayer.sendMessage(new Message(MessageType.GUESSED, Arrays.toString(currentGame.getGuessed())));
		toPlayer.sendMessage(new Message(MessageType.ATTEMPTS, String.valueOf(currentGame.getAttempts())));
		toPlayer.flush();
	}
}