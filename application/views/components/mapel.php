<!-- Page Content  -->
<div id="content-page" class="content-page">
   <div class="container-fluid">
      <div class="row">
         <div class="col-sm-12">
            <div class="iq-card">
               <div class="iq-card-header d-flex justify-content-between">
                  <div class="iq-header-title">
                     <h4 class="card-title">Daftar Mapel</h4>
                  </div>
                  <div class="iq-card-header-toolbar d-flex align-items-center">
                     <button class="float-right btn btn-sm btn-primary" id="btn-tambah" data-toggle="modal" data-target="#modal-add-mapel">Tambah</button>
                  </div>
               </div>
               <div class="iq-card-body">
                  <div class="table-responsive">
                     <table id="table-mapel" class="table table-striped mt-4" role="grid" aria-describedby="user-list-page-info">
                        <thead>
                           <tr>
                              <th>Nama Mapel</th>
                              <th>Tingkat</th>
                              <th>Nilai KKM</th>
                              <th>Created At</th>
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


<div class="modal fade" id="modal-add-mapel" tabindex="-1" role="dialog" aria-labelledby="modal-add" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content">
         <div class="modal-header bg-primary">
            <h5 class="modal-title text-white">Modal Tambah</h5>
            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">

            <form id="form-add-mapel" method="POST">
               <div class="row">

                  <div class="col-md-6">
                     <div class="form-group">
                        <label for="">Nama Mata Pelajaran</label>
                        <input type="text" name="nama_mapel" class="form-control">
                     </div>
                  </div>

                  <div class="col-md-6">
                     <div class="form-group">
                        <label for="">Tingkat</label>
                        <input type="number" name="tingkat" class="form-control" min="1">
                     </div>
                  </div>

                  <div class="col-md-6">
                     <div class="form-group">
                        <label for="">Nilai KKM</label>
                        <input type="number" name="nilai_kkm" class="form-control" min="1">
                     </div>
                  </div>

               </div>
            </form>

         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" form="form-add-mapel">Save</button>
         </div>
      </div>
   </div>
</div>

<div class="modal fade" id="modal-update-mapel" tabindex="-1" role="dialog" aria-labelledby="modal-update" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content">
         <div class="modal-header bg-warning">
            <h5 class="modal-title text-white">Modal Update</h5>
            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">

            <form id="form-update-mapel" method="POST">
               <div class="row">
                  <input type="hidden" name="id">
                  <div class="col-md-6">
                     <div class="form-group">
                        <label for="">Nama Mata Pelajaran</label>
                        <input type="text" name="nama_mapel" class="form-control">
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
                        <label for="">Nilai KKM</label>
                        <input type="number" name="nilai_kkm" class="form-control">
                     </div>
                  </div>

               </div>
            </form>

         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-warning" form="form-update-mapel">Save</button>
         </div>
      </div>
   </div>
</div>

<div class="modal fade" id="modal-delete-mapel" tabindex="-1" role="dialog" aria-labelledby="modal-delete" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
      <div class="modal-content">
         <div class="modal-header bg-danger">
            <h5 class="modal-title text-white">Modal Delete</h5>
            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">

            <form id="form-delete-mapel" method="POST">
               <input type="hidden" name="id">
            </form>

            <p>Apakah anda yakin ingin menghapus data ini ?</p>

         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-danger" form="form-delete-mapel">Hapus</button>
         </div>
      </div>
   </div>
</div>