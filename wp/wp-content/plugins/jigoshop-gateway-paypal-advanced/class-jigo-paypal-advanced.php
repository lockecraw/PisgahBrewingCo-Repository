<?php
/**
 * Paypal Advanced Payments Gateway Class
 *
 * @author Kiran Polapragada <kiran@limecuda.com>
 **/
class jigoshop_paypal_advanced extends jigoshop_payment_gateway {

	public function __construct() {

		//necessary properties
		$this->id   = 'paypal_advanced';
		$this->icon 		= '';
		$this->has_fields  = false;

		$this->testurl   = 'https://pilot-payflowpro.paypal.com';
		$this->liveurl   = 'https://payflowpro.paypal.com';
		$this->relay_response_url	= str_replace('https:', 'http:', add_query_arg('paypalAdvListener', 'jigopaypaladv_status', home_url('/')));
		$this->method_title     = __( 'PayPal Advanced', 'jigo_paypaladv' );
		$this->secure_token_id = '';
		$this->securetoken = '';
		
		// Define user set variables and load settings
		if(($this->title = get_option('jigo_paypaladv_title'))=='') {
			$this->title = 'PayPal Advanced';
		}
		if(($this->description = get_option('jigo_paypaladv_description'))=='') {
			$this->description = 'PayPal Advanced Description';
		}
		
		if(($this->layout = get_option('jigo_paypaladv_layout'))=='') {
			$this->layout = 'C';
		}
		if(($this->transtype = get_option('jigo_paypaladv_transtype'))=='') {
			$this->transtype = 'S';
		}

		$this->loginid    	= get_option('jigo_paypaladv_loginid');
		$this->resellerid   = get_option('jigo_paypaladv_resellerid');
		$this->password   	= get_option('jigo_paypaladv_password');
		$this->user 		= get_option('jigo_paypaladv_user');
		$this->enabled 		= get_option('jigo_paypaladv_enabled');
		$this->testmode = get_option('jigo_paypaladv_testmode');

		//determine the host address and user
		$this->user = $this->user==''?$this->loginid:$this->user;
		$this->hostaddr  = $this->testmode == 'yes'?$this->testurl:$this->liveurl;


		// hooks
		add_action( 'jigoshop_update_options', array(&$this, 'process_admin_options') );// Save admin options
		add_action( 'receipt_paypal_advanced', array(&$this, 'receipt_page') );// Payment form hook

		if(isset($_GET['paypalAdvListener']) && $_GET['paypalAdvListener']=='jigopaypaladv_status') {
			add_action( 'init', array(&$this, 'relay_response') );// check the response
		}
		
	}

	/**
	 * Check if required fields for configuring the gateway are filled up by the administrator
	 **/
	function checks() {
	
		$return_str = ''; //return the string
		if ( $this->enabled == 'no' )
			return;

	
		// Check required fields
		if ( ! $this->loginid ) {
			$return_str .= '<span class="error" style="color:red">' . sprintf( __('Please enter your PayPal Advanced Account Login ID', 'jigo_paypaladv')) . '</span><br/>';

		} 
		
		if ( ! $this->resellerid ) {
			$return_str .='<span class="error" style="color:red">' . sprintf( __('Please enter your PayPal Advanced Account Reseller ID', 'jigo_paypaladv')) . '</span><br/>';

		} 

		if ( ! $this->password ) {
			$return_str .='<span class="error" style="color:red">' . sprintf( __('Please enter your PayPal Advanced Account Password', 'jigo_paypaladv') ) . '</span><br/>';
		}
		
		return $return_str;

	}

