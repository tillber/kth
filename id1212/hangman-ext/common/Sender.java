package common;

import java.io.ByteArrayOutputStream;
import java.io.DataOutputStream;
import java.io.IOException;
import java.io.ObjectOutputStream;
import java.net.Socket;

/**
 * Sends messages as bytes to the given socket
 * @author tillber
 *
 */
public class Sender {
	private DataOutputStream toRecipient;
	
	public Sender(Socket recipientSocket) {
		try {
			this.toRecipient = new DataOutputStream(recipientSocket.getOutputStream());
		} catch (IOException e) {
			e.printStackTrace();
		}
	}
	
	/**
	 * Returns the byte length of any object
	 * @param object The object
	 * @return The length of the object
	 */
	public int getByteLength(Object object) {
		int length = 0;
		try {
			ByteArrayOutputStream byteStream = new ByteArrayOutputStream();
			ObjectOutputStream objectStream = new ObjectOutputStream(byteStream);
			
			objectStream.writeObject(object);
			objectStream.flush();
			
			length = byteStream.toByteArray().length;
			
			byteStream.close();
			objectStream.close();
		} catch (IOException e) {
			e.printStackTrace();
		}
		return length;
	}
	
	/**
	 * Sends a message to the recipient socket
	 * @param message The message to be sent
	 */
	public void sendMessage(Message message) {
		try {
			toRecipient.write(getByteLength(message));
			
			ByteArrayOutputStream byteOutput = new ByteArrayOutputStream();
			ObjectOutputStream objectOutput = new ObjectOutputStream(byteOutput);
			objectOutput.writeObject(message);
			
			for(byte byteToSend : byteOutput.toByteArray()) {
				toRecipient.writeByte(byteToSend);
			}
		} catch (IOException e) {
			e.printStackTrace();
		}
	}
	
	/**
	 * Sends messages to the recipient socket
	 * @param messages The messages to be sent
	 */
	public void sendMessage(Message... messages) {
		for(Message message : messages) {
			sendMessage(message);
		}
	}
	
	/**
	 * Flushes the output stream.
	 */
	public void flush() {
		try {
			toRecipient.flush();
		} catch (IOException e) {
			e.printStackTrace();
		}
	}
	
}
