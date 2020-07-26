<?php
  ini_set('serialize_precision', '16');
  header("Access-Control-Allow-Origin: *");
  if(isset($_GET['q']) && $_GET['q'] != '') {
    $arr = array();
    if( preg_match( "/[2-4][0-9]\.[0-9]+\s*,*\s*1[2-5][0-9]\.[0-9]+/u", $_GET['q'], $matches )) {
      $latlon = preg_split("/[　 ,]+/", $matches[0]);
      $lat = trim($latlon[0]);
      $lon = trim($latlon[1]);
      $item['place_id'] = '';
      $item['licence'] = '';
      $item['osm_type'] = 'relation';
      $item['osm_id'] = '';
      $item['boundingbox'] = [$lat, $lat, $lon, $lon];
      $item['lat'] = $lat;
      $item['lon'] = $lon;
      $item['display_name'] = '';
      $item['class'] = 'boundary';
      $item['type'] = 'administrative';
      $item['importance'] = '';
      $item['icon'] = '';
      $item['address']['suburb'] = '';
      $item['address']['city'] = '';
      $item['address']['province'] = '';
      $item['address']['country'] = '日本';
      $item['address']['country_code'] = 'jp';
      array_push($arr, $item);
    } else {
      $csis = 'http://geocode.csis.u-tokyo.ac.jp/cgi-bin/simple_geocode.cgi?addr=';
      $charset = '&charset=UTF8';
      $xml = file_get_contents( $csis . $_GET['q'] . $charset );
      $res = simplexml_load_string($xml);
      $arr = array();
      $count = 0;
      foreach( $res->candidate as $cand ) {
        $item = array();
        $lat = round( floatval( $cand->latitude ), 6);
        $lon = round( floatval( $cand->longitude ), 6);
        $item['place_id'] = '';
        $item['licence'] = '';
        $item['osm_type'] = 'relation';
        $item['osm_id'] = '';
        $item['boundingbox'] = [$lat, $lat, $lon, $lon];
        $item['lat'] = $lat;
        $item['lon'] = $lon;
        $item['display_name'] = '';
        $item['class'] = 'boundary';
        $item['type'] = 'administrative';
        $item['importance'] = '';
        $item['icon'] = '';
        $adr = explode( '/', $cand->address );
        count($adr) > 2 ? $item['address']['suburb'] = $adr[2] : $item['address']['suburb'] = '';
        count($adr) > 1 ? $item['address']['city'] = $adr[1] : $item['address']['city'] = '';
        count($adr) > 0 ? $item['address']['province'] = $adr[0] : $item['address']['province'] = '';
        // $item['address']['country'] = '日本';
        $item['address']['country'] = strval( $cand->address );
        $item['address']['country_code'] = 'jp';
        array_push($arr, $item);
        if( ++$count > 9 ) {
          break;
        }
      }
    }
    echo json_encode($arr);
  } else {
  }
?>