	/**
	 * Relay response - Checks the payment transaction reponse based on that either completes the transaction or shows thows the exception and show sthe error
	 *
	 * @return javascript code to redirect the parent to a page
	 */
	function relay_response() {

		global $jigoshop;

		//if INVNUM is set, assign as ORDERID
		if(isset($_POST['INVNUM'])) {
			$_POST['ORDERID'] = $_POST['INVNUM'];
		}


		//if ORDERID exists in POST variable
		if(!empty($_POST['ORDERID'])) {

			//create order object
			$order = new jigoshop_order( $_POST['ORDERID']);
	
			// filter redirect page
			$redirect_url =  get_permalink(apply_filters( 'jigoshop_get_checkout_redirect_page_id', jigoshop_get_page_id('thanks') ));
	
			//if payment menthod is paypal adavanced and has some result
			if ($order->payment_method == "paypal_advanced" && isset($_POST['RESULT'])) {
	
				//handle the exceptions with Try/Catch blocks
				try {
					//check for the result code processed or not
					switch ($_POST['RESULT']) {
	
					case 0:
						//success, check for errors occurred or not while processing
						if (!isset($_POST['errors'])) { //if no errors
	
							// Add order note
							$order->add_order_note( sprintf( __('PayPal Advanced payment completed (Order ID: %s). But needs to Inquiry transaction to have confirmation that it is actually paid.', 'jigo_paypaladv' ), $_POST['ORDERID'] ) );
	
							//inquire transaction, whether it is really paid or not
								$paypal_args = array(
									'USER'     => $this->user,
									'VENDOR'   => $this->loginid,
									'PARTNER'   => $this->resellerid,
									'PWD'    => $this->password,
									'ORIGID'	=> $_POST['PNREF'],
									'TENDER'	=> 'C',
									'TRXTYPE'	=> 'I'
								);
	
								foreach ($paypal_args as $key => $val) {
									$postData .='&'.$key.'='.$val;
								}
					
								$postData = trim($postData, '&');
								
								
								/* Using Curl post necessary information to the Paypal Site to generate the secured token */
								$response = wp_remote_post( $this->hostaddr, array(
										'method'  => 'POST',
										'headers'   => array(),
										'body'    => $postData,
										'timeout'   => 70,
										'sslverify'  => false,
										'user-agent'  => 'jigoshop ' . $jigoshop->version
									));
								if ( is_wp_error($response) )
									throw new Exception(__('There was a problem connecting to the payment gateway.', 'jigo_paypaladv'));
					
								if ( empty($response['body']) )
									throw new Exception( __('Empty response.', 'jigo_paypaladv') );
	
								
								/* Parse and assign to array */
					
								parse_str($response['body'], $inquiry_result_arr);
	
								// Handle response
								if ($arr['RESULT']== 0) {//if approved
									
									// Add order note
									$order->add_order_note( sprintf( __('Received result of Inquiry Transaction for the  (Order ID: %s) and is successful', 'jigo_paypaladv' ), $_POST['ORDERID'] ) );
			
									// Payment complete
									$order->payment_complete();
			
									// Remove cart
									jigoshop_cart::empty_cart();
								
								} else{//if not approved
									//Not approved for some reason
									throw new Exception( $_POST['RESPMSG'] );
								}
								break;
						}
					break;
					default:
						//Declined or any other error
						throw new Exception( $_POST['RESPMSG'] );
					}
				}catch( Exception $e ) {
	
					//add error
					jigoshop::add_error( __('Error:', 'jigo_paypaladv') . ' "' . $e->getMessage() . '"' );
	
					//update the status to failed
					//$order->update_status('failed', __('Payment failed via PayPal Advanced because of.', 'jigo_paypaladv' ).'&nbsp;'.$e->getMessage() );
					$order->add_order_note( sprintf( __('Payment failed via PayPal Advanced because of', 'jigo_paypaladv' ).'&nbsp;'.$e->getMessage() ) );
			
					echo "<script>parent.document.getElementById('paypal-adv-err-msgs').innerHTML='ERROR:".urldecode($_POST['RESPMSG'])."';parent.document.getElementById('jigo_paypaladv_iframe').src=parent.document.getElementById('jigo_paypaladv_iframe').src;</script>";
					exit;			

				}//end try/catch
	
				//redirect to thanks page
				echo '<script>parent.location.href="'.$redirect_url.'";</script>';
				exit;
			}//end if
		}else { //if ORDERID not exists in post variable means there  is some error occurred

			echo "<script>parent.document.getElementById('paypal-adv-err-msgs').innerHTML='ERROR:".urldecode($_POST['RESPMSG'])."';parent.document.getElementById('jigo_paypaladv_iframe').src=parent.document.getElementById('jigo_paypaladv_iframe').src;</script>";
			exit;			
		}
	}

