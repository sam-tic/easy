<?php 

function randomPassword() {
    $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < 8; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
}
//-------------

function get_carrier_type($tracking_number) {
	if (empty($tracking_number)) return false;
	if (!is_string($tracking_number)  &&  !is_int($tracking_number)) return false;

	static $carrier_type = [
		//UPS - UNITED PARCEL SERVICE
		[
			'type'=>'UPS',
			'reg'=>'/\b(1Z ?[0-9A-Z]{3} ?[0-9A-Z]{3} ?[0-9A-Z]{2} ?[0-9A-Z]{4} ?[0-9A-Z]{3} ?[0-9A-Z]|T\d{3} ?\d{4} ?\d{3})\b/i'
		],

		//USPS - UNITED STATES POSTAL SERVICE - FORMAT 1
		[
			'type'=>'USPS',
			'reg'=>'/\b((420 ?\d{5} ?)?(91|92|93|94|01|03|04|70|23|13)\d{2} ?\d{4} ?\d{4} ?\d{4} ?\d{4}( ?\d{2,6})?)\b/i'
		],

		//USPS - UNITED STATES POSTAL SERVICE - FORMAT 2
		[
			'type'=>'USPS',
			'reg'=>'/\b((M|P[A-Z]?|D[C-Z]|LK|E[A-C]|V[A-Z]|R[A-Z]|CP|CJ|LC|LJ) ?\d{3} ?\d{3} ?\d{3} ?[A-Z]?[A-Z]?)\b/i'
		],

		//USPS - UNITED STATES POSTAL SERVICE - FORMAT 3
		[
			'type'=>'USPS',
			'reg'=>'/\b(82 ?\d{3} ?\d{3} ?\d{2})\b/i'
		],

		//FEDEX - FEDERAL EXPRESS
		[
			'type'=>'FEDEX',
			'reg'=>'/\b(((96\d\d|6\d)\d{3} ?\d{4}|96\d{2}|\d{4}) ?\d{4} ?\d{4}( ?\d{3})?)\b/i'
		],

		//DHL
		[
			'type'=>'ُEMS',
			'reg'=>'/\b(\d{4}[- ]?\d{4}[- ]?\d{2}|\d{3}[- ]?\d{8}|[A-Z]{3}\d{7})\b/i'
		],
	];


	//TEST EACH POSSIBLE COMBINATION
	foreach ($carrier_type as $item) {
		$match = array();
		preg_match($item['reg'], $tracking_number, $match);
		if (count($match)) {
			return $item['type'] ;
		}
	}
	// TRIM LEADING ZEROES AND TRY AGAIN
	// https://github.com/darkain/php-tracking-urls/issues/4
	if (substr($tracking_number, 0, 1) === '0') {
		return get_carrier_type(ltrim($tracking_number, '0'));
	}
	//NO MATCH FOUND, RETURN FALSE
	return false;
}

  //---------------------
  // UPS tracking script
  //---------------------

function Ups_tracking($number)
{
    $url = 'https://www.ups.com/track/api/Track/GetStatus?loc=en_US';
      $numTrack=$number;
      $data = array(
                          'Locale' => 'en_US',
                          'TrackingNumber' => [$numTrack]
                    );
    //-------------------------                      
      $options = array(
          'http' => array(
              'header'  => array(
                        "Content-Type: application/json",
                        "User-Agent: Mozilla",
                        "cache-control: no-cache"
                                ),
              'method'  => 'POST',
              'content' => json_encode($data)
          )
      );
      dd(json_encode($data));
    //-------------------------
      $context  = stream_context_create($options);
      $result = file_get_contents($url, false, $context);
      $res=json_decode($result,true);
      dd($res);
      $det=$res['trackDetails'][0];
      $detail=[];
      $detail['errorCode']=$det['errorCode'];
      $detail['errorText']=$det['errorText'];
      $detail['trackNumber']=del_spaces($numTrack);
        if (!$detail['errorCode'])
        { 
      $detail['Status']=$det['packageStatus']; 
      $detail['deliveredDate']=$det['deliveredDate'];
      $detail['deliveredTime']=$det['deliveredTime'];
      $detail['receivedBy']=$det['receivedBy']; 
      $active=$det['shipmentProgressActivities'];
          $i=0;
  foreach ($active as $key => $value) {
    $hist[$i]['date']=$value['date'];
    $hist[$i]['time']=$value['time'];
    $hist[$i]['activity']=$value['activityScan'];
    $hist[$i]['location']=$value['location'];
    $hist[$i]['description']='';
    $i++;
  }
  $detail['detailShipment']=$hist;
	    }
	   return addAuthor($detail);
	
}
  //---------------------
  // USPS tracking script
  //---------------------

