<?php headerAdmin($data); 
getModal('modalEmocion', $data);
?>
<main>
    <div class="container-fluid px-4">
    <ul class="app-breadcrumb breadcrumb">
		<li class="breadcrumb-item"><i class="fa fa-user"></i></li>
		<li class="breadcrumb-item"><a href="<?= base_url(); ?>/Diccionario"><?= $data['page_title'] ?></a></li>
	</ul>
	<div class="app-title">

		<div >
			<h1><i class="fa fa-user"></i><?= $data['page_title'] ?></h1>
			<?php if ($_SESSION['permisosMod']['w']) { ?>
				<button class="btn btn-primary" type="button" onclick=" openModal();"><i class="fas fa-plus-circle"></i> Nuevo</button>
			<?php } ?>
		</div>

	</div>

        <div class="row">
		<div class="col-md-12">
			<div class="tile">
				<div class="tile-body">
					<div class="table-responsive">
						<table class="table table-hover table-bordered " style="width:100%" id="tableEmocion">
							<thead>
								<tr>
									<th>Id</th>
									<th>Imagen</th>
                                    <th>Emocion</th>
									<th style="width:180px">Acciones</th>
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>

    </div>
</main>
<?php footerAdmin($data); ?>