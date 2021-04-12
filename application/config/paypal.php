<?php

/** set your paypal credential **/

/**
 * SDK configuration
 */
/**
 * Available option 'sandbox' or 'live'
 */

$ci = get_instance();

$ci->db->select('*');
$ci->db->from('tbl_settings');
$ci->db->where('id', '1'); 
$row_paypal_settings=$ci->db->get()->result()[0];


$config['settings'] = array(

    'mode' => $row_paypal_settings->paypal_mode,
    /**
     * Specify the max request time in seconds
     */
    'http.ConnectionTimeOut' => 1000,
    /**
     * Whether want to log to a file
     */
    'log.LogEnabled' => true,
    /**
     * Specify the file that want to write on
     */
    'log.FileName' => 'application/logs/paypal.log',
    /**
     * Available option 'FINE', 'INFO', 'WARN' or 'ERROR'
     *
     * Logging is most verbose in the 'FINE' level and decreases as you
     * proceed towards ERROR
     */
    'log.LogLevel' => 'FINE'
);