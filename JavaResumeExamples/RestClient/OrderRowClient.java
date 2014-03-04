package RestClient;

import java.util.List;

import org.json.simple.JSONObject;

import connector.data.brightpearl.BpOrderRow;
import connector.data.brightpearl.api.RestClient;
import connector.data.brightpearl.api.RestClientException;

public class OrderRowClient {

	private RestClient restClient;
	private String BASE_URI = "order-service/order/%s/row";
	
	public OrderRowClient(RestClient restClient) {
		
		this.restClient = restClient;
	}
	public void createOrderRows(Long orderId, List<BpOrderRow> bpOrderRowList) throws RestClientException   {
		
		String path = String.format(BASE_URI,orderId);
		
	    for(BpOrderRow bpOrderRow : bpOrderRowList){
	
			JSONObject jsonMessage = buildCreateOrderRowMessage(bpOrderRow);
	
			restClient.postJson(path, jsonMessage);
	    }
	}

	@SuppressWarnings("unchecked")
	private JSONObject buildCreateOrderRowMessage(BpOrderRow bpOrderRow){
	     
	    JSONObject createOrderRow = new JSONObject();

	    createOrderRow.put("productId", bpOrderRow.productId);
	    createOrderRow.put("productName", bpOrderRow.productName);
	    
	    
	    JSONObject quantity = new JSONObject();
	    
	    quantity.put("magnitude", bpOrderRow.quantity);
	    
	    createOrderRow.put("quantity", quantity);
	
	    
	    JSONObject rowValue = new JSONObject();
	    JSONObject rowNet = new JSONObject();
	    JSONObject rowTax = new JSONObject();
	 
	    rowValue.put("taxCode", bpOrderRow.taxCode);

	    rowNet.put("value", bpOrderRow.rowNet);    
	    rowTax.put("value", bpOrderRow.rowTax);    
	    
	    rowValue.put("rowNet", rowNet);
	    rowValue.put("rowTax", rowTax);
	    
	    
	    createOrderRow.put("rowValue", rowValue);
	    
	    
	    createOrderRow.put("rowNet", bpOrderRow.rowNet);
	    createOrderRow.put("rowTax", bpOrderRow.rowTax);
	    createOrderRow.put("nominalCode", bpOrderRow.nominalCode);
	         
	    return createOrderRow;
	     
	}

}
