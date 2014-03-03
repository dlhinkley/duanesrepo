package connector.data.brightpearl.api;

import java.io.IOException;
import java.io.UnsupportedEncodingException;
import java.util.ArrayList;
import java.util.List;

import org.apache.http.HttpRequest;
import org.apache.http.HttpResponse;
import org.apache.http.client.ClientProtocolException;
import org.apache.http.client.methods.HttpDelete;
import org.apache.http.client.methods.HttpGet;
import org.apache.http.client.methods.HttpPost;
import org.apache.http.client.methods.HttpPut;
import org.apache.http.entity.StringEntity;
import org.apache.http.impl.client.DefaultHttpClient;
import org.apache.http.util.EntityUtils;
import org.json.simple.JSONObject;
import org.json.simple.JSONValue;

import connector.data.brightpearl.Credentials;
import connector.main.Main;

/**
 * Provides connectivity and rest methods to communicate with 
 * Brightpearl's API
 */
public class RestClient {

	private Credentials credentials;
	private static final String AUTHENTICATE_URI_TEMPLATE  = "https://ws-%s.brightpearl.com/%s/authorise";	 
	private static final String URI_PREFIX_TEMPLATE = "https://ws-%s.brightpearl.com/2.0.0/%s/";
	private String authenticateUri;
	private String authenticationToken;
	private DefaultHttpClient httpClient;
	private String uriPrefix;

	public RestClient(Credentials credentials) {

		
		this.credentials = credentials;
	    this.httpClient = new DefaultHttpClient();
	    this.uriPrefix = String.format(URI_PREFIX_TEMPLATE, credentials.dataCentreCode, credentials.accountId );
	    authenticateUri = String.format(AUTHENTICATE_URI_TEMPLATE, credentials.dataCentreCode, credentials.accountId );
	}

