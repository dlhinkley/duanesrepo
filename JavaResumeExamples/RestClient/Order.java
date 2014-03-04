package RestClient;

import java.math.BigDecimal;
import java.util.ArrayList;
import java.util.Calendar;
import java.util.List;

import org.apache.commons.lang.StringUtils;
import org.joda.time.DateTime;
import org.joda.time.format.DateTimeFormat;
import org.joda.time.format.DateTimeFormatter;

import connector.data.EzAddress;
import connector.data.EzOrder;
import connector.data.EzOrderLine;
import connector.data.EzOrderLines;
import connector.data.brightpearl.api.RestClient;
import connector.data.brightpearl.api.RestClientException;
import connector.data.brightpearl.client.GoodsOutNoteClient;
import connector.data.brightpearl.client.OrderClient;
import connector.data.brightpearl.client.OrderNoteClient;
import connector.data.brightpearl.client.OrderRowClient;
import connector.data.fishbowl.FbDateUtility;
import connector.main.Main;

public class Order {


	private OrderRowClient orderRowClient;
	private Customer customer;
	private OrderClient orderClient;
	private GoodsOutNoteClient goodsOutNoteClient;
	private RestClient restClient;
	private OrderNoteClient orderNoteClient;

	public Order(RestClient restClient) throws RestClientException {
		
		this.restClient = restClient;
		orderRowClient = new OrderRowClient(restClient);
		customer = new Customer(restClient);
		orderClient = new OrderClient(restClient);
		goodsOutNoteClient = new GoodsOutNoteClient(restClient);	
		orderNoteClient = new OrderNoteClient(restClient); 
	}

	public String sendSoSaveRq(EzOrder ezOrder) throws RestClientException {
		
		
		// Create customer if it doesn't exist
		//
		
		BpContact bpContact = customer.searchCustomer(ezOrder.getCustomerName(),ezOrder.getBillToEmail());
		Long contactId;
		
		if ( bpContact != null ) {
			
			contactId = bpContact.contactId;
		}
		else {
			contactId = customer.createCustomer(ezOrder);
		}
		
		// Create Order
		Long orderId = createOrder(ezOrder,contactId);
		
		createOrderRows(ezOrder,orderId);
		
		if ( ezOrder.getNote() != null  && ezOrder.getNote().length() > 0 ) {
			
			BpOrderNote bpOrderNote = new BpOrderNote();
			bpOrderNote.text = ezOrder.getNote();
			
			orderNoteClient.createOrderNote(orderId, bpOrderNote );
		}
		
		return orderId.toString();
	}
	private void createOrderRows(EzOrder ezOrder, Long orderId) throws RestClientException {
	
		ProductSkuIndex.init(restClient);
		EzOrderLines ezOrderLines = ezOrder.getOrderLines();
		
		List<BpOrderRow> bpOrderRowList = new ArrayList<BpOrderRow>();

		for (int m = 0; m < ezOrderLines.size(); m++ ) {
			
			EzOrderLine ezOrderLine = ezOrderLines.get(m);
			
			BpOrderRow bpOrderRow = new BpOrderRow();
			bpOrderRow.productId = ProductSkuIndex.getProductId( ezOrderLine.getProductNumber() );
			bpOrderRow.quantity =  new BigDecimal( ezOrderLine.getQuantity()).intValue();
			
			if ( ezOrderLine.getProductNumber().equals("Shipping") ) {
				
				bpOrderRow.nominalCode = Main.config.getBrightPearlShippingAccount(); // Shipping sales
			}
			else {
				
//				bpOrderRow.nominalCode = "4000"; // Merchandise Sales
			}
			if ( bpOrderRow.productId == null ) {
				
				bpOrderRow.productName = ezOrderLine.getProductNumber() + ": " + ezOrderLine.getDescription();				
			}
			else {
				
				bpOrderRow.productName = ezOrderLine.getDescription();
			}
			bpOrderRow.rowNet = Double.parseDouble( ezOrderLine.getProductPrice() ) * bpOrderRow.quantity;
			bpOrderRow.rowTax = 0.00;
			bpOrderRow.taxCode = "N"; // N - non taxable , T - Taxable
			
			bpOrderRowList.add(bpOrderRow);		
		}
		
		// Create another line for taxes if there is tax
		double totalTax = Double.parseDouble( ezOrder.getTotalTax() );
		
		if ( totalTax > 0.00 ) {
			
			BpOrderRow bpOrderRow = new BpOrderRow();
			bpOrderRow.quantity = 1;
			bpOrderRow.nominalCode = Main.config.getBrightPearlSalesTaxAccount(); // Shipping sales

			bpOrderRow.productName = "Tax";
			bpOrderRow.rowNet = 0.00;
			bpOrderRow.rowTax = totalTax;
			bpOrderRow.taxCode = "T"; // N - non taxable , T - Taxable
			
			bpOrderRowList.add(bpOrderRow);		
		}
		orderRowClient.createOrderRows(orderId, bpOrderRowList);
	}

