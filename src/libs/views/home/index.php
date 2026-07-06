<input type="hidden" id="grossprofit_graph_data" value='<?= $this->grossprofit_graph; ?>'>
<input type="hidden" id="menu_graph_data" value='<?= $this->menu_graph; ?>'>
<input type="hidden" id="products_graph_data" value='<?= $this->products_graph; ?>'>
<input type="hidden" id="purchase_price" value='<?= $this->purchase_price; ?>'>
<input type="hidden" id="age_group_data" value='<?= $this->age_group; ?>'>
<input type="hidden" id="products_monthly" value='<?= $this->products_monthly; ?>'>
<div class="main-section home">
    <div class="close-wrap">
        <i class="fas fa-caret-left history_back open"></i>
    </div>
    <div class="main-wrapper">
        <div class="main-top">
            <div class="graph-wrap">
                <div class="grossprofit-graph">
                    <canvas id="grossprofit_graph" class="canvas"></canvas>
                </div>
                <div class="menu-graph">
                    <canvas id="menu_graph" class="canvas"></canvas>
                </div>
                <div class="age-group canvas-container">
                    <canvas id="age_group" class="canvas"></canvas>
                </div>
                <div class="products-graph">
                    <canvas id="products_graph" class="canvas"></canvas>
                </div>
                <!-- <div class="purchase-price-graph">
                    <canvas id="purchase_price_graph" class="canvas"></canvas>
                </div> -->
                <div class="products-group">
                    <p>今月売上個数</p>
                    <input type="month" class="products_date" value="<?= date('Y-m') ?>">
                    <div class="prodcuts_item_wrap">

                    </div>
                </div>
                <div class="table-ave-wrap">
                    <p>直近1年間の平均</p>
                    <table class="table-ave">
                        <tr>
                            <th>総粗利</th>
                            <td><?= number_format($this->ave_grossprofit); ?>円</td>
                        </tr>
                        <tr>
                            <th>施術売上</th>
                            <td><?= number_format($this->ave_menu); ?>円</td>
                        </tr>
                        <tr>
                            <th>商品売り上げ</th>
                            <td><?= number_format($this->ave_products); ?>円</td>
                        </tr>
                    </table>
                    <!-- <p>総粗利：<?= number_format($this->ave_grossprofit); ?>円</p>
                    <p>施術売上：<?= number_format($this->ave_menu); ?>円</p>
                    <p>商品売り上げ：<?= number_format($this->ave_products); ?>円</p> -->
                </div>
                <div>
                    <p>年間総売上</p>
                    <p style="font-size:2rem;color:#1e88e5;"><?= number_format($this->total_sales); ?>円</p>
                </div>
            </div>
        </div>
        <!-- <div class="main-bottom">
            <div class="registration-wrap">
                <div class="stock-wrap">
                    <h2>Products Stock</h2>
                    <?php foreach ($this->stock as $stock) : ?>
                        <button class="btn btn-add select_stock" data-id="<?= $stock['id']; ?>"><?= $stock['name']; ?>/<?= $stock['price'] ?>円/<?= $stock['cost'] ?>%</button>
                    <?php endforeach; ?>
                    <a href="<?= URL . 'stock/create'; ?>"><button class="btn btn-create">追加</button></a>
                </div>
            </div>
        </div> -->
    </div>
</div>