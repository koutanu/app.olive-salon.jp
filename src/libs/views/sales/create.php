<input type="hidden" class="tax_rate" value='<?= $this->tax_rate; ?>'>
<div class="main-section sales-create">
    <div class="close-wrap">
        <i class="fas fa-caret-left history_back open"></i>
    </div>
    <form action="<?= URL ?>sales/save" method="post" id="form">
        <div class="main-wrapper">
            <div class="main-left">
                <div class="top-btn-wrap">
                    <button type="button" class="btn btn-add sales">売上確認</button>
                    <button type="button" class="btn btn-add bg-blue">売上登録</button>
                    <button type="button" class="btn btn-add customer_detail">顧客情報</button>
                </div>
                <div>
                    <span>名前：<?= $this->customer['name']; ?>/</span>
                    <span>年齢：<?= $this->age; ?>/</span>
                    <span>住所：<?= $this->customer['prefecture'] . $this->customer['city'] . $this->customer['address']; ?></span>
                    <div>
                        <span>来店日：</span>
                        <input type="date" name="created_at" class="created_at" value="<?= date('Y-m-d'); ?>">
                        <p>メニュー</p>
                        <?php foreach ($this->menu_list as $value) : ?>
                            <button type="button" class="btn btn-add menu-select menu_select" data-price="<?= $value['price'] ?>" data-id="<?= $value['id'] ?>" data-discount="<?= $value['first_time_discount'] ?>"><?= $value['name']; ?></button>
                        <?php endforeach; ?>
                        <p>オプション</p>
                        <div class="menu-option-wrap">
                            <?php foreach ($this->option_list as $key => $value) : ?>
                                <div>
                                    <input type="checkbox" name="menu_option[]" class="menu_option" value="<?= $value['id'] ?>" style="display:none;">
                                    <button type="button" class="btn btn-add option-select option_select" data-price="<?= $value['price'] ?>"><?= $value['name']; ?></button>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <div style="margin-top:5px">
                            <input type="checkbox" id="first_time_check" class="first_time_check"><label for="first_time_check" class="first_time_check">初回価格</label>
                            <p>初回割引</p>
                            <input type="text" name="first_discount" class="menu_first_discount menu_input" value="0" readonly>
                        </div>
                        <div class="d-flex gap-5px" style="margin-top:5px;">
                            <div>
                                <p>予約割引</p>
                                <input type="text" name="reservation_discount" class="menu_reservation_discount menu_input" value="<?= $this->reservation_discount; ?>">
                            </div>
                            <!-- <div>
                                <p>誕生日割引</p>
                                <input type="text" name="birthday_discount" class="birthday_discount menu_input" value="<?= $this->birthday_discount; ?>">
                            </div> -->
                            <div>
                                <p>割引(その他)</p>
                                <input type="text" name="other_discount" class="menu_other_discount menu_input" value="0">
                            </div>
                        </div>
                        <p>割引合計</p>
                        <input type="text" class="menu_total_discount" value="0" readonly>
                        <p>施術売上 - 割引合計</p>
                        <input type="text" name="sales" class="menu_sales" value="0" readonly>
                        <input type="hidden" class="original_sales">
                        <input type="hidden" class="first_time_discount">
                        <input type="hidden" class="menu_id" name="menu_id">
                        <div class="save-btn-wrap">
                            <input type="checkbox" name="next_reservation_flag" value="1" id="next_reservation_flag"><label for="next_reservation_flag">次回予約日</label>
                            <input type="date" name="next_reservation_date" class="next_reservation_date" value="" disabled>
                            <input type="checkbox" name="paypay_flag" value="1" id="paypay_flag"><label for="paypay_flag">PayPay支払い</label>
                            <button type="button" class="btn btn-add save bg-orange">登録する</button>
                            <input type="hidden" name="customer_id" id="customer_id" value="<?= $this->customer['id']; ?>">
                        </div>
                    </div>
                </div>
                <div class="karte-wrap">
                    <p>カルテ</p>
                    <div class="textarea-wrap">
                        <textarea type="text" name="karte"></textarea>
                    </div>
                </div>
            </div>
            <div class="main-right">
                <div class="products-wrap">
                    <p>商品売り上げ</p>
                    <div class="stock-wrap">
                        <?php foreach ($this->stock as $stock) : ?>
                            <div class="stock-item-wrap select_products" id="select_products_<?= $stock['id']; ?>">
                                <p class="stock_name"><?= $stock['name']; ?></p>
                                <p>在庫数：<?= $stock['lot']; ?>セット
                                    <?php if ($stock['unit'] > 0) : ?>
                                        (バラ)<?= $stock['unit'] ?>個
                                    <?php endif; ?>
                                </p>
                                <input type="hidden" class="products_id" value="<?= $stock['products_id']; ?>">
                                <input type="hidden" class="stock_id" value="<?= $stock['id']; ?>">
                                <input type="hidden" class="stock_lot" value="<?= $stock['lot']; ?>">
                                <input type="hidden" class="stock_unit" value="<?= $stock['unit']; ?>">
                                <input type="hidden" class="max_unit" value="<?= $stock['max_unit']; ?>">
                                <input type="hidden" class="products_unit" value="<?= $stock['products_unit']; ?>">
                                <input type="hidden" class="tax_id" value="<?= $stock['tax_id']; ?>">
                                <input type="hidden" class="price" value="<?= $stock['price']; ?>">
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div id="products_item_wrap" class="products-item-wrap">

                    </div>
                    <p>商品売上</p>
                    <input type="text" name="products_total_sales" id="products_total_sales" value="0" readonly>
                    <!-- <p>商品粗利</p>
                    <input type="text" name="products_total_gross_profit" id="products_total_gross_profit" value="0" readonly> -->
                </div>
            </div>
        </div>
    </form>
</div>