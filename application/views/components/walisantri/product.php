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