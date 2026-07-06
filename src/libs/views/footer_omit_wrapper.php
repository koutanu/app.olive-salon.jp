<footer>
    <div></div>
    <p>@shinchan</p>
</footer>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="<?= URL; ?>js/main.js" charset="UTF-8"></script>
<?php if (isset($this->js)) : ?>
    <?php foreach ($this->js as $js) : ?>
        <script src="<?= URL; ?>js/<?= $js; ?>" charset="UTF-8"></script>
    <?php endforeach; ?>
<?php endif; ?>
</body>

</html>