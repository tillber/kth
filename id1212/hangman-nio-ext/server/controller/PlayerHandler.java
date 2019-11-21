package server.controller;
import java.io.ByteArrayInputStream;
import java.io.ByteArrayOutputStream;
import java.io.IOException;
import java.io.ObjectInputStream;
import java.io.ObjectOutputStream;
import java.nio.ByteBuffer;
import java.nio.channels.SelectionKey;
import java.nio.channels.Selector;
import java.nio.channels.SocketChannel;
import java.util.Arrays;

import common.Message;
import common.MessageType;
import server.model.Game;
import server.model.GameStatus;

public class PlayerHandler{	
	private SocketChannel socketChannel;
	private Selector selector;
	
	private Game currentGame;
	private int score = 0;
	
	private ByteBuffer messageBuffer = ByteBuffer.allocate(1024);
	
	public PlayerHandler(SocketChannel socketChannel, Selector selector) {
		this.socketChannel = socketChannel;
		this.selector = selector;
	}
	
	private void sendMessage(Message message) {
		try {
			messageBuffer.clear();
			
			ByteArrayOutputStream byteStream = new ByteArrayOutputStream();
			ObjectOutputStream objectStream = new ObjectOutputStream(byteStream);
			objectStream.writeObject(message);
			objectStream.flush();
			
			messageBuffer.putInt(byteStream.toByteArray().length);
			for(Byte b : byteStream.toByteArray()) {
				messageBuffer.put(b);
			}
			
			messageBuffer.flip();
			socketChannel.write(messageBuffer);
			
		} catch (IOException e) {
			e.printStackTrace();
		}
	}
	
	public void receiveFromClient(SelectionKey key) {
		try {
			messageBuffer.clear();
			int readBytes = socketChannel.read(messageBuffer);
			
			if(readBytes == -1) {
				throw new IOException();
			}
			
			messageBuffer.flip();
			
			while(readBytes > 0 && messageBuffer.hasRemaining()) {
				int messageLength = messageBuffer.getInt();
				
				byte[] messageInBytes = new byte[messageLength];
				
				int byteCount = 0;
				byte read = 0;
				
				while(byteCount < messageLength && (read = messageBuffer.get()) != -1) {
					messageInBytes[byteCount] = read;
					byteCount++;
				}
				
				String[] input = bytesToMessage(messageInBytes).getContent().split(" ");
				if(input[0].equals("guess")) {
					try {
						char[] guess = input[1].toUpperCase().toCharArray();
						currentGame.guess(guess);
						
						if(currentGame.getStatus().equals(GameStatus.LOSS)) {
							sendMessage(new Message(MessageType.LOSS, Arrays.toString(currentGame.getWord())));
							sendMessage(new Message(MessageType.SCORE, String.valueOf(--score)));
							currentGame = null;
						}else if(currentGame.getStatus().equals(GameStatus.WIN)) {
							sendMessage(new Message(MessageType.WIN, Arrays.toString(currentGame.getWord())));
							sendMessage(new Message(MessageType.SCORE, String.valueOf(++score)));
							currentGame = null;
						}else{
							sendMessage(new Message(MessageType.GUESSED, Arrays.toString(currentGame.getGuessed())));
							sendMessage(new Message(MessageType.ATTEMPTS, String.valueOf(currentGame.getAttempts())));
						}
						
					} catch (ArrayIndexOutOfBoundsException e) {}
				}else if(input[0].equals("start")) {
					if(currentGame == null) {
						startNewGame();
					}
				}else {
					sendMessage(new Message(MessageType.INVALID));
				}
			}
		} catch (IOException e) {
			System.out.println("client disconnected");
			Thread.currentThread().interrupt();
		}
	}
	
	/*Converts a byte array to a Message object*/
	private Message bytesToMessage(byte[] bytes) {
		Message message = null;
		try {
			ByteArrayInputStream byteInput = new ByteArrayInputStream(bytes);
			ObjectInputStream objectInput = new ObjectInputStream(byteInput);
			message = (Message)objectInput.readObject();
		} catch (ClassNotFoundException e) {
			e.printStackTrace();
		} catch (IOException e) {
			e.printStackTrace();
		}
		return message;
	}
	
	public void startNewGame() {
		currentGame = new Game();
		sendMessage(new Message(MessageType.START));
		sendMessage(new Message(MessageType.GUESSED, Arrays.toString(currentGame.getGuessed())));
		sendMessage(new Message(MessageType.ATTEMPTS, String.valueOf(currentGame.getAttempts())));
	}
	
	public Selector getSelector() {
		return selector;
	}
}