<div class="main-section customer">
    <div class="close-wrap">
        <i class="fas fa-caret-left history_back open"></i>
    </div>
    <div class="main-wrapper">
        <div class="main-top">
            <div class="customer-header">
                <p>総顧客数：<?= count($this->customer); ?>人</p>
                <p>今月が誕生日の人</p>
                <?php foreach ($this->birthday_customer as $value) : ?>
                    <button type="button" class="select_customer btn btn-add" data-customer-id="<?= $value['id'] ?>"><?= $value['name'] . ' / ' . $value['month'] . '月' . $value['day'] . '日'; ?></button>
                <?php endforeach; ?>
                <p>来月が誕生日の人</p>
                <?php foreach ($this->birthday_customer_nextmonth as $value) : ?>
                    <button type="button" class="select_customer btn btn-add" data-customer-id="<?= $value['id'] ?>"><?= $value['name'] . ' / ' . $value['month'] . '月' . $value['day'] . '日'; ?></button>
                <?php endforeach; ?>
                <p>本日予約の人</p>
                <?php if ($this->today_customer) : ?>
                    <?php foreach ($this->today_customer as $value) : ?>
                        <button type="button" class="select_customer btn btn-add" data-customer-id="<?= $value['customer_id'] ?>"><?= $value['name'] ?></button>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
            <div>
                <input type="text" class="name">
                <button type="button" id="search" class="btn btn-add" style="margin-left:5px;">検索する</button>
            </div>
            <div class="initial-wrap">
                <?php foreach (Util::getNameInitialList() as $value) : ?>
                    <?php $flag = false; ?>
                    <?php foreach (preg_split("//u", "あかさたなはまやらわ") as $initial) : ?>
                        <?php if ($value == $initial) : ?>
                            <?php $flag = true; ?>
                        <?php endif; ?>
                    <?php endforeach; ?>
                    <span class="select_initial <?= ($flag == true) ? 'text-orange' : ''; ?>" data-initial="<?= $value; ?>"><?= $value; ?></span>
                <?php endforeach; ?>
            </div>
            <p>※青色 = 半年以内に来たことがある人</p>
            <p>※濃い青色 = 1年以内に来たことがある人</p>
            <div class="customer-wrap">
                <?php foreach ($this->customer as $value) : ?>
                    <div>
                        <?php if (!$value['last_visit_date']) : ?>
                            <button type="button" class="select_customer btn btn-add" style="opacity:0.3" data-customer-id="<?= $value['id'] ?>"><?= $value['name']; ?></button>
                        <?php elseif ($value['last_visit_date'] > date('Y-m-d H:i:s', strtotime('-6 month'))) : ?>
                            <button type="button" class="select_customer btn btn-add bg-blue" data-customer-id="<?= $value['id'] ?>"><?= $value['name']; ?></button>
                        <?php elseif ($value['last_visit_date'] > date('Y-m-d H:i:s', strtotime('-12 month'))) : ?>
                            <button type="button" class="select_customer btn btn-add" style="background:#154594;" data-customer-id="<?= $value['id'] ?>"><?= $value['name']; ?></button>
                        <?php else : ?>
                            <button type="button" class="select_customer btn btn-add" data-customer-id="<?= $value['id'] ?>"><?= $value['name']; ?></button>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="main-bottom">

        </div>
    </div>
</div>