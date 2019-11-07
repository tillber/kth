package common;

import java.io.Serializable;

public class Message implements Serializable {
	private final MessageType type;
	private final String content;
	
	public Message(MessageType type, String content) {
		this.type = type;
		this.content = content;
	}
	
	public Message(String message) {
		this.type = MessageType.valueOf(message.split("[\\{\\}]")[1].split(";")[0].split(":")[1]);
		this.content = message.split("[\\{\\}]")[1].split(";")[1].split(":")[1];
	}
	
	public Message(MessageType type) {
		this.type = type;
		this.content = "";
	}
	
	public String getContent() {
		return content;
	}
	
	public MessageType getType() {
		return type;
	}
	
	public String toString() {
		return "Message{type:" + type + ";content:" + content + "}";
	}
}
