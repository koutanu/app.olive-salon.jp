<?php require VIEWS . 'customer/_form_helpers.php'; ?>
<div class="main-section customer-create">
    <div class="close-wrap">
        <button type="button" class="history_back open" aria-label="戻る"><i class="fas fa-caret-left" aria-hidden="true"></i></button>
    </div>
    <div class="main-wrapper">
        <div class="main-top">
            <form action="<?= URL ?>customer/save" method="post" id="form">
                <div class="customer-detail">
                    <div class="section">
                        <h2>基本情報</h2>
                        <div class="form-grid">
                            <div class="name-wrap">
                                <div class="field">
                                    <label for="customer_name">名前</label>
                                    <input type="text" id="customer_name" name="name" required>
                                </div>
                                <div class="field">
                                    <label for="customer_kana">フリガナ(全角カタカナ)</label>
                                    <input type="text" id="customer_kana" name="kana">
                                </div>
                            </div>
                            <div class="field-row">
                                <div class="field">
                                    <span class="field-label">生年月日</span>
                                    <div class="birthday-row">
                                        <select name="year" class="birthday year" data-yyyy="<?= date('Y'); ?>-<?= date('Y') - 120; ?>" aria-label="生年"></select>
                                        <select name="month" class="birthday month" aria-label="月">
                                            <?php for ($i = 1; $i <= 12; $i++) : ?>
                                                <option value="<?= $i; ?>"><?= $i ?>月</option>
                                            <?php endfor; ?>
                                        </select>
                                        <select name="day" class="birthday day" aria-label="日">
                                            <?php for ($i = 1; $i <= 31; $i++) : ?>
                                                <option value="<?= $i; ?>"><?= $i ?>日</option>
                                            <?php endfor; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="field field-narrow">
                                    <label for="customer_age">年齢</label>
                                    <input type="text" id="customer_age" class="age" size="4" readonly>
                                </div>
                                <div class="field">
                                    <span class="field-label">性別</span>
                                    <div class="choice-row">
                                        <label class="choice"><input type="radio" name="sex" id="sex1" value="1">男性</label>
                                        <label class="choice"><input type="radio" name="sex" id="sex2" value="2">女性</label>
                                    </div>
                                </div>
                            </div>
                            <div class="address-wrap">
                                <div class="field field-post">
                                    <label for="post">〒</label>
                                    <input type="text" name="post" id="post">
                                </div>
                                <div class="field">
                                    <label for="prefecture">都道府県</label>
                                    <input type="text" name="prefecture" id="prefecture">
                                </div>
                                <div class="field">
                                    <label for="city">市町村</label>
                                    <input type="text" name="city" id="city">
                                </div>
                                <div class="field field-wide">
                                    <label for="address">住所</label>
                                    <input type="text" name="address" id="address" size="40">
                                </div>
                                <div class="field field-wide">
                                    <label for="apartment">マンション</label>
                                    <input type="text" name="apartment" id="apartment" size="40">
                                </div>
                            </div>
                            <div class="field-row">
                                <div class="field">
                                    <span class="field-label">結婚</span>
                                    <div class="choice-row">
                                        <label class="choice"><input type="radio" name="civilstatus" id="civilstatus1" value="1">既婚</label>
                                        <label class="choice"><input type="radio" name="civilstatus" id="civilstatus2" value="2">未婚</label>
                                    </div>
                                </div>
                                <div class="field">
                                    <label for="children">子供</label>
                                    <input type="text" id="children" name="children">
                                </div>
                                <div class="field">
                                    <label for="tel">電話番号</label>
                                    <input type="tel" id="tel" name="tel">
                                </div>
                            </div>
                            <div class="field-row">
                                <div class="field field-wide">
                                    <label for="work">仕事</label>
                                    <input type="text" id="work" name="work" size="40">
                                </div>
                                <div class="field field-wide">
                                    <label for="hobby">趣味</label>
                                    <input type="text" id="hobby" name="hobby" size="40">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="section">
                        <h2>きっかけ</h2>
                        <div class="choice-group">
                            <div class="choice-row">
                                <label class="choice"><input type="checkbox" name="ad1" id="ad1" value="1">紹介</label>
                                <input type="text" name="ad1_text" id="ad1_text" class="inline-text" placeholder="紹介者など">
                                <label class="choice"><input type="checkbox" name="ad2" id="ad2" value="1">HP</label>
                                <label class="choice"><input type="checkbox" name="ad3" id="ad3" value="1">Instagram</label>
                                <label class="choice"><input type="checkbox" name="ad_other" id="ad_other" value="1">その他</label>
                                <input type="text" name="ad_other_text" id="ad_other_text" class="inline-text" placeholder="その他">
                            </div>
                        </div>
                    </div>

                    <div class="section">
                        <h2>お悩みについて</h2>
                        <div class="choice-group">
                            <p class="group-label">あたま</p>
                            <div class="choice-row">
                                <label class="choice"><input type="checkbox" name="head1" id="head1" value="1">頭痛</label>
                                <label class="choice"><input type="checkbox" name="head2" id="head2" value="1">目の疲れ</label>
                                <label class="choice"><input type="checkbox" name="head3" id="head3" value="1">めまい</label>
                                <label class="choice"><input type="checkbox" name="head4" id="head4" value="1">耳鳴り</label>
                            </div>
                        </div>
                        <div class="choice-group">
                            <p class="group-label">おかお</p>
                            <div class="choice-row">
                                <label class="choice"><input type="checkbox" name="face1" id="face1" value="1">小顔</label>
                                <label class="choice"><input type="checkbox" name="face2" id="face2" value="1">たるみ</label>
                                <label class="choice"><input type="checkbox" name="face3" id="face3" value="1">しわ</label>
                                <label class="choice"><input type="checkbox" name="face4" id="face4" value="1">しみ</label>
                                <label class="choice"><input type="checkbox" name="face5" id="face5" value="1">乾燥</label>
                                <label class="choice"><input type="checkbox" name="face6" id="face6" value="1">アレルギー</label>
                            </div>
                        </div>
                        <div class="choice-group">
                            <p class="group-label">からだ</p>
                            <div class="choice-row">
                                <label class="choice"><input type="checkbox" name="body1" id="body1" value="1">首こり</label>
                                <label class="choice"><input type="checkbox" name="body2" id="body2" value="1">肩こり</label>
                                <label class="choice"><input type="checkbox" name="body3" id="body3" value="1">肩の痛み</label>
                                <label class="choice"><input type="checkbox" name="body4" id="body4" value="1">腕の痛み</label>
                                <label class="choice"><input type="checkbox" name="body5" id="body5" value="1">背中の痛み</label>
                                <label class="choice"><input type="checkbox" name="body6" id="body6" value="1">腰痛</label>
                                <label class="choice"><input type="checkbox" name="body7" id="body7" value="1">おしりの痛み</label>
                                <label class="choice"><input type="checkbox" name="body8" id="body8" value="1">ひざの痛み</label>
                                <label class="choice"><input type="checkbox" name="body9" id="body9" value="1">太ももの痛み</label>
                                <label class="choice"><input type="checkbox" name="body10" id="body10" value="1">ふくらはぎの痛み</label>
                            </div>
                        </div>
                        <div class="choice-group">
                            <p class="group-label">全身</p>
                            <div class="choice-row">
                                <label class="choice"><input type="checkbox" name="wholebody1" id="wholebody1" value="1">冷え(手)</label>
                                <label class="choice"><input type="checkbox" name="wholebody2" id="wholebody2" value="1">冷え(足)</label>
                                <label class="choice"><input type="checkbox" name="wholebody3" id="wholebody3" value="1">むくみ</label>
                                <label class="choice"><input type="checkbox" name="wholebody4" id="wholebody4" value="1">疲労感</label>
                                <label class="choice"><input type="checkbox" name="wholebody5" id="wholebody5" value="1">イライラしやすい</label>
                                <label class="choice"><input type="checkbox" name="wholebody6" id="wholebody6" value="1">ストレスを感じやすい</label>
                                <label class="choice"><input type="checkbox" name="wholebody7" id="wholebody7" value="1">胃腸が弱い</label>
                            </div>
                        </div>
                        <div class="choice-group">
                            <p class="group-label">眠り</p>
                            <div class="choice-row">
                                <label class="choice"><input type="checkbox" name="sleep1" id="sleep1" value="1">不眠</label>
                                <label class="choice"><input type="checkbox" name="sleep2" id="sleep2" value="1">常に眠い</label>
                                <label class="choice"><input type="checkbox" name="sleep3" id="sleep3" value="1">寝つき(悪い)</label>
                                <label class="choice"><input type="checkbox" name="sleep4" id="sleep4" value="1">寝つき(良い)</label>
                                <label class="choice"><input type="checkbox" name="sleep5" id="sleep5" value="1">眠り(深い)</label>
                                <label class="choice"><input type="checkbox" name="sleep6" id="sleep6" value="1">眠り(浅い)</label>
                            </div>
                        </div>
                        <div class="field-row">
                            <div class="field">
                                <span class="field-label">夢</span>
                                <div class="choice-row">
                                    <label class="choice"><input type="radio" name="dream" id="dream1" value="1">よく見る</label>
                                    <label class="choice"><input type="radio" name="dream" id="dream2" value="2">時々見る</label>
                                    <label class="choice"><input type="radio" name="dream" id="dream3" value="3">見ない</label>
                                </div>
                            </div>
                            <div class="field">
                                <span class="field-label">睡眠時間</span>
                                <div class="choice-row">
                                    <label class="choice"><input type="radio" name="sleep_time" id="sleep_time1" value="1">規則的</label>
                                    <label class="choice"><input type="radio" name="sleep_time" id="sleep_time2" value="2">不規則</label>
                                </div>
                            </div>
                        </div>
                        <div class="choice-group">
                            <p class="group-label">大小便</p>
                            <div class="choice-row">
                                <label class="choice"><input type="checkbox" name="excretion1" id="excretion1" value="1">便秘</label>
                                <label class="choice"><input type="checkbox" name="excretion2" id="excretion2" value="1">下痢</label>
                                <label class="choice"><input type="checkbox" name="excretion3" id="excretion3" value="1">頻尿</label>
                            </div>
                        </div>
                        <div class="choice-group">
                            <p class="group-label">生理</p>
                            <div class="choice-row">
                                <label class="choice"><input type="checkbox" name="period1" id="period1" value="1">生理痛</label>
                                <label class="choice"><input type="checkbox" name="period2" id="period2" value="1">生理不順</label>
                                <label class="choice"><input type="checkbox" name="period3" id="period3" value="1">PMS</label>
                                <label class="choice"><input type="checkbox" name="period4" id="period4" value="1">更年期障害</label>
                            </div>
                        </div>
                        <div class="choice-group">
                            <p class="group-label">ライフスタイル</p>
                            <div class="field-row">
                                <div class="field">
                                    <span class="field-label">勤務時間</span>
                                    <div class="choice-row">
                                        <label class="choice"><input type="radio" name="work_time" id="work_time1" value="1">規則的</label>
                                        <label class="choice"><input type="radio" name="work_time" id="work_time2" value="2">不規則</label>
                                    </div>
                                </div>
                                <div class="field">
                                    <span class="field-label">勤務スタイル</span>
                                    <div class="choice-row">
                                        <label class="choice"><input type="radio" name="work_style" id="work_style1" value="1">立ち仕事</label>
                                        <label class="choice"><input type="radio" name="work_style" id="work_style2" value="2">座り仕事</label>
                                    </div>
                                </div>
                                <div class="field">
                                    <label for="work_style_text">PC作業時間</label>
                                    <input type="text" id="work_style_text" name="work_style_text">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="section section-activity">
                        <h2>現在行っていること</h2>
                        <div class="choice-group">
                            <p class="group-label">運動系</p>
                            <div class="field-row activity-row">
                                <div class="field">
                                    <span class="field-label">ジム</span>
                                    <div class="choice-row">
                                        <input type="radio" name="gym" id="gym1" value="1" class="hidden-input"><label for="gym1" class="gym-label radio-green">○</label>
                                        <input type="radio" name="gym" id="gym2" value="2" class="hidden-input"><label for="gym2" class="gym-label radio-blue">△</label>
                                    </div>
                                </div>
                                <div class="field">
                                    <span class="field-label">ヨガ</span>
                                    <div class="choice-row">
                                        <input type="radio" name="yoga" id="yoga1" value="1" class="hidden-input"><label for="yoga1" class="yoga-label radio-green">○</label>
                                        <input type="radio" name="yoga" id="yoga2" value="2" class="hidden-input"><label for="yoga2" class="yoga-label radio-blue">△</label>
                                    </div>
                                </div>
                                <div class="field">
                                    <span class="field-label">ウォーキング</span>
                                    <div class="choice-row">
                                        <input type="radio" name="walk" id="walk1" value="1" class="hidden-input"><label for="walk1" class="walk-label radio-green">○</label>
                                        <input type="radio" name="walk" id="walk2" value="2" class="hidden-input"><label for="walk2" class="walk-label radio-blue">△</label>
                                    </div>
                                </div>
                                <div class="field field-wide">
                                    <label for="sports_other_text">その他</label>
                                    <input type="text" id="sports_other_text" name="sports_other_text" size="40">
                                </div>
                            </div>
                        </div>
                        <div class="choice-group">
                            <p class="group-label">食事</p>
                            <div class="field-row">
                                <div class="field">
                                    <span class="field-label">ダイエット食品</span>
                                    <div class="choice-row">
                                        <input type="radio" name="healthy_food" id="healthy_food1" value="1" class="hidden-input"><label for="healthy_food1" class="healthy-food-label radio-green">○</label>
                                        <input type="radio" name="healthy_food" id="healthy_food2" value="2" class="hidden-input"><label for="healthy_food2" class="healthy-food-label radio-blue">△</label>
                                    </div>
                                </div>
                                <div class="field">
                                    <span class="field-label">単一ダイエット</span>
                                    <div class="choice-row">
                                        <input type="radio" name="diet" id="diet1" value="1" class="hidden-input"><label for="diet1" class="diet-label radio-green">○</label>
                                        <input type="radio" name="diet" id="diet2" value="2" class="hidden-input"><label for="diet2" class="diet-label radio-blue">△</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="choice-group">
                            <p class="group-label">その他</p>
                            <div class="field-row">
                                <div class="choice-row">
                                    <label class="choice"><input type="checkbox" name="clinic1" id="clinic1" value="1">クリニック</label>
                                    <label class="choice"><input type="checkbox" name="clinic2" id="clinic2" value="1">エステサロン</label>
                                    <label class="choice"><input type="checkbox" name="clinic3" id="clinic3" value="1">接骨院・整体</label>
                                </div>
                                <div class="field field-wide">
                                    <label for="clinic_other_text">他</label>
                                    <input type="text" id="clinic_other_text" name="clinic_other_text" size="40">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="section">
                        <h2>病歴</h2>
                        <div class="choice-group">
                            <p class="group-label">アレルギー</p>
                            <div class="field-row">
                                <div class="choice-row">
                                    <label class="choice"><input type="checkbox" name="allergy1" id="allergy1" value="1">紫外線</label>
                                    <label class="choice"><input type="checkbox" name="allergy2" id="allergy2" value="1">花粉</label>
                                    <label class="choice"><input type="checkbox" name="allergy3" id="allergy3" value="1">化粧品</label>
                                    <label class="choice"><input type="checkbox" name="allergy4" id="allergy4" value="1">日焼け止め</label>
                                    <label class="choice"><input type="checkbox" name="allergy5" id="allergy5" value="1">香料</label>
                                </div>
                                <div class="field">
                                    <label for="allergy_other_text">その他</label>
                                    <input type="text" id="allergy_other_text" name="allergy_other_text">
                                </div>
                            </div>
                        </div>
                        <div class="choice-group">
                            <p class="group-label">手術歴</p>
                            <div class="field-row">
                                <div class="choice-row">
                                    <label class="choice"><input type="radio" name="ope" id="ope1" value="1">ない</label>
                                    <label class="choice"><input type="radio" name="ope" id="ope2" value="2">ある</label>
                                </div>
                                <div class="field">
                                    <label for="ope_parts">箇所</label>
                                    <input type="text" id="ope_parts" name="ope_parts" size="30">
                                </div>
                                <div class="field">
                                    <label for="surgery_period">時期</label>
                                    <input type="text" id="surgery_period" name="surgery_period" size="30">
                                </div>
                            </div>
                        </div>
                        <div class="choice-group">
                            <p class="group-label">常用のお薬</p>
                            <div class="field-row">
                                <div class="choice-row">
                                    <label class="choice"><input type="radio" name="medicine" id="medicine1" value="1">ない</label>
                                    <label class="choice"><input type="radio" name="medicine" id="medicine2" value="2">ある</label>
                                </div>
                                <div class="field">
                                    <label for="medicine_name">薬名</label>
                                    <input type="text" id="medicine_name" name="medicine_name" size="30">
                                </div>
                            </div>
                        </div>
                        <div class="choice-group">
                            <p class="group-label">傷・ケガ</p>
                            <div class="field-row">
                                <div class="choice-row">
                                    <label class="choice"><input type="radio" name="injury" id="injury1" value="1">ない</label>
                                    <label class="choice"><input type="radio" name="injury" id="injury2" value="2">ある</label>
                                </div>
                                <div class="field">
                                    <label for="injury_parts">箇所</label>
                                    <input type="text" id="injury_parts" name="injury_parts" size="30">
                                </div>
                                <div class="field">
                                    <label for="injury_period">時期</label>
                                    <input type="text" id="injury_period" name="injury_period" size="30">
                                </div>
                            </div>
                        </div>
                        <div class="choice-group">
                            <p class="group-label">過去に化粧品でトラブル</p>
                            <div class="field-row">
                                <div class="choice-row">
                                    <label class="choice"><input type="radio" name="trouble" id="trouble1" value="1">ない</label>
                                    <label class="choice"><input type="radio" name="trouble" id="trouble2" value="2">ある</label>
                                </div>
                                <div class="field">
                                    <label for="trouble_parts">箇所</label>
                                    <input type="text" id="trouble_parts" name="trouble_parts" size="30">
                                </div>
                                <div class="field">
                                    <label for="trouble_period">時期</label>
                                    <input type="text" id="trouble_period" name="trouble_period" size="30">
                                </div>
                            </div>
                        </div>
                        <div class="choice-group">
                            <p class="group-label">コンタクト</p>
                            <div class="choice-row">
                                <label class="choice"><input type="checkbox" name="contactlens1" id="contactlens1" value="1">していない</label>
                                <label class="choice"><input type="checkbox" name="contactlens2" id="contactlens2" value="1">している（ソフト）</label>
                                <label class="choice"><input type="checkbox" name="contactlens3" id="contactlens3" value="1">している（ハード）</label>
                            </div>
                        </div>
                        <div class="choice-group">
                            <p class="group-label">まつげエクステ</p>
                            <div class="choice-row">
                                <label class="choice"><input type="radio" name="eyelash" id="eyelash1" value="1">していない</label>
                                <label class="choice"><input type="radio" name="eyelash" id="eyelash2" value="2">している</label>
                            </div>
                        </div>
                    </div>

                    <div class="section">
                        <h2>施術中について</h2>
                        <div class="choice-group">
                            <p class="group-label">マッサージの強さ</p>
                            <div class="choice-row">
                                <label class="choice"><input type="checkbox" name="massage1" id="massage1" value="1">弱</label>
                                <label class="choice"><input type="checkbox" name="massage2" id="massage2" value="1">中</label>
                                <label class="choice"><input type="checkbox" name="massage3" id="massage3" value="1">強</label>
                            </div>
                        </div>
                        <div class="choice-group">
                            <p class="group-label">ご要望</p>
                            <div class="field-row">
                                <div class="choice-row">
                                    <label class="choice"><input type="checkbox" name="request1" id="request1" value="1">お悩みを何とかしたい</label>
                                    <label class="choice"><input type="checkbox" name="request2" id="request2" value="1">症状を予防したい</label>
                                    <label class="choice"><input type="checkbox" name="request3" id="request3" value="1">アドバイスが欲しい</label>
                                    <label class="choice"><input type="checkbox" name="request4" id="request4" value="1">自分でケアする方法が知りたい</label>
                                    <label class="choice"><input type="checkbox" name="request5" id="request5" value="1">ゆっくり寝たい</label>
                                </div>
                                <div class="field field-wide">
                                    <label for="request_other_text">他</label>
                                    <input type="text" id="request_other_text" name="request_other_text" size="30">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="section section-other">
                        <h2>その他(ご要望)</h2>
                        <textarea name="other" class="other-textarea" aria-label="その他ご要望"></textarea>
                    </div>
                </div>
                <div class="form-actions">
                    <label class="created-at-field" for="created_at">登録日
                        <input type="date" id="created_at" name="created_at" value="<?= date('Y-m-d'); ?>">
                    </label>
                    <button type="button" class="btn btn-add save">登録する</button>
                    <input type="hidden" name="save_flag" value="create">
                </div>
            </form>
        </div>
    </div>
</div>