	private Long createOrder(EzOrder ezOrder, Long contactId) throws RestClientException {
		
		BpOrder bpOrder = mapOrder(ezOrder,contactId);
		
		
		Long orderId = orderClient.createOrder(bpOrder);
		
		return orderId;
		
		
	}

	private BpOrder mapOrder(EzOrder ezOrder,Long contactId) throws RestClientException {
		
		OrderStatusIndex.init(restClient);
		ShippingMethodIndex.init(restClient);

		BpOrder bpOrder = new BpOrder();
		bpOrder.orderTypeCode = "SO";
		bpOrder.reference = ezOrder.getPoNum();
		bpOrder.placedOn =  FbDateUtility.convertStringToCalendar( ezOrder.getCreatedDate());
		bpOrder.orderStatusId = OrderStatusIndex.getOrderStatus("New web order").orderStatusId;
		
		try {
		bpOrder.shippingMethodId = ShippingMethodIndex.getShippingMethod( ezOrder.getCarrier() ).shippingMethodId;
		}
		catch (NullPointerException e ) {
		
			throw new RestClientException("Invalid Shipping Method: " + ezOrder.getCarrier());
		}
		bpOrder.taxDate =  Calendar.getInstance();
		bpOrder.contactId = contactId;
		
		bpOrder.deliveryAddressFullName = ezOrder.getShipToName();
//		bpOrder.deliveryCompanyName = ezOrder.getShipTo
		
		EzAddress ezAddress = ezOrder.getShipToAddress();
		ezAddress.readAddressField();
		
		
		bpOrder.deliveryCity = ezAddress.getCity();
		bpOrder.deliveryCountryIsoCode = ezAddress.getCountry();
		bpOrder.deliveryPostalCode = ezAddress.getZipCode();
		bpOrder.deliveryState = ezAddress.getState();
		bpOrder.deliveryStreet = ezAddress.getAddress1();
//		bpOrder.suburb = ezAddress.getAddress2();		
		

		bpOrder.deliveryTelephone = ezOrder.getShipToPhone();
		bpOrder.deliveryEmail = ezOrder.getShipToEmail();
		
		// If a default warehouse is selected, use it
		if ( Main.config.getDefaultLocationGroup().length() > 0 ) {
			
			bpOrder.warehouseId = Long.parseLong( Main.config.getDefaultLocationGroup() );
		}
		
		return bpOrder;
	}

	public String getStatus(Long orderId) throws RestClientException {

		/* 
		 RestClient.getJson response={"response":[{"statusId":1,"visible":false,"sortOrder":0,"orderTypeCode":"SO","name":"Draft \/ Quote","disabled":false},
		 {"statusId":18,"visible":true,"sortOrder":10,"orderTypeCode":"SO","name":"Quote sent","disabled":false},
		 {"statusId":2,"visible":true,"sortOrder":20,"orderTypeCode":"SO","name":"New web order","disabled":false},
		 {"statusId":3,"visible":true,"sortOrder":30,"orderTypeCode":"SO","name":"New phone order","disabled":false},
		 {"statusId":17,"visible":true,"sortOrder":40,"orderTypeCode":"SO","name":"Ready to ship","disabled":false},
		 {"statusId":19,"visible":true,"sortOrder":50,"orderTypeCode":"SO","name":"Packed","disabled":false},
		 {"statusId":4,"visible":true,"sortOrder":60,"orderTypeCode":"SO","name":"Invoiced","disabled":false},
		 {"statusId":20,"visible":true,"sortOrder":70,"orderTypeCode":"SO","name":"On hold","disabled":false},
		 {"statusId":5,"visible":false,"sortOrder":80,"orderTypeCode":"SO","name":"Cancelled","disabled":false},
		 {"statusId":6,"visible":false,"sortOrder":0,"orderTypeCode":"PO","name":"Pending PO","disabled":false},
		 {"statusId":7,"visible":true,"sortOrder":10,"orderTypeCode":"PO","name":"Placed with supplier","disabled":false},
		 {"statusId":8,"visible":true,"sortOrder":30,"orderTypeCode":"PO","name":"Products received","disabled":false},
		 {"statusId":9,"visible":true,"sortOrder":40,"orderTypeCode":"PO","name":"Invoice received","disabled":false},
		 {"statusId":11,"visible":false,"sortOrder":0,"orderTypeCode":"SC","name":"Sales credit complete","disabled":false},
		 {"statusId":10,"visible":false,"sortOrder":0,"orderTypeCode":"SC","name":"Sales credit","disabled":false},
		 {"statusId":21,"visible":false,"sortOrder":0,"orderTypeCode":"SC","name":"Cancelled","disabled":false},
		 {"statusId":13,"visible":false,"sortOrder":0,"orderTypeCode":"PC","name":"Purchase credit complete","disabled":false},
		 {"statusId":12,"visible":false,"sortOrder":0,"orderTypeCode":"PC","name":"Purchase credit","disabled":false}]}

		*/
		
		// Default to issued
		String status = "Issued";
		
		BpOrder bpOrder = orderClient.getOrder(orderId);
		
		// If it was canceled, set to void
		if ( bpOrder.statusName.equals("Cancelled") ) {
			
			status = "Void";
		}
		else {
			
			List<BpGoodsOutNote> goodsOutNoteList = goodsOutNoteClient.findAllGoodsOutNote(orderId);
			
			// If it's being shipped, check to see if it's all shipped or partially shipped
			//
			if ( goodsOutNoteList.size() > 0 ) {
				
				int shipments = 0;
				
				for (int m = 0; m < goodsOutNoteList.size(); m++ ) {
					
					if ( goodsOutNoteList.get(m).statusShipped ) {
						
						shipments++;
					}			
				}
				// If everything is shipped, make fulfilled
				if ( shipments == goodsOutNoteList.size() ) {
					
					status = "Fulfilled";
				}
				// If at least one item shipped, make it in progress
				else if ( shipments > 0 ) {
					
					status = "In Progress";
				}
			}
			
		}
		return status;
	}

