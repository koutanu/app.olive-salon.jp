<div class="main-section stock-detail">
    <div class="close-wrap">
        <i class="fas fa-caret-left history_back open"></i>
    </div>
    <div class="main-wrapper">
        <div class="main-top">
            <p><?= $this->stock[0]['name']; ?></p>
            <p>基本売値</p>
            <input type="text" class="price" value="<?= $this->h($this->stock[0]['price']); ?>" inputmode="numeric">
            <input type="hidden" class="products_id" value="<?= $this->h($this->stock[0]['products_id']); ?>">
            <button type="button" class="btn btn-add save">登録</button>
            <div class="stock-table-wrap">
                <p>仕入記録</p>
                <table class="stock-table">
                    <tr>
                        <th>仕入日</th>
                        <th>仕入個数</th>
                        <th>原価</th>
                        <th>送料(一個当たり)</th>
                    </tr>
                    <?php foreach ($this->stock_delivery as $e) : ?>
                        <tr>
                            <td><?= date('Y年m月d日', strtotime($e['delivery_at'])) ?></td>
                            <td class="text-right"><?= $e['lot'] ?>セット</td>
                            <td class="text-right"><?= number_format($e['cost']) ?>円</td>
                            <td class="text-right"><?= number_format($e['postage_cost'], 2) ?>円</td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        </div>
    </div>
</div>