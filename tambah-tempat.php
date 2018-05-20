<?php
  require_once('layout/header.php');
  require_once('layout/sidebar.php');
?>
      <div class="bs-docs-section">
        <div class="row">
          <div class="col-lg-12">
            <div class="page-header">
              <h1 id="forms">Input Jalan</h1>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-12">
            <!-- tab -->
            <!--<form class="form-horizontal" method="POST" enctype="multipart/form-data" action="tambah-app-action.php"> </form>-->
              <div class="well bs-component">
                <fieldset>
                  <legend>Input Tempat</legend>
                  <input type="hidden" name="aksi" id="aksi" value="-1">
                  <input type="hidden" name="id-tempat" id="id-tempat" value="-1">
                  <div class="row">
                    <div class="col-lg-12">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="nama">Nama Tempat</label>
                          <input class="form-control" required="required" name="nama" type="text" id="nama">
                          <small class="text-danger"></small>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="location">Lokasi</label>
                          <input class="form-control" required="required" name="location" type="text" id="location" disabled>
                          <small class="text-danger"></small>
                        </div>
                      </div>
                    </div>
                    <div class="clearfix">
                    <div class="col-lg12">
                      <div class="form-group">
                          <label for="placeid">Place ID</label>
                            <input class="form-control" required="required" name="placeid" type="text" id="placeid" disabled>
                            <small class="text-danger"></small>
                        </div>
                    </div>
                  </div>
                </fieldset>
                <div class="btn-toolbar">
                  <button class="btn btn-success pull-right" id="btn-simpan">Simpan</button>
                  <button class="btn btn-success pull-right" id="btn-batal">Batal</button>
                  <button class="btn btn-danger pull-left" id="btn-hapus" disabled>Hapus</button>
                </div>
              </div>
          </div>
          <!-- end tab -->
        </div>
        <div class="clearfix"></div>
            <div class="clearfix"></div>
            <div class="row">
              <div class="col-sm-12">
                <div class="map-container">
                  <input id="pac-input" class="controls" type="text" placeholder="Search Box" id="placeSearch">
                  <div id="map">
                    
                  </div>
                </div>
              </div>
            </div>
      </div>
    </div>
    <script type="text/javascript">
      // This example adds a search box to a map, using the Google Place Autocomplete
      // feature. People can enter geographical searches. The search box will return a
      // pick list containing a mix of places and predicted search terms.

      // This example requires the Places library. Include the libraries=places
      // parameter when you first load the API. For example:
      // <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">

      var map;
      var markers = [];
      var rectangles = [];
      var jalanData= [];
      var boundsCianjur;
      var boundsCianjurKota;

      $(document).on('click', '#btn-batal', function(e) {
        e.preventDefault();
        loadExitingPlace();
        if (map != null) {
          map.fitBounds(boundsCianjurKota);
        }
      });

      $(document).on('click', '#btn-simpan', function(e){
        if ($("#location").val() === '' || $("#nama").val() === '') {
          alert('Pilih jalan di map terlebih dahulu/Nama jalan tidak boleh kosong');
          return;
        }
        $.post("tambah-tempat-action.php",
        {
          aksi: $("#aksi").val(),
          id_tempat: $("#id-tempat").val(),
          nama: $("#nama").val(),
          location: $("#location").val(),
          placeid: $("#placeid").val()
        },
        function(data,status){
            alert("Pesan : " + data);
            loadExitingPlace();
        });
        if (map != null) {
          map.fitBounds(boundsCianjurKota);
        }
        $("#pac-input").val('');
      });

      $(document).on('click', '#btn-hapus', function(e){
        if ($("#id-tempat").val() <= 0) {
          alert('Tidak ada yang di edit');
          return;
        }
        $.post("tambah-tempat-action.php",
        {
          aksi: "hapus",
          id_tempat: $("#id-tempat").val()
        },
        function(data,status){
            alert("Pesan : " + data);
        });
        loadExitingPlace();
        if (map != null) {
          map.fitBounds(boundsCianjurKota);
        }
        $(this).attr("disabled", true);
      });

      function setExitingStreet(f_place) {
        $("#btn-hapus").attr("disabled", false);
        $("#id-tempat").val(f_place.a_id);
        $("#nama").val(f_place.title);
        $("#location").val(f_place.a_location);
        $("#placeid").val(f_place.a_placeid);
        $("#aksi").val("edit");
      }

      function clearMap() {
        jalanData.forEach(function(marker) {
          marker.setMap(null);
        });
        markers.forEach(function(marker) {
          marker.setMap(null);
        });
        rectangles.forEach(function(rectangle) {
          rectangle.setMap(null);
        });
        markers = [];
        rectangles = [];
        jalanData = [];

        $("#id-tempat").val('-1');
        $("#nama").val('');
        $("#location").val('');
        $("#placeid").val('');
        $("#btn-hapus").attr("disabled", true);
      }

      function loadExitingPlace(){
        if (map == null){
          return;
        }

        clearMap();
        
        var xhttp;
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            var obj = JSON.parse(this.responseText); 
            for (i =0; i < obj.tempat.length; ++i) {
              var l_lat = obj.tempat[i].location.split(",");
              var marker = new google.maps.Marker({
                map: map,
                title: obj.tempat[i].nama,
                position: new google.maps.LatLng(l_lat[0], l_lat[1]),
                a_id: obj.tempat[i].id,
                a_location: obj.tempat[i].location,
                a_placeid: obj.tempat[i].place_id
              });
              marker.addListener('click', function() {
                setExitingStreet(this);
                topFunction();
              });
              jalanData.push(marker);
            }
          }
        };
        xhttp.open("GET", "get-place.php", true);
        xhttp.send();
      }

      function topFunction() {
        document.body.scrollTop = 0;
        document.documentElement.scrollTop = 0;
      }

      function initAutocomplete() {
        map = new google.maps.Map(document.getElementById('map'), {
          center: {lat: -33.8688, lng: 151.2195},
          zoom: 13,
          mapTypeId: 'roadmap'
        });
        // Defind default bounds to cianjur
        boundsCianjur = new google.maps.LatLngBounds();
        boundsCianjur.extend(new google.maps.LatLng(-6.602095,107.48484));
        boundsCianjur.extend(new google.maps.LatLng(-7.504663,106.776047));
        boundsCianjurKota = new google.maps.LatLngBounds();
        boundsCianjurKota.extend(new google.maps.LatLng(-6.803476,107.15325));
        boundsCianjurKota.extend(new google.maps.LatLng(-6.84117,107.122121));

        // Create the search box and link it to the UI element.
        var input = document.getElementById('pac-input');
        var searchBox = new google.maps.places.SearchBox(input, { bounds: boundsCianjurKota });
        //console.log(searchBox);
        map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

        // Bias the SearchBox results towards current map's viewport.
        //new google.maps.LatLng( -6.602095,107.48484, -7.504663,106.776047);
        map.fitBounds(boundsCianjurKota);
        map.addListener('bounds_changed', function() {
          searchBox.setBounds(boundsCianjurKota);
        });

        loadExitingPlace();

        // Listen for the event fired when the user selects a prediction and retrieve
        // more details for that place.
        searchBox.addListener('places_changed', function() {
          var places = searchBox.getPlaces();

          if (places.length == 0) {
            return;
          }

          // Clear out the old markers.
          //clearMap();


          // For each place, get the icon, name and location.
          var bounds = new google.maps.LatLngBounds();
          places.forEach(function(place) {
            if (!place.geometry) {
              console.log("Returned place contains no geometry");
              return;
            }

            for (j = 0; j < jalanData.length; ++j) {
              if (place.place_id === jalanData[j].a_placeid) {
                setExitingStreet(jalanData[j]);
                if (place.geometry.viewport) {
                  // Only geocodes have viewport.
                  bounds.union(place.geometry.viewport);
                } else {
                  bounds.extend(place.geometry.location);
                }
                return;
              }
            }

            var location = place.geometry.location;
            var streetName = place.name;;
            /*if (place.address_components) {
              for(var i=0;i<place.address_components.length;i++) {
                var comp = place.address_components[i];
                if (comp.types.length && comp.types[0] == 'route') {
                  streetName = "";
                  break;
                } else {
                  streetName = comp.long_name;
                  break;
                }
              } 
            } else {
              streetName = $("#pac-input").val();
            }*/
            if (streetName === ''){
              bounds = boundsCianjurKota;
              window.alert('Maap yang anda cari atau pilih adalah jalan');
              $("#pac-input").val('');
              return;
            }
            var icon = {
              url: place.icon,
              size: new google.maps.Size(71, 71),
              origin: new google.maps.Point(0, 0),
              anchor: new google.maps.Point(17, 34),
              scaledSize: new google.maps.Size(25, 25)
            };
                        
            // Create a marker for each place.
            markers.push(new google.maps.Marker({
              map: map,
              icon: icon,
              title: place.name,
              position: place.geometry.location
            }));



            if (place.geometry.viewport) {
              // Only geocodes have viewport/bounds.
              bounds.extend(place.geometry.viewport.getNorthEast());
              bounds.extend(place.geometry.viewport.getSouthWest());
              console.log("viewport");
            } else {
              bounds.extend(place.geometry.location);
              console.log("location");
            }
            // Place Result on input
            //$("#name").value(place.id);
            $("#nama").val(streetName);
            $("#location").val(place.geometry.location.lat() + "," + place.geometry.location.lng());
            $("#placeid").val(place.place_id);
            $("#aksi").val("tambah");

            rectangles.push(
              new google.maps.Rectangle({
                strokeColor: '#FF0000',
                strokeOpacity: 0.8,
                strokeWeight: 2,
                fillColor: '#FF0000',
                fillOpacity: 0,
                map: map,
                bounds: bounds
              })
            );
          });
          map.fitBounds(bounds);
        });
      }
    </script>
<?php
  require_once('layout/footer.php');
?>