<!-- Page Content  -->
<div id="content-page" class="content-page">
   <div class="container-fluid">
      <div class="row mb-3">
         <div class="col-md-3">
            <div class="left-panel">
               <div class="iq-filter-border iq-card py-2 px-3">
                  <div id="clear-refinements" class="float-right">
                     <button disabled="" id="clear-result" class="btn btn-primary border-0 btn-sm mr-2"><i class="ri-refresh-line mr-0"></i></button>
                  </div>
                  <h4>Filter </h4>
               </div>

               <!-- <div class="iq-filter-border iq-card">
                  <h5 class="card-title">Urutkan Harga</h5>
                  <div id="numeric-menu">
                     <div class="ais-NumericMenu">
                        <ul class="ais-NumericMenu-list">
                           <li class="ais-NumericMenu-item ais-NumericMenu-item--selected">
                              <div>
                                 <label class="ais-NumericMenu-label"> 
                                 <input type="radio"
                                       class="ais-NumericMenu-radio" name="price" checked=""> 
                                    <span
                                       class="ais-NumericMenu-labelText">All</span> 
                                    </label>
                              </div>
                           </li>
                           <li class="ais-NumericMenu-item">
                              <div><label class="ais-NumericMenu-label"> 
                                 <input type="radio" value="0-100000"
                                       class="ais-NumericMenu-radio" name="price"> <span
                                       class="ais-NumericMenu-labelText">Dibawah 100.000</span> </label></div>
                           </li>
                           <li class="ais-NumericMenu-item">
                              <div><label class="ais-NumericMenu-label"> 
                                 <input type="radio" value="100000-500000"
                                       class="ais-NumericMenu-radio" name="price"> <span
                                       class="ais-NumericMenu-labelText">100.000 - 500.000</span> </label></div>
                           </li>
                           <li class="ais-NumericMenu-item">
                              <div><label class="ais-NumericMenu-label"> 
                                 <input type="radio" value="500000"
                                       class="ais-NumericMenu-radio" name="price"> <span
                                       class="ais-NumericMenu-labelText">Diatas 500.000</span> </label></div>
                           </li>
                        </ul>
                     </div>
                  </div>
               </div> -->

               <div class="iq-filter-border iq-card">
                  <h5 class="card-title">Kategori</h5>
                  <div id="brand-list">
                     <ul class="list-group iq-list-style-1" id="category-list">

                     </ul>
                  </div>
               </div>

               <button class="float-right btn btn-primary btn-rounded" id="btn-add-product" data-toggle="modal" data-target="#modal-add-product">Tambah Produk</button>


               <!-- <div class="iq-filter-border iq-card">
                  <h5 class="card-title">Rating</h5>
                  <div id="rating-menu">
                     <div class="ais-RatingMenu"><svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
                           <symbol id="ais-RatingMenu-starSymbol" viewBox="0 0 24 24">
                              <path
                                 d="M12 .288l2.833 8.718h9.167l-7.417 5.389 2.833 8.718-7.416-5.388-7.417 5.388 2.833-8.718-7.416-5.389h9.167z">
                              </path>
                           </symbol>
                           <symbol id="ais-RatingMenu-starEmptySymbol" viewBox="0 0 24 24">
                              <path
                                 d="M12 6.76l1.379 4.246h4.465l-3.612 2.625 1.379 4.246-3.611-2.625-3.612 2.625 1.379-4.246-3.612-2.625h4.465l1.38-4.246zm0-6.472l-2.833 8.718h-9.167l7.416 5.389-2.833 8.718 7.417-5.388 7.416 5.388-2.833-8.718 7.417-5.389h-9.167l-2.833-8.718z">
                              </path>
                           </symbol>
                        </svg>
                        <ul class="ais-RatingMenu-list">
                           <li class="ais-RatingMenu-item">
                              <div>
                                 <a href="#" class="d-flex justify-content-between ais-RatingMenu-link"
                                    aria-label="4 &amp; up">
                                    <div>
                                       <i class="ri-star-fill text-warning mr-2"></i><i
                                          class="ri-star-fill text-warning mr-2"></i><i
                                          class="ri-star-fill text-warning mr-2"></i><i
                                          class="ri-star-fill text-warning mr-2"></i><i
                                          class="ri-star-line text-primary mr-2"></i>
                                       <span class="ais-RatingMenu-label text-primary">&amp; Up</span>
                                    </div>
                                    <span class="badge iq-bg-primary">16074</span>
                                 </a>
                              </div>
                           </li>
                           <li class="ais-RatingMenu-item">
                              <div>
                                 <a href="#" class="d-flex justify-content-between ais-RatingMenu-link"
                                    aria-label="3 &amp; up">
                                    <div>
                                       <i class="ri-star-fill text-warning mr-2"></i><i
                                          class="ri-star-fill text-warning mr-2"></i><i
                                          class="ri-star-fill text-warning mr-2"></i><i
                                          class="ri-star-line text-primary mr-2"></i><i
                                          class="ri-star-line text-primary mr-2"></i>
                                       <span class="ais-RatingMenu-label text-primary">&amp; Up</span>
                                    </div>
                                    <span class="badge iq-bg-primary">17696</span>
                                 </a>
                              </div>
                           </li>
                           <li class="ais-RatingMenu-item">
                              <div>
                                 <a href="#" class="d-flex justify-content-between ais-RatingMenu-link"
                                    aria-label="2 &amp; up">
                                    <div>
                                       <i class="ri-star-fill text-warning mr-2"></i><i
                                          class="ri-star-fill text-warning mr-2"></i><i
                                          class="ri-star-line text-primary mr-2"></i><i
                                          class="ri-star-line text-primary mr-2"></i><i
                                          class="ri-star-line text-primary mr-2"></i>
                                       <span class="ais-RatingMenu-label text-primary">&amp; Up</span>
                                    </div>
                                    <span class="badge iq-bg-primary">17890</span>
                                 </a>
                              </div>
                           </li>
                           <li class="ais-RatingMenu-item">
                              <div>
                                 <a href="#" class="d-flex justify-content-between ais-RatingMenu-link"
                                    aria-label="1 &amp; up">
                                    <div>
                                       <i class="ri-star-fill text-warning mr-2"></i><i
                                          class="ri-star-line text-primary mr-2"></i><i
                                          class="ri-star-line text-primary mr-2"></i><i
                                          class="ri-star-line text-primary mr-2"></i><i
                                          class="ri-star-line text-primary mr-2"></i>
                                       <span class="ais-RatingMenu-label text-primary">&amp; Up</span>
                                    </div>
                                    <span class="badge iq-bg-primary">18046</span>
                                 </a>
                              </div>
                           </li>
                        </ul>
                     </div>
                  </div>
               </div>

               <div class="iq-filter-border iq-card">
                  <h5 class="card-title">Free Shipping</h5>
                  <div id="toggle-refinement">
                     <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input brand-checkbox" id="free_Ship" value="">
                        <label class="custom-control-label" for="free_Ship">Free shipping</label>
                     </div>
                  </div>
               </div> -->

            </div>
         </div>
         <div class="col-md-9">
            <div class="right-panel">
               <div class="row">
                  <div class="col-md-12">
                     <div class="iq-card">
                        <div class="d-flex align-items-center justify-content-between pl-2 pr-3">
                           <div class="d-flex iq-algolia-search">
                              <div id="searchbox" class="ais-SearchBox">
                                 <div class="ais-SearchBox">
                                    <form action="" role="search" class="ais-SearchBox-form" novalidate="">
                                       <input class="ais-SearchBox-input" type="search" placeholder="Search for products" autocomplete="off" autocorrect="off" autocapitalize="off" maxlength="512"><button class="ais-SearchBox-submit" type="submit" title="Submit the search query."><svg class="ais-SearchBox-submitIcon" xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 40 40">
                                             <path d="M26.804 29.01c-2.832 2.34-6.465 3.746-10.426 3.746C7.333 32.756 0 25.424 0 16.378 0 7.333 7.333 0 16.378 0c9.046 0 16.378 7.333 16.378 16.378 0 3.96-1.406 7.594-3.746 10.426l10.534 10.534c.607.607.61 1.59-.004 2.202-.61.61-1.597.61-2.202.004L26.804 29.01zm-10.426.627c7.323 0 13.26-5.936 13.26-13.26 0-7.32-5.937-13.257-13.26-13.257C9.056 3.12 3.12 9.056 3.12 16.378c0 7.323 5.936 13.26 13.258 13.26z">
                                             </path>
                                             <button class="ais-SearchBox-reset" type="reset" title="Clear the search query." hidden=""><svg class="ais-SearchBox-resetIcon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" width="10" height="10">
                                                   <path d="M8.114 10L.944 2.83 0 1.885 1.886 0l.943.943L10 8.113l7.17-7.17.944-.943L20 1.886l-.943.943-7.17 7.17 7.17 7.17.943.944L18.114 20l-.943-.943-7.17-7.17-7.17 7.17-.944.943L0 18.114l.943-.943L8.113 10z">
                                                   </path>
                                                </svg>
                                             </button>
                                             <span class="ais-SearchBox-loadingIndicator" hidden="">
                                                <svg class="ais-SearchBox-loadingIcon" width="16" height="16" viewBox="0 0 38 38" xmlns="http://www.w3.org/2000/svg" stroke="#444">
                                                   <g fill="none" fillrule="evenodd">
                                                      <g transform="translate(1 1)" strokewidth="2">
                                                         <circle strokeopacity=".5" cx="18" cy="18" r="18"></circle>
                                                         <path d="M36 18c0-9.94-8.06-18-18-18">
                                                            <animateTransform attributeName="transform" type="rotate" from="0 18 18" to="360 18 18" dur="1s" repeatCount="indefinite"></animateTransform>
                                                         </path>
                                                      </g>
                                                   </g>
                                                </svg>
                                             </span>
                                    </form>
                                 </div>
                              </div>

                           </div>

                           <div id="selectLimit" class="d-flex justify-content-between">
                              <select name="limit" id="limit" class="ais-SortBy-select">
                                 <option value="">Limit</option>
                                 <option value="2">2</option>
                                 <option value="5">5</option>
                                 <option value="10">10</option>
                                 <option value="25">25</option>
                                 <option value="50">50</option>
                              </select>
                           </div>

                        </div>
                     </div>
                  </div>

                  <div class="col-md-12">
                     <div id="hits" class="iq-product-layout-grid">
                        <div class="ais-Hits iq-product">
                           <ul class="ais-Hits-list iq-product-list" id="product-list">
                           </ul>
                        </div>
                     </div>

                     <!-- <div class="text-center mt-2 mb-3">
                        <button class="btn btn-primary" id="btn-load-more">Load More</button>
                     </div> -->
                  </div>
               </div>
            </div>
         </div>
      </div>

   </div>