	/**
	 * Gets the secured token by passing all the required information to PayPal site
	 *
	 * @param order an jigoshop_order Object
	 * @return secure_token as string
	 */
	function get_secure_token( $order ) {

		global $jigoshop;

		//generate unique id
		$this->secure_token_id = uniqid(substr($_SERVER['HTTP_HOST'], 0, 9), true);

		//prepare paypal_ars array to pass to paypal to generate the secure token
		$paypal_args = array();

			$paypal_args = array(
			'VERBOSITY' =>'HIGH',
			'USER'     => $this->user,
			'VENDOR'   => $this->loginid,
			'PARTNER'   => $this->resellerid,
			'PWD'    => $this->password,
			'SECURETOKENID'  => $this->secure_token_id,
			'CREATESECURETOKEN' => 'Y',
			'TRXTYPE'   => $this->transtype,
			'CUSTREF' => $order->id,
			'INVNUM'=>  $order->id,
			'AMT'    => $order->order_total,
			'COMPANYNAME['.strlen($order->billing_company).']'  => $order->billing_company,
			'CURRENCY'   => get_option('jigoshop_currency'),
			'EMAIL'    => $order->billing_email,
			'BILLTOFIRSTNAME['.strlen($order->billing_first_name).']' => $order->billing_first_name,
			'BILLTOLASTNAME['.strlen($order->billing_last_name).']' => $order->billing_last_name,
			'BILLTOSTREET['.strlen($order->billing_address_1 .' '.$order->billing_address_2).']'  => $order->billing_address_1 .' '.$order->billing_address_2,
			'BILLTOCITY['.strlen($order->billing_city).']'  => $order->billing_city,
			'BILLTOSTATE['.strlen($order->billing_state).']'  => $order->billing_state,
			'BILLTOZIP'   => $order->billing_postcode,
			'BILLTOCOUNTRY['.strlen($order->billing_country).']'  => $order->billing_country,
			'BILLTOEMAIL'  => $order->billing_email,
			'BILLTOPHONENUM' => $order->billing_phone,
			'SHIPTOFIRSTNAME['.strlen($order->shipping_first_name).']' => $order->shipping_first_name,
			'SHIPTOLASTNAME['.strlen($order->shipping_last_name).']' => $order->shipping_last_name,
			'SHIPTOSTREET['.strlen($order->shipping_address_1 .' '.$order->shipping_address_2).']'  => $order->shipping_address_1 .' '.$order->shipping_address_2,
			'SHIPTOCITY['.strlen($order->shipping_city).']'  => $order->shipping_city,
			'SHIPTOSTATE['.strlen($order->shipping_state).']'  => $order->shipping_state,
			'SHIPTOZIP'   => $order->shipping_postcode,
			'SHIPTTOCOUNTRY['.strlen($order->shipping_country).']' => $order->shipping_country,
			'BUTTONSOURCE' => 'LimeCudaLLC_Cart_PPA'
		);

// If prices include tax or have order discounts, send the whole order as a single item
		if ( get_option('jigoshop_prices_include_tax')=='yes' || $order->order_discount > 0 ) {

			// Discount
			$paypal_args['discount_amount_cart'] = $order->order_discount;
			// Don't pass items - paypal borks tax due to prices including tax. PayPal has no option for tax inclusive pricing sadly. Pass 1 item for the order items overall
			$item_names = array();

			//prepare items
			if ( sizeof( $order->items ) > 0 ) {
				foreach ( $order->$items as $item )
					if ( $item['qty'] )
						$item_names[] = $item['name'] . ' x ' . $item['qty'];
			}
			$items_str = sprintf( __('Order %s' , 'jigo_paypaladv'), $order->id ) . " - " . implode(', ', $item_names);
			$paypal_args['L_NAME1['.strlen($items_str).']']  = $items_str;
			$paypal_args['L_QTY1']   = 1;
			$paypal_args['L_COST1']   = number_format($order->order_total - $order->order_shipping - $order->order_shipping_tax + $order->order_discount, 2, '.', '');

			// Shipping Cost
			if ( ( $order->order_shipping + $order->order_shipping_tax ) > 0 ) :
				$ship_method_title = __( 'Shipping via', 'jigo_paypaladv' ) . ' ' . ucwords( $order->shipping_method_title );
				$paypal_args['L_NAME2['.strlen($ship_method_title).']'] = $ship_method_title;
				$paypal_args['L_QTY2'] 	= '1';
				$paypal_args['L_COST2'] 	= number_format( $order->order_shipping + $order->order_shipping_tax , 2, '.', '' );
			endif;

		} else {
		
			// Tax
			$paypal_args['TAXAMT'] = $order->get_total_tax();

			// Cart Contents
			$item_loop = 0;
			
			if (sizeof($order->items)>0) : foreach ($order->items as $item) :

				if(!empty($item['variation_id'])) {
					$_product = new jigoshop_product_variation($item['variation_id']);
				} else {
					$_product = new jigoshop_product($item['id']);
				}

				if ($_product->exists() && $item['qty']) :

					$item_loop++;

					$title = $_product->get_title();

					//if variation, insert variation details into product title
					if ($_product instanceof jigoshop_product_variation) {
						$variation_details = array();

						foreach ($_product->get_variation_attributes() as $name => $value) {
							$variation_details[] = ucfirst(str_replace('tax_', '', $name)) . ': ' . ucfirst($value);
						}

						if (count($variation_details) > 0) {
							$title .= ' (' . implode(', ', $variation_details) . ')';
						}
					}

					$paypal_args['L_NAME'.$item_loop.'['.strlen($title).']'] = $title;
					if ($_product->get_sku()) $paypal_args['L_SKU'.$item_loop] = $_product->get_sku();
					$paypal_args['L_QTY'.$item_loop] = $item['qty'];
					$paypal_args['L_COST'.$item_loop] = number_format( apply_filters( 'jigoshop_paypal_adjust_item_price' ,$_product->get_price(), $item), 2);
				endif;
			endforeach; endif;

			// Shipping Cost item - paypal only allows shipping per item, we want to send shipping for the order
			if ( ( $order->order_shipping + $order->order_shipping_tax ) > 0 ) {
				$item_loop++;
				$ship_method_title = __( 'Shipping via', 'jigo_paypaladv' ) . ' ' . ucwords( $order->shipping_method_title );
				$paypal_args['L_NAME'.$item_loop.'['.strlen($ship_method_title).']'] = $ship_method_title;
				$paypal_args['L_QTY'.$item_loop] = '1';
				$paypal_args['L_COST'.$item_loop] = number_format($order->shipping, 2, '.', '');
			}

		}


		//apply filters, any plugins or custom coding can induce or reduce the arguments
		$paypal_args = apply_filters( 'jigo_paypaladv_args', $paypal_args );



		//handle exceptions using try/catch blocks for the request to get secure tocken from paypal
		try {

			/* prepare post data to post to the paypal site */
			$postData = '';
			foreach ($paypal_args as $key => $val) {
				$postData .='&'.$key.'='.$val;
			}

			$postData = trim($postData, '&');


			/* Using Curl post necessary information to the Paypal Site to generate the secured token */
			$response = wp_remote_post( $this->hostaddr, array(
					'method'  => 'POST',
					'headers'   => array(),
					'body'    => $postData,
					'timeout'   => 70,
					'sslverify'  => false,
					'user-agent'  => 'jigoshop ' . $jigoshop->version
				));
			if ( is_wp_error($response) )
				throw new Exception(__('There was a problem connecting to the payment gateway.', 'jigo_paypaladv'));

			if ( empty($response['body']) )
				throw new Exception( __('Empty response.', 'jigo_paypaladv') );

			/* Parse and assign to array */

			parse_str($response['body'], $arr);


			// Handle response
			if ($arr['RESULT']>0) {

				// raise exception
				throw new Exception( __( 'There was an error processing your order.', 'jigo_paypaladv' ) );

			}else {//return the secure token
				return $arr['SECURETOKEN'];
			}

		} catch( Exception $e ) {

			jigoshop::add_error( __('Error:', 'jigo_paypaladv') . ' "' . $e->getMessage() . '"' );
			return;
		}

	}

