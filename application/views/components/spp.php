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


<div class="modal fade" id="modal-view-spp" tabindex="-1" role="dialog" aria-labelledby="modal-add" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content">
         <div class="modal-header bg-primary">
            <h5 class="modal-title text-white">SPP <span class="nama_santri"></span></h5>
            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">

            <form method="POST" class="mb-2" id="form-add-spp">
               <input type="hidden" name="santri_id">
               <div class="row">
                  <div class="col-md">
                     <div class="form-group">
                        <label for="bulan">Bulan</label>
                        <select name="bulan" id="bulan" class="form-control">
                           <option value="januari">Januari</option>
                           <option value="februari">Februari</option>
                           <option value="maret">Maret</option>
                           <option value="april">April</option>
                           <option value="mei">Mei</option>
                           <option value="juni">Juni</option>
                           <option value="juli">Juli</option>
                           <option value="agustus">Agustus</option>
                           <option value="september">September</option>
                           <option value="oktober">Oktober</option>
                           <option value="november">November</option>
                           <option value="desember">Desember</option>
                        </select>
                     </div>
                  </div>

                  <div class="col-md">
                     <div class="form-group">
                        <label for="nominal">Nominal</label>
                        <input type="text" id="nominal" name="nominal" class="form-control">
                     </div>
                  </div>
               </div>

               <button class="btn btn-primary float-right mb-2" type="submit">Bayar</button>
            </form>

            <div class="table-responsive">
               <table class="table table-flush">
                  <thead>
                     <th>Bulan</th>
                     <th>Status</th>
                     <th>Cetak</th>
                  </thead>
                  <tbody id="table-body-spp">

                  </tbody>
               </table>
            </div>

         </div>
      </div>
   </div>
</div>