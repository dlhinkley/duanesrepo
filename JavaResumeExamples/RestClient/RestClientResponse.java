package connector.data.brightpearl.api;

import java.io.IOException;
import java.io.InputStreamReader;
import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;

import org.apache.commons.lang.StringUtils;
import org.apache.http.HttpResponse;
import org.apache.http.ParseException;
import org.apache.http.util.EntityUtils;
import org.json.simple.JSONObject;
import org.json.simple.JSONValue;

import connector.main.Main;

public class RestClientResponse {

	private int statusCode;
	private JSONObject jsonObject;
	private HashMap<Integer,String> codes = new HashMap<Integer,String>();

	public RestClientResponse(HttpResponse httpResponse) throws RestClientException {

		initMessages();
		
		this.statusCode = httpResponse.getStatusLine().getStatusCode();
		
		this.jsonObject = readResponse(httpResponse);
		
		consumeResponse( httpResponse);
	}
	private void consumeResponse(HttpResponse httpResponse) throws RestClientException {
		
        // Consume the response
        try {
			EntityUtils.toString(httpResponse.getEntity());
		} 
        catch (IllegalStateException e) {
			
        	// This is ok
			Main.logDebug(this,"IllegalStateException=" + e.getMessage(),10);

		} 
        catch (ParseException e) {
			
        	// This is ok
			Main.logDebug(this,"ParseException=" + e.getMessage(),10);

		} 
        catch (IOException e) {
			
        	// This is ok
			Main.logDebug(this,"IOException=" + e.getMessage(),10);
		}
		
	}
	private void initMessages() {
		
		codes.put(400, "Bad Request"); // You will generally encounter this status code if you send a malformed request to the Brightpearl API or if that request cannot be validated. For example if you attempt to create a contact with a missing or invalid email addres, you can expect to receive a 400.
		
		codes.put(401, "Unauthorized"); // If you attempt to access the Brightpearl API without an authorisation token, or attempt to authorise yourself using invalid credentials, you will receive 401
		codes.put(403, "Forbidden"); // For reasons of security, the reasons why you receive this status code are kept vague, but you will receive it when you attempt to do something the Brightpearl API decides that you are not allowed to.
		codes.put(404, "Not Found"); // 404 means that the resource you wanted to manipulate could not be found; for example issuing a Warehouse DELETE against an ID that does not exist will result in a 404. It can also mean that you have a mistake in the structure of your URI, so when you are first developing your integration, check your URIs when you see a 404.
		codes.put(409, "Conflict"); // We will send this error if your request is syntactically correct but violates some business rule. For example, if you issue a Warehouse POST request which is syntactically correct but specifies a warehouse name that is already in use, you will receive a 409
		codes.put(500, "Internal Server Error"); // This status code indicates a technical failure inside the Brightpearl API. You can infer nothing about the actual status of your response from this status code, and you should proceed with caution before attempting to issue the request again. If you receive this status code, the body of the response should include instructions on how to contact Brightpearl.
		codes.put(503, "Service Unavailable"); // You will receive this status code if the Brightpearl API is too busy to accept your request, or if your access to the Brightpearl API has been temporarily suspended due to overuse.
		codes.put(200, "OK"); // The request was as completed as expected: if you issued a GET, one or more resources were returned; POST, one or more resources were created; PUT one or more resources were modified; DELETE one or more resources were destroyed.
		codes.put(207, "Multi-Status"); // Only returned if you have performed a destructive operation (POST, PUT, DELETE) against more than one resource and the operations against each indiviudal resource did not share a common outcome. For example, if you DELETEd two resources and both were deleted you can expect 200. If both DELETEs were forbidden, you'd expect 403. If one DELETE was successful but one was forbidden, you would receive 207. Information about the result of each individual operation is included in the response.
		
	}	
	
	private JSONObject readResponse(HttpResponse httpResponse) {
		
		JSONObject response = null;
		try {
			InputStreamReader reader = new InputStreamReader( httpResponse.getEntity().getContent() );
			response = (JSONObject) JSONValue.parse(reader);	
		} 
		catch (IllegalStateException e) {

			Main.logDebug(this,"IllegalStateException message=" + e.getMessage(), 1);
			//throw new RestClientException("Invalid state received for post from server",e);

		} 
		catch (IOException e) {

			Main.logDebug(this,"IOException message=" + e.getMessage(), 1);
//			throw new RestClientException("Error recieving post from server",e);
		} 
		return response;
	}
	public int getStatusCode() {

		return this.statusCode;
	}
	public String getStatusMessage() {
		
		return codes.get(statusCode);
	}
	public JSONObject getJsonObject() {

		return jsonObject;
	}
	public boolean isSuccess() {

		return ( statusCode == 200 || statusCode == 207 );
	}
	public String getMessage() {
		
		String message;
		
		if ( isErrorMessageExists() ) {
			
			message = getErrorMessage();
		}
		else {
			
			message = getStatusMessage();
		}
		return message;
		
	}
	private String getErrorMessage() {
		
        List<JSONObject> jsonErrorsList =  (List<JSONObject>) jsonObject.get("errors");
        ArrayList<String> messageArray = new ArrayList<String>();
        
        for(JSONObject jsonError : jsonErrorsList){

        	messageArray.add( jsonError.get("message").toString() );
        }
		return StringUtils.join(messageArray, "\n");
	}
	private boolean isErrorMessageExists() {
		
		boolean message = false;
		
		try {
		 
			message = jsonObject.containsKey("errors");
		}
		catch (NullPointerException e) {
			
			// Nothing returned
		}
		
		return message;
	}
}
