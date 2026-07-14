<input type="hidden" id="token" value="<?= $this->h($this->token); ?>">
<input type="hidden" id="doc_root" value="<?= URL; ?>">
<input type="hidden" id="method" value="<?= $this->h($this->method); ?>">
<div class="header-wrap">
    <div class="top-menu">
        <button type="button" class="side-menu-toggle" aria-label="メニューを開く" aria-expanded="false" aria-controls="side-menu">
            <i class="fas fa-bars" aria-hidden="true"></i>
        </button>
    </div>
    <h1 class="title"><?= $this->h($this->title); ?></h1>
    <div class="right-top-menu">
        <button type="button" class="logout" onclick="location = '<?= URL . 'admin/logout'; ?>';" aria-label="ログアウト" title="ログアウト">
            <i class="fas fa-sign-out-alt" aria-hidden="true"></i>
        </button>
        <span><?= $this->h(Session::getUserInfo('user_name')); ?></span>
    </div>
</div>
<div class="wrapper">
