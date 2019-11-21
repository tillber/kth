package client;

import java.io.ByteArrayInputStream;
import java.io.IOException;
import java.io.ObjectInputStream;
import java.nio.ByteBuffer;
import java.nio.channels.ClosedChannelException;
import java.nio.channels.SelectionKey;
import java.nio.channels.Selector;
import java.nio.channels.SocketChannel;
import java.util.Iterator;

import common.Message;

public class ServerConnection implements Runnable {
	private SocketChannel socketChannel;
	private Selector selector;
	private ByteBuffer byteBuffer = ByteBuffer.allocate(1024);
	
	public ServerConnection(SocketChannel socketChannel, Selector selector) {
		this.socketChannel = socketChannel;
		this.selector = selector;
	}

	public void run() {
		try {
			while(true) {
				selector.select();
				Iterator<SelectionKey> keys = selector.selectedKeys().iterator();
				while(keys.hasNext()) {
					SelectionKey key = keys.next();
					keys.remove();
					
					if(!key.isValid()) {
						continue;
					}
					
					if(key.isConnectable()) {
						connectToServer(key);
					}else if(key.isReadable()) {
						receiveFromServer(key);	
					}
				}
			}
		} catch (IOException e) {
			e.printStackTrace();
		}
	}
	
	private void connectToServer(SelectionKey key) {
		try {
			SocketChannel sc = (SocketChannel)key.channel();
			sc.finishConnect();
			System.out.println("connected to server");
			socketChannel.register(selector, SelectionKey.OP_READ);
		} catch (ClosedChannelException e) {
			e.printStackTrace();
		} catch (IOException e) {
			e.printStackTrace();
		}
	}
	
	private void receiveFromServer(SelectionKey key) {
		try {
			byteBuffer.clear();
			int readBytes = socketChannel.read(byteBuffer);
			byteBuffer.flip();
			while(readBytes > 0 && byteBuffer.hasRemaining()) {
				int messageLength = byteBuffer.getInt();
				
				byte[] messageInBytes = new byte[messageLength];
				
				int byteCount = 0;
				byte read = 0;
				
				while(byteCount < messageLength && (read = byteBuffer.get()) != -1) {
					messageInBytes[byteCount] = read;
					byteCount++;
				}
				interpretMessage(bytesToMessage(messageInBytes));
			}
		} catch (IOException e) {
			e.printStackTrace();
		}
	}
		
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
		
	private static void interpretMessage(Message message) {
		try {
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
		} catch (Exception e) {
			//System.err.println(e);
			e.printStackTrace();
		}
	}
}
