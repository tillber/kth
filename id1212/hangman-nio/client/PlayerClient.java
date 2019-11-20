package client;

import java.io.BufferedReader;
import java.io.ByteArrayOutputStream;
import java.io.InputStreamReader;
import java.io.ObjectOutputStream;
import java.net.InetAddress;
import java.net.InetSocketAddress;
import java.net.SocketAddress;
import java.nio.ByteBuffer;
import java.nio.channels.SelectionKey;
import java.nio.channels.Selector;
import java.nio.channels.SocketChannel;

import common.Message;
import common.MessageType;

public class PlayerClient {
	
	private static String host;
	private static int port;
	private static ByteBuffer messageBuffer = ByteBuffer.allocate(2048);
	private static SocketChannel socketChannel;
	private static Selector selector;
	
	public static void main(String[] args) {
		host = (args.length > 0) ? args[0] : "localhost";
		port = (args.length > 1) ? Integer.parseInt(args[1]) : 8080;

		try {
			socketChannel = SocketChannel.open();
			selector = Selector.open();
			
			InetAddress inetAddress = InetAddress.getByName(host);
			SocketAddress serverAddress = new InetSocketAddress(inetAddress, port);
			
			socketChannel.configureBlocking(false);
			socketChannel.register(selector, SelectionKey.OP_CONNECT);
			socketChannel.connect(serverAddress);
			
			Thread serverConnection = new Thread(new ServerConnection(socketChannel, selector));
			serverConnection.start();
			
			while(!socketChannel.isConnected()) {
				System.out.println("waiting for connection");
				Thread.sleep(2000);
			}
			
			BufferedReader fromClient = new BufferedReader(new InputStreamReader(System.in));
			String input;
			while((input = fromClient.readLine()) != null) {
				if("quit".equalsIgnoreCase(input)) {
					System.out.println("you quit the game");
					socketChannel.close();
					System.exit(0);
				}else{
					messageBuffer.clear();
					
					ByteArrayOutputStream byteStream = new ByteArrayOutputStream();
					ObjectOutputStream objectStream = new ObjectOutputStream(byteStream);
					objectStream.writeObject(new Message(MessageType.INPUT, input));
					objectStream.flush();
					
					messageBuffer.putInt(byteStream.toByteArray().length);
					for(Byte b : byteStream.toByteArray()) {
						messageBuffer.put(b);
					}
					
					messageBuffer.flip();
					socketChannel.write(messageBuffer);
				}
			}
			
		}catch(Exception e) {
			e.printStackTrace();
		}
	}	
}
