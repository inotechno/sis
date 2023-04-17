<!-- Page Content  -->
<div id="content-page" class="content-page">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card-columns" id="rombel-list">

                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-add-anggota" tabindex="-1" role="dialog" aria-labelledby="modal-add" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white">Tambah Anggota <span class="nama_kelas"></span></h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <form id="form-add-anggota" method="POST">
                    <div class="row">
                        <div class="col-md">
                            <input type="text" class="form-control col-3 form-control-sm" placeholder="Search nis ..." id="search-anggota">
                            <table id="table-add-anggota" class="table table-striped mt-4" role="grid" aria-describedby="user-list-page-info">
                                <thead>
                                    <tr>
                                        <th>Nama Santri</th>
                                        <th>NIS</th>
                                        <th>Check</th>
                                    </tr>
                                </thead>
                                <tbody id="table-body-add-anggota">

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <input type="hidden" name="kelas_id">
                </form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" form="form-add-anggota">Save</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-pindah-anggota" tabindex="-1" role="dialog" aria-labelledby="modal-pindah-anggota" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title" id="modalTitleUpdate">Pindah Rombel</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <form id="form-pindah-anggota" method="POST">
                    <input type="hidden" name="id">
                    <input type="hidden" name="santri_id">
                    <div class="row">
                        <div class="col-md">
                            <div class="form-group">
                                <label for="nama_santri">Nama Lengkap</label>
                                <input type="text" name="nama_santri" class="form-control" readonly>
                            </div>
                        </div>

                        <div class="col-md">
                            <div class="form-group">
                                <label for="select-kelas">Pilih Kelas</label>
                                <select name="kelas_id" id="select-kelas" class="form-control select2 select-kelas" style="width: 100%;"></select>
                            </div>
                        </div>
                    </div>

                </form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-warning" form="form-pindah-anggota">Pindahkan</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-keluar-anggota" tabindex="-1" role="dialog" aria-labelledby="modal-keluar-anggota" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title text-white">Keluarkan Anggota</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <form id="form-keluar-anggota" method="POST">
                    <div class="form-group">
                        <input type="hidden" name="santri_id">
                    </div>
                    <p>Apakah anda yakin ingin mengeluarkan <span class="nama_santri"></span> dari rombel ini ?</p>
                </form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-danger" form="form-keluar-anggota">Keluarkan</button>
            </div>
        </div>
    </div>
</div>