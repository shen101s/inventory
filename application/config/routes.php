<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'Home/index';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['validate'] = 'Home/validate';
$route['logout'] = 'Home/logout';

$route['totalsalespermonth'] = 'Home/totalsalespermonth';


$route['transaction'] = 'Transaction/index';
$route['transaction/dttransindex'] = 'Transaction/dttransindex';
$route['transaction/deltrans'] = 'Transaction/deltrans';



$route['transaction/clientselect'] = 'Transaction/clientselect';
$route['transaction/clientselect/addnew'] = 'Transaction/addnew';
$route['transaction/transsave'] = 'Transaction/transsave';
$route['transaction/dtownerdata'] = 'Transaction/dtownerdata';
$route['transaction/selectowner'] = 'Transaction/selectowner';
$route['transaction/clientinfo'] = 'Transaction/clientinfo';
$route['transaction/editowner'] = 'Transaction/editowner';

$route['transaction/savepet'] = 'Transaction/savepet';
$route['transaction/selectpet'] = 'Transaction/selectpet';
$route['transaction/deletepet'] = 'Transaction/deletepet';

$route['transaction/selectmed'] = 'Transaction/selectmed';
$route['transaction/addserv'] = 'Transaction/addserv';
$route['transaction/transave'] = 'Transaction/transave';
$route['transaction/transervsave'] = 'Transaction/transervsave';

$route['transaction/transervdel'] = 'Transaction/transervdel';
#$route['transaction/labresult/(:any)'] = 'Transaction/labresult/$1';

/*report*/
$route['report/stockinventory'] = 'Report/stockinventory';
$route['report/medicine'] = 'Report/medicine';
$route['report/medicine/expiry'] = 'Report/medicineexpiry';
$route['report/supply'] = 'Report/supply';
$route['report/supply/expiry'] = 'Report/supplyexpiry';
$route['report/food'] = 'Report/food';
$route['report/food/expiry'] = 'Report/foodexpiry';
$route['report/vaccine'] = 'Report/vaccine';
$route['report/vaccine/expiry'] = 'Report/vaccineexpiry';

$route['report/commission'] = 'Report/commission';
$route['report/sales'] = 'Report/sales';
$route['report/stockissuance'] = 'Report/stockissuance';


/*billing*/
$route['billing'] = 'Billing/index';
$route['billing/additem'] = 'Billing/additem';
$route['billing/savetrans'] = 'Billing/savetrans';
$route['billing/searchitem'] = 'Billing/searchitem';
$route['billing/displaypet'] = 'Billing/displaypet';





$route['categories'] = 'Services/index';
$route['categories/servsave'] = 'Services/servsave';
$route['categories/dtservindex'] = 'Services/dtservindex';

$route['categories/details'] = 'Services/details';
$route['categories/servdetailssave'] = 'Services/servdetailssave';
$route['categories/dtservdetails'] = 'Services/dtservdetails';
$route['categories/dtservindexprice'] = 'Services/dtservindexprice';
$route['categories/servdetailsedit'] = 'Services/servdetailsedit';

$route['categories/servsaveprice'] = 'Services/servsaveprice';
$route['categories/servpriceedit'] = 'Services/servpriceedit';

$route['categories/servsaveadjustqty'] = 'Services/servsaveadjustqty';
$route['categories/serveditadjustqty'] = 'Services/serveditadjustqty';


#desc
$route['categories/dtservindexdesc'] = 'Services/dtservindexdesc';
$route['categories/servdetailssavedesc'] = 'Services/servdetailssavedesc';
$route['categories/servdescedit'] = 'Services/servdescedit';


$route['unit'] = 'Units/index';
$route['unit/dtunitindex'] = 'Units/dtunitindex';
$route['unit/unitedit'] = 'Units/unitedit';
$route['unit/unitsave'] = 'Units/unitsave';


/*$route['employees'] = 'Employees/index';
$route['employees/dtempindex'] = 'Employees/dtempindex';
$route['employees/empsave'] = 'Employees/empsave';
$route['employees/empedit'] = 'Employees/empedit';*/

$route['users'] = 'Users/index';
$route['users/dtuserindex'] = 'Users/dtuserindex';
$route['users/usersave'] = 'Users/usersave';
$route['users/useredit'] = 'Users/useredit';
$route['users/userchangepassword'] = 'Users/userchangepassword';



$route['client'] = 'Transaction/clientpage';
$route['dtownerdata'] = 'Transaction/dtownerdata';
$route['editowner'] = 'Transaction/editowner';
$route['transsave'] = 'Transaction/clienttranssave';
$route['savepet'] = 'Transaction/savepet';
$route['selectpet'] = 'Transaction/selectpet';
$route['deletepet'] = 'Transaction/deletepet';
$route['editpet'] = 'Transaction/editpet';

$route['selectbreed'] = 'Transaction/selectbreed';  #todo implement this



$route['selpethistory'] = 'Transaction/selpethistory';
$route['savepethistory'] = 'Transaction/savepethistory';
$route['deletepethistory'] = 'Transaction/deletepethistory';
$route['editpethistory'] = 'Transaction/editpethistory';


$route['species'] = 'Species/index';
$route['species/dtspeciesindex'] = 'Species/dtspeciesindex';
$route['species/savespec'] = 'Species/savespec';
$route['species/editspec'] = 'Species/editspec';

$route['dtbreedindex'] = 'Species/dtbreedindex';
$route['species/savebreed'] = 'Species/savebreed';
$route['species/editbreed'] = 'Species/editbreed';


$route['barcode'] = 'Barcode/index';
$route['categories/stockcard'] = 'Report/stockcard';


$route['changepassword'] = 'Home/changepassword';


#delete below




$route['categories/editservice'] = 'Services/editservice';






/*$route['medicines'] = 'Medicines/index';
$route['medicines/dtmedindex'] = 'Medicines/dtmedindex';
$route['medicines/medsave'] = 'Medicines/medsave';

$route['medicines/medselprice'] = 'Medicines/medselprice';

$route['medicines/mededitprice'] = 'Medicines/mededitprice';

$route['medicines/dtmedindexprice'] = 'Medicines/dtmedindexprice';*/


$route['supplies'] = 'Supplies/index';