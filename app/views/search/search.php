<div class="content">
	<aside class="aside-cards-list">
		<h3 class="title">Rechercher - "<?php echo $search; ?>" (Vous ne trouvez pas ? Faite une <a href="<?php echo  WEBROOT. 'search/advanced' ?>">recherche avancée</a>)</h3>

<?php include VIEW."search/order_form.php";?>
		
		
<?php
			if(!empty($channels)) { 
				foreach($channels as $chan) {

echo '
				<div class="card video"  ">
					<div class="thumbnail bg-loader" data-background-load-in-view data-background="'.$chan->getAvatar().'" style="width:50%; margin:auto;">
						<a href="'.WEBROOT.'channel/'.$chan->id.'" class="overlay"></a>
					</div>
					<div class="description">
						<a href="'.WEBROOT.'channel/'.$chan->id.'"><h4>'.$chan->name.'</h4></a>
						<div>
							<span class="view">'.number_format($chan->getAllViews()).' / ' .$chan->getSubscribersNumber().' Abonnés </span>

						</div>
					</div>
				</div>';
	
				}
				
			}
			?>
		<?php 
		if(!empty($videos)) {
			foreach ($videos as $vid) {
				echo Utils::getVideoCardHTML($vid);
			}
		} ?>
	</aside>
</div>
<?php
		if(isset($order_way, $order)){
?>
		<script type="text/javascript">
		
			var options = document.getElementById('order-select').options;
			for (var i = 0; i < options.length; i++) {
				if(options[i].dataset.order == "<?php echo $order_way; ?>" && options[i].value == "<?php echo $order; ?>"){
					options[0].selected = false;
					options[i].selected = true;
					break;
				}
			}
		</script>
<?php 
		}


