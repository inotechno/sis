<!-- Page Content  -->
<div id="content-page" class="content-page">
   <div class="container-fluid">
      <div class="row">
         <div class="col-sm-12">
            <div class="iq-card">
               <div class="iq-card-header d-flex justify-content-between">
                  <div class="iq-header-title">
                     <h4 class="card-title">Daftar Maklumat</h4>
                  </div>
                  <div class="iq-card-header-toolbar d-flex align-items-center">
                     <button class="float-right btn btn-sm btn-primary" id="btn-tambah" data-toggle="modal" data-target="#modal-add-maklumat">Tambah</button>
                  </div>
               </div>
               <div class="iq-card-body">
                  <div class="table-responsive">
                     <table id="table-maklumat" class="table table-striped mt-4" role="grid" aria-describedby="user-list-page-info">
                        <thead>
                           <tr>
                              <th>No</th>
                              <th>Title</th>
                              <th>Content</th>
                              <th>Category</th>
                              <th>Target</th>
                              <th>Author</th>
                              <th>Status</th>
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


<div class="modal fade" id="modal-add-maklumat" tabindex="-1" role="dialog" aria-labelledby="modal-add" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
      <div class="modal-content">
         <div class="modal-header bg-primary">
            <h5 class="modal-title text-white">Modal Tambah</h5>
            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">

            <form id="form-add-maklumat" method="POST" enctype="multipart/form-data">
               <div class="row">

                  <div class="col-md-6">
                     <div class="form-group">
                        <label for="">Title</label>
                        <input type="text" name="title" class="form-control" required>
                     </div>
                  </div>

                  <div class="col-md-6">
                     <div class="form-group">
                        <label for="">Thumbnail</label>

                        <input type="file" name="thumbnail" class="form-control-file form-control" required>
                     </div>
                  </div>

                  <div class="col-md-6">
                     <div class="form-group">
                        <label for="category">Category</label>
                        <select name="category" class="form-control select2 select-category" style="width: 100%;">
                        </select>
                     </div>
                  </div>

                  <div class="col-md-6">
                     <div class="form-group">
                        <label for="tujuan">Tujuan</label>
                        <select name="tujuan" class="form-control select2 select-tujuan" style="width: 100%;">
                        </select>
                     </div>
                  </div>

                  <div class="col-md-12">
                     <div class="form-group">
                        <label for="">Content</label>
                        <textarea name="content" id="content" class="text-editor" cols="30" rows="10"></textarea>
                     </div>
                  </div>

               </div>
            </form>

         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" form="form-add-maklumat">Save</button>
         </div>
      </div>
   </div>
</div>

<div class="modal fade" id="modal-update-maklumat" tabindex="-1" role="dialog" aria-labelledby="modal-update" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content">
         <div class="modal-header bg-warning">
            <h5 class="modal-title text-white">Modal Update</h5>
            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">

            <form id="form-update-maklumat" method="POST" enctype="multipart/form-data">
               <div class="row">
                  <input type="hidden" name="id">
                  <div class="col-md-12">
                     <div class="form-group">
                        <label for="">Title</label>
                        <input type="text" name="title" class="form-control">
                     </div>
                  </div>

                  <div class="col-md-6">
                     <div class="form-group">
                        <label for="">Thumbnail</label>

                        <input type="file" name="thumbnail" class="form-control-file form-control">
                     </div>
                  </div>

                  <div class="col-md-6">
                     <div class="form-group">
                        <label for="category">Category</label>
                        <select name="category" class="form-control select2 select-category" style="width: 100%;">
                        </select>
                     </div>
                  </div>

                  <div class="col-md-6">
                     <div class="form-group">
                        <label for="tujuan">Tujuan</label>
                        <select name="tujuan" class="form-control select2 select-tujuan" style="width: 100%;">
                        </select>
                     </div>
                  </div>

                  <div class="col-md-12">
                     <div class="form-group">
                        <label for="">Content</label>
                        <textarea name="content" class="text-editor" cols="30" rows="10"></textarea>
                     </div>
                  </div>
               </div>
            </form>

         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-warning" form="form-update-maklumat">Save</button>
         </div>
      </div>
   </div>
</div>

<div class="modal fade" id="modal-delete-maklumat" tabindex="-1" role="dialog" aria-labelledby="modal-delete" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
      <div class="modal-content">
         <div class="modal-header bg-danger">
            <h5 class="modal-title text-white">Modal Delete</h5>
            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">

            <form id="form-delete-maklumat" method="POST">
               <input type="hidden" name="id">
            </form>

            <p>Apakah anda yakin ingin menghapus data ini ?</p>

         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-danger" form="form-delete-maklumat">Hapus</button>
         </div>
      </div>
   </div>
</div>

<div class="modal fade" id="modal-post-maklumat" tabindex="-1" role="dialog" aria-labelledby="modal-post" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
      <div class="modal-content">
         <div class="modal-header bg-success">
            <h5 class="modal-title text-white">Modal Post</h5>
            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">

            <form id="form-post-maklumat" method="POST">
               <input type="hidden" name="id">
            </form>

            <p>Apakah anda yakin ingin posting maklumat ini ?</p>

         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-success" form="form-post-maklumat">Posting</button>
         </div>
      </div>
   </div>
</div>