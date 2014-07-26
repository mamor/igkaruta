<div class="navbar navbar-default">
	<div class="container">
		<a class="navbar-brand" href="<?php echo url(); ?>">KARUTA</a>
<?php if (! is_array(\Session::get('accessToken'))): ?>
		<ul class="nav navbar-nav navbar-right">
			<li><a href="<?php echo url('auth/login'); ?>">Login with Instagram</a></li>
		</ul>
<?php else: ?>
		<ul class="nav navbar-nav navbar-right">
			<li><a href="<?php echo url('auth/logout'); ?>">Logout</a></li>
		</ul>
<?php endif; ?>
	</div>
</div>
