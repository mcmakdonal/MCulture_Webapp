<!-- Modal -->
<div class="modal fade" id="map-modal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">×</button>
            <h4 class="modal-title"> แผนที่ </h4>
            </div>
            <div class="modal-body">
                <div id="map"></div>
                    <hr />
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <input type="text" class="form-control" id="search" placeholder="ค้นหา... เช่น 13.694638, 100.602441 หรือ ตำแหน่ง ที่ต้องการเช่น Central World">
                        </div>
                    </div>
                    <div class="row" style="margin-top: 10px;">
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <input id="submit" class="btn btn-google center-block" type="button" value="Search">
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <input id="myloc" onclick="getLocation()" class="btn btn-google center-block" type="button" value="My Location">
                        </div>
                    </div>
                    <div class="row" style="margin-top: 10px;">
                        <div class="col-xs-12">
                            <input type="text" class="form-control" id="address" placeholder="รายละเอียดตำแหน่ง" readonly="true">
                        </div>
                    </div>
                    <div class="row" style="margin-top: 10px;">
                        <div class="col-xs-6">
                            <input type="text" class="form-control" id="lat" readonly="true">
                        </div>
                        <div class="col-xs-6">
                            <input type="text" class="form-control"  id="long" readonly="true">
                        </div>
                        <div class="col-xs-12 text-center" style="margin-top: 10px;">
                            <button type="button" class="btn btn-success" onclick="select_map()"> เลือก </button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal"> ปิด </button>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">

            </div>
        </div>
    </div>
</div>
<script>
    var markers = [];
    var map;
    function initAutocomplete() {
        map = new google.maps.Map(document.getElementById('map'), {
            zoom: 16,
            center: {lat: 13.7563309, lng: 100.50176510000006},
            mapTypeId: 'roadmap'
        });
        var geocoder = new google.maps.Geocoder();

        document.getElementById('submit').addEventListener('click', function () {
            deleteMarkers();
            geocodeAddress(geocoder, map);
        });
    }

    function geocodeAddress(geocoder, resultsMap) {
        var address = document.getElementById('search').value;
        // var i = 1;
        geocoder.geocode({'address': address}, function (results, status) {
            if (status === 'OK') {
                // i = i +1;
                resultsMap.setCenter(results[0].geometry.location);
                // console.log(i + ' | ' + results[0].geometry.location);
                var marker = new google.maps.Marker({
                    map: resultsMap,
                    draggable: true,
                    position: results[0].geometry.location
                });
                markers.push(marker);
                document.getElementById('address').value = results[0].formatted_address;
                document.getElementById('lat').value = results[0].geometry.location.lat();
                document.getElementById('long').value = results[0].geometry.location.lng();

                // ลบตัวแรก มันเบิ้ล
                markers[0].setMap(null);
                google.maps.event.addListener(marker, 'dragend', function (event) {
                    document.getElementById("lat").value = this.getPosition().lat();
                    document.getElementById("long").value = this.getPosition().lng();
                });
            } else {
                alert('กรุณากรอกข้อมูลสำหรับค้นหา: ' + status);
            }
            return;
        });
    }

    function getLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition);
        } else {
            alert("Geolocation is not supported by this browser.");
        }
    }

    function showPosition(position) {
        var lat = position.coords.latitude;
        var lng = position.coords.longitude;
        map = new google.maps.Map(document.getElementById('map'), {
            zoom: 16,
            center: {lat: lat, lng: lng},
            mapTypeId: 'roadmap'
        });
        var marker = new google.maps.Marker({
            map: map,
            draggable: true,
            position: {lat: lat, lng: lng},
        });

        document.getElementById("lat").value = lat;
        document.getElementById("long").value = lng;

        google.maps.event.addListener(marker, 'dragend', function (event) {
            // console.log(this);
            document.getElementById("lat").value = this.getPosition().lat();
            document.getElementById("long").value = this.getPosition().lng();
        });

        markers.push(marker);
    }
    // Sets the map on all markers in the array.
    function setMapOnAll(map) {
        for (var i = 0; i < markers.length; i++) {
        markers[i].setMap(map);
        }
    }

    // Removes the markers from the map, but keeps them in the array.
    function clearMarkers() {
        setMapOnAll(null);
    }

    // Shows any markers currently in the array.
    function showMarkers() {
        setMapOnAll(map);
    }

    // Deletes all markers in the array by removing references to them.
    function deleteMarkers() {
        clearMarkers();
        markers = [];
    }

</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC0nDv-RQaz6eQeISg-aIdACH-F1U_cdtU&libraries=places&callback=initAutocomplete"
async defer></script>
