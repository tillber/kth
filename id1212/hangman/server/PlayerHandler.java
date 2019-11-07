package server;
import java.io.IOException;
import java.io.ObjectInputStream;
import java.io.ObjectOutputStream;
import java.net.Socket;
import java.util.Arrays;
import java.util.List;

import common.GameStatus;
import common.Message;
import common.MessageType;

public class PlayerHandler implements Runnable{
	
	private ObjectInputStream fromPlayer;
	private ObjectOutputStream toPlayer;
	
	private final List<String> words;
	private final int id;
	private int score = 0;
	private Game currentGame;
	
	private static final String GUESS = "guess";
	private static final String START = "start";
	
	public PlayerHandler(Socket playerSocket, List<String> words, int id) {
		try {
			this.fromPlayer = new ObjectInputStream(playerSocket.getInputStream());
			this.toPlayer = new ObjectOutputStream(playerSocket.getOutputStream());
		} catch (IOException e) {
			System.out.println("Could not get input stream from client socket!");
			Thread.currentThread().interrupt();
		}
		
		this.words = words;
		this.id = id;
	}

	@Override
	public void run() {		
		startGame();
		
		while(true) {			
			try {
				Message message;
				if((message = (Message)fromPlayer.readObject()) != null) {
					String[] input = message.getContent().split(" ");
					
					if(input[0].equals(GUESS)) {
						try {
							char[] guess = input[1].toUpperCase().toCharArray();
							currentGame.guess(guess);
							
							if(currentGame.getStatus().equals(GameStatus.LOSS)) {
								toPlayer.writeObject(new Message(MessageType.LOSS));
								toPlayer.writeObject(new Message(MessageType.SCORE, String.valueOf(--score)));
								toPlayer.flush();
								currentGame = null;
							}else if(currentGame.getStatus().equals(GameStatus.WIN)) {
								toPlayer.writeObject(new Message(MessageType.WIN));
								toPlayer.writeObject(new Message(MessageType.SCORE, String.valueOf(++score)));
								toPlayer.flush();
								currentGame = null;
							}else{
								toPlayer.writeObject(new Message(MessageType.GUESSED, Arrays.toString(currentGame.getGuessed())));
								toPlayer.writeObject(new Message(MessageType.ATTEMPTS, String.valueOf(currentGame.getAttempts())));
								toPlayer.flush();
							}
							
						} catch (ArrayIndexOutOfBoundsException e) {}
					}else if(input[0].equals(START)) {
						if(currentGame == null) {
							startGame();
						}
					}else {
						toPlayer.writeObject(new Message(MessageType.INVALID));
						toPlayer.flush();
					}
				}
			} catch (Exception e) {
				System.out.println("Player #" + id + " Handler> Connection to player lost.");
				Thread.currentThread().interrupt();
				break;
			}
		}
	}
	
	private void startGame() {
		char[] word = chooseWord();
		currentGame = new Game(word, word.length);
		
		try {
			toPlayer.writeObject(new Message(MessageType.START));
			toPlayer.writeObject(new Message(MessageType.GUESSED, Arrays.toString(currentGame.getGuessed())));
			toPlayer.writeObject(new Message(MessageType.ATTEMPTS, String.valueOf(currentGame.getAttempts())));
			toPlayer.flush();
		} catch (IOException e) {
			System.out.println("Player #" + id + " Handler> Connection to player lost.");
			Thread.currentThread().interrupt();
		}
	}
	
	private char[] chooseWord(){
		int line = (int)(Math.random() * words.size());
		char[] word = words.get(line).toUpperCase().toCharArray();
		System.out.println("Player #" + id + " Handler> Chosen word: " + Arrays.toString(word));
		return word;
	}
}
