<form id="form-checkout" method="POST" action="<?= site_url('_WaliSantri/Saldo/pay') ?>">
   <!-- Page Content  -->
   <div id="content-page" class="content-page">
      <div class="container-fluid">
         <div class="row">
            <div class="col-md-6">
               <div class="iq-card">
                  <div class="iq-card-body">
                     <div class="form-group">
                        <label for="">Pilih Santri</label>
                        <select name="santri_id" id="santri_id" class="form-control select2 select-santri"></select>
                     </div>
                  </div>
               </div>

               <div class="iq-card">
                  <div class="iq-card-body">
                     <div class="form-group">
                        <label for="name">Jumlah Uang</label>
                        <input type="text" id="amount" name="amount" class="form-control">
                     </div>
                  </div>
               </div>

               <div class="iq-card">
                  <div class="iq-card-body">
                     <p><b>Price Details</b></p>
                     <div class="d-flex justify-content-between">
                        <span>Total Harga</span>
                        <span id="total-harga"></span>
                     </div>

                     <div class="d-flex justify-content-between">
                        <span>Fee Layanan</span>
                        <span class="text-danger" id="fee"></span>
                     </div>

                     <div class="d-flex justify-content-between">
                        <span class="text-dark">Sub Total</span>
                        <span class="text-dark" id="sub-total"></span>
                     </div>

                     <div class="d-flex justify-content-between mt-3">
                        <span>PPN</span>
                        <span class="text-primary" id="ppn"></span>
                     </div>

                     <div class="d-flex justify-content-between">
                        <span class="text-dark"><strong>Total</strong></span>
                        <span class="text-dark"><strong id="gross_amount"></strong></span>
                     </div>

                     <input type="hidden" name="gross_amount">

                     <button class="btn btn-primary col mt-1 d-block" type="button" id="btn-checkout"><span class="ri-shopping-cart-fill"></span> &nbsp;Checkout</button>

                  </div>
               </div>

            </div>

            <div class="col-md">

               <div class="iq-card">
                  <div class="iq-card-header d-flex justify-content-between">
                     <div class="iq-header-title">
                        <h4 class="card-title">Metode Pembayaran</h4>
                     </div>
                  </div>
                  <div class="iq-card-body">

                     <ul class="list-group" id="payment-method">

                     </ul>

                     <input id="token_id" name="token_id" type="hidden" />
                     <input id="auth_id" name="auth_id" type="hidden" />
                     <div id="form-card" class="mt-2" style="display: none;">

                        <div class="form-group">
                           <label for="">Card Number</label>
                           <input type="number" class="form-control" name="card_number" value="4000000000000002">
                        </div>

                        <div class="row mt-2">

                           <div class="col-md">
                              <div class="form-group">
                                 <label for="">CVN</label>
                                 <input type="number" name="cvn" class="form-control" value="123">
                              </div>
                           </div>

                           <div class="col-md">
                              <div class="form-group">
                                 <label for="">Expire Month</label>
                                 <select name="month" id="month_ex" class="form-control">
                                    <option value="01" selected>01</option>
                                    <option value="02">02</option>
                                    <option value="03">03</option>
                                    <option value="04">04</option>
                                    <option value="05">05</option>
                                    <option value="06">06</option>
                                    <option value="08">08</option>
                                    <option value="09">09</option>
                                    <option value="10">10</option>
                                    <option value="11">11</option>
                                    <option value="12">12</option>
                                 </select>
                              </div>
                           </div>

                           <div class="col-md">
                              <div class="form-group">
                                 <label for="">Expire Year</label>
                                 <input type="number" name="year" min="1900" max="2099" step="1" value="2023" class="form-control">
                              </div>
                           </div>

                        </div>

                        <small class="text-danger" id="error"></small>
                        <!-- <button id="check-card" type="button" class="form-control">cek</button> -->
                     </div>
                  </div>
               </div>


            </div>

         </div>
      </div>
   </div>

</form>

<div class="modal fade" id="modal-checkout" tabindex="-1" role="dialog" aria-labelledby="modal-delete" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
      <div class="modal-content">
         <div class="modal-header bg-danger">
            <h5 class="modal-title text-white">Konfirmasi Pesanan !</h5>
            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">

            <p>Apakah anda yakin ingin melanjutkan pembayaran ?, jika belum silahkan periksa kembali data yang akan dikirim !</p>

         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-danger" form="form-checkout">Bayar</button>
         </div>
      </div>
   </div>
</div>

<div class="modal fade" id="modal-container" tabindex="-1" role="dialog" aria-labelledby="modal-delete" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered modal-md" role="document">
      <div class="modal-content">
         <div class="modal-body">
            <iframe width="100%" height="350px" id="sample-inline-frame" name="sample-inline-frame"></iframe>
         </div>
      </div>
   </div>
</div>