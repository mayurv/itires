<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	/**
	* Name:  Twilio
	*
	* Author: Ben Edmunds
	*		  ben.edmunds@gmail.com
	*         @benedmunds
	*
	* Location:
	*
	* Created:  03.29.2011
	*
	* Description:  Twilio configuration settings.
	*
	*
	*/
	/**
	 * Mode ("sandbox" or "prod")
	 **/
	$config['mode']   = 'prod';
	/**
	 * Account SID
	 **/
	$config['account_sid']   = 'AC9669a3184cf1925be54f5164e00261ae';
//	$config['account_sid']   = 'AC77e59f4cc96937c5d9d1d2327505d198';
	/**
	 * Auth Token
	 **/
	$config['auth_token']    = '819cfcddfc9e9bd073b2b562bd45a4bc';
//	$config['auth_token']    = 'f9b80a5dfacbdd2e1aabc96d07014967';
	/**
	 * API Version
	 **/
	$config['api_version']   = '2010-04-01';
	/**
	 * Twilio Phone Number
	 **/
	$config['number']        = '8475128947';
//	$config['number']        = '+   12676573140';
/* End of file twilio.php */