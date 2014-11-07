<div class="content wide channel">
	<div class="bg-loader" id="background-wide" data-background="<?php echo $background; ?>"></div>

	<section class="inner">
		<ul class="top">
			<li><b><?php echo $subscribers; ?></b> Abonnés</li>
			<li><b><?php echo count($videos); ?></b> Vidéos</li>
			<li><b><?php echo $total_views; ?></b> Vue<?php echo $total_views>1? 's' : ''; ?></li>
		</ul>

		<div class="left">
			<span class="bg-loader" data-background="<?php echo $avatar; ?>"></span>
			<p><?php echo $name; ?></p>

			<?php if(!$channelBelongsToUser): ?>
				<?php if (Session::isActive()) { ?>
					<button <?php if($subscribed) echo 'class="subscribed"'; ?> id="subscribe-button" data-text="S'abonner|Se désabonner" onclick="subscribeAction('<?php echo $id; ?>')">
						<?php echo $subscribed ? 'Se désabonner' : 'S\'abonner'; ?>
					</button>
				<?php } else { ?>
					<a href="<?php echo WEBROOT.'login' ?>">Connectez-vous</a> pour vous abonner a cette chaîne !
				<?php } ?>
			<?php endif ?>
		</div>

		<?php if($description != '') { ?>
			<div class="right">
				<?php echo $description; ?>
			</div>
		<?php } ?>
	</section>
</div>

<div class="content">
	<nav class="tabs">
		<ul>
			<li <?php echo (isset($current) && $current == 'videos') ? 'class="current"' : 'class="channel"'; ?>><a href="<?php echo WEBROOT.'channel/'.$name; ?>">Vidéos</a></li>
			<li <?php echo (isset($current) && $current == 'playlists') ? 'class="current"' : 'class="channel"'; ?>><a href="<?php echo WEBROOT.'channel/'.$name.'/playlists/'; ?>">Playlists</a></li>
			<li <?php echo (isset($current) && $current == 'social') ? 'class="current"' : 'class="channel"'; ?>><a href="<?php echo WEBROOT.'channel/'.$name.'/social/'; ?>">Social</a></li>
		</ul>
	</nav>
</div>