	public JSONObject postJson(String path, JSONObject jsonObject) throws RestClientException {
		
		String uri = this.uriPrefix + path;
		HttpPost httpPost = new HttpPost(uri);
		
		return postJson(httpPost,jsonObject);
	}
	public JSONObject postJson(HttpPost httpPost, JSONObject jsonObject) throws RestClientException {

		Main.logDebug(this,"uri=" + httpPost.getURI() + " jsonObject=" + jsonObject, 10);

		String json = JSONValue.toJSONString(jsonObject);
		
		try {
			httpPost.setEntity(new StringEntity(json));
		} 
		catch (UnsupportedEncodingException e) {

			throw new RestClientException("Error encoding post",e);
		}
		setHeaders(httpPost);

		HttpResponse httpResponse;
		try {
			httpResponse = this.httpClient.execute(httpPost);
			
		} 
		catch (ClientProtocolException e) {

			throw new RestClientException("Invalid post protocol",e);
		} 
		catch (IOException e) {

			throw new RestClientException("Error sending post to server",e);
		}

		
		RestClientResponse restClientResponse = new RestClientResponse(httpResponse);
		
		
		Main.logDebug(this,"statusCode=" + restClientResponse.getStatusCode() + " message=" + restClientResponse.getStatusMessage(), 10);

		if( restClientResponse.isSuccess()) {


		}
		else{

			throw new RestClientException(restClientResponse.getMessage(),restClientResponse.getStatusCode());
		}
		Main.logDebug(this,"response=" + restClientResponse.getJsonObject(), 10);
		
		return restClientResponse.getJsonObject();
	}
	public void putJson(String path, JSONObject jsonObject) throws RestClientException{
		
		Main.logDebug(this,"path=" + path + " jsonObject=" + jsonObject, 10);
		
		String uri = this.uriPrefix + path;
		
		Main.logDebug(this,"uri=" + uri, 10);
		 
	    HttpPut put = new HttpPut(uri);
	     
		String json = JSONValue.toJSONString(jsonObject);

		try {
			put.setEntity(new StringEntity(json));
		} 
		catch (UnsupportedEncodingException e) {

			throw new RestClientException("Invalid put encoding",e);
		}
		
		
	    setHeaders(put);
	     
	    HttpResponse httpResponse;
		try {
			httpResponse = this.httpClient.execute(put);
		} 
		catch (ClientProtocolException e) {
			
			throw new RestClientException("Invalid put protocol",e);
		} 
		catch (IOException e) {
			
			throw new RestClientException("Error sending put to server",e);
		}
	    
		RestClientResponse restClientResponse = new RestClientResponse(httpResponse);
	    
		Main.logDebug(this,"statusCode=" + restClientResponse.getStatusCode() + " message=" + restClientResponse.getStatusMessage(), 10);
	     
	    if( restClientResponse.isSuccess() ){
	    	
	        Main.logDebug(this,"record put",10);
      
	    }
	    else{
			throw new RestClientException(restClientResponse.getMessage(),restClientResponse.getStatusCode());
	    }
	}
	public JSONObject getJson(String path, Long id) throws RestClientException {
		
		path += "/" + id;
		
		return getJson(path);
	}
	public ArrayList<JSONObject> getJsonSearch(String path, String search) throws RestClientException {
		
		path += "-search?" + search;
		
		JSONObject jsonObject = getJson(path);
		
		return readSearchResponse(jsonObject);
	}
	public JSONObject getJson(String path) throws RestClientException {
		 
		String uri = this.uriPrefix + path;
		
		Main.logDebug(this,"uri=" + uri, 10);

		HttpGet get = new HttpGet(uri);
	    setHeaders(get);
	      
	    HttpResponse httpResponse;
	    
	    try {
			 httpResponse = this.httpClient.execute(get);
	    } 
		catch (ClientProtocolException e) {
			
			throw new RestClientException("Invalid get protocol",e);
		} 
		catch (IOException e) {
			
			throw new RestClientException("Error sending get to server",e);
		}
		
		
		RestClientResponse restClientResponse = new RestClientResponse(httpResponse);
		
		Main.logDebug(this,"statusCode=" + restClientResponse.getStatusCode() + " message=" + restClientResponse.getStatusMessage(), 10);
		
	    if ( ! restClientResponse.isSuccess() ) {
	    	
			throw new RestClientException(restClientResponse.getMessage(),restClientResponse.getStatusCode());
	    }
		
		Main.logDebug(this,"response=" + restClientResponse.getJsonObject(), 10);
		
		return restClientResponse.getJsonObject();
	}
	public void delete(String path) throws RestClientException {
		 
		String uri = this.uriPrefix + path;
		
		Main.logDebug(this,"uri=" + uri, 10);
		
	    HttpDelete delete = new HttpDelete(uri);
	    setHeaders(delete);
	     
	    HttpResponse httpResponse;
		try {
			httpResponse = this.httpClient.execute(delete);
		} 
		catch (ClientProtocolException e) {
			
			throw new RestClientException("Invalid delete protocol",e);
		} 
		catch (IOException e) {
			
			throw new RestClientException("Error sending delete to server",e);
		}
	    
		RestClientResponse restClientResponse = new RestClientResponse(httpResponse);
	    
		Main.logDebug(this,"statusCode=" + restClientResponse.getStatusCode() + " message=" + restClientResponse.getStatusMessage(), 10);

	     
	    if( restClientResponse.isSuccess() ){
	    	
	        Main.logDebug(this,"record deleted",10);        
	    }
	    else{
			throw new RestClientException(restClientResponse.getMessage(),restClientResponse.getStatusCode());
	    }

	}

