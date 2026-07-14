<input type="hidden" id="id" value="<?= $this->h($this->sales['id']); ?>">
<input type="hidden" id="customer_id" value="<?= $this->h($this->sales['customer_id']); ?>">
<div class="main-section sales-detail">
    <div class="close-wrap">
        <i class="fas fa-caret-left history_back open"></i>
    </div>
    <div class="main-wrapper">
        <div>
            <div class="top-btn-wrap">
                <button type="button" class="btn btn-add sales">売上確認</button>
                <button type="button" class="btn btn-add sales">戻る</button>
                <button type="button" class="btn btn-delete delete">削除する</button>
            </div>
            <div>
                <p><?= $this->h($this->sales['customer_name']); ?></p>
                <p>来店日&emsp;：<?= date('Y年m月d日', strtotime($this->sales['created_at'])); ?></p>
                <?php if ($this->sales['next_reservation_flag'] == 1) : ?>
                    <span>次回予約：</span><input type="date" class="reservation_date" value="<?= date('Y-m-d', strtotime($this->sales['next_reservation_date'])); ?>">
                <?php else : ?>
                    <p>次回予約：なし</p>
                <?php endif; ?>
                <button class="btn-add change_reservation">次回予約変更</button>
                <?php if ($this->sales['cancel_flag'] == 1) : ?>
                    <button class="btn-add bg-orange cancel" data-flag="<?= $this->sales['cancel_flag']; ?>">キャンセルを取り消す</button>
                <?php else : ?>
                    <button class="btn-add bg-orange cancel" data-flag="<?= $this->sales['cancel_flag']; ?>">キャンセル</button>
                <?php endif; ?>
            </div>
            <div class="mt-10px">
                <div>
                    <div>
                        <p><?= $this->sales['menu_name']; ?>コース</p>
                        <?php if ($this->menu_option) : ?>
                            <ul>オプション：
                                <?php foreach ($this->menu_option as $value) : ?>
                                    <li><?= $this->h($value['name']); ?></li>
                                <?php endforeach; ?>
                            </ul>
                        <?php else : ?>
                            <p>オプション：なし</p>
                        <?php endif; ?>
                        <p class="mt-10px">初回割引額：<?= number_format($this->sales['first_discount']); ?>円</p>
                        <p>予約割引額：<?= number_format($this->sales['reservation_discount']); ?>円</p>
                        <p>その他割引額：<?= number_format($this->sales['other_discount']); ?>円</p>
                        <p>施術売上：<?= number_format($this->sales['sales']); ?>円</p>
                    </div>
                </div>
            </div>
            <div class="mt-10px">
                <p>売上商品</p>
                <table class="products-table">
                    <tr>
                        <th>商品名</th>
                        <th>売上(税込)</th>
                        <th>送料原価</th>
                        <th>販売個数</th>
                    </tr>
                    <?php $products_sales = 0; ?>
                    <?php $products_sales_and_tax = 0; ?>
                    <?php $cost = 0; ?>
                    <?php foreach ($this->products as $product) : ?>
                        <?php $products_sales_and_tax += $product['price'] * (1 + (0.01 * $product['tax_rate'])); ?>
                        <?php $products_sales += $product['price']; ?>
                        <?php
                        if ($product['unit'] > 1) {
                            $cost += ($product['cost'] / $product['unit']) + ($product['postage_cost'] / $product['unit']);
                        } else {
                            $cost += ($product['cost'] * $product['lot']) + ($product['postage_cost'] * $product['lot']);
                        }
                        ?>
                        <tr>
                            <td><?= $product['name']; ?></td>
                            <td><?= number_format($product['price'] * (1 + (0.01 * $product['tax_rate']))); ?>円</td>
                            <?php if ($product['unit'] > 0) : ?>
                                <td><?= number_format($product['postage_cost'] / $product['unit'], 2); ?>円</td>
                            <?php else : ?>
                                <td><?= number_format($product['postage_cost'] * $product['lot'], 2); ?>円</td>
                            <?php endif; ?>
                            <?php if ($product['unit'] > 0) : ?>
                                <td><?= $product['lot'] ?>セット <?= $product['unit']; ?>個</td>
                            <?php else : ?>
                                <td><?= $product['lot'] ?>セット</td>
                            <?php endif; ?>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
            <div class="mt-10px">
                <p>商品売り上げ：<?= number_format($products_sales_and_tax); ?>円</p>
                <p>商品粗利：<?= number_format($products_sales - $cost, 2); ?>円</p>
            </div>
            <div>
                <p>総売上</p>
                <p>施術売上+商品売上 = <?= number_format($this->sales['sales'] + $products_sales_and_tax) ?>円</p>
            </div>
            <?php if ($this->sales['paypay_flag'] == 1) : ?>
                <div class="mt-10px">
                    <p>支払方法</p>
                    <p>paypay</p>
                </div>
            <?php endif; ?>
        </div>
        <div class="karte-wrap">
            <p>カルテ</p>
            <textarea><?= $this->h($this->sales['karte']); ?></textarea>
        </div>
    </div>
</div>