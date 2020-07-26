# GeocoderProxy

* OpenStreetMap の [Nominatim](https://wiki.openstreetmap.org/wiki/JA:Nominatim) に対応したクライアントから東京大学空間情報科学研究センター(CSIS)が提供する「[シンプルジオコーディング実験](http://newspat.csis.u-tokyo.ac.jp/geocode/modules/geocode/index.php?content_id=1)」にアクセスするために、サーバーサイドでインタフェースを変換します。
* 以下のような流れになります。

```クライアント ⇒ (q=住所) ⇒ GeocoderProxy ⇒ (?addr=住所) ⇒ CSIS ⇒ (XML) ⇒ GeocoderProxy ⇒ (JSON) ⇒ クライアント```
* [Leaflet](https://leafletjs.com/)のプラグイン [Leaflet Control Geocoder](https://github.com/perliedman/leaflet-control-geocoder) で動作確認しました。
* 35.658099, 139.741357 という形式で緯度経度が渡されたときは、ジオコーダを呼び出さずにそのままの値を返します。

## 使用法
* search.php と .htaccess をWebサーバに設置します。.htaccess は、拡張子なしで search.php をアクセス可能にするためのものです。

### Leaflet Control Geocoder の設定
* L.Control.geocoder の geocoder オプションで L.Control.Geocoder.Nominatim を指定し、その serviceUrl オプションで GeocoderProxy を設置したサーバーを指定します。
```
  L.Control.geocoder({
    geocoder: new L.Control.Geocoder.Nominatim({
      serviceUrl: /* URL of the service */
    }),
```

## 利用例
* [月待ビンゴ攻略マップ](https://moon.midoriit.com/map/) で利用しています。
