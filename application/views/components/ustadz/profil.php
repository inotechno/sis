<!-- Page Content  -->
<div id="content-page" class="content-page">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="iq-card">
                    <div class="iq-card-body p-0">
                        <div class="iq-edit-list">
                            <ul class="iq-edit-profile d-flex nav nav-pills">
                                <li class="col-md-6 p-0">
                                    <a class="nav-link active" data-toggle="pill" href="#profil-pengguna">
                                        Profil Pengguna
                                    </a>
                                </li>
                                <li class="col-md-6 p-0">
                                    <a class="nav-link" data-toggle="pill" href="#akun-password">
                                        Akun & Password
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-12">
                <form id="form-update-profil" method="POST" enctype="multipart/form-data">
                    <div class="iq-edit-list-data">
                        <div class="tab-content">
                            <div class="tab-pane fade active show" id="profil-pengguna" role="tabpanel">
                                <div class="iq-card">
                                    <div class="iq-card-header d-flex justify-content-between">
                                        <div class="iq-header-title">
                                            <h4 class="card-title">Profil Pengguna</h4>
                                        </div>
                                    </div>
                                    <div class="iq-card-body">

                                        <div class="row">
                                            <div class="image-upload col-md text-center">
                                                <label for="imageUpdate">
                                                    <img id="previewImg" width="250" height="250" src="https://upload.wikimedia.org/wikipedia/commons/thumb/9/9e/Plus_symbol.svg/1200px-Plus_symbol.svg.png" />
                                                </label>

                                                <input id="imageUpdate" type="file" name="images" onchange="previewImage(this);">
                                            </div>

                                            <div class="col-md">
                                                <div class="form-group">
                                                    <label for="nik">NIK</label>
                                                    <input type="text" class="form-control" name="nik" id="nik" value="">
                                                </div>
                                                <div class="form-group">
                                                    <label for="nip">NIP</label>
                                                    <input type="text" class="form-control" name="nip" id="nip" value="">
                                                </div>
                                                <div class="form-group">
                                                    <label for="name">Nama</label>
                                                    <input type="text" class="form-control" name="name" id="name" value="">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="form-group col-sm-6">
                                                <label for="jenis_kelamin">Jenis Kelamin</label>
                                                <select name="jenis_kelamin" id="" class="form-control">
                                                    <option value="L">Laki-laki</option>
                                                    <option value="P">Perempuan</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-sm-6">
                                                <label for="tempat_lahir">Tempat Lahir</label>
                                                <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir" value="">
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="form-group col-sm-6">
                                                <label for="tanggal_lahir">Tanggal Lahir</label>
                                                <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" value="">
                                            </div>
                                            <div class="form-group col-sm-6">
                                                <label for="phone">Phone</label>
                                                <input type="text" class="form-control phone-mask" id="phone" name="phone" value="">
                                            </div>
                                        </div>

                                    </div>

                                </div>
                            </div>

                            <div class="tab-pane fade" id="akun-password" role="tabpanel">
                                <div class="iq-card">
                                    <div class="iq-card-header d-flex justify-content-between">
                                        <div class="iq-header-title">
                                            <h4 class="card-title">Akun & Password</h4>
                                        </div>
                                    </div>
                                    <div class="iq-card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="email">Email</label>
                                                    <input name="email" class="form-control" readonly>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="password">Password</label>
                                                    <inpput name="password" class="form-control" readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="col-lg-12 mb-4">
                <button type="submit" class="btn btn-success btn-lg col-12" form="form-update-profil">Simpan Profil</button>
            </div>
        </div>
    </div>
</div>