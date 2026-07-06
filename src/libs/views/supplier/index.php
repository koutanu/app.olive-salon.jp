<div class="main-section supplier">
    <div class="close-wrap">
        <i class="fas fa-caret-left history_back open"></i>
    </div>
    <div class="main-wrapper">
        <div class="main-top">
            <form action="<?= URL ?>supplier/save" method="post" enctype="multipart/form-data" id="form">
                <div class="top-btn-wrap">
                    <button type="button" class="btn btn-add save">登録する</button>
                </div>
                <p>作成日</p>
                <input type="date" name="created_at" value="<?= date('Y-m-d'); ?>">
                <p>仕入先名</p>
                <input type="text" name="name">
                <input type="hidden" name="save_flag" value="create">
            </form>
        </div>
        <div class="main-bottom">
            <?php foreach ($this->supplier as $value) : ?>
                <button type="button" class="btn btn-add"><?= $value['name']; ?></button>
            <?php endforeach; ?>
        </div>
    </div>
</div>