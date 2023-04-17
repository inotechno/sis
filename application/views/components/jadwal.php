<!-- Page Content  -->
<div id="content-page" class="content-page">
   <div class="container-fluid">
      <div class="row">
         <div class="col-sm-12">
            <div class="iq-card">
               <div class="iq-card-header d-flex justify-content-between">
                  <div class="iq-header-title">
                     <h4 class="card-title">Daftar Jadwal</h4>
                  </div>
                  <div class="iq-card-header-toolbar d-flex align-items-center">
                     <button class="float-right btn btn-sm btn-primary" id="btn-tambah" data-toggle="modal" data-target="#modal-add-jadwal">Tambah</button>
                  </div>
               </div>
               <div class="iq-card-body">
                  <div class="table-responsive">
                     <table id="table-jadwal" class="table table-striped mt-4" role="grid" aria-describedby="user-list-page-info">
                        <thead>
                           <tr>
                              <th>Kelas</th>
                              <th>Mapel</th>
                              <th>Pengajar</th>
                              <th>Hari, Waktu Mulai</th>
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


<div class="modal fade" id="modal-add-jadwal" tabindex="-1" role="dialog" aria-labelledby="modal-add" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content">
         <div class="modal-header bg-primary">
            <h5 class="modal-title text-white">Modal Tambah</h5>
            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">

            <form id="form-add-jadwal" method="POST">
               <div class="row">

                  <div class="col-md-6">
                     <div class="form-group">
                        <label for="mapel_id">Mata Pelajaran</label>
                        <select name="mapel_id" class="form-control select2 select-mapel" style="width: 100%;">
                        </select>
                     </div>
                  </div>

                  <div class="col-md-6">
                     <div class="form-group">
                        <label for="ustadz_id">Ustadz</label>
                        <select name="ustadz_id" class="form-control select-ustadz select2" style="width: 100%;">
                        </select>
                     </div>
                  </div>

                  <div class="col-md-6">
                     <div class="form-group">
                        <label for="kelas_id">Kelas</label>
                        <select name="kelas_id" class="form-control select2 select-kelas" style="width: 100%;">
                        </select>
                     </div>
                  </div>

                  <div class="col-md-6">
                     <div class="form-group">
                        <label for="hari">Hari</label>
                        <select name="hari" class="form-control select-hari select2" style="width: 100%;">
                           <option value="senin">Senin</option>
                           <option value="selasa">Selasa</option>
                           <option value="rabu">Rabu</option>
                           <option value="kamis">Kamis</option>
                           <option value="jumat">Jumat</option>
                           <option value="sabtu">Sabtu</option>
                           <option value="minggu">Minggu</option>
                        </select>
                     </div>
                  </div>

                  <div class="col-md">
                     <div class="form-group">
                        <label for="waktu_mulai">Waktu Mulai</label>
                        <input type="time" id="waktu_mulai" name="waktu_mulai" class="form-control">
                     </div>
                  </div>
               </div>
            </form>

         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" form="form-add-jadwal">Save</button>
         </div>
      </div>
   </div>
</div>

<div class="modal fade" id="modal-update-jadwal" tabindex="-1" role="dialog" aria-labelledby="modal-update" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content">
         <div class="modal-header bg-warning">
            <h5 class="modal-title text-white">Modal Update</h5>
            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">

            <form id="form-update-jadwal" method="POST">
               <div class="row">
                  <input type="hidden" name="id">
                  <div class="col-md-6">
                     <div class="form-group">
                        <label for="mapel_id">Mata Pelajaran</label>
                        <select name="mapel_id" class="form-control select2 select-mapel" style="width: 100%;">
                        </select>
                     </div>
                  </div>

                  <div class="col-md-6">
                     <div class="form-group">
                        <label for="ustadz_id">Ustadz</label>
                        <select name="ustadz_id" class="form-control select-ustadz select2" style="width: 100%;">
                        </select>
                     </div>
                  </div>

                  <div class="col-md-6">
                     <div class="form-group">
                        <label for="kelas_id">Kelas</label>
                        <select name="kelas_id" class="form-control select2 select-kelas" style="width: 100%;">
                        </select>
                     </div>
                  </div>

                  <div class="col-md-6">
                     <div class="form-group">
                        <label for="hari">Hari</label>
                        <select name="hari" class="form-control select-hari select2" style="width: 100%;">
                           <option value="senin">Senin</option>
                           <option value="selasa">Selasa</option>
                           <option value="rabu">Rabu</option>
                           <option value="kamis">Kamis</option>
                           <option value="jumat">Jumat</option>
                           <option value="sabtu">Sabtu</option>
                           <option value="minggu">Minggu</option>
                        </select>
                     </div>
                  </div>

                  <div class="col-md">
                     <div class="form-group">
                        <label for="waktu_mulai">Waktu Mulai</label>
                        <input type="time" id="waktu_mulai" name="waktu_mulai" class="form-control">
                     </div>
                  </div>
               </div>
            </form>

         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-warning" form="form-update-jadwal">Save</button>
         </div>
      </div>
   </div>
</div>

<div class="modal fade" id="modal-delete-jadwal" tabindex="-1" role="dialog" aria-labelledby="modal-delete" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
      <div class="modal-content">
         <div class="modal-header bg-danger">
            <h5 class="modal-title text-white">Modal Delete</h5>
            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">

            <form id="form-delete-jadwal" method="POST">
               <input type="hidden" name="id">
            </form>

            <p>Apakah anda yakin ingin menghapus data ini ?</p>

         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-danger" form="form-delete-jadwal">Hapus</button>
         </div>
      </div>
   </div>
</div>