</div>


<div class="modal fade" id="modal-add-product" tabindex="-1" role="dialog" aria-labelledby="modal-add" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content">
         <div class="modal-header bg-primary">
            <h5 class="modal-title text-white">Modal Tambah</h5>
            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">

            <form id="form-add-product" method="POST" enctype="multipart/form-data">
               <div class="row">

                  <div class="col-md">
                     <div class="form-group">
                        <label for="">Barcode</label>
                        <input type="text" name="barcode" class="form-control">
                        <small class="text-muted">* Scan atau ketik angka pada barcode</small>
                     </div>
                  </div>

               </div>

               <div class="row" id="field-product">

                  <div class="col-md-12">
                     <div class="form-group">
                        <label for="imageUpload">Image</label>
                        <div class="row">
                           <div class="image-upload col-md">
                              <label for="image1">
                                 <img width="100" height="100" src="https://upload.wikimedia.org/wikipedia/commons/thumb/9/9e/Plus_symbol.svg/1200px-Plus_symbol.svg.png" />
                              </label>

                              <input id="image1" type="file" name="image1" onchange="previewImage(this);">
                           </div>

                           <div class="image-upload col-md">
                              <label for="image2">
                                 <img width="100" height="100" src="https://upload.wikimedia.org/wikipedia/commons/thumb/9/9e/Plus_symbol.svg/1200px-Plus_symbol.svg.png" />
                              </label>

                              <input id="image2" type="file" name="image2" onchange="previewImage(this);">
                           </div>

                           <div class="image-upload col-md">
                              <label for="image3">
                                 <img width="100" height="100" src="https://upload.wikimedia.org/wikipedia/commons/thumb/9/9e/Plus_symbol.svg/1200px-Plus_symbol.svg.png" />
                              </label>

                              <input id="image3" type="file" name="image3" onchange="previewImage(this);">
                           </div>

                           <div class="image-upload col-md">
                              <label for="image4">
                                 <img width="100" height="100" src="https://upload.wikimedia.org/wikipedia/commons/thumb/9/9e/Plus_symbol.svg/1200px-Plus_symbol.svg.png" />
                              </label>

                              <input id="image4" type="file" name="image4" onchange="previewImage(this);">
                           </div>

                           <div class="image-upload col-md">
                              <label for="image5">
                                 <img width="100" height="100" src="https://upload.wikimedia.org/wikipedia/commons/thumb/9/9e/Plus_symbol.svg/1200px-Plus_symbol.svg.png" />
                              </label>

                              <input id="image5" type="file" name="image5" onchange="previewImage(this);">
                           </div>
                        </div>
                     </div>
                  </div>

                  <div class="col-md-6">
                     <div class="form-group">
                        <label for="">Title</label>
                        <input type="text" id="title" name="title" class="form-control">
                     </div>
                  </div>

                  <div class="col-md-6">
                     <div class="row">
                        <div class="col-md">
                           <div class="form-group">
                              <label for="">Harga</label>
                              <input type="text" name="price" class="form-control">
                           </div>
                        </div>

                        <div class="col-md-4">
                           <div class="form-group">
                              <label for="">Satuan</label>
                              <select name="satuan" id="" class="form-control">
                                 <option value="pcs">Pcs</option>
                                 <option value="kilo">Kilo</option>
                                 <option value="lembar">Lembar</option>
                              </select>
                           </div>
                        </div>
                     </div>
                  </div>

                  <div class="col-md-6">
                     <div class="form-group">
                        <label for="category_id">Pilih Kategori</label>
                        <select name="category_id" class="form-control select-category" id="category_id"></select>
                     </div>
                  </div>

                  <div class="col-md-6">
                     <div class="form-group">
                        <label for="">Stok</label>
                        <input type="text" name="stok" class="form-control">
                     </div>
                  </div>

                  <div class="col-md-12">
                     <div class="form-group">
                        <label for="">Deskripsi</label>
                        <textarea name="description" class="form-control" id="description" cols="20" rows="5"></textarea>
                     </div>
                  </div>

               </div>
            </form>

         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" form="form-add-product">Save</button>
         </div>
      </div>
   </div>
