<style>
	#botoncarrito{
		border:none;
		background:indigo;
		padding:5px;
		border-radius:20px;
		width:50px;
	}
</style>
<?php
	if(isset($_GET['prod'])){
			echo '
				<a href="tienda.php?prod='.$_GET['prod'].'">
					<button id="botoncarrito">
						🛒
					</button>
				</a>
			';
	}
?>