	/**
	 * Check if this gateway is enabled if available in the user's country and have valid information
	 */
	function is_available() {

		//check for availability in thier user country
		if (!in_array(get_option('jigoshop_currency'), array('USD'))) return false;
		return true;
	
	}

	/**
	 * Admin Panel Options
	 * - Options for bits like 'title' and availability on a country-by-country basis
	 *
	 * @since 1.0.0
	 */
	public function admin_options() {

?>
    	<?php
		//if available then only generate the form
		if ( $this->is_available() ) {

			// Generate the HTML For the settings form.
			$this->generate_settings_html();

		} else {

?>
            		<div class="inline error"><p><strong><?php _e( 'Gateway Disabled', 'jigo_paypaladv' ); ?></strong>: <?php _e( 'PayPal Advanced does support USD only.', 'jigo_paypaladv' ); ?></p></div>
        		<?php

		}
	} // End admin_options()

	/**
	 * Generates Settings Form Fields
	 */
	function generate_settings_html() {
	?>
</tr>
<tr></td>
	<h3><?php _e('PayPal Advanced', 'jigo_paypaladv'); ?></h3>
	<p class="section_description"><?php _e('PayPal Payments Advanced uses an iframe to seamlessly integrate PayPal hosted pages into the checkout process.', 'jigo_paypaladv'); ?></p>
	<table class="form-table">
		<tr>
			<th></th>
			<td align="left"><?php echo $this->checks();?></td>
		</tr>
    	<tr>
	        <th></th>
	        <td class="forminp">
				<input type="checkbox" name="jigo_paypaladv_enabled" id="jigo_paypaladv_enabled" value="yes" <?php if ($this->enabled == 'yes') echo 'checked'; ?>>&nbsp;&nbsp;<?php _e('Enable PayPal Advanced', 'jigo_paypaladv') ?>
	        </td>
	    </tr>
		<tr>
	        <th><a href="#" tip="<?php _e('This controls the title which the user sees during checkout.','jigo_paypaladv') ?>" class="tips" tabindex="99"></a><?php _e('Title', 'jigo_paypaladv') ?></th>
	        <td class="forminp">
		        <input class="input-text" type="text" name="jigo_paypaladv_title" id="jigo_paypaladv_title" style="min-width:50px;" value="<?php echo $this->title;?>" />
	        </td>
	    </tr>
	    <tr>
	        <th><a href="#" tip="<?php _e('This controls the description which the user sees during checkout.','jigo_paypaladv') ?>" class="tips" tabindex="99"></a><?php _e('Description', 'jigo_paypaladv') ?></th>
	        <td class="forminp">
		        <input class="input-text" type="text" name="jigo_paypaladv_description" id="jigo_paypaladv_description" style="min-width:50px;" value="<?php echo $this->description;?>" />
	        </td>
	    </tr>
		<tr>
	        <th><a href="#" tip="<?php _e('Enter your PayPal Advanced merchant login ID that you created when you registered the account.','jigo_paypaladv') ?>" class="tips" tabindex="99"></a><?php _e('Login ID', 'jigo_paypaladv') ?></th>
	        <td class="forminp">
		        <input class="input-text" type="text" name="jigo_paypaladv_loginid" id="jigo_paypaladv_loginid" style="min-width:50px;" value="<?php echo $this->loginid;?>" />
	        </td>
	    </tr>
		<tr>
	        <th><a href="#" tip="<?php _e('Enter your PayPal Advanced reseller ID. If you purchased the account directly from PayPal, use PayPal.','jigo_paypaladv') ?>" class="tips" tabindex="99"></a><?php _e('Reseller ID', 'jigo_paypaladv') ?></th>
	        <td class="forminp">
		        <input class="input-text" type="text" name="jigo_paypaladv_resellerid" id="jigo_paypaladv_resellerid" style="min-width:50px;" value="<?php echo $this->resellerid;?>" />
	        </td>
	    </tr>
		<tr>
	        <th><a href="#" tip="<?php _e('Enter your PayPal Advanced user account for this site. Leave this blank if you have not setup multiple users on your PayPal  Advanced account.','jigo_paypaladv') ?>" class="tips" tabindex="99"></a><?php _e('User', 'jigo_paypaladv') ?></th>
	        <td class="forminp">
		        <input class="input-text" type="text" name="jigo_paypaladv_user" id="jigo_paypaladv_user" style="min-width:50px;" value="<?php echo $this->user;?>" />
	        </td>
	    </tr>
		<tr>
	        <th><a href="#" tip="<?php _e('Enter your PayPal Advanced account password.','jigo_paypaladv') ?>" class="tips" tabindex="99"></a><?php _e('Password', 'jigo_paypaladv') ?></th>
	        <td class="forminp">
		        <input class="input-text" type="password" name="jigo_paypaladv_password" id="jigo_paypaladv_password" style="min-width:50px;" value="<?php echo $this->password;?>" />
	        </td>
	    </tr>
		<tr>
	        <th><?php _e('PayPal sandbox', 'jigo_paypaladv') ?></th>
	        <td class="forminp">
				<input type="checkbox" name="jigo_paypaladv_testmode" id="jigo_paypaladv_testmode" value="yes" <?php if ($this->testmode == 'yes') echo 'checked'; ?>>		       
	        </td>
	    </tr>
		<tr>
	        <th><?php _e('Transaction Type', 'jigo_paypaladv') ?></th>
	        <td class="forminp">
		        <select name="jigo_paypaladv_transtype" id="jigo_paypaladv_transtype" style="min-width:100px;">
		            <option value="A" <?php if ($this->transtype == 'A') echo 'selected="selected"'; ?>><?php _e('Authorization', 'jigo_paypaladv'); ?></option>
		            <option value="S" <?php if ($this->transtype == 'S') echo 'selected="selected"'; ?>><?php _e('Sale', 'jigo_paypaladv'); ?></option>
		        </select>
	        </td>
	    </tr>
		<tr>
	        <th><?php _e('Layout', 'jigo_paypaladv') ?></th>
	        <td class="forminp">
		        <select name="jigo_paypaladv_layout" id="jigo_paypaladv_layout" style="min-width:100px;">
		            <option value="A" <?php if ($this->layout == 'A') echo 'selected="selected"'; ?>><?php _e('Layout A', 'jigo_paypaladv'); ?></option>
		            <option value="B" <?php if ($this->layout == 'B') echo 'selected="selected"'; ?>><?php _e('Layout B', 'jigo_paypaladv'); ?></option>
					<option value="C" <?php if ($this->layout == 'C') echo 'selected="selected"'; ?>><?php _e('Layout C', 'jigo_paypaladv'); ?></option>
		        </select>
	        </td>
	    </tr>
		<tr>
	        <td colspan="2">
			<h3><?php _e('PayPal Manager Set Up', 'jigo_paypaladv');?></h3>
			<div style="padding:5px;"><?php _e('Copy the following URL to the field labeled <strong>Enter Return URL</strong>','jigo_paypaladv');?>:&nbsp;&nbsp;<strong><?php echo 	$this->relay_response_url; ?></strong></div>
			<div style="padding:5px;"><?php _e('Copy the following URL to the field labeled <strong>Enter Error URL</strong>','jigo_paypaladv');?>:&nbsp;&nbsp;<strong><?php echo 	$this->relay_response_url; ?></strong></div>
			<div style="padding:5px;"><?php _e('Please Use <strong>https</strong> instead of http in the above URLs, if your site is using SSL');?></div>
			</td>
	    </tr>
		</table>
	</td>
</tr>
	<?php
	} // End init_form_fields()

