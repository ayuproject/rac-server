<?php
  require_once('layout/header.php');
  require_once('layout/sidebar.php');
  require_once('config/database.php');

?>
        <div class="bs-docs-section">
            <div class="row">
            <div class="col-lg-4">
                    <div class="well bs-component">
                        <fieldset>
                            <legend>User</legend>
                            <input type="hidden" name="id" id="id-user" value="-1">
                            <input type="hidden" name="aksi" id="aksi" value="tambah">
                            <div class="form-group">
                                <label for="nama">Username</label>
                                <input class="form-control" required="required" name="nama" type="text" id="nama" value="<?=$_SESSION['login_level'] != 1 ? $_SESSION['login_user'] : "" ?>">
                                <small class="text-danger"></small>
                            </div>
                            <div class="form-group">
                                <label for="pass">Password</label>
                                <input class="form-control" required="required" name="pass" type="text" id="pass" value="<?=$_SESSION['login_level'] != 1 ? $_SESSION['login_pass'] : "" ?>">
                                <small class="text-danger"></small>
                            </div>
                        </fieldset>
                        <div class="btn-toolbar">
                            <button class="btn btn-success" id="btn-simpan">Simpan</button>
                            <button class="btn btn-primary pull-right" id="btn-batal">Batal</button>
                        </div>
                    </div>
                </div>
<?php
    if ($_SESSION['login_level'] == 1) {
?>
                <div class="col-lg-8">
                    <div class="well bs-component">
                        <div style="height:730px; overflow:auto;">
                            <div class="bs-component">
                                <table class="table table-striped table-hover" id="tb-angkot">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Nama</th>
                                            <th>Password</th>
                                            <th>Edit</th>
                                            <th>Hapus</th>
                                        </tr>
                                    </thead>
                                    <tbody>
<?php
    $stmt = $conn->prepare("
            SELECT
                id,
                user_name,
                password, 
                lv
            FROM
                tb_users;

        ");

    $stmt->execute();
    $result = $stmt->fetchAll();
    $num = 0;
    foreach ($result as $data) {
        ?>
                                        <tr class="btnDelete" data-id="<?=$data["id"]?>" >
                                            <td><?=++$num?></td>
                                            <td class="username"><?=$data["user_name"]?></td>
                                            <td class="password"><?=$data["password"]?></td>
                                            <td><button class='btn btn-primary btn-edit'>Edit</button></td>
                                            <td> <?=$data["lv"] != 1 ? "<button class='btn btn-danger btnDelete' href=''>delete</button>" : "" ?></td>
                                        </tr>
        
        <?php
    }                                    
?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- modal-->
                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h3 class="modal-title" id="myModalLabel">Warning!</h3>

                            </div>
                            <div class="modal-body">
                                <h4 id="myModalDesc"></h4>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" id="btnDelteYes" href="#">Yes</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- modal end-->
<?php
    }
?>
            </div>
        </div>
    </div>
    <script type="text/javascript">
<?php
    if ($_SESSION['login_level'] == 1) {
?>
    $('button.btnDelete').on('click', function (e) {
        e.preventDefault();
        var id = $(this).closest('tr').data('id');
        var nama = $(this).parent().parent().find(".username").html();
        $("#myModalDesc").html("Anda yakin ingin menghapus " + nama);
        $('#myModal').data('id', id).modal('show');
    });

    $('#btnDelteYes').click(function () {
        var id = $('#myModal').data('id');
        $.post("edit-user-action.php",
        {
            aksi: "hapus",
            id: id
        },
        function(data,status){
            alert("Pesan : " + data);
            location.reload();
        });
        /*$('[data-id=' + id + ']').remove();
        $('#myModal').modal('hide');*/
    });

    $('.btn-edit').click(function () {
        var id = $(this).closest('tr').data('id');
        var nama = $(this).parent().parent().find(".username").html();
        var pass = $(this).parent().parent().find(".password").html();
        $('#nama').val(id);
        $('#nama').val(nama);
        $('#pass').val(pass);
        $('#id-user').val(id);
        $('#aksi').val('edit');
    });
<?php
    }
?>
    $('#btn-simpan').click(function () {
        var id = $('#id-user').val();
        var nama = $('#nama').val();
        var pass = $('#pass').val();
        console.log(id);
        $.post("edit-user-action.php",
        {
            aksi: $('#aksi').val(),
            id: id,
            nama: nama,
            pass: pass
        },
        function(data,status){
            alert("Pesan : " + data);
            location.reload();
        });
    });

    $('#btn-batal').click(function () {
        $('#nama').val('');
        $('#pass').val('');
        $('#id-user').val('-1');
        $('#aksi').val('tambah');
    });
      
    </script>
<?php
  require_once('layout/footer.php');
?>