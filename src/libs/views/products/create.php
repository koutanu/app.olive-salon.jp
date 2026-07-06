<div class="main-section products-create">
    <div class="close-wrap">
        <i class="fas fa-caret-left history_back open"></i>
    </div>
    <div class="main-wrapper">
        <div class="main-top">
            <h2>商品情報</h2>
            <form action="<?= URL ?>products/save" method="post" enctype="multipart/form-data" id="form">
                <p>仕入先</p>
                <select name="supplier_id">
                    <?php foreach ($this->supplier as $value) : ?>
                        <option value="<?= $value['id'] ?>"><?= $value['name']; ?></option>
                    <?php endforeach; ?>
                </select>
                <p>商品名</p>
                <input type="text" name="name" size="50">
                <p>フリガナ</p>
                <input type="text" name="kana" size="50">
                <p>入り数</p>
                <input type="text" name="unit" size="10" value="1">
                <p>販売税率</p>
                <select>
                    <?php foreach ($this->tax_rate as $tax) : ?>
                        <option value="<?= $tax['id']; ?>"><?= $tax['name']; ?></option>
                    <?php endforeach; ?>
                </select>
                <div style="margin-bottom:10px;">
                    <p>画像</p>
                    <input type="file" name="image" id="image" accept="image/png, image/jpeg">
                </div>
                <input type="date" name="created_at" value="<?= date('Y-m-d'); ?>">
                <button type="button" class="btn btn-add save">登録する</button>
                <input type="hidden" name="save_flag" value="create">
            </form>
        </div>
    </div>
</div>