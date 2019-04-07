<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
defined('SHOW_DEBUG_BACKTRACE') OR define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
|--------------------------------------------------------------------------
| FL INITIAL CONFIGS 
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
define('SYSTEM_NAME', 'NVELOOP GEMS');
define('SYSTEM_CODE', 'ZV_ORDER_MNG_DEV1');
define('SYSTEM_SHOTR_NAME', 'NV GEMS');
define('SYSTEM_POWERED_BY', 'Nveloop Solution');
define('SYS_DATE_FORMAT', 'm/d/Y');
define('NO_GEM', '0'); //jewelry only ->1
define('SYS_EXP', '2019-06-30 23:58'); //jewelry only ->1

define('INVOICE_NO_PREFIX', 'NI'. date('my'));
define('TEMP_INVOICE_NO_PREFIX', 'TMP');
define('SUP_INVOICE_NO_PREFIX', 'SI'. date('my'));
define('SALE_ORDER_NO_PREFIX', 'SO'. date('my'));
define('TEMP_SALE_ORDER_NO_PREFIX', 'TO'. date('my'));
define('QUOTE_NO_PREFIX', 'NQ'. date('my')); //Quote
define('CREDIT_NOTE_PREFIX', 'CN'. date('my')); //Credit Note
define('CS_NO_PREFIX', 'CS'. date('my')); //consignee Submission
define('CR_NO_PREFIX', 'CR'. date('my')); // Consignee Received
define('OG_NO_PREFIX', 'OG'. date('my')); // Consignee Received
define('CRF_SUB_NO_PREFIX', 'CMS'. date('my')); // Xragtman Submission No
define('CRF_REC_NO_PREFIX', 'CMR'. date('my')); // Xragtman Receive No
define('GM_ISSUE_PREFIX', 'GI'. date('my')); // Gem Issue No 
define('GM_RECEIVE_PREFIX', 'GR'. date('my')); // Gem Issue No 


/*
|--------------------------------------------------------------------------
| FL INITIAL SETUPS
|--------------------------------------------------------------------------
|
| Controlling the process
|
 */
//  1--> enabed; 0-->disabled 
define('SYSTEM_LOG_ENABLE', 0);
define('SELECT2_ROWS_LOAD', 25);

/*
|--------------------------------------------------------------------------
| FL Form Actions
|--------------------------------------------------------------------------
|
| Controlling the process
|
 */
//  1--> enabed; 0-->disabled
define('Add', 'Create New');
define('Edit', 'Update');
define('Delete', 'Remove');
define('View', 'View');


/*
|--------------------------------------------------------------------------
| ENCRYPTION SALT
|--------------------------------------------------------------------------
|
| 
|Define a 32-byte (64 character) hexadecimal encryption key
| Note: The same encryption key used to encrypt the data must be used to decrypt the data
|
*/
define('ENCRYPTION_KEY', '2267805b609e6b33ff137c0f7f258416'); //flpassm.d.5
/*
 * 
 */
 /*
|--------------------------------------------------------------------------
| DB Tables
|--------------------------------------------------------------------------
|
| These are used to database table  name
|
*/
//FL TABLE PREFIX
define('TB_PREFIX',      		'');

