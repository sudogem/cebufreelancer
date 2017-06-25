<ul id="miniflex">
	<li><a href="<?= site_url("users/$username")?>" <?= (isset($menu_resume) && $menu_resume ? 'class="active"' : '') ?> >Resume</a></li>
	<li><a href="<?= site_url("users/$username/portfolio") ?>" <?= (isset($menu_portfolio) && $menu_portfolio ? 'class="active"' : '') ?> >Portfolio</a></li>
	<li><a href="<?= site_url("users/$username/socialmedia") ?>" <?= (isset($menu_socialmedia) && $menu_socialmedia ? 'class="active"' : '') ?> >Social media</a></li>
	<li><a href="<?= site_url("users/$username/contact")?>" <?= (isset($menu_contact) && $menu_contact ? 'class="active"' : '') ?> >Contact</a></li>
</ul>