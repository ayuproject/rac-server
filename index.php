<?php
  require_once('layout/header.php');
  require_once('layout/sidebar.php');
?>

      <div class="bs-docs-section">  
        <div class="row">
          <div class="col-lg-12">
            <div class="col-md-7">
                <div class="row">
                  <div class="col-sm-12">
                    <div class="map-container">
                      <div id="map">
                        
                      </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-5">
              <!-- tab -->
                <div class="well bs-component">
                  <fieldset>
                    <div class="row">
                      <div class="col-lg-12">
                        <form method="POST" action="tambah-angkot.php">
                          <input type="hidden" name="aksi" value="tambah">
                          <input type="hidden" name="id" value="-1">;
                          <button class="btn btn-primary btn-block" type="submit">Tambahkan Angkot</button>
                        </form>
                        <div class="clearfix"></div>
                        <div style="height:730px; overflow:auto;">
                          <div class="bs-component">
                            <table class="table table-striped table-hover" id="tb-angkot">
                              <thead>
                                <tr>
                                  <th>id</th>
                                  <th>Nama</th>
                                  <th>Ubah/Hapus</th>
                                  <th>Lihat Rute</th>
                                </tr>
                              </thead>
                              <tbody>
                                
                              </tbody>
                            </table>
                          </div>
                        </div>
                      </div>
                    </div>
                  </fieldset>
                </div>
            <!-- end tab -->
          </div>
        </div>
      </div>
      <script type="text/javascript">
        var jalanData = [];
        var tempatData = [];
        function initAutocomplete() {
          map = new google.maps.Map(document.getElementById('map'), {
            center: {lat: -33.8688, lng: 151.2195},
            zoom: 13,
            mapTypeId: 'roadmap'
          });

          boundsCianjurKota = new google.maps.LatLngBounds();
          boundsCianjurKota.extend(new google.maps.LatLng(-6.803476,107.15325));
          boundsCianjurKota.extend(new google.maps.LatLng(-6.84117,107.122121));
          var directionsService = new google.maps.DirectionsService;
          var directionsDisplay = new google.maps.DirectionsRenderer;
          map.addListener('bounds_changed', function() {
            
          });
          map.fitBounds(boundsCianjurKota);
          loadAllAngkot();

          $(document).on("click", ".btn-ubah", function(e){
            var id = $(this).parent().parent().find(".id").html();
            $.post("tambah-angkot-action.php",
            {
              aksi: "edit",
              id: id
            },
            function(data,status){
                alert("Pesan : " + data);
                location.reload();
            });
          });

          $(document).on("click", ".btn-lihat", function(e){
            var id = $(this).parent().parent().find(".id").html();
            var xhttp;
            xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
              if (this.readyState == 4 && this.status == 200) {
                var obj = JSON.parse(this.responseText); 
                //rute
                directionsDisplay.setMap(null);
                directionsDisplay.setMap(map);
                clearMarker();
                var waypts = [];
                var satu_jalur = obj.angkot.satu_jalur;
                for (i =0; i < obj.angkot.rute.length; ++i) {
                  var loc = obj.angkot.rute[i].split(",");
                  waypts.push({location: new google.maps.LatLng(loc[0], loc[1])});
                }
                calculateAndDisplayRoute(directionsService, directionsDisplay, waypts, satu_jalur)
                //jalan
                for (i =0; i < obj.angkot.jalan.length; ++i) {
                  var l_lat = obj.angkot.jalan[i].location.split(",");
                  var marker = new google.maps.Marker({
                    map: map,
                    icon: "http://maps.google.com/mapfiles/ms/icons/green-dot.png",
                    title: obj.angkot.jalan[i].nama,
                    position: new google.maps.LatLng(l_lat[0], l_lat[1]),
                    a_id: obj.angkot.jalan[i].id,
                    a_location: obj.angkot.jalan[i].location
                  });
                  marker.addListener('click', function() {
                    var contentStr = "<h3><b>" + this.title + "</b></h3><br><b>ID:</b> " + this.a_id + "<br> <b>Location:</b> " + this.a_location;
                    var infowindow = new google.maps.InfoWindow({
                      content: contentStr
                    }).open(map, this);

                  });
                  jalanData.push(marker);
                }

                //tempat
                for (i =0; i < obj.angkot.tempat.length; ++i) {
                  var l_lat = obj.angkot.tempat[i].latlng.split(",");
                  var marker = new google.maps.Marker({
                    map: map,
                    icon: "http://maps.google.com/mapfiles/ms/icons/blue-dot.png",
                    title: obj.angkot.tempat[i].nama,
                    position: new google.maps.LatLng(l_lat[0], l_lat[1]),
                    a_id: obj.angkot.tempat[i].id,
                    a_location: obj.angkot.tempat[i].latlng
                  });
                  marker.addListener('click', function() {
                    var contentStr = "<h3><b>" + this.title + "</b></h3><br><b>ID:</b> " + this.a_id + "<br> <b>Location:</b> " + this.a_location;
                    var infowindow = new google.maps.InfoWindow({
                      content: contentStr
                    }).open(map, this);
                  });
                  tempatData.push(marker);
                }
              }
            };
            xhttp.open("GET", "get-angkot.php?id=" + id, true);
            xhttp.send();
          });

          $(document).on("click", ".btn-edit", function(e){
            
          });

          function loadAllAngkot(){

            var tab = $('#tb-angkot > tbody:last-child');
            var xhttp;

            xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
              if (this.readyState == 4 && this.status == 200) {
                var obj = JSON.parse(this.responseText); 
                for (i =0; i < obj.angkot.length; ++i) {
                  tab.append("<tr> <td class='id'>" + obj.angkot[i].id + "</td> <td>" + obj.angkot[i].nama + "</td><td><form method='POST' action='tambah-angkot.php'><input name='id' type='hidden' value='" + obj.angkot[i].id + "'><input name='aksi' type='hidden' value='edit'><button type='submit' class='btn btn-primary'>Edit/Hapus</button></form></td><td><button class='btn btn-primary btn-lihat'><span class='glyphicon glyphicon-eye-open'></span></button></td></tr>");
                }
              }
            };
            xhttp.open("GET", "get-all-angkot-result.php", true);
            xhttp.send();
          }

          function clearMarker() {
            jalanData.forEach(function(marker) {
              marker.setMap(null);
            });
            jalanData = [];

            tempatData.forEach(function(marker) {
              marker.setMap(null);
            });
            tempatData = [];
          }
        }

        function calculateAndDisplayRoute(directionsService, directionsDisplay, waypts, satu_jalur) {

          var start = waypts[0].location.lat() + "," + waypts[0].location.lng();
          var end = "";
          if (satu_jalur) {
            end = waypts[waypts.length - 1].location.lat() + "," + waypts[waypts.length - 1].location.lng();
            waypts.splice(waypts.length - 1, 1);
          } else {
            end = start;
          }

          waypts.splice(0, 1);

          directionsService.route({
            origin: start,
            destination: end,
            waypoints: waypts,
            optimizeWaypoints: true,
            travelMode: 'DRIVING'
          }, function(response, status) {
            if (status === 'OK') {
              directionsDisplay.setDirections(response);
              
            } else {
              window.alert('Directions request failed due to ' + status);
            }
          });
        }
      </script>

<?php
  require_once('layout/footer.php');
?>
