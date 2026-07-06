<input type="hidden" id="api" value="<?= MAP_API; ?>">
<div class="main-section customer-detail">
    <div class="close-wrap">
        <i class="fas fa-caret-left history_back open"></i>
    </div>
    <div class="main-wrapper">
        <div class="main-top">
            <div class="top-btn-wrap">
                <button type="button" class="btn btn-add sales">売上確認</button>
                <button type="button" class="btn btn-add sales_create">売上登録</button>
                <button type="button" class="btn btn-add bg-blue">顧客情報</button>
                <div style="float:right;">
                    <button type="button" class="btn btn-add save">更新する</button>
                    <button type="button" class="btn btn-delete delete">削除する</button>
                </div>
            </div>
            <form action="<?= URL ?>customer/save" method="post" id="form">
                <div class="customer-detail-wrap">
                    <div class="section">
                        <h2>基本情報</h2>
                        <div class="d-flex gap-10px">
                            <p>登録日</p>
                            <input type="date" name="created_at" value="<?= date('Y-m-d', strtotime($this->customer['created_at'])); ?>">
                            <p>更新日：<?= date('Y/m/d', strtotime($this->customer['updated_at'])); ?></p>
                            <div>
                                <button type="button" class="btn btn-add btn_map bg-orange">Google map</button>
                                <input type="hidden" class="lat" value="<?= $this->customer['lat'] ?>">
                                <input type="hidden" class="lng" value="<?= $this->customer['lng'] ?>">
                            </div>
                        </div>
                        <div class="name-wrap">
                            <div>
                                <p>名前</p>
                                <input type="text" name="name" value="<?= $this->customer['name']; ?>">
                            </div>
                            <div>
                                <p>フリガナ(全角カタカナ)</p>
                                <input type="text" name="kana" value="<?= $this->customer['kana']; ?>">
                            </div>
                        </div>
                        <div class="d-flex gap-5px">
                            <div>
                                <p>生年月日</p>
                                <select name="year" class="birthday year" data-yyyy="<?= date('Y'); ?>-<?= date('Y') - 120; ?>" data-year="<?= $this->customer['year'] ?>"></select>
                                <select name="month" class="birthday month">
                                    <?php for ($i = 1; $i <= 12; $i++) : ?>
                                        <option value="<?= $i; ?>" <?= ($this->customer['month'] == $i) ? 'selected' : ''; ?>><?= $i ?>月</option>
                                    <?php endfor; ?>
                                </select>
                                <select name="day" class="birthday day">
                                    <?php for ($i = 1; $i <= 31; $i++) : ?>
                                        <option value="<?= $i; ?>" <?= ($this->customer['day'] == $i) ? 'selected' : ''; ?>><?= $i ?>日</option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                            <div>
                                <p>年齢</p>
                                <input type="text" value="<?= $this->age; ?>">
                            </div>
                            <div>
                                <p>性別</p>
                                <input type="hidden" name="sex">
                                <input type="radio" name="sex" id="sex1" value="1" <?= ($this->customer['sex'] == 1) ? 'checked' : '';  ?>><label for="sex1">男性</label>
                                <input type="radio" name="sex" id="sex2" value="2" <?= ($this->customer['sex'] == 2) ? 'checked' : '';  ?>><label for="sex2">女性</label>
                            </div>
                        </div>
                        <div class="address-wrap">
                            <div>
                                <p>〒</p>
                                <input type="text" name="post" id="post" value="<?= $this->customer['post']; ?>">
                            </div>
                            <div>
                                <p>都道府県</p>
                                <input type="text" name="prefecture" id="prefecture" value="<?= $this->customer['prefecture']; ?>">
                            </div>
                            <div>
                                <p>市町村</p>
                                <input type="text" name="city" id="city" value="<?= $this->customer['city']; ?>">
                            </div>
                        </div>
                        <div class="address-wrap">
                            <div>
                                <p>住所</p>
                                <input type="text" name="address" id="address" value="<?= $this->customer['address']; ?>" size="40">
                            </div>
                            <div>
                                <p>マンション</p>
                                <input type="text" name="apartment" id="apartment" value="<?= $this->customer['apartment']; ?>" size="40">
                            </div>
                        </div>
                        <div class="d-flex gap-5px">
                            <div>
                                <p>結婚</p>
                                <input type="hidden" name="civilstatus">
                                <input type="radio" name="civilstatus" id="civilstatus1" value="1" <?= ($this->customer['civilstatus'] == 1) ? 'checked' : '';  ?>><label for="civilstatus1">既婚</label>
                                <input type="radio" name="civilstatus" id="civilstatus2" value="2" <?= ($this->customer['civilstatus'] == 2) ? 'checked' : '';  ?>><label for="civilstatus2">未婚</label>
                            </div>
                            <div>
                                <p>子供</p>
                                <input type="text" name="children" value="<?= $this->customer['children']; ?>" size="40">
                            </div>
                            <div>
                                <p>電話番号</p>
                                <input type="tel" name="tel" value="<?= preg_replace("/(\d{3})(\d{4})(\d{4})/", "$1-$2-$3", $this->customer['tel']); ?>">
                            </div>
                        </div>
                        <div class="d-flex gap-5px">
                            <div>
                                <p>仕事</p>
                                <input type="text" name="work" size="40" value="<?= $this->customer['work']; ?>">
                            </div>
                            <div>
                                <p>趣味</p>
                                <input type="text" name="hobby" size="60" value="<?= $this->customer['hobby']; ?>">
                            </div>
                        </div>
                    </div>
                    <div class="section">
                        <div>
                            <p>きっかけ</p>
                            <!-- null送信用 -->
                            <input type="hidden" name="ad1">
                            <input type="hidden" name="ad2">
                            <input type="hidden" name="ad3">
                            <input type="hidden" name="ad_other">
                            <!-- null送信用 -->
                            <input type="checkbox" name="ad1" id="ad1" value="1" <?= ($this->customer['ad1'] == 1) ? 'checked' : '';  ?>><label for="ad1">紹介</label>
                            <input type="text" name="ad1_text" id="ad1_text" value="<?= $this->customer['ad1_text']; ?>">
                            <input type="checkbox" name="ad2" id="ad2" value="1" <?= ($this->customer['ad2'] == 1) ? 'checked' : '';  ?>><label for="ad2">HP</label>
                            <input type="checkbox" name="ad3" id="ad3" value="1" <?= ($this->customer['ad3'] == 1) ? 'checked' : '';  ?>><label for="ad3">instagram</label>
                            <input type="checkbox" name="ad_other" id="ad_other" value="1" <?= ($this->customer['ad_other'] == 1) ? 'checked' : '';  ?>><label for="ad_other">その他</label>
                            <input type="text" name="ad_other_text" id="ad_other_text" value="<?= $this->customer['ad_other_text']; ?>">
                        </div>
                    </div>
                    <div class="section">
                        <h2>お悩みについて</h2>
                        <div>
                            <p>【あたま】</p>
                            <!-- null送信用 -->
                            <?php foreach (range(1, 4) as $i) : ?>
                                <input type="hidden" name="head<?= $i; ?>">
                            <?php endforeach; ?>
                            <!-- null送信用 -->
                            <input type="checkbox" name="head1" id="head1" value="1" <?= ($this->customer['head1'] == 1) ? 'checked' : '';  ?>><label for="head1">頭痛</label>
                            <input type="checkbox" name="head2" id="head2" value="1" <?= ($this->customer['head2'] == 1) ? 'checked' : '';  ?>><label for="head2">目の疲れ</label>
                            <input type="checkbox" name="head3" id="head3" value="1" <?= ($this->customer['head3'] == 1) ? 'checked' : '';  ?>><label for="head3">めまい</label>
                            <input type="checkbox" name="head4" id="head4" value="1" <?= ($this->customer['head4'] == 1) ? 'checked' : '';  ?>><label for="head4">耳鳴り</label>
                        </div>
                        <div>
                            <p>【おかお】</p>
                            <!-- null送信用 -->
                            <?php foreach (range(1, 6) as $i) : ?>
                                <input type="hidden" name="face<?= $i; ?>">
                            <?php endforeach; ?>
                            <!-- null送信用 -->
                            <input type="checkbox" name="face1" id="face1" value="1" <?= ($this->customer['face1'] == 1) ? 'checked' : '';  ?>><label for="face1">小顔</label>
                            <input type="checkbox" name="face2" id="face2" value="1" <?= ($this->customer['face2'] == 1) ? 'checked' : '';  ?>><label for="face2">たるみ</label>
                            <input type="checkbox" name="face3" id="face3" value="1" <?= ($this->customer['face3'] == 1) ? 'checked' : '';  ?>><label for="face3">しわ</label>
                            <input type="checkbox" name="face4" id="face4" value="1" <?= ($this->customer['face4'] == 1) ? 'checked' : '';  ?>><label for="face4">しみ</label>
                            <input type="checkbox" name="face5" id="face5" value="1" <?= ($this->customer['face5'] == 1) ? 'checked' : '';  ?>><label for="face5">乾燥</label>
                            <input type="checkbox" name="face6" id="face6" value="1" <?= ($this->customer['face6'] == 1) ? 'checked' : '';  ?>><label for="face6">アレルギー</label>
                        </div>
                        <div>
                            <p>【からだ】</p>
                            <!-- null送信用 -->
                            <?php foreach (range(1, 10) as $i) : ?>
                                <input type="hidden" name="body<?= $i; ?>">
                            <?php endforeach; ?>
                            <!-- null送信用 -->
                            <input type="checkbox" name="body1" id="body1" value="1" <?= ($this->customer['body1'] == 1) ? 'checked' : '';  ?>><label for="body1">首こり</label>
                            <input type="checkbox" name="body2" id="body2" value="1" <?= ($this->customer['body2'] == 1) ? 'checked' : '';  ?>><label for="body2">肩こり</label>
                            <input type="checkbox" name="body3" id="body3" value="1" <?= ($this->customer['body3'] == 1) ? 'checked' : '';  ?>><label for="body3">肩の痛み</label>
                            <input type="checkbox" name="body4" id="body4" value="1" <?= ($this->customer['body4'] == 1) ? 'checked' : '';  ?>><label for="body4">腕の痛み</label>
                            <input type="checkbox" name="body5" id="body5" value="1" <?= ($this->customer['body5'] == 1) ? 'checked' : '';  ?>><label for="body5">背中の痛み</label>
                            <input type="checkbox" name="body6" id="body6" value="1" <?= ($this->customer['body6'] == 1) ? 'checked' : '';  ?>><label for="body6">腰痛</label>
                            <input type="checkbox" name="body7" id="body7" value="1" <?= ($this->customer['body7'] == 1) ? 'checked' : '';  ?>><label for="body7">おしりの痛み</label>
                            <input type="checkbox" name="body8" id="body8" value="1" <?= ($this->customer['body8'] == 1) ? 'checked' : '';  ?>><label for="body8">ひざの痛み</label>
                            <input type="checkbox" name="body9" id="body9" value="1" <?= ($this->customer['body9'] == 1) ? 'checked' : '';  ?>><label for="body9">太ももの痛み</label>
                            <input type="checkbox" name="body10" id="body10" value="1" <?= ($this->customer['body10'] == 1) ? 'checked' : '';  ?>><label for="body10">ふくらはぎの痛み</label>
                        </div>
                        <div>
                            <p>【全身】</p>
                            <!-- null送信用 -->
                            <?php foreach (range(1, 7) as $i) : ?>
                                <input type="hidden" name="wholebody<?= $i; ?>">
                            <?php endforeach; ?>
                            <!-- null送信用 -->
                            <input type="checkbox" name="wholebody1" id="wholebody1" value="1" <?= ($this->customer['wholebody1'] == 1) ? 'checked' : '';  ?>><label for="wholebody1">冷え(手)</label>
                            <input type="checkbox" name="wholebody2" id="wholebody2" value="1" <?= ($this->customer['wholebody2'] == 1) ? 'checked' : '';  ?>><label for="wholebody2">冷え(足)</label>
                            <input type="checkbox" name="wholebody3" id="wholebody3" value="1" <?= ($this->customer['wholebody3'] == 1) ? 'checked' : '';  ?>><label for="wholebody3">むくみ</label>
                            <input type="checkbox" name="wholebody4" id="wholebody4" value="1" <?= ($this->customer['wholebody4'] == 1) ? 'checked' : '';  ?>><label for="wholebody4">疲労感</label>
                            <input type="checkbox" name="wholebody5" id="wholebody5" value="1" <?= ($this->customer['wholebody5'] == 1) ? 'checked' : '';  ?>><label for="wholebody5">イライラしやすい</label>
                            <input type="checkbox" name="wholebody6" id="wholebody6" value="1" <?= ($this->customer['wholebody6'] == 1) ? 'checked' : '';  ?>><label for="wholebody6">ストレスを感じやすい</label>
                            <input type="checkbox" name="wholebody7" id="wholebody7" value="1" <?= ($this->customer['wholebody7'] == 1) ? 'checked' : '';  ?>><label for="wholebody7">胃腸が弱い</label>
                        </div>
                        <div>
                            <p>【眠り】</p>
                            <!-- null送信用 -->
                            <?php foreach (range(1, 6) as $i) : ?>
                                <input type="hidden" name="sleep<?= $i; ?>">
                            <?php endforeach; ?>
                            <!-- null送信用 -->
                            <input type="checkbox" name="sleep1" id="sleep1" value="1" <?= ($this->customer['sleep1'] == 1) ? 'checked' : '';  ?>><label for="sleep1">不眠</label>
                            <input type="checkbox" name="sleep2" id="sleep2" value="1" <?= ($this->customer['sleep2'] == 1) ? 'checked' : '';  ?>><label for="sleep2">常に眠い</label>
                            <input type="checkbox" name="sleep3" id="sleep3" value="1" <?= ($this->customer['sleep3'] == 1) ? 'checked' : '';  ?>><label for="sleep3">寝つき(悪い)</label>
                            <input type="checkbox" name="sleep4" id="sleep4" value="1" <?= ($this->customer['sleep4'] == 1) ? 'checked' : '';  ?>><label for="sleep4">寝つき(良い)</label>
                            <input type="checkbox" name="sleep5" id="sleep5" value="1" <?= ($this->customer['sleep5'] == 1) ? 'checked' : '';  ?>><label for="sleep5">眠り(深い)</label>
                            <input type="checkbox" name="sleep6" id="sleep6" value="1" <?= ($this->customer['sleep6'] == 1) ? 'checked' : '';  ?>><label for="sleep6">眠り(浅い)</label>
                        </div>
                        <div class="d-flex gap-10px">
                            <div>
                                <p>夢</p>
                                <div>
                                    <input type="hidden" name="dream">
                                    <input type="radio" name="dream" id="dream1" value="1" <?= ($this->customer['dream'] == 1) ? 'checked' : '';  ?>><label for="dream1">よく見る</label>
                                    <input type="radio" name="dream" id="dream2" value="2" <?= ($this->customer['dream'] == 2) ? 'checked' : '';  ?>><label for="dream2">時々見る</label>
                                    <input type="radio" name="dream" id="dream3" value="3" <?= ($this->customer['dream'] == 3) ? 'checked' : '';  ?>><label for="dream3">見ない</label>
                                </div>
                            </div>
                            <div>
                                <p>睡眠時間</p>
                                <input type="hidden" name="sleep_time">
                                <input type="radio" name="sleep_time" id="sleep_time1" value="1" <?= ($this->customer['sleep_time'] == 1) ? 'checked' : '';  ?>><label for="sleep_time1">規則的</label>
                                <input type="radio" name="sleep_time" id="sleep_time2" value="2" <?= ($this->customer['sleep_time'] == 2) ? 'checked' : '';  ?>><label for="sleep_time2">不規則</label>
                            </div>
                        </div>
                        <div>
                            <p>【大小便】</p>
                            <!-- null送信用 -->
                            <?php foreach (range(1, 3) as $i) : ?>
                                <input type="hidden" name="excretion<?= $i; ?>">
                            <?php endforeach; ?>
                            <!-- null送信用 -->
                            <input type="checkbox" name="excretion1" id="excretion1" value="1" <?= ($this->customer['excretion1'] == 1) ? 'checked' : '';  ?>><label for="excretion1">便秘</label>
                            <input type="checkbox" name="excretion2" id="excretion2" value="1" <?= ($this->customer['excretion2'] == 1) ? 'checked' : '';  ?>><label for="excretion2">下痢</label>
                            <input type="checkbox" name="excretion3" id="excretion3" value="1" <?= ($this->customer['excretion3'] == 1) ? 'checked' : '';  ?>><label for="excretion3">頻尿</label>
                        </div>
                        <div>
                            <p>【生理】</p>
                            <!-- null送信用 -->
                            <?php foreach (range(1, 4) as $i) : ?>
                                <input type="hidden" name="period<?= $i; ?>">
                            <?php endforeach; ?>
                            <!-- null送信用 -->
                            <input type="checkbox" name="period1" id="period1" value="1" <?= ($this->customer['period1'] == 1) ? 'checked' : '';  ?>><label for="period1">生理痛</label>
                            <input type="checkbox" name="period2" id="period2" value="1" <?= ($this->customer['period2'] == 1) ? 'checked' : '';  ?>><label for="period2">生理不順</label>
                            <input type="checkbox" name="period3" id="period3" value="1" <?= ($this->customer['period3'] == 1) ? 'checked' : '';  ?>><label for="period3">PMS</label>
                            <input type="checkbox" name="period4" id="period4" value="1" <?= ($this->customer['period4'] == 1) ? 'checked' : '';  ?>><label for="period4">更年期障害</label>
                        </div>
                        <div>
                            <p>【ライフスタイル】</p>
                            <div class="d-flex gap-10px">
                                <div>
                                    <p>勤務時間</p>
                                    <input type="hidden" name="work_time">
                                    <input type="radio" name="work_time" id="work_time1" value="1" <?= ($this->customer['work_time'] == 1) ? 'checked' : '';  ?>><label for="work_time1">規則的</label>
                                    <input type="radio" name="work_time" id="work_time2" value="2" <?= ($this->customer['work_time'] == 2) ? 'checked' : '';  ?>><label for="work_time2">不規則</label>
                                </div>
                                <div>
                                    <p>勤務スタイル</p>
                                    <input type="hidden" name="work_style">
                                    <input type="radio" name="work_style" id="work_style1" value="1" <?= ($this->customer['work_style'] == 1) ? 'checked' : '';  ?>><label for="work_style1">立ち仕事</label>
                                    <input type="radio" name="work_style" id="work_style2" value="2" <?= ($this->customer['work_style'] == 2) ? 'checked' : '';  ?>><label for="work_style2">座り仕事</label>
                                </div>
                                <div>
                                    <p>PC作業時間</p>
                                    <input name="work_style_text" value="<?= $this->customer['work_style_text']; ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="section">
                        <h2>現在行っていること</h2>
                        <div>
                            <p>【運動系】</p>
                            <div class="d-flex gap-10px">
                                <div>
                                    <p>ジム</p>
                                    <input type="hidden" name="gym">
                                    <input type="radio" name="gym" id="gym1" value="1" class="hidden-input" <?= ($this->customer['gym'] == 1) ? 'checked' : '';  ?>><label for="gym1" class="gym-label radio-green">○</label>
                                    <input type="radio" name="gym" id="gym2" value="2" class="hidden-input" <?= ($this->customer['gym'] == 2) ? 'checked' : '';  ?>><label for="gym2" class="gym-label radio-blue">△</label>
                                </div>
                                <div>
                                    <p>ヨガ</p>
                                    <input type="hidden" name="yoga">
                                    <input type="radio" name="yoga" id="yoga1" value="1" class="hidden-input" <?= ($this->customer['yoga'] == 1) ? 'checked' : '';  ?>><label for="yoga1" class="yoga-label radio-green">○</label>
                                    <input type="radio" name="yoga" id="yoga2" value="2" class="hidden-input" <?= ($this->customer['yoga'] == 2) ? 'checked' : '';  ?>><label for="yoga2" class="yoga-label radio-blue">△</label>
                                </div>
                                <div>
                                    <p>ウォーキング</p>
                                    <input type="hidden" name="walk">
                                    <input type="radio" name="walk" id="walk1" value="1" class="hidden-input" <?= ($this->customer['walk'] == 1) ? 'checked' : '';  ?>><label for="walk1" class="walk-label radio-green">○</label>
                                    <input type="radio" name="walk" id="walk2" value="2" class="hidden-input" <?= ($this->customer['walk'] == 2) ? 'checked' : '';  ?>><label for="walk2" class="walk-label radio-blue">△</label>
                                </div>
                                <div>
                                    <p>その他</p>
                                    <input type="text" name="sports_other_text" size="40" value="<?= $this->customer['sports_other_text']; ?>">
                                </div>
                            </div>
                        </div>
                        <div>
                            <p>【食事】</p>
                            <div class="d-flex gap-10px">
                                <div>
                                    <p>ダイエット食品</p>
                                    <input type="hidden" name="healthy_food">
                                    <input type="radio" name="healthy_food" id="healthy_food1" value="1" class="hidden-input" <?= ($this->customer['healthy_food'] == 1) ? 'checked' : '';  ?>><label for="healthy_food1" class="healthy-food-label radio-green">○</label>
                                    <input type="radio" name="healthy_food" id="healthy_food2" value="2" class="hidden-input" <?= ($this->customer['healthy_food'] == 2) ? 'checked' : '';  ?>><label for="healthy_food2" class="healthy-food-label radio-blue">△</label>
                                </div>
                                <div>
                                    <p>単一ダイエット</p>
                                    <input type="hidden" name="diet">
                                    <input type="radio" name="diet" id="diet1" value="1" class="hidden-input" <?= ($this->customer['diet'] == 1) ? 'checked' : '';  ?>><label for="diet1" class="diet-label radio-green">○</label>
                                    <input type="radio" name="diet" id="diet2" value="2" class="hidden-input" <?= ($this->customer['diet'] == 2) ? 'checked' : '';  ?>><label for="diet2" class="diet-label radio-blue">△</label>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex gap-10px">
                            <div>
                                <p>【その他】</p>
                                <!-- null送信用 -->
                                <?php foreach (range(1, 3) as $i) : ?>
                                    <input type="hidden" name="clinic<?= $i; ?>">
                                <?php endforeach; ?>
                                <!-- null送信用 -->
                                <input type="checkbox" name="clinic1" id="clinic1" value="1" <?= ($this->customer['clinic1'] == 1) ? 'checked' : '';  ?>><label for="clinic1">クリニック</label>
                                <input type="checkbox" name="clinic2" id="clinic2" value="1" <?= ($this->customer['clinic2'] == 1) ? 'checked' : '';  ?>><label for="clinic2">エステサロン</label>
                                <input type="checkbox" name="clinic3" id="clinic3" value="1" <?= ($this->customer['clinic3'] == 1) ? 'checked' : '';  ?>><label for="clinic3">接骨院・整体</label>
                            </div>
                            <div>
                                <p>他</p>
                                <input type="text" name="clinic_other_text" size="40" value="<?= $this->customer['clinic_other_text']; ?>">
                            </div>
                        </div>
                    </div>
                    <div class="section">
                        <h2>病歴</h2>
                        <div class="d-flex gap-10px">
                            <div>
                                <p>【アレルギー】</p>
                                <!-- null送信用 -->
                                <?php foreach (range(1, 5) as $i) : ?>
                                    <input type="hidden" name="allergy<?= $i; ?>">
                                <?php endforeach; ?>
                                <!-- null送信用 -->
                                <input type="checkbox" name="allergy1" id="allergy1" value="1" <?= ($this->customer['allergy1'] == 1) ? 'checked' : '';  ?>><label for="allergy1">紫外線</label>
                                <input type="checkbox" name="allergy2" id="allergy2" value="1" <?= ($this->customer['allergy2'] == 1) ? 'checked' : '';  ?>><label for="allergy2">花粉</label>
                                <input type="checkbox" name="allergy3" id="allergy3" value="1" <?= ($this->customer['allergy3'] == 1) ? 'checked' : '';  ?>><label for="allergy3">化粧品</label>
                                <input type="checkbox" name="allergy4" id="allergy4" value="1" <?= ($this->customer['allergy4'] == 1) ? 'checked' : '';  ?>><label for="allergy4">日焼け止め</label>
                                <input type="checkbox" name="allergy5" id="allergy5" value="1" <?= ($this->customer['allergy5'] == 1) ? 'checked' : '';  ?>><label for="allergy5">香料</label>
                            </div>
                            <div>
                                <p>その他</p>
                                <input type="text" name="allergy_other_text" value="<?= $this->customer['allergy_other_text']; ?>">
                            </div>
                        </div>
                        <div class="d-flex gap-10px">
                            <div>
                                <p>【手術歴】</p>
                                <input type="hidden" name="ope">
                                <input type="radio" name="ope" id="ope1" value="1" <?= ($this->customer['ope'] == 1) ? 'checked' : '';  ?>><label for="ope1">ない</label>
                                <input type="radio" name="ope" id="ope2" value="2" <?= ($this->customer['ope'] == 2) ? 'checked' : '';  ?>><label for="ope2">ある</label>
                            </div>
                            <div>
                                <p>箇所</p>
                                <input type="text" name="ope_parts" size="30" value="<?= $this->customer['ope_parts']; ?>">
                            </div>
                            <div>
                                <p>時期</p>
                                <input type="text" name="surgery_period" size="30" value="<?= $this->customer['surgery_period']; ?>">
                            </div>
                        </div>
                        <div class="d-flex gap-10px">
                            <div>
                                <p>【常用のお薬】</p>
                                <input type="hidden" name="medicine">
                                <input type="radio" name="medicine" id="medicine1" value="1" <?= ($this->customer['medicine'] == 1) ? 'checked' : '';  ?>><label for="medicine1">ない</label>
                                <input type="radio" name="medicine" id="medicine2" value="2" <?= ($this->customer['medicine'] == 2) ? 'checked' : '';  ?>><label for="medicine2">ある</label>
                            </div>
                            <div>
                                <p>薬名</p>
                                <input type="text" name="medicine_name" size="30" value="<?= $this->customer['medicine_name']; ?>">
                            </div>
                        </div>
                        <div class="d-flex gap-10px">
                            <div>
                                <p>【傷・ケガ】</p>
                                <input type="hidden" name="injury">
                                <input type="radio" name="injury" id="injury1" value="1" <?= ($this->customer['injury'] == 1) ? 'checked' : '';  ?>><label for="injury1">ない</label>
                                <input type="radio" name="injury" id="injury2" value="2" <?= ($this->customer['injury'] == 2) ? 'checked' : '';  ?>><label for="injury2">ある</label>
                            </div>
                            <div>
                                <p>箇所</p>
                                <input type="text" name="injury_parts" size="30" value="<?= $this->customer['injury_parts']; ?>">
                            </div>
                            <div>
                                <p>時期</p>
                                <input type="text" name="injury_period" size="30" value="<?= $this->customer['injury_period']; ?>">
                            </div>
                        </div>
                        <div class="d-flex gap-10px">
                            <div>
                                <p>【過去に化粧品でトラブル】</p>
                                <input type="hidden" name="trouble">
                                <input type="radio" name="trouble" id="trouble1" value="1" <?= ($this->customer['trouble'] == 1) ? 'checked' : '';  ?>><label for="trouble1">ない</label>
                                <input type="radio" name="trouble" id="trouble2" value="2" <?= ($this->customer['trouble'] == 2) ? 'checked' : '';  ?>><label for="trouble2">ある</label>
                            </div>
                            <div>
                                <p>箇所</p>
                                <input type="text" name="trouble_parts" size="30" value="<?= $this->customer['trouble_parts']; ?>">
                            </div>
                            <div>
                                <p>時期</p>
                                <input type="text" name="trouble_period" size="30" value="<?= $this->customer['trouble_period']; ?>">
                            </div>
                        </div>
                        <div>
                            <p>【コンタクト】</p>
                            <!-- null送信用 -->
                            <?php foreach (range(1, 3) as $i) : ?>
                                <input type="hidden" name="contactlens<?= $i; ?>">
                            <?php endforeach; ?>
                            <!-- null送信用 -->
                            <input type="checkbox" name="contactlens1" id="contactlens1" value="1" <?= ($this->customer['contactlens1'] == 1) ? 'checked' : '';  ?>><label for="contactlens1">していない</label>
                            <input type="checkbox" name="contactlens2" id="contactlens2" value="1" <?= ($this->customer['contactlens2'] == 1) ? 'checked' : '';  ?>><label for="contactlens2">している（ソフト）</label>
                            <input type="checkbox" name="contactlens3" id="contactlens3" value="1" <?= ($this->customer['contactlens3'] == 1) ? 'checked' : '';  ?>><label for="contactlens3">している（ハード）</label>
                        </div>
                        <div>
                            <p>【まつげエクステ】</p>
                            <input type="hidden" name="eyelash">
                            <input type="radio" name="eyelash" id="eyelash1" value="1" <?= ($this->customer['eyelash'] == 1) ? 'checked' : '';  ?>><label for="eyelash1">していない</label>
                            <input type="radio" name="eyelash" id="eyelash2" value="2" <?= ($this->customer['eyelash'] == 2) ? 'checked' : '';  ?>><label for="eyelash2">している</label>
                        </div>
                    </div>
                    <div class="section">
                        <h2>施術中について</h2>
                        <div>
                            <p>【マッサージの強さ】</p>
                            <!-- null送信用 -->
                            <?php foreach (range(1, 3) as $i) : ?>
                                <input type="hidden" name="massage<?= $i; ?>">
                            <?php endforeach; ?>
                            <!-- null送信用 -->
                            <input type="checkbox" name="massage1" id="massage1" value="1" <?= ($this->customer['massage1'] == 1) ? 'checked' : '';  ?>><label for="massage1">弱</label>
                            <input type="checkbox" name="massage2" id="massage2" value="1" <?= ($this->customer['massage2'] == 1) ? 'checked' : '';  ?>><label for="massage2">中</label>
                            <input type="checkbox" name="massage3" id="massage3" value="1" <?= ($this->customer['massage3'] == 1) ? 'checked' : '';  ?>><label for="massage3">強</label>
                        </div>
                        <div class="d-flex gap-10px">
                            <div>
                                <p>【ご要望】</p>
                                <!-- null送信用 -->
                                <?php foreach (range(1, 5) as $i) : ?>
                                    <input type="hidden" name="request<?= $i; ?>">
                                <?php endforeach; ?>
                                <!-- null送信用 -->
                                <input type="checkbox" name="request1" id="request1" value="1" <?= ($this->customer['request1'] == 1) ? 'checked' : '';  ?>><label for="request1">お悩みを何とかしたい</label>
                                <input type="checkbox" name="request2" id="request2" value="1" <?= ($this->customer['request2'] == 1) ? 'checked' : '';  ?>><label for="request2">症状を予防したい</label>
                                <input type="checkbox" name="request3" id="request3" value="1" <?= ($this->customer['request3'] == 1) ? 'checked' : '';  ?>><label for="request3">アドバイスが欲しい</label>
                                <input type="checkbox" name="request4" id="request4" value="1" <?= ($this->customer['request4'] == 1) ? 'checked' : '';  ?>><label for="request4">自分でケアする方法が知りたい</label>
                                <input type="checkbox" name="request5" id="request5" value="1" <?= ($this->customer['request5'] == 1) ? 'checked' : '';  ?>><label for="request5">ゆっくり寝たい</label>
                            </div>
                            <div>
                                <p>他</p>
                                <input type="text" name="request_other_text" size="30" value="<?= $this->customer['request_other_text']; ?>">
                            </div>
                        </div>
                    </div>
                    <div>
                        <h2>その他(ご要望)</h2>
                        <textarea name="other" class="other-textarea"><?= $this->customer['other']; ?></textarea>
                    </div>
                </div>
                <button type="button" class="btn btn-add save">更新する</button>
                <input type="hidden" name="id" id="id" value="<?= $this->customer['id']; ?>">
                <input type="hidden" name="save_flag" value="update">
            </form>
        </div>
    </div>
</div>