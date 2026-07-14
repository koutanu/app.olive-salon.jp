<input type="hidden" id="grossprofit_graph_data" value="<?= $this->jsonAttr($this->grossprofit_graph); ?>">
<input type="hidden" id="menu_graph_data" value="<?= $this->jsonAttr($this->menu_graph); ?>">
<input type="hidden" id="products_graph_data" value="<?= $this->jsonAttr($this->products_graph); ?>">
<div class="main-section sales">
    <div class="close-wrap">
        <i class="fas fa-caret-left history_back open"></i>
    </div>
    <div class="main-wrapper">
        <div class="main-top">
            <div>
                <div class="top-btn-wrap">
                    <button type="button" class="btn btn-add bg-blue">売上確認</button>
                    <button type="button" class="btn btn-add sales_create">売上登録</button>
                    <button type="button" class="btn btn-add customer_detail">顧客情報</button>
                </div>
                <div>
                    <input type="hidden" id="id" value="<?= $this->h($this->customer['id']); ?>">
                    <span>名前：<?= $this->customer['name']; ?>/</span>
                    <span>年齢：<?= $this->age; ?>/</span>
                    <span>住所：<?= $this->customer['prefecture'] . $this->customer['city'] . $this->customer['address']; ?></span>
                </div>
                <?php if ($this->last_visit) : ?>
                    <p>前回来店日：<?= $this->last_visit; ?></p>
                <?php endif; ?>
                <div>
                    <p>次回予約日：<?= $this->next_reservation_date; ?></p>
                </div>
                <div>
                    <?php foreach ($this->sales as $value) : ?>
                        <button type="button" class="btn btn-add btn-sales select_sales" data-id="<?= $value['id']; ?>"><?= date('Y年m月d日', strtotime($value['created_at'])); ?></button>
                    <?php endforeach; ?>
                </div>
            </div>
            <div>
                <div class="graph-wrap">
                    <div class="grossprofit-graph">
                        <canvas id="grossprofit_graph" class="canvas"></canvas>
                    </div>
                    <div class="menu-graph">
                        <canvas id="menu_graph" class="canvas"></canvas>
                    </div>
                    <div class="products-graph">
                        <canvas id="products_graph" class="canvas"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>