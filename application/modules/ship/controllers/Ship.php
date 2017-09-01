<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Ship extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library(array('ion_auth', 'form_validation'));
        $this->load->language(array('product_lang'));

        /* Load Backend model */
        $this->load->model(array('users', 'backend/group_model', 'backend/pattribute', 'backend/pattribute_sub'));
        $this->load->model(array('users', 'backend/product_category', 'backend/product_sub_category'));

        /* Load Master model */
        $this->load->model(array('master/mst_make', 'master/mst_model', 'master/mst_year', 'backend/coupon_category', 'backend/coupon_method', 'backend/coupon_method_tax', 'backend/coupon_group'));
        $this->flexi = new stdClass;

        $this->load->library('flexi_cart');

        /* PHPExcel Library */
        $this->load->library('excel');

        /* Load Product model */
        $this->load->model(array('backend/product_attribute', 'backend/product', 'backend/product_images'));

        $this->load->model(array('users', 'backend/orders_summary', 'backend/orders_details', 'demo_cart_admin_model'));

        $this->load->helper(array('url', 'language'));

        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));
//        $this->load->library('fedex');
        $this->lang->load('auth');
    }

    public function index() {
        echo 'In Progress';
        die;
    }

    public function fedEx() {
//        echo 'In Progress';
//        die;
// Copyright 2009, FedEx Corporation. All rights reserved.
// Version 12.0.0
        $base_url = base_url();
        require_once(APPPATH . 'libraries/fedex.php5');
//        require_once($base_url.'application/library/fedex.php5');
//The WSDL is not included with the sample code.
//Please include and reference in $path_to_wsdl variable.
        $path_to_wsdl = base_url()."wsdl/ShipService_v21.wsdl";

        define('SHIP_LABEL', 'shipexpresslabel.pdf');  // PNG label file. Change to file-extension .pdf for creating a PDF label (e.g. shiplabel.pdf)
        define('SHIP_CODLABEL', 'CODexpressreturnlabel.pdf');  // PNG label file. Change to file-extension .pdf for creating a PDF label (e.g. CODexpressreturnlabel.pdf)

        ini_set("soap.wsdl_cache_enabled", "0");

        $client = new SoapClient($path_to_wsdl, array('trace' => 1)); // Refer to http://us3.php.net/manual/en/ref.soap.php for more information

        $request['WebAuthenticationDetail'] = array(
            'ParentCredential' => array(
                'Key' => getProperty('parentkey'),
                'Password' => getProperty('parentpassword')
            ),
            'UserCredential' => array(
                'Key' => getProperty('key'),
                'Password' => getProperty('Life_rocks1')
            )
        );

        $request['ClientDetail'] = array(
            'AccountNumber' => getProperty('shipaccount'),
            'MeterNumber' => getProperty('meter')
        );
        $request['TransactionDetail'] = array('CustomerTransactionId' => '*** Express Domestic Shipping Request using PHP ***');
        $request['Version'] = array(
            'ServiceId' => 'ship',
            'Major' => '21',
            'Intermediate' => '0',
            'Minor' => '0'
        );
        $request['RequestedShipment'] = array(
            'ShipTimestamp' => date('c'),
            'DropoffType' => 'REGULAR_PICKUP', // valid values REGULAR_PICKUP, REQUEST_COURIER, DROP_BOX, BUSINESS_SERVICE_CENTER and STATION
            'ServiceType' => 'PRIORITY_OVERNIGHT', // valid values STANDARD_OVERNIGHT, PRIORITY_OVERNIGHT, FEDEX_GROUND, ...
            'PackagingType' => 'YOUR_PACKAGING', // valid values FEDEX_BOX, FEDEX_PAK, FEDEX_TUBE, YOUR_PACKAGING, ...
            'TotalWeight' => array(
                'Value' => 50.0,
                'Units' => 'LB' // valid values LB and KG
            ),
            'Shipper' => addShipper(),
            'Recipient' => addRecipient(),
            'ShippingChargesPayment' => addShippingChargesPayment(),
            'SpecialServicesRequested' => addSpecialServices(),
            'LabelSpecification' => addLabelSpecification(),
            'PackageCount' => 1,
            'RequestedPackageLineItems' => array(
                '0' => addPackageLineItem1()
            )
        );



        try {
            if (setEndpoint('changeEndpoint')) {
                $newLocation = $client->__setLocation(setEndpoint('endpoint'));
            }

            $response = $client->processShipment($request);  // FedEx web service invocation

            if ($response->HighestSeverity != 'FAILURE' && $response->HighestSeverity != 'ERROR') {
                printSuccess($client, $response);

                $fp = fopen(SHIP_CODLABEL, 'wb');
                fwrite($fp, $response->CompletedShipmentDetail->AssociatedShipments->Label->Parts->Image); //Create COD Return PNG or PDF file
                fclose($fp);
                echo '<a href="./' . SHIP_CODLABEL . '">' . SHIP_CODLABEL . '</a> was generated.' . Newline;

                // Create PNG or PDF label
                // Set LabelSpecification.ImageType to 'PDF' or 'PNG for generating a PDF or a PNG label       
                $fp = fopen(SHIP_LABEL, 'wb');
                fwrite($fp, $response->CompletedShipmentDetail->CompletedPackageDetails->Label->Parts->Image); //Create PNG or PDF file
                fclose($fp);
                echo '<a href="./' . SHIP_LABEL . '">' . SHIP_LABEL . '</a> was generated.';
            } else {
                printError($client, $response);
            }

            writeToLog($client);    // Write to log file
        } catch (SoapFault $exception) {
            printFault($exception, $client);
        }

        function addShipper() {
            $shipper = array(
                'Contact' => array(
                    'PersonName' => 'Sender Name',
                    'CompanyName' => 'Sender Company Name',
                    'PhoneNumber' => '1234567890'
                ),
                'Address' => array(
                    'StreetLines' => array('Address Line 1'),
                    'City' => 'Austin',
                    'StateOrProvinceCode' => 'TX',
                    'PostalCode' => '73301',
                    'CountryCode' => 'US'
                )
            );
            return $shipper;
        }

        function addRecipient() {
            $recipient = array(
                'Contact' => array(
                    'PersonName' => 'Recipient Name',
                    'CompanyName' => 'Recipient Company Name',
                    'PhoneNumber' => '1234567890'
                ),
                'Address' => array(
                    'StreetLines' => array('Address Line 1'),
                    'City' => 'Herndon',
                    'StateOrProvinceCode' => 'VA',
                    'PostalCode' => '20171',
                    'CountryCode' => 'US',
                    'Residential' => true
                )
            );
            return $recipient;
        }

        function addShippingChargesPayment() {
            $shippingChargesPayment = array('PaymentType' => 'SENDER',
                'Payor' => array(
                    'ResponsibleParty' => array(
                        'AccountNumber' => getProperty('billaccount'),
                        'Contact' => null,
                        'Address' => array(
                            'CountryCode' => 'US')
                    )
                )
            );
            return $shippingChargesPayment;
        }

        function addLabelSpecification() {
            $labelSpecification = array(
                'LabelFormatType' => 'COMMON2D', // valid values COMMON2D, LABEL_DATA_ONLY
                'ImageType' => 'PDF', // valid values DPL, EPL2, PDF, ZPLII and PNG
                'LabelStockType' => 'PAPER_7X4.75'
            );
            return $labelSpecification;
        }

        function addSpecialServices() {
            $specialServices = array(
                'SpecialServiceTypes' => array('COD'),
                'CodDetail' => array(
                    'CodCollectionAmount' => array(
                        'Currency' => 'USD',
                        'Amount' => 150
                    ),
                    'CollectionType' => 'ANY' // ANY, GUARANTEED_FUNDS
                )
            );
            return $specialServices;
        }

        function addPackageLineItem1() {
            $packageLineItem = array(
                'SequenceNumber' => 1,
                'GroupPackageCount' => 1,
                'Weight' => array(
                    'Value' => 5.0,
                    'Units' => 'LB'
                ),
                'Dimensions' => array(
                    'Length' => 20,
                    'Width' => 20,
                    'Height' => 10,
                    'Units' => 'IN'
                )
            );
            return $packageLineItem;
        }

    }

}
