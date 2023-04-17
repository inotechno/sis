<!-- Page Content  -->
<div id="content-page" class="content-page">
   <div class="container-fluid">
      <div class="row">
         <div class="col-lg-12">
            <div class="iq-card">
               <div class="iq-card-body p-0">
                  <div class="iq-edit-list">
                     <ul class="iq-edit-profile d-flex nav nav-pills">
                        <li class="col-md-3 p-0">
                           <a class="nav-link active" data-toggle="pill" href="#konfigurasi-aplikasi">
                              Konfigrasi Aplikasi
                           </a>
                        </li>
                        <li class="col-md-3 p-0">
                           <a class="nav-link" data-toggle="pill" href="#visi-misi">
                              Visi & Misi
                           </a>
                        </li>
                        <li class="col-md-3 p-0">
                           <a class="nav-link" data-toggle="pill" href="#emailandsms">
                              Xendit Key
                           </a>
                        </li>
                        <li class="col-md-3 p-0">
                           <a class="nav-link" data-toggle="pill" href="#manage-contact">
                              Manage Contact
                           </a>
                        </li>
                     </ul>
                  </div>
               </div>
            </div>
         </div>

         <div class="col-lg-12">
            <form method="POST" id="form-config" enctype="multipart/form-data">
               <div class="iq-edit-list-data">
                  <div class="tab-content">
                     <div class="tab-pane fade active show" id="konfigurasi-aplikasi" role="tabpanel">
                        <div class="iq-card">
                           <div class="iq-card-header d-flex justify-content-between">
                              <div class="iq-header-title">
                                 <h4 class="card-title">Konfigurasi Aplikasi</h4>
                              </div>
                           </div>
                           <div class="iq-card-body">
                              <div class="form-group row align-items-center">
                                 <div class="col-md-6">
                                    <img width="150" height="150" class="img-fluid" src="<?= base_url('assets/images/' . _LOGO_FULL . '?time=' . time()) ?>" alt="">
                                    <div class="form-group">
                                       <label for="">Logo Full</label>
                                       <div class="custom-file">
                                          <input type="file" class="custom-file-input" name="LOGO_FULL" id="logo-full">
                                          <label class="custom-file-label" for="logo-full">Choose file</label>
                                       </div>
                                    </div>
                                 </div>

                                 <div class="col-md-6">
                                    <img width="150" height="150" class="img-fluid" src="<?= base_url('assets/images/' . _LOGO_MINI . '?time=' . time()) ?>" alt="">
                                    <div class="form-group">
                                       <label for="">Logo Mini</label>
                                       <div class="custom-file">
                                          <input type="file" class="custom-file-input" name="LOGO_MINI" id="logo-mini">
                                          <label class="custom-file-label" for="logo-mini">Choose file</label>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <div class="row align-items-center mt-4">
                                 <div class="form-group col-sm-6">
                                    <label for="APP_NAME">APP Name</label>
                                    <input type="text" class="form-control" name="APP_NAME" id="APP_NAME" value="<?= _APP_NAME ?>">
                                 </div>
                                 <div class="form-group col-sm-6">
                                    <label for="SHORT_APP_NAME">Short APP Name</label>
                                    <input type="text" class="form-control" name="SHORT_APP_NAME" id="SHORT_APP_NAME" value="<?= _SHORT_APP_NAME ?>">
                                 </div>
                                 <div class="form-group col-sm-6">
                                    <label for="NAMA_PESANTREN">Nama Pesantren</label>
                                    <input type="text" class="form-control" id="NAMA_PESANTREN" name="NAMA_PESANTREN" value="<?= _NAMA_PESANTREN ?>">
                                 </div>
                                 <div class="form-group col-sm-6">
                                    <label for="NAMA_PENDIRI">Nama Pendiri</label>
                                    <input type="text" class="form-control" id="NAMA_PENDIRI" name="NAMA_PENDIRI" value="<?= _NAMA_PENDIRI ?>">
                                 </div>
                                 <div class="form-group col-sm-6">
                                    <label for="NOMOR_SK">Nomor SK</label>
                                    <input type="text" class="form-control" id="NOMOR_SK" name="NOMOR_SK" value="<?= _NOMOR_SK ?>">
                                 </div>
                                 <div class="form-group col-sm-6">
                                    <label for="NPWP">NPWP</label>
                                    <input type="text" class="form-control npwp-mask" id="NPWP" name="NPWP" value="<?= _NPWP ?>">
                                 </div>
                                 <div class="form-group col-sm-6">
                                    <label for="PHONE">Phone</label>
                                    <input type="text" class="form-control" id="PHONE" name="PHONE" value="<?= _PHONE ?>">
                                 </div>
                                 <div class="form-group col-sm-6">
                                    <label for="EMAIL">Email</label>
                                    <input type="text" class="form-control" id="EMAIL" name="EMAIL" value="<?= _EMAIL ?>">
                                 </div>
                                 <div class="form-group col-sm-12">
                                    <label>Alamat</label>
                                    <textarea class="form-control" name="ALAMAT" rows="5" style="line-height: 22px;"><?= _ALAMAT ?></textarea>
                                 </div>
                              </div>

                           </div>
                        </div>
                     </div>
                     <div class="tab-pane fade" id="visi-misi" role="tabpanel">
                        <div class="iq-card">
                           <div class="iq-card-header d-flex justify-content-between">
                              <div class="iq-header-title">
                                 <h4 class="card-title">Visi & Misi</h4>
                              </div>
                           </div>
                           <div class="iq-card-body">
                              <div class="row">
                                 <div class="col-md-6">
                                    <div class="form-group">
                                       <label for="cpass">Visi</label>
                                       <textarea name="VISI" id="visi" cols="30" class="text-editor" rows="10"><?= _VISI ?></textarea>
                                    </div>
                                 </div>

                                 <div class="col-md-6">
                                    <div class="form-group">
                                       <label for="cpass">Misi</label>
                                       <textarea name="MISI" id="misi" cols="30" class="text-editor" rows="10"><?= _MISI ?></textarea>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="tab-pane fade" id="emailandsms" role="tabpanel">
                        <div class="iq-card">
                           <div class="iq-card-header d-flex justify-content-between">
                              <div class="iq-header-title">
                                 <h4 class="card-title">Email and SMS</h4>
                              </div>
                           </div>
                           <div class="iq-card-body">
                              <div class="row">
                                 <div class="form-group col-sm-6">
                                    <label for="XENDIT_KEY">Private Key</label>
                                    <input type="text" class="form-control" name="XENDIT_KEY" id="XENDIT_KEY" value="<?= _XENDIT_KEY ?>">
                                 </div>
                                 <div class="form-group col-sm-6">
                                    <label for="XENDIT_PUBLIC_KEY">Public Key</label>
                                    <input type="text" class="form-control" name="XENDIT_PUBLIC_KEY" id="XENDIT_PUBLIC_KEY" value="<?= _XENDIT_PUBLIC_KEY ?>">
                                 </div>
                                 <div class="form-group col-sm-6">
                                    <label for="XENDIT_CALLBACK_TOKEN">Callback Token</label>
                                    <input type="text" class="form-control" name="XENDIT_CALLBACK_TOKEN" id="XENDIT_CALLBACK_TOKEN" value="<?= _XENDIT_CALLBACK_TOKEN ?>">
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="tab-pane fade" id="manage-contact" role="tabpanel">
                        <div class="iq-card">
                           <div class="iq-card-header d-flex justify-content-between">
                              <div class="iq-header-title">
                                 <h4 class="card-title">Manage Contact</h4>
                              </div>
                           </div>
                           <div class="iq-card-body">
                              <form>
                                 <div class="form-group">
                                    <label for="cno">Contact Number:</label>
                                    <input type="text" class="form-control" id="cno" value="001 2536 123 458">
                                 </div>
                                 <div class="form-group">
                                    <label for="email">Email:</label>
                                    <input type="text" class="form-control" id="email" value="nikjone@demo.com">
                                 </div>
                                 <div class="form-group">
                                    <label for="url">Url:</label>
                                    <input type="text" class="form-control" id="url" value="https://getbootstrap.com">
                                 </div>
                              </form>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </form>
         </div>

         <div class="col-lg-12 mb-4">
            <button type="submit" class="btn btn-success btn-lg col-12" form="form-config">Simpan Konfigurasi</button>
         </div>
      </div>
   </div>
</div>