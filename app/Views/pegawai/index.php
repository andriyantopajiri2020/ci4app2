<?= $this->extend('/layout/template') ?>

<?= $this->section('content') ?>
<div class="container">
    <h2 class="mt-2">Daftar Pegawai</h2>
    <div class="row mt-3 mb-3">
        <div class="col-1">
            <select class="form-control" aria-label="Default select example">
                <option selected value="10">10</option>
                <option value="25">25</option>
                <option value="50">50</option>
                <option value="100">100</option>
            </select>
        </div>
        <div class="col-6"></div>
        <div class="col-4">
            <form action="" method="post">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Masukkan kata kunci pencarion..." name="keyword">
                    <button class="btn btn-outline-secondary" type="submit" id="cari">Cari</button>
                </div>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Alamat</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1 + (6 * ($curentPage - 1)); ?>
                    <?php foreach ($pegawai as $row) : ?>
                        <tr>
                            <th scope="row"><?= $i++ ?></th>
                            <td><?= $row['nama'] ?></td>
                            <td><?= $row['alamat'] ?></td>
                            <td>
                                <a href="" class="btn btn-success">Detail</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?= $pager->links('pegawai', 'pegawai_pagination') ?>
        </div>
    </div>
</div>
<?= $this->endSection() ?>