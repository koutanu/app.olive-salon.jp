<!--wrapper用div-->
</div>
<!-- モーダルウィンドウ -->
<div class="modal" role="dialog" aria-modal="true" aria-label="ダイアログ">
    <div class="header modal_header">
        <button type="button" class="btn close modal_close">閉じる</button>
    </div>
    <div class="modal_body">

    </div>
</div>
<div class="modal-overlay modal_overlay"></div>
<!-- フッター -->
<footer>
    <div></div>
    <p>Olive Salon</p>
</footer>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<?php
$needsChart = in_array($this->class, ['home', 'analysis', 'sales'], true);
$needsJpostal = in_array($this->class, ['customer'], true);
?>
<?php if ($needsChart) : ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.8.0/chart.min.js"></script>
<?php endif; ?>
<?php if ($needsJpostal) : ?>
<script src="//jpostal-1006.appspot.com/jquery.jpostal.js" type="text/javascript"></script>
<?php endif; ?>
<script src="<?= URL; ?>js/main.js" charset="UTF-8"></script>
<?php if (isset($this->js)) : ?>
    <?php foreach ($this->js as $js) : ?>
        <script src="<?= URL; ?>js/<?= $this->h($js); ?>" charset="UTF-8"></script>
    <?php endforeach; ?>
<?php endif; ?>
</body>

</html>