define('USER_TBL',      		TB_PREFIX.'user_auth');
define('USER_ROLE',      		TB_PREFIX.'user_role');
define('USER',                          TB_PREFIX.'user_details');
define('MODULES',                       TB_PREFIX.'modules');
define('MODULES_ACTION',                TB_PREFIX.'module_actions');
define('MODULE_USER_ROLE_ACT',          TB_PREFIX.'module_user_role');
define('MODULE_FL_CHECK',               TB_PREFIX.'module_fl_check');
define('COMPANIES',                     TB_PREFIX.'company');
define('COUNTRY_LIST',                  TB_PREFIX.'countries');
define('COUNTRY_STATES',                TB_PREFIX.'country_states');
define('COUNTRY_DISTRICTS',             TB_PREFIX.'country_districts');
define('COUNTRY_CITIES',                TB_PREFIX.'country_cities ');
define('SYSTEM_LOG',                    TB_PREFIX.'system_log');
define('SYSTEM_LOG_DETAIL',             TB_PREFIX.'system_log_detail');
define('BANNERS',                       TB_PREFIX.'cms_banner');
define('DROPDOWN_LIST',                 TB_PREFIX.'dropdown_list');
define('DROPDOWN_LIST_NAMES',           TB_PREFIX.'dropdown_list_names'); 
define('TIME_BASE',                     TB_PREFIX.'time_base'); 
define('CURRENCY',                      TB_PREFIX.'currency'); 
define('CUSTOMERS',                     TB_PREFIX.'customers');
define('CUSTOMER_BRANCHES',             TB_PREFIX.'customer_branches');
define('CUSTOMER_TYPE',                 TB_PREFIX.'customer_type'); 
define('ADDONS',                        TB_PREFIX.'addons');
define('ADDON_CALC_INCLUDED',           TB_PREFIX.'addon_calculation_included');
define('PAYMENT_TERMS',                 TB_PREFIX.'payment_terms');
define('TRANSECTION',                   TB_PREFIX.'transection');
define('TRANSECTION_REF',               TB_PREFIX.'transection_ref');
define('TRANSECTION_TYPES',             TB_PREFIX.'transection_types');
define('PAYMENT_METHOD',                TB_PREFIX.'transection_payment_method');
define('ITEM_UOM',                      TB_PREFIX.'item_uom');
define('ITEMS',                         TB_PREFIX.'items');
define('ITEM_TYPES',                         TB_PREFIX.'item_types');
define('ITEM_CAT',                      TB_PREFIX.'item_categories');
define('ITEM_PRICES',                   TB_PREFIX.'item_prices');
define('ITEM_STOCK',                    TB_PREFIX.'item_stock');
define('ITEM_STOCK_TRANS',              TB_PREFIX.'item_stock_transection');
define('SUPPLIERS',                     TB_PREFIX.'suppliers');
define('INV_LOCATION',                  TB_PREFIX.'inventory_location');
define('INVOICES',                      TB_PREFIX.'invoices');
define('INVOICE_TYPE',                  TB_PREFIX.'invoice_type');
define('INVOICES_TEMP',                 TB_PREFIX.'invoice_temp');
define('INVOICES_ADDONS',               TB_PREFIX.'invoice_addons');
define('SUPPLIER_INVOICE',              TB_PREFIX.'supplier_invoice');
define('SUPPLIER_INVOICE_DESC',         TB_PREFIX.'supplier_invoice_description');
define('SALES_ORDERS',                  TB_PREFIX.'sales_orders');
define('SALES_ORDER_DESC',              TB_PREFIX.'sales_order_description');
define('INVOICE_DESC',                  TB_PREFIX.'invoice_description');
define('QUOTATIONS',                    TB_PREFIX.'quotations');
define('SALES_PERSONS',                 TB_PREFIX.'sales_persons');
define('SALES_ORDER_ITEM_TEMP',         TB_PREFIX.'sales_order_item_temp');
define('CONSIGNEES',                    TB_PREFIX.'consignees');
define('CREDIT_NOTES',                  TB_PREFIX.'credit_notes');
define('CREDIT_NOTES_DESC',             TB_PREFIX.'credit_notes_desc');
define('CONSIGNEE_SUBMISSION',          TB_PREFIX.'consignee_submission');
define('CONSIGNEE_SUBMISSION_DESC',     TB_PREFIX.'consignee_submission_description');
define('CONSIGNEE_RECIEVE',             TB_PREFIX.'consignee_recieve');
define('CONSIGNEE_RECIEVE_DESC',        TB_PREFIX.'consignee_recieve_description');
define('BANK_ACCOUNTS',                 TB_PREFIX.'bank_accounts');
define('CONSIGNEE_COMMISH',             TB_PREFIX.'consignee_commission');
define('LOCATION_TRASNFER',             TB_PREFIX.'inventory_location_transfer');
define('LOCATION_TRASNFER_DESC',        TB_PREFIX.'inventory_location_transfer_desc');
define('SALES_VOUCHER',                 TB_PREFIX.'sales_voucher');
define('PRINT_PROFILE',                 TB_PREFIX.'printer_profile');
define('GL_CHART_CLASS',                TB_PREFIX.'gl_chart_classes');
define('GL_CHART_MASTER',               TB_PREFIX.'gl_chart_master');
define('GL_CHART_TYPE',                 TB_PREFIX.'gl_chart_types');
define('GL_TRANS',                      TB_PREFIX.'gl_transections');
define('GL_QUICK_ENTRY',                TB_PREFIX.'gl_quick_entries');
define('GL_QUICK_ENTRY_ACC',            TB_PREFIX.'gl_quick_entry_accounts');
define('GL_FISCAL_YEARS',               TB_PREFIX.'gl_fiscal_year');
define('OLD_GOLD',                      TB_PREFIX.'old_gold');
define('OLD_GOLD_DESC',                 TB_PREFIX.'old_gold_desc');
define('OLD_GOLD_REF',                  TB_PREFIX.'old_gold_ref');
define('CRAFTMANS',                     TB_PREFIX.'craftmans');
define('CRAFTMANS_SUBMISSION',          TB_PREFIX.'so_craftman_submission');
define('CRAFTMANS_RECEIVE',             TB_PREFIX.'so_craftman_receivals');
define('CRAFTMANS_RECEIVE_DESC',        TB_PREFIX.'so_craftman_receivals_desc');
define('GEM_ISSUES',                    TB_PREFIX.'gem_issues');
define('GEM_ISSUE_TYPES',               TB_PREFIX.'gem_issue_types');
define('GEM_ISSUE_RECORDS',             TB_PREFIX.'gem_issue_item_record');
define('GEM_RECEIVAL',                  TB_PREFIX.'gem_receivals');
define('GEM_LAPIDARY_COSTING',             TB_PREFIX.'gem_lapidary_costing');


