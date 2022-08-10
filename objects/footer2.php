<!--Contiene el bloque con el pie de página de la aplicación web-->
<link rel="stylesheet" type="text/css" href="../../css/footer.css">
<style type="text/css">
	.footer-control{
		position: absolute;
		margin-top: -30px;
	}

	.footer-control button{
		float: right;
		width: 35.33px;
		height: 35.33px;
		border-radius: 20px;
		border-color: white;
		background-color: #18347D;
		color: white;
		border-width: 1px;
	}
</style>
<script type="text/javascript">
	function toggleFooter(button){
		var b=document.getElementsByClassName("footer-body")[0];
		if(b.hidden){
			b.hidden=false;
			button.getElementsByTagName("i")[0].classList.add("fa-chevron-down");
			button.getElementsByTagName("i")[0].classList.remove("fa-chevron-up");
		}else{
			b.hidden=true;
			button.getElementsByTagName("i")[0].classList.remove("fa-chevron-down");
			button.getElementsByTagName("i")[0].classList.add("fa-chevron-up");
		}
		
	}
</script>
<footer>
	<?php if(isset($_SESSION['user'])): ?>
		<div class="footer-control col-12 padd"><button onclick="toggleFooter(this);"><i class="fa fa-chevron-up"></i></button></div>
	<?php endif; ?>
	<div class="footer-content col-12">
		<?php if(isset($_SESSION['user'])): ?>
		<div class="footer-body" hidden>
			<div class="row-simple">
				<div class="col-4 padd">
					<h4>Información</h4>
					<ul style="list-style: none;">
						<li style="text-align: left;"><a style="color: white;" href=""><i class="fa fa-question-circle"></i> Ayuda</a></li>
						<li style="text-align: left;"><a style="color: white;" href=""><i class="fa fa-info-circle"></i> Acerca de</a></li>
					</ul>
				</div>

				<div class="col-4 padd">
					<h4>Pruebas</h4>
					<ul style="list-style: none;">
						<li style="text-align: left;"><a style="color: white;" href="../../reservas/registrar2"><i class="fa fa-exclamation-circle"></i> <strong> (Nuevo)</strong> Registrar reserva</a></li>
					</ul>
				</div>
			</div>
		</div>
		<?php endif; ?>
		<div class="footer-footer">
			<p>Hotel &copy; 2022 | Todos los derechos reservados</p>
			
		</div>
	</div>
</footer>
