<!-- Page Content  -->
<div id="content-page" class="content-page">
   <div class="container-fluid">
      <div class="row">

         <div class="col-md-4">
            <div class="iq-card">
               <div class="iq-card-header d-flex justify-content-between">
                  <div class="iq-header-title">
                     <h4 class="card-title">Penerima</h4>
                  </div>
                  <div class="iq-card-header-toolbar d-flex align-items-center">
                     <select name="bulan" class="form-control">
                        <option value="">Pilih Bulan</option>
                        <option value="1">Januari</option>
                        <option value="2">Februari</option>
                        <option value="3">Maret</option>
                        <option value="4">April</option>
                        <option value="5">Mei</option>
                        <option value="6">Juni</option>
                        <option value="7">Juli</option>
                        <option value="8">Agustus</option>
                        <option value="9">September</option>
                        <option value="10">November</option>
                        <option value="11">Oktober</option>
                        <option value="12">Desember</option>
                     </select>
                  </div>
               </div>
               <div class="iq-card-body">
                  <ul class="list-inline p-0 m-0" id="list-ustadz">
                  </ul>
               </div>
            </div>

         </div>

         <div class="col-md hide-before-nis">
            <div class="iq-card">

               <div class="iq-card-body">
                  <div class="row">
                     <div class="col-md">
                        <form method="get" id="form-search-produk">
                           <input type="text" name="barcode_search" class="form-control">
                        </form>
                        <p class="card-text">
                           <small class="text-muted">* Scan barcode produk disini</small>
                        </p>
                     </div>

                     <div class="col-md text-right align-middle">
                        <h2 class="font-weight-bold">Rp. <span id="total-invoice">0</span></h2>
                     </div>
                  </div>
               </div>
            </div>

            <form id="form-checkout" method="POST">
               <input type="hidden" name="ustadz_id">
               <input type="hidden" name="bulan">

               <div class="iq-card">
                  <div class="iq-card-body">
                     <h4 class="card-title">Checkout</h4>

                     <ul class="suggestions-lists m-0 p-0 list-product">

                     </ul>
                  </div>
               </div>
            </form>

            <button class="btn btn-warning btn-rounded float-right" type="submit" form="form-checkout"><span class="ri-shopping-cart-fill"></span> &nbsp;Checkout</button>
         </div>

      </div>
   </div>
</div>