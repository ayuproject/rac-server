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
            <!-- tab -->
            <div class="bs-component">
              <ul class="nav nav-tabs">
                <li class="active"><a href="#inputapp" data-toggle="tab">Input Data Aplikasi</a></li>
                <li><a href="#inputappf" data-toggle="tab">Input Gambar Aplikasi</a></li>
              </ul>
              <div id="myTabContent" class="tab-content">
                <div class="tab-pane fade active in" id="inputapp">
                  <div class="well bs-component">
                    <form class="form-horizontal">
                      <fieldset>
                        <legend>Legend</legend>
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
                            <label for="textArea">Deskripsi</label>
                            <textarea class="form-control" rows="3" id="textArea"></textarea>
                          </div>
                        </div>
                      </fieldset>
                    </form>
                  </div>
                </div>
                <div class="tab-pane fade" id="inputappf">
                  <p>Food truck fixie locavore, accusamus mcsweeney's marfa nulla single-origin coffee squid. Exercitation +1 labore velit, blog sartorial PBR leggings next level wes anderson artisan four loko farm-to-table craft beer twee. Qui photo booth letterpress, commodo enim craft beer mlkshk aliquip jean shorts ullamco ad vinyl cillum PBR. Homo nostrud organic, assumenda labore aesthetic magna delectus mollit.</p>
                </div>
              </div>
            </div>
            <!-- end tab -->
          </div>
        </div>
      </div>
<?php
  require_once('layout/footer.php');
?>