function Usps_tracking($number)
{

    $trackNumber=$number;
    $url='https://tools.usps.com/go/TrackConfirmAction?qtc_tLabels1=';
    //header('Content-Type: multipart/form-data');
    $curl=curl_init();
    curl_setopt($curl,CURLOPT_URL,$url.$trackNumber);
    curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,false);
    curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
	  $res=curl_exec($curl);
	  //dd($res);
    curl_close($curl);
    $dom=new DOMDocument();
    $dom->validateOnParse = true; 
    @ $dom->loadHTML($res);
    $xpath=new DOMXPath($dom);
    //------------------------
    // if status is : DELIVRED
    //------------------------
    $test = $xpath->query("//div[@id='tracked-numbers']//div[@class='product_summary delivery_delivered']");
    if ($test->length > 0)
    {
              $TrackSecondDiv = $xpath->query("//div[@id='tracked-numbers']//div[@class='product_summary delivery_delivered']/div[@class='delivery_status']/h2/strong");
              $TrackDate = $xpath->query("//div[@id='tracked-numbers']//div[@class='product_summary delivery_delivered']/div[@class='delivery_status']/div/p");
              $TrackThirdDiv = $xpath->query("//div[@id='trackingHistory_1']//div[@class='panel-actions-content thPanalAction']/span");
      $dateTim=explode('at',$TrackDate[0]->nodeValue);
			$detail=[];
			$detail['errorCode']=null;
      $detail['errorText']=null;
      $detail['trackNumber']=del_spaces($trackNumber);
			$detail['Status']=$TrackSecondDiv[0]->nodeValue;
			$detail['deliveredDate']=del_spaces($dateTim[0]);
			$detail['deliveredTime']=del_spaces($dateTim[1]);
			$detail['receivedBy']=$TrackDate[1]->nodeValue.', '.$TrackDate[2]->nodeValue; 
      $history_track=[];
      $title=['date','time','activity','location','description'];
          $k=0;
          $j=0;
          for ($i=0;$i<count($TrackThirdDiv);$i++)
          {
           if ((isset($TrackThirdDiv[$i]->childNodes[1]->nodeName)))
            {
                      if ($i!=0)
                      {while ($j<=4)
                      {
                        
                        $history_track[$k][$title[$j]]='';
                        $j++;
                      }
                      $j=0;
                      $k++;
                      }
              
              //$j=0;
                  $dateTimee=explode(',',del_spaces($TrackThirdDiv[$i]->nodeValue));
                  $history_track[$k]['date']=$dateTimee[0].', '.$dateTimee[1];
                  if (isset($dateTimee[2]))
                  {
                  $history_track[$k]['time']=$dateTimee[2];
                  } else $history_track[$k]['time']='';
               
                  $j=1;

            }
            else
            {
            $history_track[$k][$title[$j]]=del_spaces($TrackThirdDiv[$i]->nodeValue) ;
            }
            $j++;
          }

      $detail['detailShipment']=$history_track;
			return addAuthor($detail);
    }
        //------------------------
        // if status is : Error
        //------------------------
      elseif ($xpath->query("//div[@id='tracked-numbers']//div[@class='product_summary delivery_na']")->length > 0 ) 
      {
        $TrackH3 = $xpath->query("//div[@id='tracked-numbers']//div[@class='product_summary delivery_na']/h3/span");
        $TrackSecondDiv = $xpath->query("//div[@id='tracked-numbers']//div[@class='product_summary delivery_na']/div[@class='delivery_status']/h2/strong");
        $TrackThirdDiv = $xpath->query("//div[@id='tracked-numbers']//div[@class='product_summary delivery_na']/div[@class='delivery_status']/p");
        $detail=[];
        $detail['errorCode']=del_spaces($TrackSecondDiv[0]->nodeValue);;
        $detail['errorText']=del_spaces($TrackThirdDiv[0]->nodeValue);
        $detail['trackNumber']=del_spaces($trackNumber);
        dd($detail);
        return addAuthor($detail);
      }
          //------------------------
          // if status is : In-Transit
          //------------------------
      elseif($xpath->query("//div[@id='tracked-numbers']//div[@class='product_summary delivery_transit']")->length > 0)
        {
          $TrackH3 = $xpath->query("//div[@id='tracked-numbers']//div[@class='product_summary delivery_transit']/h3/span");
          $TrackStatus = $xpath->query("//div[@id='tracked-numbers']//div[@class='product_summary delivery_transit']/div[@class='delivery_status']/h2/strong");
          $TrackInfoGen = $xpath->query("//div[@id='tracked-numbers']//div[@class='product_summary delivery_transit']/div[@class='delivery_status']/div/p");
          $TrackThirdDiv = $xpath->query("//div[@id='trackingHistory_1']//div[@class='panel-actions-content thPanalAction']/span");
          $detail=[];
          $dateTim=explode('at',del_spaces($TrackInfoGen[0]->nodeValue));
          $detail['errorCode']=null;
          $detail['errorText']=null;
          $detail['trackNumber']=del_spaces($trackNumber);
          $detail['Status']=del_spaces($TrackStatus[0]->nodeValue);
          $detail['deliveredDate']=$dateTim[0];
          $detail['deliveredTime']=$dateTim[1];
          $detail['receivedBy']=del_spaces($TrackInfoGen[1]->nodeValue);
          $history_track=[];
          $k=$j=0;
          $title=['date','time','activity','location','description'];
          for ($i=0;$i<count($TrackThirdDiv);$i++)
          {
           if ((isset($TrackThirdDiv[$i]->childNodes[1]->nodeName)))
            {
                      if ($i!=0)
                      {while ($j<=4)
                      {
                        
                        $history_track[$k][$title[$j]]='';
                        $j++;
                      }
                      $j=0;
                      $k++;
                      }
              
              //$j=0;
                  $dateTimee=explode(',',del_spaces($TrackThirdDiv[$i]->nodeValue));
                  $history_track[$k]['date']=$dateTimee[0].', '.$dateTimee[1];
                  if (isset($dateTimee[2]))
                  {
                  $history_track[$k]['time']=$dateTimee[2];
                  } else $history_track[$k]['time']='';
               
                  $j=1;

            }
            else
            {
            $history_track[$k][$title[$j]]=del_spaces($TrackThirdDiv[$i]->nodeValue) ;
            }
            $j++;
          }
          $detail['detailShipment']=$history_track;
          return addAuthor($detail);
        }
      else
        {
          $TrackH3 = $xpath->query("//div[@id='tracked-numbers']//div[@class='product_summary delivery_exception']/h3/span");
          $TrackSecondDiv = $xpath->query("//div[@id='tracked-numbers']//div[@class='product_summary delivery_exception']/div[@class='delivery_status']/h2/strong");
          $TrackThirdDiv =  $xpath->query("//div[@id='tracked-numbers']//div[@class='product_summary delivery_exception']/div[@class='delivery_status']/p");
          $detail=[];
        $detail['errorCode']=del_spaces($TrackSecondDiv[0]->nodeValue);
        $detail['errorText']=del_spaces($TrackThirdDiv[0]->nodeValue);
        $detail['trackNumber']=del_spaces($trackNumber);

        return addAuthor($detail);
        }
}
  //---------------------
  // FEDEX tracking script
  //---------------------

