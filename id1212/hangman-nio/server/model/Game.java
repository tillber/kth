package server.model;
import java.io.FileNotFoundException;
import java.io.IOException;
import java.nio.file.Files;
import java.nio.file.Paths;
import java.util.ArrayList;
import java.util.Arrays;
import java.util.List;

public class Game {
	
	private final char[] word;
	private char[] guessed;
	private int attempts;
	private GameStatus status;
	private static List<String> words = new ArrayList<String>();
	
	/**
	 * Constructor for a new Hangman-game.
	 * @param word
	 */
	public Game() {
		try {
			readWords();
		} catch (FileNotFoundException e) {
			System.out.println("words file not found");
		}
		
		word = chooseWord();
		guessed = new char[word.length];
		Arrays.fill(guessed, '_');
		attempts = word.length;
		this.status = GameStatus.IN_PROGRESS;
	}
	
	public Game(char[] word, char[] guessed, int attempts) {
		this.word = word;
		this.guessed = guessed;
		this.attempts = attempts;
		this.status = GameStatus.IN_PROGRESS;
	}
	
	public char[] getWord() {
		return word;
	}
	
	public char[] getGuessed() {
		return guessed;
	}
	
	public int getAttempts() {
		return attempts;
	}
	
	public GameStatus getStatus() {
		return status;
	}
	
	public void guess(char[] guess) {
		if(Arrays.toString(guess).equals(Arrays.toString(word))) {
			guessed = guess;
		} else if(guess.length == 1 && Arrays.toString(word).contains(Character.toString(guess[0]))) {
			for(int i = 0; i < guess.length; i++) {
				for(int j = 0; j < word.length; j++) {
					if(guess[i] == word[j]) {
						guessed[j] = guess[i];
					}
				}
			}
		}else {
			attempts--;
		}
		
		checkStatus();
	}
	
	private static void readWords() throws FileNotFoundException {
		try {
			words = Files.readAllLines(Paths.get("../words.txt"));
		} catch (IOException e) {
			System.out.println("could not read words file, terminating...");
			System.exit(0);
		}
	}
	
	private char[] chooseWord(){
		int line = (int)(Math.random() * words.size());
		char[] word = words.get(line).toUpperCase().toCharArray();
		return word;
	}
	
	private void checkStatus() {
		if(attempts == 0) {
			status = GameStatus.LOSS;
		}else if(Arrays.equals(word, guessed)) {
			status = GameStatus.WIN;
		}else {
			status = GameStatus.IN_PROGRESS;
		}
	}
}