	public function process_admin_options() {

		// Define user set variables and load settings
		update_option('jigo_paypaladv_title',$_POST['jigo_paypaladv_title']);
		update_option('jigo_paypaladv_description',$_POST['jigo_paypaladv_description']);
		update_option('jigo_paypaladv_testmode',$_POST['jigo_paypaladv_testmode']);
		update_option('jigo_paypaladv_layout',$_POST['jigo_paypaladv_layout']);
		update_option('jigo_paypaladv_transtype',$_POST['jigo_paypaladv_transtype']);
		update_option('jigo_paypaladv_loginid',$_POST['jigo_paypaladv_loginid']);
		update_option('jigo_paypaladv_resellerid',$_POST['jigo_paypaladv_resellerid']);
		update_option('jigo_paypaladv_password',$_POST['jigo_paypaladv_password']);
		update_option('jigo_paypaladv_user',$_POST['jigo_paypaladv_user']);
		update_option('jigo_paypaladv_enabled',$_POST['jigo_paypaladv_enabled']);
	}
	/**
	 * There are no payment fields for paypal, but we want to show the description if set.
	 **/
	function payment_fields() {

		if ($this->description) echo wpautop(wptexturize($this->description));
	}

	/**
	 * Process the payment
	 **/
	function process_payment( $order_id ) {
		global $jigoshop;
		
		//create the order object
		$order = new jigoshop_order( $order_id );

		//use try/catch blocks to handle exceptions while processing the payment
		try {
			// Check amount
			if ( $order->order_total * 100 < 50 ) {
				throw new Exception( __( 'Minimum order total is 0.50', 'jigo_paypaladv' ) );
			}

			//get secure token
			$this->securetoken = $this->get_secure_token($order);

			//reset them to null, before storing new values
			$_SESSION['paypal_adv_secure_token'] = '';
			$_SESSION['paypal_adv_secure_token_id'] = '';

			//if valid securetoken
			if ($this->securetoken !="") {

				//assign to session variables to use them later
				$_SESSION['paypal_adv_secure_token'] = $this->securetoken;
				$_SESSION['paypal_adv_secure_token_id'] = $this->secure_token_id;

				//Log
				if ($this->debug=='yes') $this->log->add( 'paypal_advanced', sprintf(__('Secured Token generated successfully for the order #%s', 'jigo_paypaladv'), $order_id));

				//redirect to pay
				return array(
					'result'  => 'success',
					'redirect' => add_query_arg('order', $order->id, add_query_arg('key', $order->order_key, get_permalink(jigoshop_get_page_id('pay'))))
				);
			}
		}catch( Exception $e ) {

			//add error
			jigoshop::add_error( __('Error:', 'jigo_paypaladv') . ' "' . $e->getMessage() . '"' );

			//Log
			if ($this->debug=='yes')
				$this->log->add( 'paypal_advanced', 'Error Occurred while processing the order #' . $_SESSION['order_awaiting_payment']);
		}
		return;

	}


