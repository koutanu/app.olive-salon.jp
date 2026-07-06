<div class="login-form-section">
	<div>
		<form action="<?= URL ?>login/zikkou" method="post" id="form" class="login-form">
			<div class="p-2">
				<div class="text-red">
					<?= $this->alert; ?>
				</div>
				<div class="mt-3">
					<span>アカウント：</span>
					<input type="text" name="login_account" placeholder="アカウント">
				</div>
				<div>
					<span>パスワード：</span>
					<input type="password" name="password" placeholder="パスワード">
				</div>
				<div class="mt-3">
					<button type="submit" id="login" class="btn btn-login">ログイン</button>
				</div>
			</div>
		</form>
		<!-- <a href="<?= URL; ?>login/account">アカウント新規追加</a> -->
	</div>
</div>