</div>

<div class="modal fade" id="modal-update-product" tabindex="-1" role="dialog" aria-labelledby="modal-update" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content">
         <div class="modal-header bg-warning">
            <h5 class="modal-title text-white">Modal Update</h5>
            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">

            <form id="form-update-product" method="POST">
               <div class="row">
                  <input type="hidden" name="id">

                  <div class="col-md-12">
                     <div class="form-group">
                        <label for="imageUpload">Image</label>
                        <div class="row">
                           <div class="image-upload col-md text-center">
                              <label for="imageUpdate1">
                                 <img width="100" height="100" src="https://upload.wikimedia.org/wikipedia/commons/thumb/9/9e/Plus_symbol.svg/1200px-Plus_symbol.svg.png" />
                              </label>

                              <input id="imageUpdate1" type="file" name="image1" onchange="previewImage(this);">
                           </div>

                           <div class="image-upload col-md text-center">
                              <label for="imageUpdate2">
                                 <img width="100" height="100" src="https://upload.wikimedia.org/wikipedia/commons/thumb/9/9e/Plus_symbol.svg/1200px-Plus_symbol.svg.png" />
                              </label>

                              <input id="imageUpdate2" type="file" name="image2" onchange="previewImage(this);">
                           </div>

                           <div class="image-upload col-md text-center">
                              <label for="imageUpdate3">
                                 <img width="100" height="100" src="https://upload.wikimedia.org/wikipedia/commons/thumb/9/9e/Plus_symbol.svg/1200px-Plus_symbol.svg.png" />
                              </label>

                              <input id="imageUpdate3" type="file" name="image3" onchange="previewImage(this);">
                           </div>

                           <div class="image-upload col-md text-center">
                              <label for="imageUpdate4">
                                 <img width="100" height="100" src="https://upload.wikimedia.org/wikipedia/commons/thumb/9/9e/Plus_symbol.svg/1200px-Plus_symbol.svg.png" />
                              </label>

                              <input id="imageUpdate4" type="file" name="image4" onchange="previewImage(this);">
                           </div>

                           <div class="image-upload col-md text-center">
                              <label for="imageUpdate5">
                                 <img width="100" height="100" src="https://upload.wikimedia.org/wikipedia/commons/thumb/9/9e/Plus_symbol.svg/1200px-Plus_symbol.svg.png" />
                              </label>

                              <input id="imageUpdate5" type="file" name="image5" onchange="previewImage(this);">
                           </div>
                        </div>
                     </div>
                  </div>

                  <div class="col-md-6">
                     <div class="form-group">
                        <label for="">Title</label>
                        <input type="text" id="title_update" name="title" class="form-control">
                     </div>
                  </div>

                  <div class="col-md-6">
                     <div class="form-group">
                        <label for="">Barcode</label>
                        <input type="text" name="barcode" class="form-control">
                     </div>
                  </div>

                  <div class="col-md-6">
                     <div class="row">
                        <div class="col-md">
                           <div class="form-group">
                              <label for="">Harga</label>
                              <input type="text" name="price" class="form-control">
                           </div>
                        </div>

                        <div class="col-md-4">
                           <div class="form-group">
                              <label for="">Satuan</label>
                              <select name="satuan" id="" class="form-control">
                                 <option value="pcs">Pcs</option>
                                 <option value="kilo">Kilo</option>
                                 <option value="lembar">Lembar</option>
                              </select>
                           </div>
                        </div>
                     </div>
                  </div>

                  <div class="col-md-6">
                     <div class="form-group">
                        <label for="category_id">Pilih Kategori</label>
                        <select name="category_id" class="form-control select-category" id="category_id_update"></select>
                     </div>
                  </div>

                  <div class="col-md-12">
                     <div class="form-group">
                        <label for="">Deskripsi</label>
                        <textarea name="description" class="form-control" id="description_update" cols="20" rows="5"></textarea>
                     </div>
                  </div>

               </div>
            </form>

         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-warning" form="form-update-product">Save</button>
         </div>
      </div>
   </div>
</div>

<div class="modal fade" id="modal-delete-product" tabindex="-1" role="dialog" aria-labelledby="modal-delete" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
      <div class="modal-content">
         <div class="modal-header bg-danger">
            <h5 class="modal-title text-white">Modal Delete</h5>
            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">

            <form id="form-delete-product" method="POST">
               <input type="hidden" name="id">
            </form>

            <p>Apakah anda yakin ingin menghapus produk ini ?</p>

         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-danger" form="form-delete-product">Hapus</button>
         </div>
      </div>
   </div>
</div>

<div class="modal fade" id="modal-add-stok" tabindex="-1" role="dialog" aria-labelledby="modal-delete" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
      <div class="modal-content">
         <div class="modal-header bg-primary">
            <h5 class="modal-title text-white">Modal Tambah Stok</h5>
            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">

            <form id="form-add-stok" method="POST">
               <input type="hidden" name="id">
               <div class="form-group">
                  <label for="">Stok</label>
                  <input type="number" name="stok" class="form-control" placeholder="15" min="1">
               </div>
            </form>

         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" form="form-add-stok">Tambah</button>
         </div>
      </div>
   </div>
</div>