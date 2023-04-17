<!-- Page Content  -->
<div id="content-page" class="content-page">
    <div class="container-fluid">

        <div class="row mb-3">
            <div class="col-md text-right">
                <button type="button" class="btn btn-primary btn-lg" id="btn-add"><i class="ri-add-line"></i> Tambah</button>
            </div>
        </div>


        <div class="row" id="category-list">
        </div>
    </div>
</div>

<div class="modal fade" id="modal-add" tabindex="-1" role="dialog" aria-labelledby="modal-add" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white">Modal Tambah</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <form id="form-add" method="POST">
                    <div class="form-group">
                        <input type="text" id="title" name="title" class="form-control" placeholder="Title">
                    </div>

                    <div class="form-group">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="customFile">
                            <label class="custom-file-label" for="customFile">Pilih Gambar</label>
                        </div>
                    </div>
                </form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" form="form-add">Save</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-update" tabindex="-1" role="dialog" aria-labelledby="modal-update" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title" id="modalTitleUpdate">Modal Update</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <form id="form-update" method="POST">
                    <input type="hidden" name="id">
                    <div class="form-group">
                        <input type="text" name="title" class="form-control" placeholder="Title">
                    </div>

                    <div class="form-group">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="customFile">
                            <label class="custom-file-label" for="customFile">Pilih Gambar</label>
                        </div>
                    </div>
                </form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" form="form-update">Save</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-delete" tabindex="-1" role="dialog" aria-labelledby="modal-delete" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title text-white">Modal Delete</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <form id="form-delete" method="POST">
                    <div class="form-group">
                        <input type="hidden" name="id">
                    </div>
                    <p>Apakah anda yakin ingin menghapus kategori ini ?</p>
                </form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-danger" form="form-delete">Delete</button>
            </div>
        </div>
    </div>
</div>