	public EzOrder getOrder(Long orderId) throws RestClientException {
		
		EzOrder ezOrder = new EzOrder();
		
//		BpOrder bpOrder = orderClient.getOrder(orderId);
		
		ezOrder.setStatus( this.getStatus(orderId) );
		ezOrder.setOrderNumber(orderId.toString());
		
		return ezOrder;
	}

	public String getTrackingNumber(long orderId) throws RestClientException {

		Main.logDebug(this, "start orderId=" + orderId, 10);
		
		List<BpGoodsOutNote> goodsOutNoteList = goodsOutNoteClient.findAllGoodsOutNote(orderId);
		
		ArrayList<String> trackingNumbers = new ArrayList<String>();
		
		for (int m = 0; m < goodsOutNoteList.size(); m++ ) {
			
			Main.logDebug(this, "m=" + m + " statusShipped=" + goodsOutNoteList.get(m).statusShipped, 10);

			if ( goodsOutNoteList.get(m).statusShipped && goodsOutNoteList.get(m).shippingReference != null && goodsOutNoteList.get(m).shippingReference.length() > 0 ) {
				
				trackingNumbers.add( goodsOutNoteList.get(m).shippingReference);
			}			
		}
		Main.logDebug(this, "end trackingNumbers=" + trackingNumbers, 10);
		
		return StringUtils.join(trackingNumbers,", ");
	}

	public String getCarrier(long orderId) throws RestClientException {
		
		ShippingMethodIndex.init(restClient);

		List<BpGoodsOutNote> goodsOutNoteList = goodsOutNoteClient.findAllGoodsOutNote(orderId);
		
		ArrayList<String> carrierList = new ArrayList<String>();
		
		for (int m = 0; m < goodsOutNoteList.size(); m++ ) {
			
			Long shippingMethodId = goodsOutNoteList.get(m).shippingMethodId;

			if ( goodsOutNoteList.get(m).statusShipped && shippingMethodId != null && shippingMethodId > 0 ) {
				
				String shippingMethodName = ShippingMethodIndex.getShippingMethod(shippingMethodId).name;
				carrierList.add( shippingMethodName );
			}			
		}
		
		return StringUtils.join(carrierList,", ");
		
	}

	public String getShippedOn(long orderId) throws RestClientException {

		DateTime shippedOn = null;
		
		List<BpGoodsOutNote> goodsOutNoteList = goodsOutNoteClient.findAllGoodsOutNote(orderId);
		
		ArrayList<String> carrierList = new ArrayList<String>();
		
		for (int m = 0; m < goodsOutNoteList.size(); m++ ) {
			
			if ( goodsOutNoteList.get(m).statusShippedOn != null && shippedOn == null ) {
				
				shippedOn = goodsOutNoteList.get(m).statusShippedOn;
			}
			
			else if ( goodsOutNoteList.get(m).statusShippedOn != null && goodsOutNoteList.get(m).statusShippedOn.toDate().compareTo(  shippedOn.toDate() ) > 0 ) {
				
				shippedOn = goodsOutNoteList.get(m).statusShippedOn;
				
			}			
		}
		return shippedOn.toString(DateTimeFormat.forPattern("yyyy-MM-dd"));
	}




}
