<div class="main-section stock">
    <div class="close-wrap">
        <i class="fas fa-caret-left history_back open"></i>
    </div>
    <div class="main-wrapper">
        <div class="main-top">
            <?php foreach ($this->stock as $stock) : ?>
                <div class="products-wrap select_stock" data-id="<?= $stock['products_id']; ?>">
                    <img src="<?= URL . 'images/'; ?><?= (!empty($stock['image1_link'])) ? 'products/' . $stock['image1_link'] : 'base/image_not_found.webp'; ?>" class="products-image">
                    <div class="stock-text-wrap">
                        <p><?= (mb_strlen($stock['name']) >= 12) ? mb_substr($stock['name'], 0, 11) . '...' : $stock['name']; ?></p>
                        <p>在庫数：<?= $stock['lot']; ?>セット
                            <?php if ($stock['unit'] > 0) : ?>
                                <span>(バラ)<?= $stock['unit'] ?>個</span>
                            <?php endif; ?>
                        </p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>