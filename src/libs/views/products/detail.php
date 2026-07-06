<div class="main-section products-detail">
    <div class="close-wrap">
        <i class="fas fa-caret-left history_back open"></i>
    </div>
    <div class="main-wrapper">
        <div class="main-top">
            <div style="float:right;">
                <button type="button" class="btn btn-add save">更新する</button>
                <button type="button" class="btn btn-delete delete">削除する</button>
            </div>
            <h2>商品情報</h2>
            <form action="<?= URL ?>products/save" method="post" enctype="multipart/form-data" id="form">
                <div class="d-flex gap-10px">
                    <div>
                        <p>登録日</p>
                        <p><?= date('Y年m月d日', strtotime($this->products['created_at'])); ?></p>
                    </div>
                    <div>
                        <p>更新日</p>
                        <p><?= (!is_null($this->products['updated_at'])) ? date('Y年m月d日', strtotime($this->products['updated_at'])) : ''; ?></p>
                    </div>
                </div>
                <div>
                    <img src="<?= URL . 'images/'; ?><?= (!empty($this->products['image1_link'])) ? 'products/' . $this->products['image1_link'] : 'base/image_not_found.webp'; ?>" class="products-image">
                </div>
                <input type="file" name="image" id="image" accept="image/png, image/jpeg">
                <input type="hidden" name="image1_link" value="<?= $this->products['image1_link'] ?>">
                <p>仕入先</p>
                <select name="supplier_id">
                    <?php foreach ($this->supplier as $value) : ?>
                        <option value="<?= $value['id'] ?>" <?= ($this->products['supplier_id'] == $value['id']) ? 'selected' : ''; ?>><?= $value['name']; ?></option>
                    <?php endforeach; ?>
                </select>
                <p>商品名</p>
                <input type="text" name="name" size="50" value="<?= $this->products['name']; ?>">
                <p>フリガナ</p>
                <input type="text" name="kana" size="50" value="<?= $this->products['kana']; ?>">
                <p>入り数</p>
                <input type="text" name="unit" size="10" value="<?= $this->products['unit']; ?>">
                <p>仕入値</p>
                <input type="text" name="price" size="10" value="<?= $this->products['price']; ?>">
                <p>販売税率</p>
                <select name="tax_id">
                    <?php foreach ($this->tax as $tax) : ?>
                        <option value="<?= $tax['id'] ?>" <?= ($this->products['tax_id'] == $tax['id']) ? 'selected' : ''; ?>><?= $tax['name']; ?></option>
                    <?php endforeach; ?>
                </select><br>
                <input type="date" name="updated_at" value="<?= date('Y-m-d'); ?>" style="margin-top:5px;">
                <button type="button" class="btn btn-add save">更新する</button>
                <input type="hidden" name="id" id="id" value="<?= $this->products['id']; ?>">
                <input type="hidden" name="save_flag" value="update">
            </form>
        </div>
    </div>
</div>