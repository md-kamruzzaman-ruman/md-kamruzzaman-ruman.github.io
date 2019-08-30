<?php
	include('simple_html_dom.php');

	$url = "http://onlinebooking.flyregent.com/vars/public/CustomerPanels/Requirements.aspx";
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_HEADER, false);
	curl_setopt($ch, CURLOPT_USERAGENT,'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.100 Safari/537.36');
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

	$html = curl_exec($ch);
	curl_close($ch);
	//echo $html;
	

	$oDom = new simple_html_dom();
	$oDom->load($html);
	$nodes = $oDom->find("input[type=hidden]");
	
	$session_id = $nodes[3]->value;
	$rqtm1 = $nodes[4]->value;

	$data =array (
	'FormData' => 
	array (
    'x' => 40,
    'y' => 235,
    'rqtm' => "$rqtm1",
    'Origin' => 
    array (
      0 => 'DAC',
	  1 => '',
	  2 => '',
	  3 => '',
    ),
    'VarsSessionID' => "$session_id",
    'Destination' => 
    array (
      0 => 'CGP',
	  1 => '',
	  2 => '',
	  3 => '',
    ),
    'DepartureDate' => 
    array (
      0 => '11-Sep-2019',
      1 => '',
      2 => '',
      3 => '',
    ),
    'ReturnDate' => 
    array (
      0 => '',
      1 => '',
      2 => '',
      3 => '',
    ),
    'Adults' => '1',
    'Children' => '1',
    'SmallChildren' => 0,
    'Seniors' => 0,
    'Students' => 0,
    'Infants' => '0',
    'Youths' => 0,
    'Teachers' => 0,
    'SeatedInfants' => 0,
    'EVoucher' => '',
    'recaptcha' => 'SHOW',
    'SearchUser' => 'PUBLIC',
    'SearchSource' => 'requirements',
  ),
  'IsMMBChangeFlightMode' => false,
  'IsRefineSerach' => false,
);
	
	$data_string = json_encode($data);
	//echo "data ===".$data_string;
	$ch2 = curl_init("https://onlinebooking.flyregent.com/vars/public/WebServices/AvailabilityWS.asmx/GetFlightAvailability");

	curl_setopt($ch2, CURLOPT_HEADER, false);
	curl_setopt($ch2, CURLOPT_USERAGENT,'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.100 Safari/537.36');
	curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch2, CURLOPT_COOKIE,'VarsSessionID=$session_id');
	curl_setopt($ch2, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($ch2, CURLOPT_POST, true);
	curl_setopt($ch2, CURLOPT_POSTFIELDS, $data_string);
	curl_setopt($ch2, CURLOPT_HTTPHEADER, array(                                                                          
    'Content-Type: application/json'
	));

	$html2 = curl_exec($ch2);

	curl_close($ch2);
	echo $html2;
	
	$data3 = "VarsSessionID=$session_id";

	$urlr = "https://onlinebooking.flyregent.com/vars/public/FlightSelect.aspx";

	$ch3 = curl_init($urlr);
	curl_setopt($ch3, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch3, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($ch3, CURLOPT_USERAGENT,'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.100 Safari/537.36');
	curl_setopt($ch3, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch3, CURLOPT_POST, true);
	curl_setopt($ch3, CURLOPT_POSTFIELDS, $data3);
	curl_setopt($ch3, CURLOPT_HTTPHEADER, array(                                                                      
    'Content-Type: application/x-www-form-urlencoded'
	));
	$html3 = curl_exec($ch3);
	curl_close($ch3);

	echo $html3;
	
	$data4 = array (
		'addFlightRequest' => 
		array (
		'VarsSessionID' => "$session_id",
		'fareData' => 
		array (
		0 => '0_0_0_9_Q',
		),
		'Zone' => 'PUBLIC',
	),
	);
	$data_string2 = json_encode($data4);
	$ch4 = curl_init("https://onlinebooking.flyregent.com/vars/public/WebServices/AvailabilityWS.asmx/AddFlightToBasket?VarsSessionID=$session_id");
	curl_setopt($ch4, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch4, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($ch4, CURLOPT_USERAGENT,'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.100 Safari/537.36');
	curl_setopt($ch4, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch4, CURLOPT_POST, true);
	curl_setopt($ch4, CURLOPT_POSTFIELDS, $data_string2);
	curl_setopt($ch4, CURLOPT_HTTPHEADER, array(                                                                      
    'Content-Type: application/json'
	));
	$html4 = curl_exec($ch4);
	
	function get_string_between($string, $start, $end)
	{
		$string = ' ' . $string;
		$ini = strpos($string, $start);
		if ($ini == 0) return '';
		$ini += strlen($start);
		$len = strpos($string, $end, $ini) - $ini;
		return substr($string, $ini, $len);
	}

	//$parsed = get_string_between($html4, 'BasketGrandTotalPrice\" \u003e', ' BDT');
	//echo $parsed;

?>





