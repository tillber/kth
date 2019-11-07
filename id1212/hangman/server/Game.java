package server;
import java.util.Arrays;

import common.GameStatus;

public class Game {
	
	private final char[] word;
	private char[] guessed;
	private int attempts;
	private GameStatus status;
	
	/**
	 * Constructor for a new Hangman-game.
	 * @param word
	 */
	public Game(char[] word) {
		this.word = word;
		guessed = new char[word.length];
		Arrays.fill(guessed, '_');
		attempts = word.length;
		status = GameStatus.IN_PROGRESS;
	}
	
	/**
	 * Constructor for a Hangman-game.
	 * @param word
	 * @param guessed
	 * @param attempts
	 */
	public Game(char[] word, int attempts) {
		this.word = word;
		
		this.guessed = new char[word.length];
		for(int i = 0; i < guessed.length; i++) {
			guessed[i] = '_';
		}
		
		this.attempts = attempts;
		status = GameStatus.IN_PROGRESS;
	}
	
	public Game(char[] word, char[] guessed, int attempts) {
		this.word = word;
		this.guessed = guessed;
		this.attempts = attempts;
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
	
	private void checkStatus() {
		if(attempts == 0) {
			status = GameStatus.LOSS;
		}else if(Arrays.equals(word, guessed)) {
			status = GameStatus.WIN;
		}
	}
	
	public void setGuessed(char[] guessed) {
		this.guessed = guessed;
	}
	
	public void setAttempts(int attempts) {
		this.attempts = attempts;
	}
}
