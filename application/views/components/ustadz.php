<!-- Page Content  -->
<div id="content-page" class="content-page">
   <div class="container-fluid">
      <div class="row">
         <div class="col-sm-12">
            <div class="iq-card">
               <div class="iq-card-header d-flex justify-content-between">
                  <div class="iq-header-title">
                     <h4 class="card-title">Daftar Ustadz</h4>
                  </div>
                  <div class="iq-card-header-toolbar d-flex align-items-center">
                     <button class="float-right btn btn-sm btn-primary" id="btn-tambah" data-toggle="modal" data-target="#modal-add-ustadz">Tambah</button>
                  </div>
               </div>
               <div class="iq-card-body">
                  <div class="table-responsive">
                     <table id="table-ustadz" class="table table-striped mt-4" role="grid" aria-describedby="user-list-page-info">
                        <thead>
                           <tr>
                              <th>Profile</th>
                              <th>Tag ID</th>
                              <th>Name</th>
                              <th>NIK</th>
                              <th>Email</th>
                              <th>Phone</th>
                              <th>Tempat, Tgl Lahir</th>
                              <th>Jenis Kelamin</th>
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

<div class="modal fade" id="modal-add-ustadz" tabindex="-1" role="dialog" aria-labelledby="modal-add" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content">
         <div class="modal-header bg-primary">
            <h5 class="modal-title text-white">Modal Tambah</h5>
            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">

            <form id="form-add-ustadz" method="POST" enctype="multipart/form-data">
               <div class="row">

                  <div class="col-md-6">
                     <div class="form-group">
                        <label for="">Images</label>
                        <div class="custom-file">
                           <input type="file" class="custom-file-input" name="images">
                           <label class="custom-file-label">Choose file</label>
                        </div>
                     </div>
                  </div>

                  <div class="col-md-6">
                     <div class="form-group">
                        <label for="">Nama</label>
                        <input type="text" name="name" class="form-control">
                     </div>
                  </div>

                  <div class="col-md-6">
                     <div class="form-group">
                        <label for="">Email</label>
                        <input type="email" name="email" class="form-control">
                     </div>
                  </div>

                  <div class="col-md-6">
                     <div class="form-group">
                        <label for="">NIK</label>
                        <input type="text" name="nik" class="form-control nik-mask">
                     </div>
                  </div>

                  <div class="col-md-6">
                     <div class="form-group">
                        <label for="">Phone</label>
                        <input type="text" name="phone" class="form-control phone-mask">
                     </div>
                  </div>

                  <div class="col-md-6">
                     <div class="form-group">
                        <label for="">NIP</label>
                        <input type="text" name="nip" class="form-control">
                     </div>
                  </div>

                  <div class="col-md-6">
                     <div class="form-group">
                        <label for="jenis_kelamin">Jenis Kelamin</label>
                        <select name="jenis_kelamin" class="form-control">
                           <option value="L">Laki-laki</option>
                           <option value="P">Perempuan</option>
                        </select>
                     </div>
                  </div>

                  <div class="col-md-6">
                     <div class="form-group">
                        <label for="">Tempat Lahir</label>
                        <input type="text" class="form-control" name="tempat_lahir">
                     </div>
                  </div>

                  <div class="col-md-6">
                     <div class="form-group">
                        <label for="">Tanggal Lahir</label>
                        <input type="date" class="form-control" name="tanggal_lahir">
                     </div>
                  </div>

               </div>
            </form>

         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" form="form-add-ustadz">Save</button>
         </div>
      </div>
   </div>
</div>

