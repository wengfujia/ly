/**
 * 高德地图控制器
 */
function MapInit(scope) {
	scope.city = '0571';
	scope.zoom = 14;
	
	scope.map = new AMap.Map("mapcontainer", {
	    resizeEnable: true,
	    zoom: scope.zoom
	});
	
	//获取地理编码
	scope.geocoder = function(address) {
	    var geocoder = new AMap.Geocoder({
	        city: scope.city, //城市，默认：“全国”
	        radius: 1000 //范围，默认：500
	    });
	    //地理编码,返回地理编码结果
	    geocoder.getLocation(address, function(status, result) {
	        if (status === 'complete' && result.info === 'OK') {
	        	scope.geocoder_CallBack(result);
	        }
	    });
	}
	
	//打点
	scope.addMarker = function(lng,lat,formattedAddress) {
	    var marker = new AMap.Marker({
	        map: scope.map,
	        position: [ lng, lat]
	    });
	    if (formattedAddress>'') {
	    	var infoWindow = new AMap.InfoWindow({
		        content: formattedAddress,
		        offset: {x: 0, y: -30}
		    });
		    marker.on("mouseover", function(e) {
		        infoWindow.open(scope.map, marker.getPosition());
		    });
	    }
	    return marker;
	}
    
}
