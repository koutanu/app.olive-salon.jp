<input type="hidden" id="age_group" value="<?= $this->jsonAttr($this->age_group); ?>">
<div class="main-section products">
    <div class="close-wrap">
        <i class="fas fa-caret-left history_back open"></i>
    </div>
    <div class="main-wrapper">
        <div class="main-top">
            <?php foreach ($this->products as $value) : ?>
                <div class="products-wrap select_products" data-products-id="<?= $value['id'] ?>">
                    <p><?= (mb_strlen($value['name']) >= 12) ? mb_substr($value['name'], 0, 11) . '...' : $value['name']; ?></p>
                    <img src="<?= URL . 'images/'; ?><?= (!empty($value['image1_link'])) ? 'products/' . $value['image1_link'] : 'base/image_not_found.webp'; ?>" class="products-image">
                </div>
            <?php endforeach; ?>
        </div>
        <div class="main-bottom">

        </div>
    </div>
</div>