package server;

import java.io.FileNotFoundException;
import java.io.IOException;
import java.net.InetSocketAddress;
import java.nio.channels.SelectionKey;
import java.nio.channels.Selector;
import java.nio.channels.ServerSocketChannel;
import java.nio.channels.SocketChannel;
import java.util.ArrayList;
import java.util.Iterator;
import java.util.List;

import server.controller.PlayerHandler;

public class Server {
	private ServerSocketChannel serverSocketChannel;
	private Selector selector;
	private List<PlayerHandler> clients = new ArrayList<>();
	private Iterator<SelectionKey> keys;
	
	private void work() {
		try {
			serverSocketChannel = ServerSocketChannel.open();
			selector = Selector.open();
			
			serverSocketChannel.configureBlocking(false);
			serverSocketChannel.bind(new InetSocketAddress("localhost", 8080));
			serverSocketChannel.register(selector, SelectionKey.OP_ACCEPT);
			
			while(true) {
				selector.select();
				keys = selector.selectedKeys().iterator();
				while(keys.hasNext()) {
					SelectionKey key = keys.next();
					keys.remove();
					
					if(!key.isValid()) {
						continue;
					}
					
					if(key.isAcceptable()) {
						startHandler(key);
					}
					
				}
				
				for(PlayerHandler client : clients) {
					Selector localSelector = client.getSelector();
					localSelector.select();
					keys = localSelector.selectedKeys().iterator();
					while(keys.hasNext()) {
						SelectionKey key = keys.next();
						keys.remove();
						
						if(!key.isValid()) {
							continue;
						}
						
						if(key.isReadable()) {
							receiveFromClient(key);
						}
					}
				}
			}			
		} catch (IOException e) {
			e.printStackTrace();
		}
	}
	
	private void receiveFromClient(SelectionKey key) {
		PlayerHandler playerHandler = (PlayerHandler)key.attachment();
		playerHandler.receiveFromClient(key);
	}
	
	private void startHandler(SelectionKey key) throws IOException {
		SocketChannel socketChannel = serverSocketChannel.accept();
		System.out.println("client connected");
		socketChannel.configureBlocking(false);
		
		PlayerHandler playerHandler = new PlayerHandler(socketChannel, selector);
		playerHandler.startNewGame();
		socketChannel.register(selector, SelectionKey.OP_READ, playerHandler);
		clients.add(playerHandler);
	}
	
	public static void main(String[] args) throws FileNotFoundException {
		Server server = new Server();
		System.out.println("server started");
		server.work();
	}

}