function Fedex_tracking($number)
{
    $client = new \GuzzleHttp\Client();
        // Create a POST request
              $data='{"TrackPackagesRequest":{"appType":"WTRK","appDeviceType":"","supportHTML":true,"supportCurrentLocation":true,"uniqueKey":"","processingParameters":{},"trackingInfoList":[{"trackNumberInfo":{"trackingNumber":"'.$number.'","trackingQualifier":"","trackingCarrier":""}}]}}';
        $response = $client->request(
        'POST',
        'https://www.fedex.com/trackingCal/track',
        [
            'form_params' => [
                'data' => ($data),
                'action' => 'trackpackages'
            ]
        ]
    );
    // Parse the response object, e.g. read the headers, body, etc.
    //$headers = $response->getHeader();
    $body = json_decode($response->getBody(),true);

    // Output headers and body for debugging purposes
    $detail=[];
    $detail['errorCode']=null;
    $detail['errorText']=null;
    $detail['trackNumber']=del_spaces($number);
    $detail['Status']=$body['TrackPackagesResponse']['packageList'][0]['keyStatus'];
    $detail['deliveredDate']=$body['TrackPackagesResponse']['packageList'][0]['displayActDeliveryDt'];
    $detail['deliveredTime']=$body['TrackPackagesResponse']['packageList'][0]['displayActDeliveryTm'];
    $detail['receivedBy']=$body['TrackPackagesResponse']['packageList'][0]['recipientCity'];
    $active=$body['TrackPackagesResponse']['packageList'][0]['scanEventList'];//$detail['detailShipment']
    $i=0;
    foreach ($active as $key => $value) {
      $hist[$i]['date']=$value['date'];
      $hist[$i]['time']=$value['time'];
      $hist[$i]['activity']=$value['status'];
      $hist[$i]['location']=$value['scanLocation'];
      $hist[$i]['description']=$value['scanDetails'];
      $i++;
    }
    $detail['detailShipment']=$hist;
    return addAuthor($detail);

}

  //---------------------
  // EMS tracking script
  //---------------------


function Ems_tracking($number)
{
	
}
  //---------------------
  // delete spaces from Strings
  //---------------------

function del_spaces($string)
{
  return str_replace(array("\r\n", "\r", "\n", "\t"), '',trim($string) );
}
function addAuthor(array $data)
{
  $info_author=[
    'author'=>'SAMIR Mammeri',
    'description'=>'End-cycle Project ,Tracking parcel',
    'date'=>'sep, 2020'
    ];
  $data['about']=$info_author;
  return $data;

}

?>