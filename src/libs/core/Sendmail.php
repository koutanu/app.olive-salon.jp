<?php

class Sendmail
{

    public static function send($data)
    {
        $status = 0;
        $toaddress = $data['sendto'];
        $subject = "お問い合わせフォームからのメールです。";
        $title = Util::setSecureString($data['subject']); //件名を設定	
        $name1 = Util::setSecureString($data["name1"]);
        $name2 = Util::setSecureString($data["name2"]);
        $name3 = Util::setSecureString($data["name3"]);
        $strZipcode = Util::setSecureString($data["zip_code"]);
        $strPrefecture = Util::setSecureString($data["prefecture"]);
        $strAddress1 = Util::setSecureString($data["address1"]);
        $strAddress2 = Util::setSecureString($data["address2"]);
        $strAddress = $strPrefecture . $strPrefecture . $strAddress1 . $strAddress2;
        $mailaddress = Util::setSecureString($data["mail_address"]);
        $telnumber = Util::setSecureString($data["tel_number"]);
        $faxnumber = Util::setSecureString($data["fax_number"]);
        $message = Util::setSecureString($data["message"]);

        //メールヘッダを設定
        $header = "From: " . $toaddress;

        //メール本文を生成
        $body = "------------------------------------------------------------\n";
        $body .= "お問い合わせフォームより下記内容で問い合わせがありました。\n";
        $body .= "------------------------------------------------------------\n";
        $body .= "氏　　　　　名: " . $name1 . "\n";
        $body .= "ふ　り　が　な: " . $name2 . "\n";
        $body .= "会　　社　　名: " . $name3 . "\n";
        $body .= "郵　便　番　号: 〒" . $strZipcode . "\n";
        $body .= "住　　　　　所: " . $strAddress . "\n";
        $body .= "電　話　番　号: " . $telnumber . "\n";
        $body .= "Ｆ Ａ Ｘ　番　号: " . $faxnumber . "\n";
        $body .= "メールアドレス: " . $mailaddress . "\n";
        $body .= "件　　　　　名: " . $title . "\n";
        $body .= "問い合わせ内容: " . $message . "\n";
        $body .= "------------------------------------------------------------\n";
        //メール送信
        if (mb_send_mail($toaddress, $subject, $body, $header)) {
            $status = 1;
            $completemessage =  $name1 . "様からのお問い合わせを受付ました。<br>";
            $completemessage =  $completemessage . "ありがとうございました。おって担当者よりご連絡いたします。<br>";
            $completemessage =  $completemessage . "※営業時間外でのお問い合わせは翌営業日以降のご確認となりますので、ご了承ください。";

            $replysubject = "【】お問合せありがとうございました。";
            //返信用メール本文を生成		
            $replymessage = $name1 . " 様\n";
            $replymessage .= "より、下記のお問い合わせ内容を受付いたしました。\n";
            $replymessage .= "折り返し担当よりご連絡差し上げますので、今しばらくお待ちください。\n";
            $replymessage .= "------------------------------------------------------------------------\n";
            $replymessage .= "氏　　　　　名: " . $name1 . "\n";
            $replymessage .= "ふ　り　が　な: " . $name2 . "\n";
            $replymessage .= "会　　社　　名: " . $name3 . "\n";
            $replymessage .= "郵　便　番　号: 〒" . $strZipcode . "\n";
            $replymessage .= "住　　　　　所: " . $strAddress . "\n";
            $replymessage .= "電　話　番　号: " . $telnumber . "\n";
            $replymessage .= "ＦＡＸ　番　号: " . $faxnumber . "\n";
            $replymessage .= "メールアドレス: " . $mailaddress . "\n";
            $replymessage .= "件　　　　　名: " . $title . "\n";
            $replymessage .= "問い合わせ内容: " . $message . "\n";
            $replymessage .= "------------------------------------------------------------------------\n";
            $replymessage .= MESSAGE_FOOTER;
            if (mb_send_mail($mailaddress, $replysubject, $replymessage, $header)) {
                $status = 2;
                $completemessageReply = "";
            } else {
                $completemessageReply = "ご入力いただきましたメールアドレス " . $toaddress . " に受付完了メールを送りましたが、エラーとなってしまいましたのでご確認ください。";
            }
        } else {
            $completemessage =  $name1 . "様　申し訳ございません。メールのエラーにより送信できませんでした。";
        }
        $result = array('status' => $status, 'complete' => $completemessage, 'completereply' => $completemessageReply);
        return $result;
    }
    public static function send_attached($data)
    {
        mb_language("Japanese");
        mb_internal_encoding("UTF-8");
        $status = 0;
        $file = array(); //ファイル
        $filename = array(); //ファイル名
        $toaddresses = array(); //送信先アドレス
        $toaddresses2 = array(); //結果表示用送信先アドレス
        $ccaddresses = array(); //CCアドレス
        $ccaddresses2 = array(); //結果表示用CCアドレス
        $seladdresses = $data['seladdresses']; //選択アドレス
        $names = Util::removeSpaceCrLf($data['names']); //名称        
        $persons = Util::removeSpaceCrLf($data['persons']); //氏名        
        $addresses = Util::removeSpaceCrLf($data['addresses']); //アドレス
        $selcc1addresses = $data['selcc1addresses']; //CC1選択ID
        $cc1persons = Util::removeSpaceCrLf($data['cc1persons']); //CC1氏名
        $cc1addresses = Util::removeSpaceCrLf($data['cc1addresses']); //CC1アドレス
        $selcc2addresses = $data['selcc2addresses']; //CC2選択ID
        $cc2persons = Util::removeSpaceCrLf($data['cc2persons']); //CC2氏名
        $cc2addresses = Util::removeSpaceCrLf($data['cc2addresses']); //CC2アドレス
        $selcc3addresses = $data['selcc3addresses']; //CC3選択ID
        $cc3persons = Util::removeSpaceCrLf($data['cc3persons']); //CC3氏名
        $cc3addresses = Util::removeSpaceCrLf($data['cc3addresses']); //CC3アドレス
        $addresscount = count($addresses); //送信先アドレス数
        //----------------------------------------------------送信先毎に送信先アドレスを配列に格納 
        for ($i = 0; $i < $addresscount; $i++) {
            $id = $seladdresses[$i]; //選択ID
            $address = $addresses[$i]; //アドレス
            $name = $names[$i]; //名称
            $person = $persons[$i]; //氏名
            $toaddresses[$i] = mb_encode_mimeheader($name . $person, "UTF-8") . "<" . $address . ">"; //送信先アドレス
            $toaddresses2[$i] = $name . $person . '<' . $address . '>'; //結果表示用送信先アドレス
            $ccaddress = ''; //CCアドレス初期化
            $ccaddress2 = ''; //結果表示用CCアドレス初期化
            if ($selcc1addresses) {
                $cc1index = array_search($id, $selcc1addresses); //選択IDと一致するCC1選択ID配列内のキー            
                if ($cc1index === false || $cc1index === null) { //---------CC1未選択                
                } else { //---------------------------CC1選択済み
                    $ccaddress = mb_encode_mimeheader($cc1persons[$cc1index], "UTF-8") . "<" . $cc1addresses[$cc1index] . ">"; //CCアドレス
                    $ccaddress2 = $cc1persons[$cc1index] . "<" . $cc1addresses[$cc1index] . ">"; //表示用CCアドレス
                } //----------------------------------CC1選択済み
            }
            if ($selcc2addresses) {
                $cc2index = array_search($id, $selcc2addresses); //選択IDと一致するCC2選択ID配列内のキー
                if ($cc2index === false || $cc2index === null) { //---------CC2未選択                
                } else { //---------------------------CC2選択済み
                    if ($cc1index === false || $cc1index === null) { //---------CC1未選択                
                    } else { //---------------------------CC1選択済み
                        $ccaddress .= ', '; //CCアドレスにカンマ区切り付加
                        $ccaddress2 .= ', '; //表示用CCアドレスにカンマ区切り付加
                    } //--------------------CC1選択済み
                    $ccaddress .= mb_encode_mimeheader($cc2persons[$cc2index], "UTF-8") . "<" . $cc2addresses[$cc2index] . ">"; //CCアドレス
                    $ccaddress2 .= $cc2persons[$cc2index] . "<" . $cc2addresses[$cc2index] . ">"; //表示用CCアドレス
                } //----------------------------------CC2選択済み
            }
            if ($selcc3addresses) {
                $cc3index = array_search($id, $selcc3addresses);
                if ($cc3index === false || $cc3index === null) { //---------CC3未選択                
                } else { //---------------------------CC3選択済み
                    if (($cc1index === false || $cc1index === null) && ($cc2index === false || $cc2index === null)) { //---------CC2未選択                
                    } else { //---------------------------CC2選択済み
                        $ccaddress .= ', '; //CCアドレスにカンマ区切り付加
                        $ccaddress2 .= ', '; //表示用CCアドレスにカンマ区切り付加
                    } //--------------------CC2選択済み
                    $ccaddress .= mb_encode_mimeheader($cc3persons[$cc3index], "UTF-8") . "<" . $cc3addresses[$cc3index] . ">"; //CCアドレス
                    $ccaddress2 .= $cc3persons[$cc3index] . "<" . $cc3addresses[$cc3index] . ">"; //表示用CCアドレス
                } //----------------------------------CC3選択済み
            }
            if ($ccaddress != '') { //------------CCアドレス有
                $ccaddresses[$i] = 'Cc:' . $ccaddress . "\n";
                $ccaddresses2[$i] = '(Cc:' . $ccaddress2 . ')';
            } else { //---------------------------CCアドレス無
                $ccaddresses[$i] = '';
                $ccaddresses2[$i] = '';
            } //----------------------------------CCアドレス有無
        }
        //----------------------------------------------------送信先毎に送信先アドレスを配列に格納
        $fromaddress = mb_encode_mimeheader('', "UTF-8") . '[' . $data['sendfrom'] . ']'; //送信元アドレス
        $fromaddress2 = '' . '[' . $data['sendfrom'] . ']'; //表示用送信元アドレス
        $replyaddress = mb_encode_mimeheader('', "UTF-8") . '<' . $data['sendfrom'] . '>'; //返信先アドレス
        mb_internal_encoding("UTF-8");
        //$subject = Util::setSecureString($data['subject']);//件名を設定
        //$message = Util::setSecureString($data["message"]);
        $subject = $data['subject']; //件名
        $message = $data["message"]; //メッセージ
        $file[1] = $data["file1"]; //添付ファイル1
        $file[2] = $data["file2"]; //添付ファイル2
        $file[3] = $data["file3"]; //添付ファイル3
        $filename[1] = $data["file1name"]; //添付ファイル名1
        $filename[2] = $data["file2name"]; //添付ファイル名2
        $filename[3] = $data["file3name"]; //添付ファイル名3
        $dir = $data["dir"]; //ディレクトリ
        if ($file[1] == '' && $file[2] == '' && $file[3] == '') {
            $boundary = '';
        } else {
            $boundary = '__BOUNDARY__'; //.md5(rand());
        }
        //----------------------------------------------------メール本文を生成
        if ($boundary != '') {
            $body_header = "--{$boundary}\n";
        }
        $body_message = $message . "\n";
        $body_message .= "\n";
        $body_message .= MESSAGE_FOOTER;
        //----------------------------------------------------メール本文を生成        
        $body_attached = '';
        if ($boundary != '') {
            //----------------------------------------------------添付ファイル処理
            for ($i = 1; $i <= 3; $i++) {
                if ($file[$i] != '') {
                    $filepath = $dir . $file[$i];
                    $body_attached .= "--{$boundary}\n";
                    //$body_attached .= "Content-Type: application:pdf; name=\"$filename[$i]\"\n";
                    $body_attached .= "Content-Type: application/octet-stream; name=\"$filename[$i]\"\n";
                    $body_attached .= "Content-Transfer-Encoding: base64\n";
                    $body_attached .= "Content-Disposition: attachment; filename=\"$filename[$i]\"\n";
                    $body_attached .= "\n";
                    $body_attached .= chunk_split(base64_encode(file_get_contents($filepath))) . "\n";
                }
            }
            $body_attached .= "--{$boundary}--";
            //----------------------------------------------------添付ファイル処理
        }
        $body = $body_header . $body_message . $body_attached;
        //----------------------------------------------------メール本文を生成
        $sentcount = 0;
        $failedcount = 0;
        mb_internal_encoding("UTF-8");
        //----------------------------------------------------メール一括送信
        for ($i = 0; $i < $addresscount; $i++) {
            $toaddress = $toaddresses[$i];
            $set_subject = str_replace(array('{name}', '{person}'), array($names[$i], $persons[$i]), $subject);
            $set_body = str_replace(array('{name}', '{person}'), array($names[$i], $persons[$i]), $body);
            //----------------------------------------------------メールヘッダを設定
            $header = '';
            //$header .= "MIME-Version: 1.0\n";
            $header .= "From: " . $fromaddress . "\n"; //送信元アドレス
            $header .= $ccaddresses[$i]; //CCアドレス
            $header .= "MIME-Version: 1.0\n";
            if ($boundary != '') {
                $header .= "Content-Type: multipart/mixed; boundary=\"{$boundary}\"\n";
            }
            //----------------------------------------------------メールヘッダを設定 
            //$result = mb_send_mail($toaddress, $subject, $body, $header);
            //----------------------------------------------------メール送信
            $result = mb_send_mail($toaddress, $set_subject, $set_body, $header);
            if ($result) {
                if ($sentcount > 0) {
                    $sentaddresses .= ', ';
                }
                //$sentaddresses .= $toaddress;
                $sentaddresses .= $toaddresses2[$i] . $ccaddresses2[$i];
                $sentcount++;
            } else {
                if ($failedcount > 0) {
                    $failedaddresses .= ', ';
                }
                //$failedaddresses .= $toaddress;
                $failedaddresses .= $toaddresses2[$i] . $ccaddresses2[$i];
                $failedcount++;
            }
            //----------------------------------------------------メール送信
        }
        //----------------------------------------------------メール一括送信
        if ($sentcount == $addresscount) {
            $status = 2;
            $completesubject = "";
            $body_message = "件名:" . $subject . "\n";
            $body_message .= "本文:\n";
            $body_message .=  $message . "\n";
            $body_message .= "上記メッセージ送信先" . $sentcount . "件\n";
            $body_message .= "------------------------------------------------------------\n";
            $body_message .= $sentaddresses . "\n";
            $body_message .= "------------------------------------------------------------\n";
            if ($failedcount > 0) {
                $body_message .= "送信失敗先" . $failedcount . "件\n";
                $body_message .= "------------------------------------------------------------\n";
                $body_message .= $failedaddresses . "\n";
                $body_message .= "------------------------------------------------------------\n";
            }
            $body = $body_header . $body_message . $body_attached;
            $complete =  $body_message;
            if (mb_send_mail($replyaddress, $completesubject, $body, $header)) {
                $status = 3;
                $completereply = "送信結果を" . $fromaddress2 . "宛てにも送信しておりますのでご確認ください。";
            } else {
                $completereply = "登録されているメールアドレス \n" . $fromaddress . "に宛に送信完了メールを送りましたが、\nエラーとなってしまいましたのでご確認ください。";
            }
        } else {
            $complete =  "メールのエラーにより送信できませんでした。";
        }
        $result = array('status' => $status, 'complete' => $complete, 'completereply' => $completereply);
        return $result;
    }
    public static function send_resetmail($data)
    {
        $status = 0;
        $toaddress = $data['sendto']; //送信先アドレス
        $subject = Util::setSecureString($data['subject']); //件名を設定	
        $fromaddress = mb_encode_mimeheader('', "UTF-8") . '[' . $data['sendfrom'] . ']'; //送信元アドレス
        //----------------------------------------------------メールヘッダを設定
        $header = '';
        //$header .= "MIME-Version: 1.0\n";
        $header .= "From: " . $fromaddress . "\n"; //送信元アドレス
        //----------------------------------------------------メールヘッダを設定
        //----------------------------------------------------メール本文を生成
        $message = Util::setSecureString($data["message"]);
        $body = $message . "\n";
        $body .= "\n";
        $body .= MESSAGE_FOOTER;
        //----------------------------------------------------メール本文を生成
        if (mb_send_mail($toaddress, $subject, $body, $header)) {
            $status = 1;
            $completemessage =  $data['sendto'] . "様からのパスワード再設定を受付いたしました。<br>";
            $completemessage =  $completemessage . "ありがとうございました。おって担当者よりご連絡いたします。<br>";
            $completemessage =  $completemessage . "※営業時間外でのお問い合わせは翌営業日以降のご確認となりますので、ご了承ください。";
            $replysubject = '[' . $toaddress . ']' . '様' . $subject;
            //返信用メール本文を生成		
            $replymessage = '[' . $toaddress . ']' . '様よりパスワード再設定メールの送信が行われました。' . "\n\n";
            $replymessage .= "------------------------------------------------------------\n";
            $replymessage .= $message;
            $replymessage .= "------------------------------------------------------------\n";
            if (mb_send_mail(INQUIRY_ADDRESS, $replysubject, $replymessage, $header)) {
                $status = 2;
                $completemessageReply = "";
            } else {
                $completemessageReply = "ご入力いただきましたメールアドレス " . $toaddress . " に受付完了メールを送りましたが、エラーとなってしまいましたのでご確認ください。";
            }
        }
        $result = array('status' => $status, 'complete' => $completemessage, 'completereply' => $completemessageReply);
        return $result;
    }
}
