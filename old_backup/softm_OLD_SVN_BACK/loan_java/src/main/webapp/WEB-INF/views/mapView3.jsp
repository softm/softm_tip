<%@ page language="java" contentType="text/html; charset=UTF-8" pageEncoding="UTF-8"%>
<script src="/js/jquery-2.1.1.js"></script>
<script type="text/javascript" src="https://openapi.map.naver.com/openapi/v3/maps.js?clientId=rDW8uCwOrCUBQDZ5_8_l"></script>
<div id="map" style="width:100%;height:400px;"></div>

<style type="text/css">
.search { position:absolute;z-index:1000;top:20px;left:20px; }
.search #address { width:150px;height:20px;line-height:20px;border:solid 1px #555;padding:5px;font-size:12px;box-sizing:content-box; }
.search #submit { height:30px;line-height:30px;padding:0 10px;font-size:12px;border:solid 1px #555;border-radius:3px;cursor:pointer;box-sizing:content-box; }
</style>

<div id="wrap" class="section">
    <h2>주소와 좌표 검색 API 사용하기</h2>
    <p>Geocoder 서브모듈의 Service 객체를 사용하여, 주소로 좌표 검색 (Geocode) 또는 좌표로 주소를 검색 (ReverseGeocode) 하는 예제입니다.<br />
    입력창에 주소를 입력하여 검색하면 해당 주소의 좌표로 이동하며, 지도를 클릭하면 해당 지점의 TM128 좌표로 주소를 검색합니다.</p>
    <div id="map" style="width:100%;height:600px;">
        <div class="search" style="">
            <input id="address" type="text" placeholder="검색할 주소" value="불정로 6" />
            <input id="submit" type="button" value="주소 검색" />
        </div>
    </div>
    <code id="snippet" class="snippet"></code>
</div>

    <script>
    var map = new naver.maps.Map("map", {
        center: new naver.maps.LatLng(37.3595316, 127.1052133),
        zoom: 10,
        mapTypeControl: true
    });

    var infoWindow = new naver.maps.InfoWindow({
        anchorSkew: true
    });

    map.setCursor('pointer');

    // search by tm128 coordinate
    function searchCoordinateToAddress(latlng) {
        var tm128 = naver.maps.TransCoord.fromLatLngToTM128(latlng);

        infoWindow.close();

        naver.maps.Service.reverseGeocode({
            location: tm128,
            coordType: naver.maps.Service.CoordType.TM128
        }, function(status, response) {
            if (status === naver.maps.Service.Status.ERROR) {
                return alert('Something Wrong!');
            }

            var items = response.result.items,
                htmlAddresses = [];

            for (var i=0, ii=items.length, item, addrType; i<ii; i++) {
                item = items[i];
                addrType = item.isRoadAddress ? '[도로명 주소]' : '[지번 주소]';

                htmlAddresses.push((i+1) +'. '+ addrType +' '+ item.address);
                htmlAddresses.push('&nbsp&nbsp&nbsp -> '+ item.point.x +','+ item.point.y);
            }

            infoWindow.setContent([
                    '<div style="padding:10px;min-width:200px;line-height:150%;">',
                    '<h4 style="margin-top:5px;">검색 좌표 : '+ response.result.userquery +'</h4><br />',
                    htmlAddresses.join('<br />'),
                    '</div>'
                ].join('\n'));

            infoWindow.open(map, latlng);
        });
    }

    // result by latlng coordinate
    function searchAddressToCoordinate(address) {
        naver.maps.Service.geocode({
            address: address
        }, function(status, response) {
            if (status === naver.maps.Service.Status.ERROR) {
                return alert('Something Wrong!');
            }

            var item = response.result.items[0],
                addrType = item.isRoadAddress ? '[도로명 주소]' : '[지번 주소]',
                point = new naver.maps.Point(item.point.x, item.point.y);
 
            infoWindow.setContent([
                    '<div style="padding:10px;min-width:200px;line-height:150%;">',
                    '<h4 style="margin-top:5px;">검색 주소 : '+ response.result.userquery +'</h4><br />',
                    addrType +' '+ item.address +'<br />',
                    '&nbsp&nbsp&nbsp -> '+ point.x +','+ point.y,
                    '</div>'
                ].join('\n'));


            map.setCenter(point);
            infoWindow.open(map, point);
        });
    }

    function initGeocoder() {
        alert(":");
        map.addListener('click', function(e) {
            searchCoordinateToAddress(e.coord);
        });

        $('#address').on('keydown', function(e) {
            var keyCode = e.which;

            if (keyCode === 13) { // Enter Key
                searchAddressToCoordinate($('#address').val());
            }
        });

        $('#submit').on('click', function(e) {
            e.preventDefault();

            searchAddressToCoordinate($('#address').val());
        });

        searchAddressToCoordinate('정자동 178-1');

    }

    naver.maps.onJSContentLoaded = initGeocoder;
    initGeocoder();
    </script>
</body>
</html>

