<?php
  require_once('layout/header.php');
  require_once('layout/sidebar.php');
?>
      <div class="bs-docs-section">
        <div class="row">
          <div class="col-lg-12">
            <div class="page-header">
              <h1 id="forms">Forms</h1>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-12">
            <div class="col-md-7">
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
            <div class="col-md-5">
              <!-- tab -->
              <div class="bs-component">
                <ul class="nav nav-tabs">
                  <li class="active"><a href="#inputapp" data-toggle="tab">Input Data Aplikasi</a></li>
                  <li><a href="#tabImg" data-toggle="tab">Input Gambar Aplikasi</a></li>
                </ul>
                <input type="hidden" name="mode-form" value="create">
                <div id="myTabContent" class="tab-content">
                  <div class="tab-pane fade active in" id="inputapp">
                    <div class="well bs-component">
                      <fieldset>
                          <div class="row">
                            <div class="col-lg-12">
                              <div class="form-group">
                                <label for="latlng">Lokasi</label>
                                <input class="form-control" required="required" name="latlng" type="text" id="latlng">
                                <small class="text-danger"></small>
                              </div>
                              <div class="clearfix"></div>
                              <button class="btn btn-primary btn-block" id="btn-add">Tambahkan</button>
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
                                      
                                    </tbody>
                                  </table>
                                </div>
                              </div>
                            </div>
                          </div>
                        <div class="clearfix"></div>
                      </fieldset>
                    </div>
                  </div>
                  <div class="tab-pane fade" id="tabImg">
                    <div class="well bs-component">
                      <fieldset>
                        <div class="col-md-5">
                          <div class="form-group">
                            <label for="nama">Nama Aplikasi</label>
                            <input class="form-control" required="required" name="nama" type="text" id="nama">
                            <small class="text-danger"></small>
                          </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-md-5">
                          <div class="form-group">
                            <label for="deskripsi">Deskripsi</label>
                            <textarea class="form-control" rows="3" name="deskripsi" id="deskripsi"></textarea>
                          </div>
                        </div>
                      </fieldset>
                    </div>
                  </div>
                  <button class="btn btn-success pull-right">Simpan</button>
              </div>
            </div>
            <!-- end tab -->
          </div>
      </div>
      </div>
      <script type="text/javascript">
        var tb_count = 0;
        $(document).on("click", ".btn-rm", function(e){
          console.log("remove");
        });

        $(document).on("click", "#btn-add", function(e){
          e.preventDefault();
          console.log("click");
          tb_count++;
          $('#tb-lokasi > tbody:last-child').append("<tr> <td>" + tb_count + "</td> <td>lokasi</td><td><button class='btn btn-danger btn-rm' name='btn-rm'>-</button></td></tr>");
        });

        function initAutocomplete() {
          map = new google.maps.Map(document.getElementById('map'), {
            center: {lat: -33.8688, lng: 151.2195},
            zoom: 13,
            mapTypeId: 'roadmap'
          });

          boundsCianjurKota = new google.maps.LatLngBounds();
          boundsCianjurKota.extend(new google.maps.LatLng(-6.803476,107.15325));
          boundsCianjurKota.extend(new google.maps.LatLng(-6.84117,107.122121));

          var input = document.getElementById('pac-input');
          var searchBox = new google.maps.places.SearchBox(input, { bounds: boundsCianjurKota });
          
          map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
          map.addListener('bounds_changed', function() {
            searchBox.setBounds(boundsCianjurKota);
          });
          map.fitBounds(boundsCianjurKota);
        }
      </script>
      
<?php
  require_once('layout/footer.php');
?>