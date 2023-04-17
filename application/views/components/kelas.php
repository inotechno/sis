<!-- Page Content  -->
<div id="content-page" class="content-page">
   <div class="container-fluid">
      <div class="row">
         <div class="col-sm-12">
            <div class="iq-card">
               <div class="iq-card-header d-flex justify-content-between">
                  <div class="iq-header-title">
                     <h4 class="card-title">Daftar Kelas</h4>
                  </div>
                  <div class="iq-card-header-toolbar d-flex align-items-center">
                     <button class="float-right btn btn-sm btn-primary" id="btn-tambah" data-toggle="modal" data-target="#modal-add-kelas">Tambah</button>
                  </div>
               </div>
               <div class="iq-card-body">
                  <div class="table-responsive">
                     <table id="table-kelas" class="table table-striped mt-4" role="grid" aria-describedby="user-list-page-info">
                        <thead>
                           <tr>
                              <th>Nama Kelas</th>
                              <th>Tingkat</th>
                              <th>Tahun Ajaran</th>
                              <th>Wali Kelas</th>
                              <th>Action</th>
                           </tr>
                        </thead>
                        <tbody>

                        </tbody>
                     </table>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>


<div class="modal fade" id="modal-add-kelas" tabindex="-1" role="dialog" aria-labelledby="modal-add" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content">
         <div class="modal-header bg-primary">
            <h5 class="modal-title text-white">Modal Tambah</h5>
            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">

            <form id="form-add-kelas" method="POST">
               <div class="row">

                  <div class="col-md-6">
                     <div class="form-group">
                        <label for="">Nama Kelas</label>
                        <input type="text" name="nama_kelas" class="form-control">
                     </div>
                  </div>

                  <div class="col-md-6">
                     <div class="form-group">
                        <label for="">Tingkat</label>
                        <input type="number" name="tingkat" class="form-control">
                     </div>
                  </div>

                  <div class="col-md-6">
                     <div class="form-group">
                        <label for="tahun_ajaran_id">Tahun Ajaran</label>
                        <select name="tahun_ajaran_id" class="form-control select2 select-tahun-ajaran" style="width: 100%;">
                        </select>
                     </div>
                  </div>

                  <div class="col-md-6">
                     <div class="form-group">
                        <label for="wali_kelas_id">Wali Kelas</label>
                        <select name="wali_kelas_id" class="form-control select-wali-kelas select2" style="width: 100%;">
                        </select>
                     </div>
                  </div>
               </div>
            </form>

         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" form="form-add-kelas">Save</button>
         </div>
      </div>
   </div>
</div>

<div class="modal fade" id="modal-update-kelas" tabindex="-1" role="dialog" aria-labelledby="modal-update" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content">
         <div class="modal-header bg-warning">
            <h5 class="modal-title text-white">Modal Update</h5>
            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">

            <form id="form-update-kelas" method="POST">
               <div class="row">
                  <input type="hidden" name="id">
                  <div class="col-md-6">
                     <div class="form-group">
                        <label for="">Nama Kelas</label>
                        <input type="text" name="nama_kelas" class="form-control">
                     </div>
                  </div>

                  <div class="col-md-6">
                     <div class="form-group">
                        <label for="">Tingkat</label>
                        <input type="number" name="tingkat" class="form-control">
                     </div>
                  </div>

                  <div class="col-md-6">
                     <div class="form-group">
                        <label for="tahun_ajaran_id">Tahun Ajaran</label>
                        <select name="tahun_ajaran_id" class="form-control select2 select-tahun-ajaran" style="width: 100%;">
                        </select>
                     </div>
                  </div>

                  <div class="col-md-6">
                     <div class="form-group">
                        <label for="wali_kelas_id">Wali Kelas</label>
                        <select name="wali_kelas_id" class="form-control select-wali-kelas select2" style="width: 100%;">
                        </select>
                     </div>
                  </div>
               </div>
            </form>

         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-warning" form="form-update-kelas">Save</button>
         </div>
      </div>
   </div>
</div>

<div class="modal fade" id="modal-delete-kelas" tabindex="-1" role="dialog" aria-labelledby="modal-delete" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
      <div class="modal-content">
         <div class="modal-header bg-danger">
            <h5 class="modal-title text-white">Modal Delete</h5>
            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">

            <form id="form-delete-kelas" method="POST">
               <input type="hidden" name="id">
            </form>

            <p>Apakah anda yakin ingin menghapus data ini ?</p>

         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-danger" form="form-delete-kelas">Hapus</button>
         </div>
      </div>
   </div>
</div>