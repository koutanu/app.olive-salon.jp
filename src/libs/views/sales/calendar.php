<?php

// 現在の年月を取得
$year = $this->year;
$month = $this->month;

// 月末日を取得
$last_day = date('t', strtotime($year . '-' . $month . '-01'));

$calendar = array();
$j = 0;

// 月末日までループ
for ($i = 1; $i < $last_day + 1; $i++) {

    // 曜日を取得
    $week = date('w', mktime(0, 0, 0, $month, $i, $year));

    // 1日の場合
    if ($i == 1) {

        // 1日目の曜日までをループ
        for ($s = 1; $s <= $week; $s++) {

            // 前半に空文字をセット
            $calendar[$j]['day'] = '';
            $j++;
        }
    }

    // 配列に日付をセット
    $calendar[$j]['day'] = $i;
    $j++;

    // 月末日の場合
    if ($i == $last_day) {

        // 月末日から残りをループ
        for ($e = 1; $e <= 6 - $week; $e++) {

            // 後半に空文字をセット
            $calendar[$j]['day'] = '';
            $j++;
        }
    }
}
$next_reservation_count = 0; //次回予約人数
$next_reservation_discount = 0; //当月次回予約割引額
$other_reservation_discount = 0; //その他割引額
$visitors_number = 0; //来客数(商品だけ除く)
$total_visitors_number = 0; //来客数
$paypay_count = 0; //paypay数
$total_sales = 0; //総売上高
foreach ($this->sales as $data) {
    if ($data['next_reservation_flag'] == 1 && $data['cancel_flag'] != 1) {
        $next_reservation_count++;
    }
    if ($data['sales'] > 0) {
        $visitors_number++;
    }
    if ($data['paypay_flag'] == 1) {
        $paypay_count++;
    }
    $total_visitors_number++;
    $total_sales += $data['sales'];
    $next_reservation_discount += $data['reservation_discount'];
    $other_reservation_discount += $data['other_discount'];
}
?>
<input type="hidden" id="grossprofit_graph_data" value="<?= $this->jsonAttr($this->grossprofit_graph); ?>">
<input type="hidden" id="menu_graph_data" value="<?= $this->jsonAttr($this->menu_graph); ?>">
<input type="hidden" id="products_graph_data" value="<?= $this->jsonAttr($this->products_graph); ?>">
<div class="main-section calendar">
    <div class="close-wrap">
        <i class="fas fa-caret-left history_back"></i>
    </div>
    <div class="main-wrapper">
        <div class="main-top">
            <div class="calendar-wrap">
                <div>
                    <input type="month" class="select_calendar" value="<?= $year . '-' . $month ?>">
                    <div class="d-flex">
                        <p>来客数(商品のみ除く)：<?= $visitors_number ?>人　</p>
                        <?php if ($next_reservation_count > 0) : ?>
                            <p>次回予約数：<?= $next_reservation_count ?>人　次回予約率：<?= (floor(($next_reservation_count / $visitors_number) * 10000)) / 100 ?>%</p>
                        <?php else : ?>
                            <p>次回予約数：0人</p>
                        <?php endif; ?>
                    </div>
                    <?php if ($total_visitors_number > 0) : ?>
                        <p>粗利：<?= number_format($total_sales + $this->products_grossprofit['products_grossprofit']); ?>円</p>
                        <p>予約割引額合計：<?= number_format($next_reservation_discount) ?>円</p>
                        <p>その他割引額合計：<?= number_format($other_reservation_discount) ?>円</p>
                        <p>paypay<?= $paypay_count ?>回</p>
                        <p>客単価(商品のみ含む)：<?= number_format(($total_sales + $this->products_grossprofit['products_grossprofit']) / $total_visitors_number); ?>円</p>
                    <?php endif; ?>
                    <p><span class="bg-blue">青色</span>=初回の人 ★=予約取ってくれた人 <span class="bg-dot" style="padding:0 2px;">点線</span>=商品のみ</p>
                </div>
                <table class="calendar">
                    <tr>
                        <th>日</th>
                        <th>月</th>
                        <th>火</th>
                        <th>水</th>
                        <th>木</th>
                        <th>金</th>
                        <th>土</th>
                    </tr>
                    <?php $cnt = 1; ?>
                    <?php foreach ($calendar as $key => $value) : ?>
                        <?php if ($cnt == 1 || $cnt % 7 == 1) : ?>
                            <tr>
                            <?php endif; ?>
                            <?php $i = []; ?>
                            <td class="<?= ($year . $month . sprintf('%02d', $value['day']) == date('Ymd')) ? 'bg-side-menu' : ''; ?>">
                                <p class="day"><?= $value['day']; ?></p>
                                <?php foreach ($this->sales as $data) : ?>
                                    <?php if (date('Ymd', strtotime($data['created_at'])) == $year . sprintf('%02d', $month) . sprintf('%02d', $value['day'])) : ?>
                                        <?php if ($data['sales'] == 0) : ?>
                                            <button type="button" class="btn btn-add select_sales bg-dot" data-id="<?= $data['id']; ?>">
                                                <?= $data['name']; ?>
                                                <?php array_push($i, $data['customer_id']) ?>
                                            </button>
                                        <?php else : ?>
                                            <button type="button" class="btn btn-add select_sales <?= ($data['first_discount'] > 0) ? 'bg-blue' : ''; ?>" data-id="<?= $data['id']; ?>">
                                                <?= ($data['next_reservation_flag'] == 1 && $data['cancel_flag'] != 1) ? '★' : ''; ?>
                                                <?= $data['name']; ?>
                                                <?php array_push($i, $data['customer_id']) ?>
                                            </button>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                                <?php foreach ($this->reservation_customer as $data) : ?>
                                    <?php if (date('Ymd', strtotime($data['next_reservation_date'])) == $year . sprintf('%02d', $month) . sprintf('%02d', $value['day'])) : ?>
                                        <button type="button" class="btn btn-add select_sales" style="opacity:0.5;" data-id="<?= $data['id']; ?>">
                                            <?= $data['name'] ?>
                                        </button>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                                <?php foreach ($this->cancel_customer as $data) : ?>
                                    <?php if (date('Ymd', strtotime($data['next_reservation_date'])) == $year . sprintf('%02d', $month) . sprintf('%02d', $value['day'])) : ?>
                                        <button type="button" class="btn btn-add select_sales bg-accent" style="opacity:0.5;" data-id="<?= $data['id']; ?>">
                                            <?= $data['name'] ?>
                                        </button>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                                <?php if ($month == date('m')) : ?>
                                    <?php if ($value['day'] == date('d')) : ?>
                                        <?php foreach ($this->today_customer as $customer) : ?>
                                            <?php if ($customer['cancel_flag'] != 1 && !in_array($customer['customer_id'], $i)) : ?>
                                                <button type="button" class="btn btn-add select_sales" style="opacity:0.5;" data-id="<?= (int)$customer['id'] ?>">
                                                    <?= $this->h($customer['name']); ?>
                                                </button>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </td>

                            <?php if ($cnt % 7 == 0) : ?>
                            </tr>
                        <?php endif; ?>
                        <?php $cnt++; ?>
                    <?php endforeach; ?>
                </table>
            </div>
        </div>
    </div>
</div>