/*
|--------------------------------------------------------------------------
| MESSAGES
|--------------------------------------------------------------------------
|
| Success Error....messages
|
*/

//define('HOTEL_LOGO',	'./storage/images/company/');
define('RECORD_ADD',	'Record added Successfully');
define('RECORD_UPDATE',	'Record updated Successfully');
define('RECORD_DELETE',	'Record Deleted Successfully');
define('ERROR',	'Error! Something went wrong.');

/*
|--------------------------------------------------------------------------
| STORAGE PLACES 
|--------------------------------------------------------------------------
|
| These are containing all the file storage places
|
*/

//define('HOTEL_LOGO',	'./storage/images/company/');
define('SAMPLE_PIC',	'./storage/images/');
define('COMPANY_LOGO',	'./storage/images/company/');
define('USER_PROFILE_PIC',	'./storage/images/users/profile/');
define('DB_BACKUPS',	'./storage/backups/database_backup/');
define('FILE_BACKUPS',	'./storage/backups/file_backups/');
define('DEFAULT_IMAGE_LOC',	'./storage/images/default/');
define('DEFAULT_PIC',	'./storage/images/default/default.jpg');
define('BANNERS_PIC',	'./storage/images/CMS/banners/'); 
define('CUSTOMER_IMAGES',	'./storage/images/customers/cust_images/'); 
define('ITEM_IMAGES',	'./storage/images/items/'); 
define('FONTS_LOC',	'./storage/fonts/'); 
define('FILE_BACKUP_SOURCE',	'./storage/');
define('CAT_IMAGES',	'./storage/images/categories/');
define('OTHER_IMAGES',	'./storage/images/other/');


define('PDF_TMP_MAIL',	'./storage/pdf/tmp_mail/'); 
/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
defined('FILE_READ_MODE')  OR define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') OR define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE')   OR define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE')  OR define('DIR_WRITE_MODE', 0755);


/***** Email Configuration */

define('ADMIN_EMAIL','fahrylafir@gmail.com');

/******** Temp config for gmail config **/
define('SMTP_USER','fahrycc@gmail.com');
define('SMTP_PWD','a715889595A');
define('SMTP_HOST','ssl://smtp.gmail.com');
define('SMTP_PORT','465');

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/
defined('FOPEN_READ')                           OR define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE')                     OR define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE')       OR define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE')  OR define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE')                   OR define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE')              OR define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT')            OR define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT')       OR define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
*/
defined('EXIT_SUCCESS')        OR define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR')          OR define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG')         OR define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE')   OR define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS')  OR define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') OR define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     OR define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE')       OR define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN')      OR define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      OR define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code
