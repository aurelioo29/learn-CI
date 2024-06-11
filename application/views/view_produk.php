<div class="row">
  <div class="col-md-12">
    <div class="box box-danger">
      <div class="box-header with-border color-header">
        <h3 class="box-title"><i class="fa fa-th"></i> Data Produk Barang</h3>
        <div class="box-tools pull-right">
          <a class="btn btn-default btn-sm" href="<?php echo base_url('Produk'); ?>">
            <span class="fa fa-refresh"></span> Refresh</a>
          <button type="button" class="btn btn-sm btn-success btnTambah" id="btnTambah">
            <span class="fa fa-plus"></span> Tambah</button>
        </div>
      </div>
      <div class="box-body">
        <div class="row">
          <div class="col-md-12">
            <table class="table table-striped" id="mydata">
              <thead>
                <tr>
                  <th style="width: 30px;text-align:center;">#No</th>
                  <th>Nama Barang</th>
                  <th>Kategori</th>
                  <th>Satuan</th>
                  <th style="width: 90px;text-align:right;">Harga Beli</th>
                  <th style="width: 80px;text-align:right;">Harga Pokok</th>
                  <th style="width: 80px;text-align:right;">Harga Jual</th>
                  <th style="width: 120px;text-align:center;">Action</th>
                </tr>
              </thead>
              <tbody id="tbl_data">
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="formModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><i class="fa fa-plus"></i>Data Supplier Barang</h4>
      </div>
      <form action="" method="post" id="form_add">
        <div class="modal-body">
          <input type="hidden" name="id_produk" id="id_produk">
          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label for="">Kategori <span class="text-danger">*</span></label>
                <select name="id_kategori" id="id_kategori" class="form-control">
                  <option value="">- Pilih Kategori -</option>
                  <?php if (!empty($kategori)) {
                    foreach ($kategori as $row) {
                      echo "<option value='{$row->id_kategori}'>{$row->nama_kategori}</option>";
                    }
                  } else {
                    echo "<option value=''>Kategori tidak tersedia</option>";
                  } ?>
                </select>
              </div>
              <div class="col-md-15">
                <div class="form-group">
                  <label for="">Nama Barang <span class="text-danger">*</span></label>
                  <input type="text" name="nama_produk" id="nama_produk" autocomplete="off" class="form-control input-sm" placeholder="Nama Barang">
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="">Satuan <span class="text-danger">*</span></label>
                <select name="id_satuan" id="id_satuan" class="form-control">
                  <option value="">- Pilih Satuan - </option>
                  <?php
                  if (!empty($satuan)) {
                    foreach ($satuan as $row) {
                      echo "<option value='{$row->id_satuan}'>{$row->nama_satuan}</option>";
                    }
                  } else {
                    echo "<option value=''>Satuan tidak tersedia</option>";
                  }
                  ?>
                </select>
                <span class="help-block"></span>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="">Barcode <span class="text-danger">*</span></label>
                <input type="text" name="barcode" id="barcode" autocomplete="off" class="form-control input-sm" placeholder="Nomor Kontak">
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label for="harga_beli">Harga Beli <span class="text-danger">*</span></label>
                <input type="text" name="harga_beli" id="" autocomplete="off" class="harga_beli form-control input-sm" onkeypress="return isNumber(this, event);" placeholder="Harga Beli">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="harga_pokok">Harga Pokok <span class="text-danger">*</span></label>
                <input type="text" name="harga_pokok" id="" autocomplete="off" class="harga_pokok form-control input-sm" onkeypress="return isNumber(this, event);" placeholder="Harga Pokok">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="harga_jual">Harga Jual <span class="text-danger">*</span></label>
                <input type="text" name="harga_jual" id="=" autocomplete="off" class="harga_jual form-control input-sm" onkeypress="return isNumber(this, event);" placeholder="Harga Jual">
              </div>
            </div>
          </div>
        </div>
      </form>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
        <button type="button" class="btn btn-primary" id="btnSimpan" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Processing ">Simpan Data</button>
      </div>
    </div>
  </div>
