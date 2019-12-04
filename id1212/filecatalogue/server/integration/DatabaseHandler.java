package server.integration;

import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.util.ArrayList;
import java.util.List;

import common.File;
import common.User;

public class DatabaseHandler {
	
	private Connection connection;
	
	public DatabaseHandler() {
		try {
			Class.forName("org.sqlite.JDBC");
			connection = DriverManager.getConnection("jdbc:sqlite:C:\\Users\\marti\\Desktop\\Programmering\\FileCatalouge\\src\\filecatalogue.sqlite");
		} catch (ClassNotFoundException e) {
			System.err.println("could not find jdbc driver for sqlite!");
		} catch (SQLException e) {
			System.err.println("could not establish connection to file catalogue database!");
		}
	}
	
	public boolean userExists(String username) {
		try {
			PreparedStatement preparedStatement = connection.prepareStatement("SELECT (COUNT(*)>0) FROM users WHERE username=?");
			preparedStatement.setString(1, username);
			ResultSet resultSet = preparedStatement.executeQuery();
			if(resultSet.next()) {
				return resultSet.getBoolean(1);
			}
		} catch (SQLException e) {
			e.printStackTrace();
		}
		return false;
	}
	
	public boolean fileExists(String filename) {
		try {
			PreparedStatement preparedStatement = connection.prepareStatement("SELECT (COUNT(*)>0) FROM files WHERE name=?");
			preparedStatement.setString(1, filename);
			ResultSet resultSet = preparedStatement.executeQuery();
			if(resultSet.next()) {
				return resultSet.getBoolean(1);
			}
		} catch (SQLException e) {
			e.printStackTrace();
		}
		return false;
	}

	/*Uploads a file to the File Catalogue*/
	public boolean uploadFile(File file) {
		if(!fileExists(file.getName())) {
			try {
				PreparedStatement preparedStatement = connection.prepareStatement("INSERT INTO files (name, owner, size) VALUES(?, ?, ?)");
				preparedStatement.setString(1, file.getName());
				preparedStatement.setString(2, file.getOwner());
				preparedStatement.setInt(3, file.getSize());
				int result = preparedStatement.executeUpdate();
				if(result > 0) {
					return true;
				}
			} catch (SQLException e) {
				e.printStackTrace();
			}
		}
		
		return false;
	}
	
	/*Searches for and downloads a file from the File Catalogue*/
	public File downloadFile(String filename) {
		if(fileExists(filename)) {
			try {
				PreparedStatement preparedStatement = connection.prepareStatement("SELECT name, owner, size FROM files WHERE name=?");
				preparedStatement.setString(1, filename);
				ResultSet resultSet = preparedStatement.executeQuery();
				if(resultSet.next()) {
					return new File(resultSet.getString(1), resultSet.getString(2), resultSet.getInt(3));
				}
			} catch (SQLException e) {
				e.printStackTrace();
			}
		}
		
		return null;
	}
	
	public boolean verifyUser(User user) {
		try {
			PreparedStatement preparedStatement = connection.prepareStatement("SELECT username, password FROM users WHERE username=?");
			preparedStatement.setString(1, user.getUsername());
			
			ResultSet resultSet = preparedStatement.executeQuery();
			if(resultSet.next()) {
				if(resultSet.getString(2).equals(user.getPassword())) {
					return true;
				}
			}
		} catch (SQLException e) {
			e.printStackTrace();
		}	
		
		return false;
	}
	
	public boolean addUser(User user) {
		if(!userExists(user.getUsername())) {
			try {
				PreparedStatement preparedStatement = connection.prepareStatement("INSERT INTO users (username, password) VALUES(?, ?)");
				preparedStatement.setString(1, user.getUsername());
				preparedStatement.setString(2, user.getPassword());
				int result = preparedStatement.executeUpdate();
				if(result > 0) {
					return true;
				}
			} catch (SQLException e) {
				e.printStackTrace();
			}
		}
		
		return false;
	}
	
	public List<File> getCatalogue() {
		try {
			PreparedStatement preparedStatement = connection.prepareStatement("SELECT name, owner, size FROM files");
			ResultSet resultSet = preparedStatement.executeQuery();
			List<File> files = new ArrayList<>();
			while(resultSet.next()) {
				files.add(new File(resultSet.getString(1), resultSet.getString(2), resultSet.getInt(3)));
			}
			
			return files;
		} catch (SQLException e) {
			e.printStackTrace();
		}
		
		return null;
	}
	
	public File getFile(String filename) {
		try {
			PreparedStatement preparedStatement = connection.prepareStatement("SELECT name, owner, size FROM files WHERE name=?");
			preparedStatement.setString(1, filename);
			ResultSet resultSet = preparedStatement.executeQuery();
			if(resultSet.next()) {
				return new File(resultSet.getString(1), resultSet.getString(2), resultSet.getInt(3));
			}
		} catch (SQLException e) {
			e.printStackTrace();
		}
		
		return null;		
	}
}
