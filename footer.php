</div>
<footer>
	<div class="footerLogo">
	<a href="<?=$this->GetUrl('/')?>">
	<div class="Logo flex">
		<?
		$imagepath ='///'.$_SERVER['HTTP_HOST'].'/Game/images/siteLogo.png';
		if(!file_exists($imagepath)){
			echo('<img src="'.$imagepath.'" style="width: 60px;height: 60px;">');
		}
		?>
		

		<div class="gradientLogo">MINE FORGE</div>
	</div>
	</a>
</div>
</footer>
		
</body>
</html>