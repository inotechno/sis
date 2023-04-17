<!-- Page Content  -->
<div id="content-page" class="content-page">
   <div class="container-fluid">
      <div class="row">
         <div class="col-md-12">
            <div class="iq-card">
               <div class="iq-card-header d-flex justify-content-between">
                  <div class="iq-header-title">
                     <h4 class="card-title">Import Santri</h4>
                  </div>
                  <div class="iq-card-header-toolbar d-flex align-items-center">
                     <a href="<?= base_url('assets/template/import-santri.xlsx') ?>" class="btn btn-success">Template</a>
                  </div>
               </div>
               <div class="iq-card-body">
                  <form id="import-santri" method="POST" enctype="multipart/form-data">
                     <div class="form-group">
                        <div class="custom-file">
                           <input type="file" name="template" class="custom-file-input" id="template-santri" required>
                           <label class="custom-file-label" for="template-santri">Pilih File</label>
                        </div>
                     </div>

                     <div class="row" id="table-preview-santri">
                        <div class="col-md-12">
                           <table class="table table-sm">
                              <thead>
                                 <td>Nama</td>
                                 <td>Email</td>
                                 <td>Password</td>
                                 <td>NIS</td>
                                 <td>Jenis Kelamin</td>
                                 <td>Tempat Lahir</td>
                                 <td>Tanggal Lahir</td>
                              </thead>
                              <tbody id="preview-santri">

                              </tbody>
                           </table>
                        </div>
                     </div>

                     <button type="submit" id="btn-upload-santri" class="btn btn-primary">Upload</button>
                  </form>
               </div>
            </div>
         </div>

         <div class="col-md-12">
            <div class="iq-card">
               <div class="iq-card-header d-flex justify-content-between">
                  <div class="iq-header-title">
                     <h4 class="card-title">Import Wali Santri</h4>
                  </div>
                  <div class="iq-card-header-toolbar d-flex align-items-center">
                     <a href="<?= base_url('assets/template/import-wali-santri.xlsx') ?>" class="btn btn-success">Template</a>
                  </div>
               </div>
               <div class="iq-card-body">
                  <form id="import-wali-santri">
                     <div class="form-group">
                        <div class="custom-file">
                           <input type="file" name="template" class="custom-file-input" id="template-wali-santri">
                           <label class="custom-file-label" for="template-wali-santri">Pilih File</label>
                        </div>
                     </div>

                     <div class="row" id="table-preview-wali-santri">
                        <div class="col-md-12">
                           <table class="table table-sm">
                              <thead>
                                 <td>Nama</td>
                                 <td>Email</td>
                                 <td>Password</td>
                                 <td>NIK</td>
                                 <td>Jenis Kelamin</td>
                                 <td>Tempat Lahir</td>
                                 <td>Tanggal Lahir</td>
                              </thead>
                              <tbody id="preview-wali-santri">

                              </tbody>
                           </table>
                        </div>
                     </div>

                     <button type="submit" id="btn-upload-wali-santri" class="btn btn-primary">Upload</button>
                  </form>
               </div>
            </div>
         </div>

         <div class="col-md-12">
            <div class="iq-card">
               <div class="iq-card-header d-flex justify-content-between">
                  <div class="iq-header-title">
                     <h4 class="card-title">Import Ustadz</h4>
                  </div>
                  <div class="iq-card-header-toolbar d-flex align-items-center">
                     <a href="<?= base_url('assets/template/import-ustadz.xlsx') ?>" class="btn btn-success">Template</a>
                  </div>
               </div>
               <div class="iq-card-body">
                  <form id="import-ustadz">
                     <div class="form-group">
                        <div class="custom-file">
                           <input type="file" name="template" class="custom-file-input" id="template-ustadz">
                           <label class="custom-file-label" for="template-ustadz">Pilih File</label>
                        </div>
                     </div>

                     <div class="row" id="table-preview-ustadz">
                        <div class="col-md-12">
                           <table class="table table-sm">
                              <thead>
                                 <td>Nama</td>
                                 <td>Email</td>
                                 <td>Password</td>
                                 <td>NIP</td>
                                 <td>NIK</td>
                                 <td>Jenis Kelamin</td>
                                 <td>Tempat Lahir</td>
                                 <td>Tanggal Lahir</td>
                              </thead>
                              <tbody id="preview-ustadz">

                              </tbody>
                           </table>
                        </div>
                     </div>

                     <button type="submit" id="btn-upload-ustadz" class="btn btn-primary">Upload</button>
                  </form>
               </div>
            </div>
         </div>

         <div class="col-md-12">
            <div class="iq-card">
               <div class="iq-card-header d-flex justify-content-between">
                  <div class="iq-header-title">
                     <h4 class="card-title">Import Mata Pelajaran</h4>
                  </div>
                  <div class="iq-card-header-toolbar d-flex align-items-center">
                     <a href="<?= base_url('assets/template/import-mapel.xlsx') ?>" class="btn btn-success">Template</a>
                  </div>
               </div>
               <div class="iq-card-body">
                  <form id="import-mapel">
                     <div class="form-group">
                        <div class="custom-file">
                           <input type="file" name="template" class="custom-file-input" id="template-mapel">
                           <label class="custom-file-label" for="template-mapel">Pilih File</label>
                        </div>
                     </div>

                     <div class="row" id="table-preview-mapel">
                        <div class="col-md-12">
                           <table class="table table-sm">
                              <thead>
                                 <td>Nama</td>
                                 <td>Tingkat</td>
                                 <td>Nilai KKM</td>
                              </thead>
                              <tbody id="preview-mapel">

                              </tbody>
                           </table>
                        </div>
                     </div>

                     <button type="submit" id="btn-upload-mapel" class="btn btn-primary">Upload</button>
                  </form>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>