<div class="login-form-section">
	<div>
		<form action="<?= URL ?>login/zikkou" method="post" id="form" class="login-form">
			<input type="hidden" name="token" value="<?= $this->h($this->token ?? $token ?? ''); ?>">
			<div class="p-2">
				<div class="text-red">
					<?= $this->h($this->alert ?? $alert ?? ''); ?>
				</div>
				<div class="mt-3">
					<label for="login_account">アカウント</label>
					<input type="text" id="login_account" name="login_account" placeholder="アカウント" required autocomplete="username">
				</div>
				<div>
					<label for="password">パスワード</label>
					<input type="password" id="password" name="password" placeholder="パスワード" required autocomplete="current-password">
				</div>
				<div style="position:absolute;left:-9999px;height:0;overflow:hidden;" aria-hidden="true">
					<label for="hp_email">メール</label>
					<input type="text" id="hp_email" name="hp_email" tabindex="-1" autocomplete="off">
				</div>
				<div class="mt-3">
					<button type="submit" id="login" class="btn btn-login">ログイン</button>
				</div>
			</div>
		</form>
	</div>
</div>
