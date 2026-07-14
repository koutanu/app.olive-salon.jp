<div class="main-section customer">
    <div class="close-wrap">
        <button type="button" class="history_back open" aria-label="戻る"><i class="fas fa-caret-left" aria-hidden="true"></i></button>
    </div>
    <div class="main-wrapper">
        <div class="main-top">
            <div class="customer-summary">
                <p class="customer-count">総顧客数：<?= count($this->customer); ?>人</p>
            </div>

            <div class="customer-highlights">
                <div class="highlight-panel">
                    <h3 class="highlight-title">本日予約</h3>
                    <div class="highlight-list">
                        <?php if (!empty($this->today_customer)) : ?>
                            <?php foreach ($this->today_customer as $value) : ?>
                                <button type="button" class="select_customer btn btn-add btn-customer" data-customer-id="<?= (int)$value['customer_id'] ?>">
                                    <?= $this->h($value['name']); ?>
                                </button>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <p class="highlight-empty">該当なし</p>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="highlight-panel">
                    <h3 class="highlight-title">今月が誕生日</h3>
                    <div class="highlight-list">
                        <?php if (!empty($this->birthday_customer)) : ?>
                            <?php foreach ($this->birthday_customer as $value) : ?>
                                <button type="button" class="select_customer btn btn-add btn-customer" data-customer-id="<?= (int)$value['id'] ?>">
                                    <?= $this->h($value['name'] . ' / ' . $value['month'] . '月' . $value['day'] . '日'); ?>
                                </button>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <p class="highlight-empty">該当なし</p>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="highlight-panel">
                    <h3 class="highlight-title">来月が誕生日</h3>
                    <div class="highlight-list">
                        <?php if (!empty($this->birthday_customer_nextmonth)) : ?>
                            <?php foreach ($this->birthday_customer_nextmonth as $value) : ?>
                                <button type="button" class="select_customer btn btn-add btn-customer" data-customer-id="<?= (int)$value['id'] ?>">
                                    <?= $this->h($value['name'] . ' / ' . $value['month'] . '月' . $value['day'] . '日'); ?>
                                </button>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <p class="highlight-empty">該当なし</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="customer-search-wrap">
                <label class="search-label" for="customer_search_name">顧客検索</label>
                <div class="search-row">
                    <input type="text" id="customer_search_name" class="name" placeholder="名前・カナで検索">
                    <button type="button" id="search" class="btn btn-add">検索する</button>
                </div>
            </div>

            <div class="initial-wrap" role="group" aria-label="頭文字検索">
                <?php foreach (Util::getNameInitialList() as $value) : ?>
                    <?php
                    $flag = false;
                    foreach (preg_split("//u", "あかさたなはまやらわ", -1, PREG_SPLIT_NO_EMPTY) as $initial) {
                        if ($value == $initial) {
                            $flag = true;
                            break;
                        }
                    }
                    ?>
                    <button type="button" class="select_initial initial-chip <?= ($flag == true) ? 'is-row-head text-orange' : ''; ?>" data-initial="<?= $this->h($value); ?>"><?= $this->h($value); ?></button>
                <?php endforeach; ?>
            </div>

            <div class="visit-legend" aria-label="来店状況の凡例">
                <span class="legend-item"><span class="legend-swatch visit-recent"></span>半年以内</span>
                <span class="legend-item"><span class="legend-swatch visit-year"></span>1年以内</span>
                <span class="legend-item"><span class="legend-swatch visit-old"></span>1年以上前</span>
                <span class="legend-item"><span class="legend-swatch visit-none"></span>来店なし</span>
            </div>

            <div class="customer-wrap">
                <?php foreach ($this->customer as $value) : ?>
                    <?php
                    $visitClass = 'visit-old';
                    if (!$value['last_visit_date']) {
                        $visitClass = 'visit-none';
                    } elseif ($value['last_visit_date'] > date('Y-m-d H:i:s', strtotime('-6 month'))) {
                        $visitClass = 'visit-recent';
                    } elseif ($value['last_visit_date'] > date('Y-m-d H:i:s', strtotime('-12 month'))) {
                        $visitClass = 'visit-year';
                    }
                    ?>
                    <button type="button" class="select_customer btn btn-add btn-customer <?= $visitClass; ?>" data-customer-id="<?= (int)$value['id'] ?>">
                        <?= $this->h($value['name']); ?>
                    </button>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="main-bottom"></div>
    </div>
</div>
