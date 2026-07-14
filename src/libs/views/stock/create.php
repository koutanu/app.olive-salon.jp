<input type="hidden" class="tax_rate" value="<?= $this->jsonAttr($this->tax_rate); ?>">
<div class="main-section stock-create">
    <div class="close-wrap">
        <i class="fas fa-caret-left history_back open"></i>
    </div>
    <form action="<?= URL ?>stock/save" method="post" id="form">
        <div class="main-wrapper">
            <div class="main-top">
                <div class="top-btn-wrap">
                    <button type="button" class="btn btn-add save">登録する</button>
                </div>
                <div>
                    <P>仕入日</P>
                    <input type="date" name="delivery_at" class="delivery_at" value="<?= date('Y-m-d'); ?>">
                    <p>仕入先</p>
                    <select name="supplier_id" class="supplier_select">
                        <?php foreach ($this->supplier as $value) : ?>
                            <option value="<?= (int)$value['id']; ?>"><?= $this->h($value['name']); ?></option>
                        <?php endforeach; ?>
                    </select>
                    <p>送料</p>
                    <input name="postage" class="postage" value="0">
                    <p>仕入値合計</p>
                    <input name="total_price" class="total_price" value="0" readonly>
                    <div class="products-wrap">
                        <!-- 商品 -->
                    </div>
                </div>
                <div class="stock-products-wrap">
                    <div class="stock-item-wrap">
                        <!-- 選択商品 -->
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>