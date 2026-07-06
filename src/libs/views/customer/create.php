<div class="main-section customer-create">
    <div class="close-wrap">
        <i class="fas fa-caret-left side-menu-close open"></i>
    </div>
    <div class="main-wrapper">
        <div class="main-top">
            <form action="<?= URL ?>/customer/save" method="post" id="form">
                <div class="customer-detail">
                    <div class="section">
                        <h2>基本情報</h2>
                        <div class="name-wrap">
                            <div>
                                <p>名前</p>
                                <input type="text" name="name">
                            </div>
                            <div>
                                <p>フリガナ(全角カタカナ)</p>
                                <input type="text" name="kana">
                            </div>
                        </div>
                        <div class="d-flex gap-5px">
                            <div>
                                <p>生年月日</p>
                                <select name="year" class="birthday year" data-yyyy="<?= date('Y'); ?>-<?= date('Y') - 120; ?>"></select>
                                <select name="month" class="birthday month">
                                    <?php for ($i = 1; $i <= 12; $i++) : ?>
                                        <option value="<?= $i; ?>"><?= $i ?>月</option>
                                    <?php endfor; ?>
                                </select>
                                <select name="day" class="birthday day">
                                    <?php for ($i = 1; $i <= 31; $i++) : ?>
                                        <option value="<?= $i; ?>"><?= $i ?>日</option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                            <div>
                                <p>年齢</p>
                                <input type="text" class="age" size="4">
                            </div>
                            <div>
                                <p>性別</p>
                                <input type="radio" name="sex" id="sex1" value="1"><label for="sex1">男性</label>
                                <input type="radio" name="sex" id="sex2" value="2"><label for="sex2">女性</label>
                            </div>
                        </div>
                        <div class="address-wrap">
                            <div>
                                <p>〒</p>
                                <input type="text" name="post" id="post">
                            </div>
                            <div>
                                <p>都道府県</p>
                                <input type="text" name="prefecture" id="prefecture">
                            </div>
                            <div>
                                <p>市町村</p>
                                <input type="text" name="city" id="city">
                            </div>
                            <div>
                                <p>住所</p>
                                <input type="text" name="address" id="address" size="40">
                            </div>
                            <div>
                                <p>マンション</p>
                                <input type="text" name="apartment" id="apartment" size="40">
                            </div>
                        </div>
                        <div class="d-flex gap-5px">
                            <div>
                                <p>結婚</p>
                                <input type="radio" name="civilstatus" id="civilstatus1" value="1"><label for="civilstatus1">既婚</label>
                                <input type="radio" name="civilstatus" id="civilstatus2" value="2"><label for="civilstatus2">未婚</label>
                            </div>
                            <div>
                                <p>子供</p>
                                <input type="text" name="children">
                            </div>
                            <div>
                                <p>電話番号</p>
                                <input type="tel" name="tel">
                            </div>
                        </div>
                        <div class="d-flex gap-5px">
                            <div>
                                <p>仕事</p>
                                <input type="text" name="work" size="40">
                            </div>
                            <div>
                                <p>趣味</p>
                                <input type="text" name="hobby" size="40">
                            </div>
                        </div>
                    </div>
                    <div class="section">
                        <div>
                            <p>きっかけ</p>
                            <input type="checkbox" name="ad1" id="ad1" value="1"><label for="ad1">紹介</label>
                            <input type="text" name="ad1_text" id="ad1_text">
                            <input type="checkbox" name="ad2" id="ad2" value="1"><label for="ad2">HP</label>
                            <input type="checkbox" name="ad3" id="ad3" value="1"><label for="ad3">instagram</label>
                            <input type="checkbox" name="ad_other" id="ad_other" value="1"><label for="ad_other">その他</label>
                            <input type="text" name="ad_other_text" id="ad_other_text">
                        </div>
                    </div>
                    <div class="section">
                        <h2>お悩みについて</h2>
                        <div>
                            <p>【あたま】</p>
                            <input type="checkbox" name="head1" id="head1" value="1"><label for="head1">頭痛</label>
                            <input type="checkbox" name="head2" id="head2" value="1"><label for="head2">目の疲れ</label>
                            <input type="checkbox" name="head3" id="head3" value="1"><label for="head3">めまい</label>
                            <input type="checkbox" name="head4" id="head4" value="1"><label for="head4">耳鳴り</label>
                        </div>
                        <div>
                            <p>【おかお】</p>
                            <input type="checkbox" name="face1" id="face1" value="1"><label for="face1">小顔</label>
                            <input type="checkbox" name="face2" id="face2" value="1"><label for="face2">たるみ</label>
                            <input type="checkbox" name="face3" id="face3" value="1"><label for="face3">しわ</label>
                            <input type="checkbox" name="face4" id="face4" value="1"><label for="face4">しみ</label>
                            <input type="checkbox" name="face5" id="face5" value="1"><label for="face5">乾燥</label>
                            <input type="checkbox" name="face6" id="face6" value="1"><label for="face6">アレルギー</label>
                        </div>
                        <div>
                            <p>【からだ】</p>
                            <input type="checkbox" name="body1" id="body1" value="1"><label for="body1">首こり</label>
                            <input type="checkbox" name="body2" id="body2" value="1"><label for="body2">肩こり</label>
                            <input type="checkbox" name="body3" id="body3" value="1"><label for="body3">肩の痛み</label>
                            <input type="checkbox" name="body4" id="body4" value="1"><label for="body4">腕の痛み</label>
                            <input type="checkbox" name="body5" id="body5" value="1"><label for="body5">背中の痛み</label>
                            <input type="checkbox" name="body6" id="body6" value="1"><label for="body6">腰痛</label>
                            <input type="checkbox" name="body7" id="body7" value="1"><label for="body7">おしりの痛み</label>
                            <input type="checkbox" name="body8" id="body8" value="1"><label for="body8">ひざの痛み</label>
                            <input type="checkbox" name="body9" id="body9" value="1"><label for="body9">太ももの痛み</label>
                            <input type="checkbox" name="body10" id="body10" value="1"><label for="body10">ふくらはぎの痛み</label>
                        </div>
                        <div>
                            <p>【全身】</p>
                            <input type="checkbox" name="wholebody1" id="wholebody1" value="1"><label for="wholebody1">冷え(手)</label>
                            <input type="checkbox" name="wholebody2" id="wholebody2" value="1"><label for="wholebody2">冷え(足)</label>
                            <input type="checkbox" name="wholebody3" id="wholebody3" value="1"><label for="wholebody3">むくみ</label>
                            <input type="checkbox" name="wholebody4" id="wholebody4" value="1"><label for="wholebody4">疲労感</label>
                            <input type="checkbox" name="wholebody5" id="wholebody5" value="1"><label for="wholebody5">イライラしやすい</label>
                            <input type="checkbox" name="wholebody6" id="wholebody6" value="1"><label for="wholebody6">ストレスを感じやすい</label>
                            <input type="checkbox" name="wholebody7" id="wholebody7" value="1"><label for="wholebody7">胃腸が弱い</label>
                        </div>
                        <div>
                            <p>【眠り】</p>
                            <input type="checkbox" name="sleep1" id="sleep1" value="1"><label for="sleep1">不眠</label>
                            <input type="checkbox" name="sleep2" id="sleep2" value="1"><label for="sleep2">常に眠い</label>
                            <input type="checkbox" name="sleep3" id="sleep3" value="1"><label for="sleep3">寝つき(悪い)</label>
                            <input type="checkbox" name="sleep4" id="sleep4" value="1"><label for="sleep4">寝つき(良い)</label>
                            <input type="checkbox" name="sleep5" id="sleep5" value="1"><label for="sleep5">眠り(深い)</label>
                            <input type="checkbox" name="sleep6" id="sleep6" value="1"><label for="sleep6">眠り(浅い)</label>
                        </div>
                        <div class="d-flex gap-10px">
                            <div>
                                <p>夢</p>
                                <div>
                                    <input type="radio" name="dream" id="dream1" value="1"><label for="dream1">よく見る</label>
                                    <input type="radio" name="dream" id="dream2" value="2"><label for="dream2">時々見る</label>
                                    <input type="radio" name="dream" id="dream3" value="3"><label for="dream3">見ない</label>
                                </div>
                            </div>
                            <div>
                                <p>睡眠時間</p>
                                <input type="radio" name="sleep_time" id="sleep_time1" value="1"><label for="sleep_time1">規則的</label>
                                <input type="radio" name="sleep_time" id="sleep_time2" value="2"><label for="sleep_time2">不規則</label>
                            </div>
                        </div>
                        <div>
                            <p>【大小便】</p>
                            <input type="checkbox" name="excretion1" id="excretion1" value="1"><label for="excretion1">便秘</label>
                            <input type="checkbox" name="excretion2" id="excretion2" value="1"><label for="excretion2">下痢</label>
                            <input type="checkbox" name="excretion3" id="excretion3" value="1"><label for="excretion3">頻尿</label>
                        </div>
                        <div>
                            <p>【生理】</p>
                            <input type="checkbox" name="period1" id="period1" value="1"><label for="period1">生理痛</label>
                            <input type="checkbox" name="period2" id="period2" value="1"><label for="period2">生理不順</label>
                            <input type="checkbox" name="period3" id="period3" value="1"><label for="period3">PMS</label>
                            <input type="checkbox" name="period4" id="period4" value="1"><label for="period4">更年期障害</label>
                        </div>
                        <div>
                            <p>【ライフスタイル】</p>
                            <div class="d-flex gap-10px">
                                <div>
                                    <p>勤務時間</p>
                                    <input type="radio" name="work_time" id="work_time1" value="1"><label for="work_time1">規則的</label>
                                    <input type="radio" name="work_time" id="work_time2" value="2"><label for="work_time2">不規則</label>
                                </div>
                                <div>
                                    <p>勤務スタイル</p>
                                    <input type="radio" name="work_style" id="work_style1" value="1"><label for="work_style1">立ち仕事</label>
                                    <input type="radio" name="work_style" id="work_style2" value="2"><label for="work_style2">座り仕事</label>
                                </div>
                                <div>
                                    <p>PC作業時間</p>
                                    <input type="text" name="work_style_text">
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
                                    <input type="radio" name="gym" id="gym1" value="1" class="hidden-input"><label for="gym1" class="gym-label radio-green">○</label>
                                    <input type="radio" name="gym" id="gym2" value="2" class="hidden-input"><label for="gym2" class="gym-label radio-blue">△</label>
                                </div>
                                <div>
                                    <p>ヨガ</p>
                                    <input type="radio" name="yoga" id="yoga1" value="1" class="hidden-input"><label for="yoga1" class="yoga-label radio-green">○</label>
                                    <input type="radio" name="yoga" id="yoga2" value="2" class="hidden-input"><label for="yoga2" class="yoga-label radio-blue">△</label>
                                </div>
                                <div>
                                    <p>ウォーキング</p>
                                    <input type="radio" name="walk" id="walk1" value="1" class="hidden-input"><label for="walk1" class="walk-label radio-green">○</label>
                                    <input type="radio" name="walk" id="walk2" value="2" class="hidden-input"><label for="walk2" class="walk-label radio-blue">△</label>
                                </div>
                                <div>
                                    <p>その他</p>
                                    <input type="text" name="sports_other_text" size="40">
                                </div>
                            </div>
                        </div>
                        <div>
                            <p>【食事】</p>
                            <div class="d-flex gap-10px">
                                <div>
                                    <p>ダイエット食品</p>
                                    <input type="radio" name="healthy_food" id="healthy_food1" value="1" class="hidden-input"><label for="healthy_food1" class="healthy-food-label radio-green">○</label>
                                    <input type="radio" name="healthy_food" id="healthy_food2" value="2" class="hidden-input"><label for="healthy_food2" class="healthy-food-label radio-blue">△</label>
                                </div>
                                <div>
                                    <p>単一ダイエット</p>
                                    <input type="radio" name="diet" id="diet1" value="1" class="hidden-input"><label for="diet1" class="diet-label radio-green">○</label>
                                    <input type="radio" name="diet" id="diet2" value="2" class="hidden-input"><label for="diet2" class="diet-label radio-blue">△</label>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex gap-10px">
                            <div>
                                <p>【その他】</p>
                                <input type="checkbox" name="clinic1" id="clinic1" value="1"><label for="clinic1">クリニック</label>
                                <input type="checkbox" name="clinic2" id="clinic2" value="1"><label for="clinic2">エステサロン</label>
                                <input type="checkbox" name="clinic3" id="clinic3" value="1"><label for="clinic3">接骨院・整体</label>
                            </div>
                            <div>
                                <p>他</p>
                                <input type="text" name="clinic_other_text" size="40">
                            </div>
                        </div>
                    </div>
                    <div class="section">
                        <h2>病歴</h2>
                        <div class="d-flex gap-10px">
                            <div>
                                <p>【アレルギー】</p>
                                <input type="checkbox" name="allergy1" id="allergy1" value="1"><label for="allergy1">紫外線</label>
                                <input type="checkbox" name="allergy2" id="allergy2" value="1"><label for="allergy2">花粉</label>
                                <input type="checkbox" name="allergy3" id="allergy3" value="1"><label for="allergy3">化粧品</label>
                                <input type="checkbox" name="allergy4" id="allergy4" value="1"><label for="allergy4">日焼け止め</label>
                                <input type="checkbox" name="allergy5" id="allergy5" value="1"><label for="allergy5">香料</label>
                            </div>
                            <div>
                                <p>その他</p>
                                <input type="text" name="allergy_other_text">
                            </div>
                        </div>
                        <div class="d-flex gap-10px">
                            <div>
                                <p>【手術歴】</p>
                                <input type="radio" name="ope" id="ope1" value="1"><label for="ope1">ない</label>
                                <input type="radio" name="ope" id="ope2" value="2"><label for="ope2">ある</label>
                            </div>
                            <div>
                                <p>箇所</p>
                                <input type="text" name="ope_parts" size="30">
                            </div>
                            <div>
                                <p>時期</p>
                                <input type="text" name="surgery_period" size="30">
                            </div>
                        </div>
                        <div class="d-flex gap-10px">
                            <div>
                                <p>【常用のお薬】</p>
                                <input type="radio" name="medicine" id="medicine1" value="1"><label for="medicine1">ない</label>
                                <input type="radio" name="medicine" id="medicine2" value="2"><label for="medicine2">ある</label>
                            </div>
                            <div>
                                <p>薬名</p>
                                <input type="text" name="medicine_name" size="30">
                            </div>
                        </div>
                        <div class="d-flex gap-10px">
                            <div>
                                <p>【傷・ケガ】</p>
                                <input type="radio" name="injury" id="injury1" value="1"><label for="injury1">ない</label>
                                <input type="radio" name="injury" id="injury2" value="2"><label for="injury2">ある</label>
                            </div>
                            <div>
                                <p>箇所</p>
                                <input type="text" name="injury_parts" size="30">
                            </div>
                            <div>
                                <p>時期</p>
                                <input type="text" name="injury_period" size="30">
                            </div>
                        </div>
                        <div class="d-flex gap-10px">
                            <div>
                                <p>【過去に化粧品でトラブル】</p>
                                <input type="radio" name="trouble" id="trouble1" value="1"><label for="trouble1">ない</label>
                                <input type="radio" name="trouble" id="trouble2" value="2"><label for="trouble2">ある</label>
                            </div>
                            <div>
                                <p>箇所</p>
                                <input type="text" name="trouble_parts" size="30">
                            </div>
                            <div>
                                <p>時期</p>
                                <input type="text" name="trouble_period" size="30">
                            </div>
                        </div>
                        <div>
                            <p>【コンタクト】</p>
                            <input type="checkbox" name="contactlens1" id="contactlens1" value="1"><label for="contactlens1">していない</label>
                            <input type="checkbox" name="contactlens2" id="contactlens2" value="1"><label for="contactlens2">している（ソフト）</label>
                            <input type="checkbox" name="contactlens3" id="contactlens3" value="1"><label for="contactlens3">している（ハード）</label>
                        </div>
                        <div>
                            <p>【まつげエクステ】</p>
                            <input type="radio" name="eyelash" id="eyelash1" value="1"><label for="eyelash1">していない</label>
                            <input type="radio" name="eyelash" id="eyelash2" value="2"><label for="eyelash2">している</label>
                        </div>
                    </div>
                    <div class="section">
                        <h2>施術中について</h2>
                        <div>
                            <p>【マッサージの強さ】</p>
                            <input type="checkbox" name="massage1" id="massage1" value="1"><label for="massage1">弱</label>
                            <input type="checkbox" name="massage2" id="massage2" value="1"><label for="massage2">中</label>
                            <input type="checkbox" name="massage3" id="massage3" value="1"><label for="massage3">強</label>
                        </div>
                        <div class="d-flex gap-10px">
                            <div>
                                <p>【ご要望】</p>
                                <input type="checkbox" name="request1" id="request1" value="1"><label for="request1">お悩みを何とかしたい</label>
                                <input type="checkbox" name="request2" id="request2" value="1"><label for="request2">症状を予防したい</label>
                                <input type="checkbox" name="request3" id="request3" value="1"><label for="request3">アドバイスが欲しい</label>
                                <input type="checkbox" name="request4" id="request4" value="1"><label for="request4">自分でケアする方法が知りたい</label>
                                <input type="checkbox" name="request5" id="request5" value="1"><label for="request5">ゆっくり寝たい</label>
                            </div>
                            <div>
                                <p>他</p>
                                <input type="text" name="request_other_text" size="30">
                            </div>
                        </div>
                    </div>
                    <div>
                        <h2>その他(ご要望)</h2>
                        <textarea name="other" class="other-textarea"></textarea>
                    </div>
                </div>
                <input type="date" name="created_at" value="<?= date('Y-m-d'); ?>">
                <button type="button" class="btn btn-add save">登録する</button>
                <input type="hidden" name="save_flag" value="create">
            </form>
        </div>
    </div>
</div>