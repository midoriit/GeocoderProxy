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
      $gsi = 'https://msearch.gsi.go.jp/address-search/AddressSearch?q=';
      $json = file_get_contents( $gsi.$_GET['q'] );
      $res = json_decode( $json , true );

      $arr = array();
      $count = 0;
      foreach( $res as $cand ) {
        $item = array();
        $lat = round( $cand["geometry"]["coordinates"][1], 6);
        $lon = round( floatval( $cand["geometry"]["coordinates"][0] ), 6);
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
        $item['address']['city'] = $cand["properties"]["title"];
        $item['address']['country'] = '日本';
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