package RestClient;

import java.util.ArrayList;
import java.util.List;

import org.json.simple.JSONObject;

import connector.data.brightpearl.BpOrder;
import connector.data.brightpearl.api.RestClient;
import connector.data.brightpearl.api.RestClientException;
import connector.data.fishbowl.FbDateUtility;
import connector.main.Main;

public class OrderClient {
	
	private RestClient restClient;
	private String BASE_URI = "order-service/order";
	
	public OrderClient(RestClient restClient) {
		
		this.restClient = restClient;
	}
	
	public Long createOrder(BpOrder bpOrder) throws RestClientException   {
		

		JSONObject jsonMessage = buildCreateOrderMessage(bpOrder);
		String path = BASE_URI;

		JSONObject parsedResponse;
			parsedResponse = restClient.postJson(path, jsonMessage);



		Long orderId = (Long) parsedResponse.get("response");

		Main.logDebug(this,"orderId=" + orderId,10);

		return orderId;  
	}

		@SuppressWarnings("unchecked")
		private JSONObject buildCreateOrderMessage(BpOrder bpOrder){
		     
		    JSONObject createOrder = new JSONObject();
		    
		     
		     
		    
		    createOrder.put("orderTypeCode", bpOrder.orderTypeCode);
		    createOrder.put("reference", bpOrder.reference);
		    createOrder.put("warehouseId", bpOrder.warehouseId);
		    createOrder.put("placedOn", FbDateUtility.getCalendarAsIso8601Date(bpOrder.placedOn));
		    
		    JSONObject orderStatus = new JSONObject();
		    JSONObject delivery = new JSONObject();;
		    
		    orderStatus.put("orderStatusId", bpOrder.orderStatusId);
		    createOrder.put("orderStatus", orderStatus);
		    
		    delivery.put("shippingMethodId", bpOrder.shippingMethodId);
		    createOrder.put("delivery", delivery);
		    
		    createOrder.put("invoices.taxDate", FbDateUtility.getCalendarAsIso8601Date(bpOrder.taxDate));
		    
		    
		    
		    
		    JSONObject parties = new JSONObject();
		    JSONObject customer = new JSONObject();
		    JSONObject partiesDelivery = new JSONObject();
		    
		    customer.put("contactId", bpOrder.contactId);
		    
		    partiesDelivery.put("addressFullName", bpOrder.deliveryAddressFullName);
		    partiesDelivery.put("companyName", bpOrder.deliveryCompanyName);
		    partiesDelivery.put("addressLine1", bpOrder.deliveryStreet);
		    partiesDelivery.put("addressLine2", bpOrder.deliverySuburb);
		    partiesDelivery.put("addressLine3", bpOrder.deliveryCity);
		    partiesDelivery.put("addressLine4", bpOrder.deliveryState);
		    partiesDelivery.put("postalCode", bpOrder.deliveryPostalCode);
		    partiesDelivery.put("telephone", bpOrder.deliveryTelephone);
		    partiesDelivery.put("email", bpOrder.deliveryEmail);
		    partiesDelivery.put("countryIsoCode", bpOrder.deliveryCountryIsoCode);
		    
		    parties.put("customer", customer);
		    parties.put("delivery", partiesDelivery);
		    createOrder.put("parties", parties);

		    createOrder.put("orderId", bpOrder.orderId);
		    
		     
		    return createOrder;
		     
		}

		public BpOrder getOrder(Long orderId) throws RestClientException {
			
			BpOrder bpOrder = null;
			
			String path = BASE_URI;

			Main.logDebug(this,"path=" + path + " orderId=" + orderId, 10);

			JSONObject parsedResponse;
				
				parsedResponse = restClient.getJson(path,orderId);
				List<BpOrder> listResponse = readListResponse(parsedResponse);
				
				if ( listResponse.size() > 0 ) {
				
					bpOrder =listResponse.get(0);


				}

			return bpOrder;	
		}
		@SuppressWarnings("unchecked")
		private List<BpOrder> readListResponse(JSONObject parsedResponse) {
			
	        List<JSONObject> allOrderAsJson =  (List<JSONObject>) parsedResponse.get("response");
	         
	        Main.logDebug(this,"Found " + allOrderAsJson.size() + " order(s)",10);
	         
	        List<BpOrder> allOrder =  new ArrayList<BpOrder>(allOrderAsJson.size());
	         
	        for(JSONObject jsonOrder : allOrderAsJson){
	             
	            BpOrder bpOrder = new BpOrder();
	            bpOrder.orderId = (Long) jsonOrder.get("id");
	            
	            JSONObject orderStatus = (JSONObject) jsonOrder.get("orderStatus");
	            
	            
	            
	            bpOrder.statusName = (String) orderStatus.get("name");
	            bpOrder.statusId = (Long) orderStatus.get("orderStatusId");
	             
	            Main.logDebug(this,"Id: " + bpOrder.orderId,10);
	             
	            allOrder.add(bpOrder);
	        }
	        Main.logDebug(this,"size=" + allOrder.size(),10);

	        return allOrder;		
		}
}
