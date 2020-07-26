# GeocoderProxy

* OpenStreetMap の [Nominatim](https://wiki.openstreetmap.org/wiki/JA:Nominatim) に対応したクライアントから東京大学空間情報科学研究センターが提供する「[シンプルジオコーディング実験](http://newspat.csis.u-tokyo.ac.jp/geocode/modules/geocode/index.php?content_id=1)」にアクセスするために、サーバーサイドでインタフェースを変換します。
* [Leaflet](https://leafletjs.com/)のプラグイン [Leaflet Control Geocoder](https://github.com/perliedman/leaflet-control-geocoder) で動作確認しました。

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
