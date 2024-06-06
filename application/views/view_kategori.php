<div class="row">
  <div class="col-md-12">
    <div class="box box-danger">
      <div class="box-header with-border color-header">
        <h3 class="box-title"><i class="fa fa-th"></i> Data Kategori Barang</h3>
        <div class="box-tools pull-right">
          <a class="btn btn-default btn-sm" href="<?php echo base_url('Kategori'); ?>">
            <span class="fa fa-refresh"></span> Refresh</a>
          <button type="button" class="btn btn-sm btn-success" id="btnTambah">
            <span class="fa fa-plus"></span> Tambah</button>
        </div>
      </div>
      <div class="box-body">
        <div class="row">
          <div class="col-md-12">
            <table class="table table-bordered table-condensed" id="mydata">
              <thead>
                <tr>
                  <th style="width: 30px; text-align: center;">#No</th>
                  <th>Kategori Barang</th>
                  <th style="width: 120px; text-align:center;"></th>
                </tr>
              </thead>
              <tbody id="tbl_data"></tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="formModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title" id="formModal">Tambah Kategori Barang</h4>
      </div>
      <div class="modal-body">
        <form action="" method="get" id="form_add">
          <input type="hidden" name="id_kategori" id="id_kategori">
          <div class="form-group">
            <label for="nama_kategori">Nama Kategori</label>
            <input type="text" name="nama_kategori" id="nama_kategori" class="form-control" placeholder="Nama Kategori">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            <button type="button" class="btn btn-primary" id="btnSimpan" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Processing ">Simpan Data</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  $(document).ready(function() {
    let btnTambah = false;
    let bEdit = false;
    tampil_data();

    function tampil_data() {
      $.ajax({
        url: '<?php echo base_url(); ?>kategori/tampilkanData',
        type: 'post',
        dataType: 'json',
        success: function(response) {
          let i;
          let no = 1;
          let html = '';
          for (i = 0; i < response.length; i++) {
            html += '<tr>' +
              '<td>' + no + '</td>' +
              '<td>' + response[i].nama_kategori + '</td>' +
              '<td><center><span><button edit-id="' + response[i].id_kategori + '" class="btn btn-success btn-xs btnEdit"><i class="fa fa-edit"></i> Edit</button><button style="margin-left: 5px;" data-id="' + response[i].id_kategori + '" class="btn btn-danger btn-xs btn_hapus"><i class="fa fa-trash"></i> Hapus</button></span></center></td>' +
              '</tr>';
            no++;
          }
          $('#tbl_data').html(html);
          $('#mydata').dataTable();
        },
        error: function(xhr, ajaxOptions, thrownError) {
          console.log(xhr.status);
          console.log(thrownError);
        }
      });
    }

    // Event handler for the "Tambah" button
    $(document).on('click', '#btnTambah', function(e) {
      e.preventDefault();
      bEdit = false;
      $('#form_add')[0].reset();
      $('.form-group').removeClass('has-error');
      $('.help-block').empty();
      $('#formModal').modal('show');
      $('.modal-title').text('Tambah Data Kategori Barang');
    });

    // Event handler for the 'Edit' button
    $('#tbl_data').on('click', '.btnEdit', function() {
      let id_kategori = $(this).attr('edit-id');
      bEdit = true;
      $.ajax({
        url: '<?php echo base_url(); ?>kategori/tampilkanDataById',
        type: 'post',
        data: {
          id_kategori: id_kategori
        },
        dataType: 'json',
        success: function(response) {
          $('#form_add')[0].reset();
          $('.form-group').removeClass('has-error');
          $('.help-block').empty();
          $('.modal-title').text('Edit Data Kategori Barang');
          $('input[name="nama_kategori"]').val(response.nama_kategori);
          $('input[name="id_kategori"]').val(response.id_kategori);
          $('#formModal').modal('show');
        }
      });
    });

    // Event handler for the 'Tambah > Save' button
    $(document).on('click', "#btnSimpan", function(e) {
      e.preventDefault();
      let $this = $(this);
      let id_kategori = $('#id_kategori').val();
      let nama_kategori = $('#nama_kategori').val();
      let sUrl;

      // check if the button is Edit or Not
      if (bEdit) {
        sUrl = '<?php echo base_url(); ?>kategori/perbaruiData';
      } else {
        sUrl = '<?php echo base_url(); ?>kategori/tambahData';
      }

      $.ajax({
        url: sUrl,
        type: 'post',
        dataType: 'json',
        data: {
          id_kategori: id_kategori,
          nama_kategori: nama_kategori
        },
        beforeSend: function() {
          $this.button('loading');
        },
        complete: function() {
          $this.button('reset');
        },
        success: function(data) {
          if (data.responce === 'success') {
            $('#form_add')[0].reset();
            $('.form-group').removeClass('has-error');
            $('.help-block').empty();
            $('#formModal').modal('hide');
            Swal.fire({
              text: 'Data berhasil disimpan',
              icon: 'success',
              title: 'Saving Success',
              showConfirmButton: false,
              timer: 1500
            });
            $('#mydata').dataTable({
              "bDestroy": true
            }).fnDestroy();
            tampil_data();
          } else {
            Swal.fire('Error!!!', 'Ops! <br>' + data.message, 'error');
          }
        }
      });
    });

    // Event handler for the 'Hapus' button
    $('#tbl_data').on('click', '.btn_hapus', function(e) {
      e.preventDefault();
      let id_kategori = $(this).attr('data-id');
      Swal.fire({
        title: 'Apakah Anda yakin?',
        text: "Data yang dihapus tidak dapat dikembalikan!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Tidak',
        confirmButtonText: 'Ya, hapus!',
        showLoaderOnConfirm: true,
        preConfirm: () => {
          return new Promise(function(resolve, reject) {
            $.ajax({
                url: '<?php echo base_url(); ?>kategori/hapusData',
                type: 'post',
                typeData: 'json',
                data: {
                  id_kategori: id_kategori
                }
              })
              .done(function(data) {
                resolve(data);
              })
              .fail(function() {
                reject();
              });
          });
        },
        allowOutsideClick: () => !Swal.isLoading()
      }).then((result) => {
        if (result.value) {
          $('#mydata').dataTable({
            'bDestroy': true
          }).fnDestroy();
          tampil_data();
          Swal.fire({
            icon: 'success',
            title: 'Data berhasil dihapus',
            showConfirmButton: false,
            timer: 1500
          });
        }
      });
    });
  });
</script>