	private void setHeaders(HttpRequest request){
		
	    if(this.authenticationToken != null){
	        request.addHeader("brightpearl-auth", this.authenticationToken);
	    }	     
	}
	public String authenticate() throws RestClientException{
		 
		Main.logDebug(this, "start",10);
		
		JSONObject jsonMessage = buildAuthenticateMessage();

		HttpPost httpPost = new HttpPost(this.authenticateUri);

		JSONObject parsedResponse =  postJson(httpPost, jsonMessage);



		this.authenticationToken = (String) parsedResponse.get("response");

		Main.logDebug(this, "end authenticationToken=" + authenticationToken,10);

		return authenticationToken;
	}
	@SuppressWarnings("unchecked")
	private JSONObject buildAuthenticateMessage(){
	     
	    JSONObject authenticate = new JSONObject();
	    JSONObject apiAccountCredentials = new JSONObject();
	    
	    apiAccountCredentials.put("emailAddress", credentials.emailAddress );
	    apiAccountCredentials.put("password", credentials.password );	
	    
	    authenticate.put("apiAccountCredentials", apiAccountCredentials);

	     
	    return authenticate;
	}	
	@SuppressWarnings("unchecked")
	private ArrayList<JSONObject> readSearchResponse(JSONObject parsedResponse) {
/*
{
  response: {
    metaData: {
      resultsAvailable: 1,
      resultsReturned: 1,
      firstResult: 1,
      lastResult: 1,
      columns: [
        {
          name: "contactId",
          sortable: true,
          filterable: true,
          reportDataType: "INTEGER",
          required: false
        },
        {
          name: "primaryEmail",
          sortable: true,
          filterable: true,
          reportDataType: "SEARCH_STRING",
          required: false
        },
        {
          name: "firstName",
          sortable: true,
          filterable: true,
          reportDataType: "SEARCH_STRING",
          required: false
        },
        {
          name: "lastName",
          sortable: true,
          filterable: true,
          reportDataType: "SEARCH_STRING",
          required: false
        }
      ],
      sorting: [
        {
          filterable: {
            name: "lastName",
            sortable: true,
            filterable: true,
            reportDataType: "SEARCH_STRING",
            required: false
          },
          direction: "ASC"
        },
        {
          filterable: {
            name: "firstName",
            sortable: true,
            filterable: true,
            reportDataType: "SEARCH_STRING",
            required: false
          },
          direction: "ASC"
        }
      ]
    },
    results: [
      [
        4,
        "admin@email.com",
        "Primary",
        "Admin"
      ]
    ]
  },
  reference: {}
}
	*/
		ArrayList<JSONObject> jsonOutList =  new ArrayList<JSONObject>();
		
	    JSONObject response =  (JSONObject) parsedResponse.get("response");
	    JSONObject metaData =  (JSONObject) response.get("metaData");
		
	    List<JSONObject> columnsList =  (List<JSONObject>) metaData.get("columns");
	    List<JSONObject> resultsList =  (List<JSONObject>) response.get("results");
	     
	    Main.logDebug(this,"columnsList=" + columnsList, 10);
	    Main.logDebug(this,"resultsList=" + resultsList, 10);
	    
	    // Loop over records
	    for (int rec = 0; rec < resultsList.size(); rec++) {
	    	
	    	JSONObject jsonRecordOut = new JSONObject();
	    	
	    	List jsonRecord = (List) resultsList.get(rec);
	    	
		    Main.logDebug(this,"jsonRecord=" + jsonRecord, 10);
	    	
	    	for (int c = 0; c < columnsList.size(); c++) {
	    		
	    		JSONObject jsonColumn = columnsList.get(c);
	    		
			    Main.logDebug(this,"jsonColumn=" + jsonColumn, 10);
	    		
	    		String columnName = jsonColumn.get("name").toString();
	    		String columnType = jsonColumn.get("reportDataType").toString();
	    		
	    		if ( columnType.equals("INTEGER") ) {
	    			
	    			Long value      = (Long) jsonRecord.get(c);
				    jsonRecordOut.put(columnName, value);
	    		}
	    		else if ( columnType.equals("BOOLEAN") ) {
	    			
	    			Boolean value      = (Boolean) jsonRecord.get(c);
				    jsonRecordOut.put(columnName, value);
	    		}
	    		else {
	    			
		    		String value      = jsonRecord.get(c).toString();
				    jsonRecordOut.put(columnName, value);
	    		}
	    		
	    			    		
	    	}
	    	jsonOutList.add(jsonRecordOut);
	    }
	    Main.logDebug(this,"jsonOutList=" + jsonOutList, 10);

	    return jsonOutList;
	}
}
