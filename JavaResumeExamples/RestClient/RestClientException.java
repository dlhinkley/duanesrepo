package connector.data.brightpearl.api;

import connector.main.Main;


public class RestClientException extends Exception {

	/**
	 * 
	 */
	private static final long serialVersionUID = 7585156968744797092L;
	private int statusCode;

	public RestClientException(String message) {
		super(message);
		Main.logDebug(this,"message=" + message, 1);
	}

	public RestClientException(String message, Exception e) {
		super(message,e);
		Main.logDebug(this,"message=" + message + " exceptionMessage=" + e.getMessage(), 1);
	}

	public RestClientException(String message, int statusCode) {
		super(message);
		Main.logDebug(this,"message=" + message + " statusCode=" + statusCode, 1);
		this.statusCode = statusCode;
	}
	public int getStatusCode() {
		
		return statusCode;
	}
}
