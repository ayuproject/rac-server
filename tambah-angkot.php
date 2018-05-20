<?php
  require_once('layout/header.php');
  require_once('layout/sidebar.php');
  require_once('config/const.php');
  

  $aksi = isset($_POST["aksi"]) ? $_POST["aksi"] : "";
  $id = isset($_POST["id"]) ? $_POST["id"] : "-1";
  $nama = "";
  $tarif = "";
  $rute = array();
  $jalan = array();
  $tempat = array();
  $obj = null;

  if ($aksi === "edit") {
    ini_set("allow_url_fopen", 1);
    $url = DOMAIN_APP."/app/angkot-result.php?id=".$id;
    $json = file_get_contents($url);
    $obj = json_decode($json, true);
    $nama = $obj["angkot"]["nama"];
    $tarif = $obj["angkot"]["harga"];
    $rute = $obj["angkot"]["rute"];
    $jalan = $obj["angkot"]["jalan"];
    $tempat = $obj["angkot"]["tempat"];
  }

?>
      <div class="bs-docs-section">
        <div class="row">
          <div class="col-lg-12">
            <div class="page-header">
              <h1 id="forms">Input Angkot</h1>
            </div>
          </div>
        </div>
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
              <div class="bs-component">
                <ul class="nav nav-tabs">
                  <li class="active"><a href="#inputdata" data-toggle="tab" id="htb-data"><span class="glyphicon glyphicon-file">Data</span></a></li>
                  <li><a href="#inputrute" data-toggle="tab" id="htb-rute"><span class="glyphicon glyphicon-flag">Rute</a></li>
                  <li><a href="#inputjalan" data-toggle="tab" id="htb-jalan"><span class="glyphicon glyphicon-road">Jalan</a></li>
                  <li><a href="#inputtempat" data-toggle="tab" id="htb-tempat"><span class="glyphicon glyphicon-home">Tempat</a></li>
                </ul>
                <input type="hidden" id="aksi" value="<?= isset($_POST['aksi']) ? $_POST['aksi'] : '' ?>">
                <input type="hidden" id="id-angkot" value="<?= isset($_POST['id']) ? $_POST['id'] : '-1' ?>">
                <div id="myTabContent" class="tab-content">
                  <div class="tab-pane fade active in" id="inputdata">
                    <div class="well bs-component">
                      <fieldset>
                        <div class="row">
                          <div class="form-group">
                            <label for="nama">Nama Angkot</label>
                            <input class="form-control" required="required" name="nama" type="text" id="nama" value="<?=$nama?>">
                            <small class="text-danger"></small>
                          </div>
                          <div class="clearfix"></div>
                          <div class="form-group">
                            <label for="tarif">Tarif Angkot</label>
                            <input class="form-control" required="required" name="nama" type="text" id="tarif"  value="<?=$tarif?>">
                            <small class="text-danger"></small>
                          </div>
                        </div>
                      </fieldset>
                    </div>
                  </div>
                  <div class="tab-pane fade" id="inputrute">
                    <div class="well bs-component">
                      <fieldset>
                          <div class="row">
                            <div class="col-lg-12">
                              <div class="form-group">
                                <label for="latlng">Lokasi</label>
                                <input class="form-control" required="required" name="latlng" type="text" id="latlng" disabled>
                                <small class="text-danger"></small>
                              </div>
                              <div class="clearfix"></div>
                              <button class="btn btn-primary btn-block" id="btn-add-rute">Tambahkan</button>
                              <div class="clearfix"></div>
                              <div style="height:355px; overflow:auto;">
                                <div class="bs-component">
                                  <table class="table table-striped table-hover" id="tb-lokasi">
                                    <thead>
                                      <tr>
                                        <th>#</th>
                                        <th>Lokasi</th>
                                        <th>Hapus</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                      <?php
                                        for ($i = 0; $i < sizeof($rute); ++$i) {
                                          echo "<tr> <td class='num'>" . ($i + 1) . "</td> <td class='latlng'>" . $rute[$i] . "</td><td><button class='btn btn-danger btn-rm' name='btn-rm'>-</button></td></tr>";
                                        }
                                      ?>
                                    </tbody>
                                  </table>
                                </div>
                              </div>
                              <div class="clearfix"></div>
                              <button class="btn btn-primary btn-block" id="btn-result-rute">Lihat hasil</button>
                            </div>
                          </div>
                        <div class="clearfix"></div>
                      </fieldset>
                    </div>
                  </div>
                  <div class="tab-pane fade" id="inputjalan">
                    <div class="well bs-component">
                      <fieldset>
                        <div class="row">
                          <div class="col-lg-12">
                            <div class="col-md-2">
                              <div class="form-group">
                                <label for="id-jalan">id</label>
                                <input class="form-control" required="required" name="latlng" type="text" id="id-jalan" disabled>
                                <small class="text-danger"></small>
                              </div>
                            </div>
                            <div class="col-md-10">
                              <div class="form-group">
                                <label for="nama-jalan">Nama</label>
                                <input class="form-control" required="required" name="latlng" type="text" id="nama-jalan" disabled>
                                <small class="text-danger"></small>
                              </div>
                            </div>
                            <div class="clearfix"></div>
                            <button class="btn btn-primary btn-block" id="btn-add-jalan">Tambahkan</button>
                            <div class="clearfix"></div>
                            <div style="height:355px; overflow:auto;">
                              <div class="bs-component">
                                <table class="table table-striped table-hover" id="tb-jalan">
                                  <thead>
                                    <tr>
                                      <th>id</th>
                                      <th>Nama</th>
                                      <th>Hapus</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <?php
                                      for ($i = 0; $i < sizeof($jalan); ++$i) {
                                        echo "<tr> <td class='id'>" . $jalan[$i]["id"] . "</td> <td class='nama'>" . $jalan[$i]["nama"] . "</td><td><button class='btn btn-danger btn-rm-jalan-tempat' name='btn-rm-jalan-tempat'>-</button></td></tr>";
                                      }
                                    ?>
                                  </tbody>
                                </table>
                              </div>
                            </div>
                          </div>
                        </div>
                      </fieldset>
                    </div>
                  </div>
                  <div class="tab-pane fade" id="inputtempat">
                    <div class="well bs-component">
                      <fieldset>
                        <div class="row">
                          <div class="col-lg-12">
                            <div class="col-md-2">
                              <div class="form-group">
                                <label for="id-tempat">id</label>
                                <input class="form-control" required="required" name="latlng" type="text" id="id-tempat" disabled>
                                <small class="text-danger"></small>
                              </div>
                            </div>
                            <div class="col-md-10">
                              <div class="form-group">
                                <label for="nama-tempat">Nama</label>
                                <input class="form-control" required="required" name="latlng" type="text" id="nama-tempat" disabled>
                                <small class="text-danger"></small>
                              </div>
                            </div>
                            <div class="clearfix"></div>
                            <button class="btn btn-primary btn-block" id="btn-add-tempat">Tambahkan</button>
                            <div class="clearfix"></div>
                            <div style="height:355px; overflow:auto;">
                              <div class="bs-component">
                                <table class="table table-striped table-hover" id="tb-tempat">
                                  <thead>
                                    <tr>
                                      <th>id</th>
                                      <th>Nama</th>
                                      <th>Hapus</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <?php
                                      for ($i = 0; $i < sizeof($tempat); ++$i) {
                                        echo "<tr> <td class='id'>" . $tempat[$i]["id"] . "</td> <td class='nama'>" . $tempat[$i]["nama"] . "</td><td><button class='btn btn-danger btn-rm-jalan-tempat' name='btn-rm-jalan-tempat'>-</button></td></tr>";
                                      }
                                    ?>
                                  </tbody>
                                </table>
                              </div>
                            </div>
                          </div>
                        </div>
                      </fieldset>
                    </div>
                  </div>
                  
                  <div class="btn-toolbar">
                    <button class="btn btn-success pull-right" id="btn-simpan">Simpan</button>
                    <button class="btn btn-danger pull-left" id="btn-hapus" <?= $aksi === "edit" ? "" : "disabled" ?>>Hapus</button>
                  </div>
              </div>
            </div>
            <!-- end tab -->
          </div>
      </div>
      </div>
      <script type="text/javascript">
        var routeMarker = false;
        var tabSelected = "";

        function initAutocomplete() {
          tabSelected = "data";
          map = new google.maps.Map(document.getElementById('map'), {
            center: {lat: -33.8688, lng: 151.2195},
            zoom: 13,
            mapTypeId: 'roadmap'
          });

          boundsCianjurKota = new google.maps.LatLngBounds();
          boundsCianjurKota.extend(new google.maps.LatLng(-6.803476,107.15325));
          boundsCianjurKota.extend(new google.maps.LatLng(-6.84117,107.122121));
          var jalanData = [];
          var tempatData = [];

          map.addListener('bounds_changed', function() {
            
          });
          map.fitBounds(boundsCianjurKota);
          
          google.maps.event.addListener(map, 'click', function(event) {
            if (tabSelected !== "rute"){
              return;
            }
            //Get the location that the user clicked.
            var clickedLocation = event.latLng;
            $("#latlng").val(event.latLng.lat() + "," + event.latLng.lng());

            //If the marker hasn't been added.
            if ( routeMarker === false){
                //Create the marker.
                routeMarker = new google.maps.Marker({
                    position: clickedLocation,
                    map: map,
                    draggable: true //make it draggable
                });
            } else {
                //Marker has already been added, so just change its location.
                routeMarker.setPosition(clickedLocation);
            }
          });
          var directionsService = new google.maps.DirectionsService;
          var directionsDisplay = new google.maps.DirectionsRenderer;

          $(document).on("click", ".btn-rm", function(e){
            $(this).parent().parent().remove();
            var tb_count = 0;
            $('#tb-lokasi > tbody > tr').each(function(){
              $(this).find(".num").html(++tb_count);
            });
            directionsDisplay.setMap(null);
            directionsDisplay = null;
            directionsDisplay = new google.maps.DirectionsRenderer;
            directionsDisplay.setMap(map);
            if (tb_count > 1) {
              calculateAndDisplayRoute(directionsService, directionsDisplay, false);
            } else {
              directionsDisplay.setMap(null);
            }
          });

          $(document).on("click", ".btn-rm-jalan-tempat", function(e){
            $(this).parent().parent().remove();
          });

          $(document).on("click", "#htb-data", function(e){
            tabSelected = "data";
            clearMarker();
          });

          $(document).on("click", "#htb-rute", function(e){
            tabSelected = "rute";
            clearMarker();
          });

          $(document).on("click", "#htb-jalan", function(e){
            tabSelected = "jalan";
            clearMarker();
            loadExitingStreet();
          });

          $(document).on("click", "#htb-tempat", function(e){
            tabSelected = "tempat";
            clearMarker();
            loadExitingPlace();
          });

          $(document).on("click", "#btn-add-rute", function(e){
            var val = $("#latlng").val();
            if (val === "") {
              window.alert("Klik pada peta untuk mengisi koordinat !");
              return;
            }
            var length = $('#tb-lokasi > tbody > tr').length;
            var tab = $('#tb-lokasi > tbody:last-child');
            tab.append("<tr> <td class='num'>" + (length + 1) + "</td> <td class='latlng'>" + val + "</td><td><button class='btn btn-danger btn-rm' name='btn-rm'>-</button></td></tr>");
            $("#latlng").val("");
            directionsDisplay.setMap(null);
            directionsDisplay.setMap(map);
            if ((length + 1) > 1) {
              calculateAndDisplayRoute(directionsService, directionsDisplay, false);
            }
          });

          $(document).on("click", "#btn-add-jalan", function(e){
            var id_jalan = $("#id-jalan").val();
            var nama_jalan = $("#nama-jalan").val();
            if (id_jalan === "" || nama_jalan === "") {
              window.alert("Klik lokasi jalan pada peta untuk mengisi jalan !");
              return;
            }
            var isExist = false;
            $('#tb-jalan > tbody > tr').each(function(){
              if ($(this).find(".id").html() === id_jalan){
                isExist = true;
                return false;
              }
            });
            if (isExist === true) {
              window.alert("Data sudah ada dalam table!");
              return;
            }
            var tab = $('#tb-jalan > tbody:last-child');  
            tab.append("<tr> <td class='id'>" + id_jalan + "</td> <td class='nama'>" + nama_jalan + "</td><td><button class='btn btn-danger btn-rm-jalan-tempat' name='btn-rm-jalan-tempat'>-</button></td></tr>");
            $("#id-jalan").val("");
            $("#nama-jalan").val("");
          });

          $(document).on("click", "#btn-add-tempat", function(e){
            var id_tempat = $("#id-tempat").val();
            var nama_tempat = $("#nama-tempat").val();
            if (id_tempat === "" || nama_tempat === "") {
              window.alert("Klik lokasi jalan pada peta untuk mengisi tempat !");
              return;
            }
            var isExist = false;
            $('#tb-tempat > tbody > tr').each(function(){
              if ($(this).find(".id").html() === id_tempat){
                isExist = true;
                return false;
              }
            });
            if (isExist === true) {
              window.alert("Data sudah ada dalam table!");
              return;
            }
            var tab = $('#tb-tempat > tbody:last-child');
            tab.append("<tr> <td class='id'>" + id_tempat + "</td> <td class='nama'>" + nama_tempat + "</td><td><button class='btn btn-danger btn-rm-jalan-tempat' name='btn-rm-jalan-tempat'>-</button></td></tr>");
            $("#id-tempat").val("");
            $("#nama-tempat").val("");
          });

          $(document).on("click", "#btn-result-rute", function(e){
            var length = $('#tb-lokasi > tbody > tr').length;
            directionsDisplay.setMap(null);
            directionsDisplay = null;
            directionsDisplay = new google.maps.DirectionsRenderer;
            directionsDisplay.setMap(map);
            if (length > 1) {
              calculateAndDisplayRoute(directionsService, directionsDisplay, true);
            }
          });

          $(document).on("click", "#btn-simpan", function(e) {
            var aksi = $("#aksi").val();
            var id = $("#id-angkot").val();
            var nama = $("#nama").val();
            var tarif = $("#tarif").val();
            var rute = [];
            var id_jalan = [];
            var id_tempat = [];

            $("#tb-lokasi > tbody > tr").each(function(){
              rute.push($(this).find(".latlng").html());
            });
            $("#tb-jalan > tbody > tr").each(function(){
              id_jalan.push($(this).find(".id").html());
            });
            $("#tb-tempat > tbody > tr").each(function(){
              id_tempat.push($(this).find(".id").html());
            });

            if (aksi !== "hapus") {
              if (nama === "") {
                window.alert("Silahkan isi nama terlebih dahulu !");
                return;
              }
              if (tarif === "") {
                window.alert("Silahkan isi tarif terlebih dahulu !");
                return;
              }
              if (rute.length < 2) {
                window.alert("Titik rute tidak boleh kurang dari 2 !");
                return;
              }
              if (id_jalan.length === 0) {
                window.alert("Silahkan isi jalan terlebih dahulu !");
                return;
              }
              if (id_tempat.length === 0) {
                window.alert("Silahkan isi tempat terlebih dahulu !");
                return;
              }
            }
            $.post("tambah-angkot-action.php",
            {
              aksi: aksi,
              id: id,
              nama: nama,
              tarif: tarif,
              rute: rute,
              id_jalan: id_jalan,
              id_tempat: id_tempat
            },
            function(data,status){
                alert("Pesan : " + data);
                location.reload();
            });
          });

          $(document).on("click", "#btn-hapus", function(e){
            var id = $("#id-angkot").val();
            $.post("tambah-angkot-action.php",
            {
              aksi: "hapus",
              id: id
            },
            function(data,status){
              alert("Pesan : " + data);
              window.location="index.php";
            });
          });

          function clearMarker() {
            jalanData.forEach(function(marker) {
              marker.setMap(null);
            });
            jalanData = [];

            tempatData.forEach(function(marker) {
              marker.setMap(null);
            });
            tempatData = [];
            if (routeMarker !== false) {
              routeMarker.setMap(null);
              routeMarker = false;
            }
          }

          function loadExitingStreet(){
            if (map == null){
              return;
            }

            var xhttp;
            xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
              if (this.readyState == 4 && this.status == 200) {
                var obj = JSON.parse(this.responseText); 
                for (i =0; i < obj.jalan.length; ++i) {
                  var l_lat = obj.jalan[i].location.split(",");

                  var marker = new google.maps.Marker({
                    map: map,
                    icon: "http://maps.google.com/mapfiles/ms/icons/green-dot.png",
                    title: obj.jalan[i].nama,
                    position: new google.maps.LatLng(l_lat[0], l_lat[1]),
                    a_id: obj.jalan[i].id,
                    a_location: obj.jalan[i].location,
                    a_northeast: obj.jalan[i].latlng1,
                    a_southwest: obj.jalan[i].latlng2,
                    a_placeid: obj.jalan[i].place_id
                  });
                  marker.addListener('click', function() {
                    $("#id-jalan").val(this.a_id);
                    $("#nama-jalan").val(this.title);
                    topFunction();
                  });
                  jalanData.push(marker);
                }
              }
            };
            xhttp.open("GET", "get-street.php", true);
            xhttp.send();
          }

          function loadExitingPlace(){
            if (map == null){
              return;
            }
            
            var xhttp;
            xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
              if (this.readyState == 4 && this.status == 200) {
                var obj = JSON.parse(this.responseText); 
                for (i =0; i < obj.tempat.length; ++i) {
                  var l_lat = obj.tempat[i].location.split(",");
                  var marker = new google.maps.Marker({
                    map: map,
                    icon: "http://maps.google.com/mapfiles/ms/icons/blue-dot.png",
                    title: obj.tempat[i].nama,
                    position: new google.maps.LatLng(l_lat[0], l_lat[1]),
                    a_id: obj.tempat[i].id,
                    a_location: obj.tempat[i].location,
                    a_placeid: obj.tempat[i].place_id
                  });
                  marker.addListener('click', function() {
                    $("#id-tempat").val(this.a_id);
                    $("#nama-tempat").val(this.title);
                    topFunction();
                  });
                  jalanData.push(marker);
                }
              }
            };
            xhttp.open("GET", "get-place.php", true);
            xhttp.send();
          }
        }

        function topFunction() {
          document.body.scrollTop = 0;
          document.documentElement.scrollTop = 0;
        }

        function calculateAndDisplayRoute(directionsService, directionsDisplay, isRound) {
          var waypts = [];
          $('#tb-lokasi > tbody > tr').each(function(){
            var loc = $(this).find(".latlng").html().split(",");
            waypts.push({
              location: new google.maps.LatLng(loc[0], loc[1])
            });
          });

          var start = waypts[0].location.lat() + "," + waypts[0].location.lng();
          var end = "";
          if (isRound == false) {
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