<div class="modal fade" id="modal-update-ustadz" tabindex="-1" role="dialog" aria-labelledby="modal-update" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content">
         <div class="modal-header bg-warning">
            <h5 class="modal-title text-white">Modal Update</h5>
            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">

            <form id="form-update-ustadz" method="POST" enctype="multipart/form-data">
               <div class="row">
                  <input type="hidden" name="id">

                  <div class="col-md-6">
                     <div class="form-group">
                        <label for="">Images</label>
                        <div class="custom-file">
                           <input type="file" class="custom-file-input" name="images">
                           <label class="custom-file-label">Choose file</label>
                        </div>
                     </div>
                  </div>

                  <div class="col-md-6">
                     <div class="form-group">
                        <label for="">Nama</label>
                        <input type="text" name="name" class="form-control">
                     </div>
                  </div>

                  <div class="col-md-6">
                     <div class="form-group">
                        <label for="">Email</label>
                        <input type="email" name="email" class="form-control">
                     </div>
                  </div>

                  <div class="col-md-6">
                     <div class="form-group">
                        <label for="">NIK</label>
                        <input type="text" name="nik" class="form-control nik-mask">
                     </div>
                  </div>

                  <div class="col-md-6">
                     <div class="form-group">
                        <label for="">Phone</label>
                        <input type="text" name="phone" class="form-control phone-mask">
                     </div>
                  </div>

                  <div class="col-md-6">
                     <div class="form-group">
                        <label for="">NIP</label>
                        <input type="text" name="nip" class="form-control">
                     </div>
                  </div>

                  <div class="col-md-6">
                     <div class="form-group">
                        <label for="jenis_kelamin">Jenis Kelamin</label>
                        <select name="jenis_kelamin" class="form-control">
                           <option value="L">Laki-laki</option>
                           <option value="P">Perempuan</option>
                        </select>
                     </div>
                  </div>

                  <div class="col-md-6">
                     <div class="form-group">
                        <label for="">Tempat Lahir</label>
                        <input type="text" class="form-control" name="tempat_lahir">
                     </div>
                  </div>

                  <div class="col-md-6">
                     <div class="form-group">
                        <label for="">Tanggal Lahir</label>
                        <input type="date" class="form-control" name="tanggal_lahir">
                     </div>
                  </div>
               </div>
            </form>

         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-warning" form="form-update-ustadz">Save</button>
         </div>
      </div>
   </div>
</div>

<div class="modal fade" id="modal-delete-ustadz" tabindex="-1" role="dialog" aria-labelledby="modal-delete" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
      <div class="modal-content">
         <div class="modal-header bg-danger">
            <h5 class="modal-title text-white">Modal Delete</h5>
            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">

            <form id="form-delete-ustadz" method="POST">
               <input type="hidden" name="id">
            </form>

            <p>Apakah anda yakin ingin menghapus data ini ?</p>

         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-danger" form="form-delete-ustadz">Hapus</button>
         </div>
      </div>
   </div>
</div>

<div class="modal fade" id="modal-ustadz-ustadz" tabindex="-1" role="dialog" aria-labelledby="modal-update" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content">
         <div class="modal-header bg-warning">
            <h5 class="modal-title text-white">Modal Update</h5>
            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">

            <form id="form-ustadz-ustadz" method="POST">
               <div class="row">
                  <input type="hidden" name="id">
                  <div class="col-md-6">
                     <div class="form-group">
                        <label for="">Ayah</label>
                        <input type="text" name="ayah" class="form-control">
                     </div>
                  </div>

                  <div class="col-md-6">
                     <div class="form-group">
                        <label for="">Email</label>
                        <input type="email" name="email_ayah" class="form-control">
                     </div>
                  </div>

                  <div class="col-md-6">
                     <div class="form-group">
                        <label for="">Ibu</label>
                        <input type="text" name="ibu" class="form-control">
                     </div>
                  </div>

                  <div class="col-md-6">
                     <div class="form-group">
                        <label for="">Ibu</label>
                        <input type="text" name="email_ibu" class="form-control">
                     </div>
                  </div>
               </div>
            </form>

         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-warning" form="form-ustadz-ustadz">Save</button>
         </div>
      </div>
   </div>
</div>

<div class="modal fade" id="modal-add-tag" tabindex="-1" role="dialog" aria-labelledby="modal-update" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
      <div class="modal-content">
         <div class="modal-header bg-warning">
            <h5 class="modal-title text-white">Modal Add Tag</h5>
            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">

            <form id="form-add-tag" method="POST">
               <input type="hidden" name="id">

               <div class="form-group">
                  <label for="input-tag">Tag ID</label>
                  <input type="text" class="form-control" readonly name="tag_id">

                  <small class="text-muted">* Silahkan tempelkan kartu RFID yang baru, form akan terisi otomatis !</small>
               </div>
            </form>
         </div>
      </div>
   </div>
</div>