	/**
	 * Displays IFRAME/Redirect to show the hosted page in Paypal
	 **/
	function receipt_page() {

		//get the mode
		$PF_MODE = $this->testmode == 'yes'?'TEST':'LIVE';

		//display the form in IFRAME, if it is layout C, otherwise redirect to paypal site
		if ($this->layout == 'C') {
			//define the url
			$location = 'https://payflowlink.paypal.com?mode='.$PF_MODE.'&amp;SECURETOKEN='.$_SESSION['paypal_adv_secure_token'].'&amp;SECURETOKENID='.$_SESSION['paypal_adv_secure_token_id'];

			//Log
			if ($this->debug=='yes') $this->log->add( 'paypal_advanced', sprintf(__('Show payment form(IFRAME) for the order #%s as it is configured to use Layout C', 'jigo_paypaladv'), $_SESSION['order_awaiting_payment']));

			//display the form
?>
		<div id="paypal-adv-err-msgs" style="color:red;"></div><iframe id="jigo_paypaladv_iframe" src="<?php echo $location;?>" width="550" height="565" scrolling="no" frameborder="0" border="0" allowtransparency="true"></iframe>

		<?php

		}else {
			//define the redirection url
			$location = 'https://payflowlink.paypal.com?mode='.$PF_MODE.'&SECURETOKEN='.$_SESSION['paypal_adv_secure_token'].'&SECURETOKENID='.$_SESSION['paypal_adv_secure_token_id'];

			//Log
			if ($this->debug=='yes') $this->log->add( 'paypal_advanced', sprintf(__('Show payment form redirecting to '.$location.' for the order #%s as it is not configured to use Layout C', 'jigo_paypaladv'), $_SESSION['order_awaiting_payment']));

			//redirect
			wp_redirect( $location);
			exit;
		}
	}

}
?>