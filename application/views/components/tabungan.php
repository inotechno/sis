<!-- Page Content  -->
<div id="content-page" class="content-page">
   <div class="container-fluid">
      <div class="row">
         <div class="col-sm-12">
            <div class="iq-card">
               <div class="iq-card-header d-flex justify-content-between">
                  <div class="iq-header-title">
                     <h4 class="card-title">Daftar Santri</h4>
                  </div>
               </div>
               <div class="iq-card-body">
                  <div class="table-responsive">
                     <table id="table-santri" class="table table-striped mt-4" role="grid" aria-describedby="user-list-page-info">
                        <thead>
                           <tr>
                              <th>NIS</th>
                              <th>Name</th>
                              <th>Kelas</th>
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


<div class="modal fade" id="modal-view-tabungan" tabindex="-1" role="dialog" aria-labelledby="modal-add" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content">
         <div class="modal-header bg-primary">
            <h5 class="modal-title text-white">Tabungan <span class="nama_santri"></span> | <span class="nis_santri"></span></h5>
            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">

            <form method="POST" class="mb-2" id="form-add-tabungan">
               <input type="hidden" name="santri_id">
               <div class="row">

                  <div class="col-md">
                     <div class="form-group">
                        <label for="nominal">Nominal</label>
                        <input type="text" id="nominal" name="nominal" class="form-control">
                     </div>
                  </div>

                  <div class="col-md">
                     <div class="form-group">
                        <label for="debit_kredit">Debit / Kredit</label>
                        <select name="debit_kredit" id="debit_kredit" class="form-control">
                           <option value="debit">Debit</option>
                           <option value="kredit">Kredit</option>
                        </select>
                     </div>
                  </div>
               </div>

               <button class="btn btn-primary float-right mb-2" type="submit">Simpan</button>
            </form>

            <div class="table-responsive">
               <table class="table table-flush">
                  <thead>
                     <th>Nominal</th>
                     <th>Debit / Kredit</th>
                     <th>Penerima</th>
                     <th>Cetak</th>
                  </thead>
                  <tbody id="table-body-tabungan">

                  </tbody>
               </table>
            </div>

            <div class="row">
               <div class="col-sm-12 col-md-6 col-lg-6">
                  <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
                     <div class="iq-card-body">
                        <div class="d-flex align-items-center justify-content-between text-right">
                           <div class="icon iq-icon-box rounded-circle bg-success">
                              <i class="ri-arrow-down-circle-fill ri-2x"></i>
                           </div>
                           <div>
                              <h5 class="mb-0">Debit</h5>
                              <span class="h4 text-success mb-0  d-inline-block w-100 debit"></span>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>

               <div class="col-sm-12 col-md-6 col-lg-6">
                  <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
                     <div class="iq-card-body">
                        <div class="d-flex align-items-center justify-content-between text-right">
                           <div class="icon iq-icon-box rounded-circle bg-danger">
                              <i class="ri-arrow-up-circle-fill ri-2x"></i>
                           </div>
                           <div>
                              <h5 class="mb-0">Kredit</h5>
                              <span class="h4 text-danger mb-0  d-inline-block w-100 kredit"></span>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>

               <div class="col-sm-12 col-md-12 col-lg-12">
                  <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
                     <div class="iq-card-body">
                        <div class="d-flex align-items-center justify-content-between text-right">
                           <div class="icon iq-icon-box rounded-circle bg-primary">
                              <i class="ri-money-dollar-circle-line ri-2x"></i>
                           </div>
                           <div>
                              <h5 class="mb-0">Saldo</h5>
                              <span class="h4 text-primary mb-0  d-inline-block w-100 saldo"></span>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>

         </div>
      </div>
   </div>
</div>