</div>

<script src="<?php echo base_url() . 'assets/js/validate.js' ?>"></script>
<script type="text/javascript">
  $(document).ready(function() {
    let btnEdit = false;
    tampil_data();

    function tampil_data() {
      $.ajax({
        url: '<?php echo base_url(); ?>Produk/tampilkanData',
        type: 'post',
        dataType: 'json',
        success: function(response) {
          let no = 1;
          let html = '';
          for (let i = 0; i < response.length; i++) {
            html += '<tr>' +
              '<td>' + no + '</td>' +
              '<td>' + response[i].nama_produk + '</td>' +
              '<td>' + response[i].nama_kategori + '</td>' +
              '<td>' + response[i].nama_satuan + '</td>' +
              '<td style="text-align:right;">' + Intl.NumberFormat('id-ID').format(response[i].harga_beli) + '</td>' +
              '<td style="text-align:right;">' + Intl.NumberFormat('id-ID').format(response[i].harga_pokok) + '</td>' +
              '<td style="text-align:right;">' + Intl.NumberFormat('id-ID').format(response[i].harga_jual) + '</td>' +
              '<td><center>' + '<span><button edit-id="' + response[i].id_produk +
              '" class="btn btn-success btn-xs btnEdit"><i class="fa fa-edit"></i> Edit</button><button style="margin-left: 5px;" data-id="' + response[i].id_produk + '" class="btn btn-danger btn-xs btn_hapus"><i class="fa fa-trash"></i> Hapus</button></span></center></td>' +
              '</tr>';
            no++;
          }
          $('#tbl_data').html(html);
          $('#mydata').DataTable();
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
      $('.modal-title').text('Tambah Data Barang');
    });

    // Event handler for the 'Edit' button
    $('#tbl_data').on('click', '.btnEdit', function() {
      let id_produk = $(this).attr('edit-id');
      bEdit = true;
      $.ajax({
        url: '<?php echo base_url(); ?>produk/tampilkanDataById',
        type: 'post',
        data: {
          id_produk: id_produk
        },
        dataType: 'json',
        success: function(response) {
          $('#form_add')[0].reset();
          $('.form-group').removeClass('has-error');
          $('.help-block').empty();
          $('.modal-title').text('Edit Data Barang');
          $('input[name="nama_produk"]').val(response.nama_kategori);
          $('input[name="id_produk"]').val(response.id_produk);
          $('input[name="id_kategori"]').val(response.id_kategori);
          $('input[name="id_satuan"]').val(response.id_satuan);
          $('input[name="barcode"]').val(response.barcode);
          $('input[name="harga_beli"]').val(parseFloat(response.harga_beli).toFixed(0));
          $('input[name="harga_pokok"]').val(parseFloat(response.harga_pokok).toFixed(0));
          $('input[name="harga_jual"]').val(parseFloat(response.harga_jual).toFixed(0));
          $('#formModal').modal('show');
        }
      });
    });

    // Event handler for the 'Tambah > Save' button
    $(document).on('click', "#btnSimpan", function(e) {
      e.preventDefault();
      let $this = $(this);
      let id_produk = $('#id_produk').val();
      let nama_kategori = $('#nama_kategori').val();
      let barcode = $('#barcode').val();
      let id_kategori = $('select[name="id_kategori"]').val();
      let id_satuan = $('select[name="id_satuan"]').val();
      let harga_jual = $('input[name="harga_jual"]').val().replace(/\./g, '');
      let harga_beli = $('input[name="harga_beli"]').val().replace(/\./g, '');
      let harga_pokok = $('input[name="harga_pokok"]').val().replace(/\./g, '');
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
          id_produk: id_produk,
          nama_kategori: nama_kategori,
          barcode: barcode,
          id_kategori: id_kategori,
          id_satuan: id_satuan,
          harga_jual: harga_jual,
          harga_beli: harga_beli,
          harga_pokok: harga_pokok
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
      let id_produk = $(this).attr('data-id');
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
                  id_produk: id_produk
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
  })
</script>