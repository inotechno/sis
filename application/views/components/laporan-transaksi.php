<!-- Page Content  -->
<div id="content-page" class="content-page">
	<div class="container-fluid">
        
        <div class="row">
            <div class="col-md">
                <div class="iq-card">
                    <div class="iq-card-header d-flex justify-content-between">
                        <div class="iq-header-title">
                            <h4 class="card-title">Filter</h4>
                        </div>
                    </div>
                    <div class="iq-card-body">
                        <form id="form-export" action="<?= site_url('Laporan/ReportTransaction') ?>" method="POST">
                            <div class="row">
                                <div class="col-md">
                                    <div class="form-group">
                                        <label for="start_date">Start Date</label>
                                        <input type="date" id="start_date" name="start_date" class="form-control" required>
                                    </div>
                                </div>

                                <div class="col-md">
                                    <div class="form-group">
                                        <label for="end_date">End Date</label>
                                        <input type="date" id="end_date" name="end_date" class="form-control" required>
                                    </div>
                                </div>   
                            </div>
                        </form>

                        <div class="row">
                            <div class="col-md text-right">
                                <button id="btn-filter" type="submit" class="btn btn-rounded btn-primary">Filter</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      
        <div class="row">
            <div class="col-md">
                <div class="iq-card">
                    <div class="iq-card-header d-flex justify-content-between">
                        <div class="iq-header-title">
                            <h4 class="card-title">Preview</h4>
                        </div>
                        <div class="iq-card-header-toolbar d-flex align-items-center">
                            
                            <button type="submit" form="form-export" class="float-right btn btn-sm btn-primary" id="btn-export">Download</button>

                        </div>
                    </div>
                    <div class="iq-card-body">
                        <table id="table-report" class="table table-flush">
                            <thead>
                                <th>No</th>
                                <th>No Order</th>
                                <th>Nama Santri</th>
                                <th>Wali Santri</th>
                                <th>Jumlah</th>
                                <th>Bank</th>
                                <th>Bank Account</th>
                                <th>Status</th>
                                <th>Created At</th>
                                <th>Jenis Transaksi</th>
                            </thead>
                            <tbody id="table-body-report">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
	</div>
</div>
