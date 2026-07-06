<input type="hidden" id="token" value="<?= $this->token; ?>">
<input type="hidden" id="doc_root" value="<?= URL; ?>">
<input type="hidden" id="method" value="<?= $this->method; ?>">
<div class="header-wrap">
    <div class="top-menu">

    </div>
    <h1 class="title"><?= $this->title; ?></h1>
    <div class="right-top-menu">
        <button class="logout" onclick="location = '<?= URL . 'admin/logout'; ?>';" data-toggle="tooltip" data-placement="bottom" title="Logout">
            <i class="fas fa-sign-out-alt"></i>
        </button>
        <span><?= Session::getUserInfo('user_name'); ?></span>
    </div>
</div>
<div class="wrapper">