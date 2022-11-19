<?php headerAdmin($data);
//getModal('modalAnalisis', $data);
?>


<main class="content m-3">
	<ul class="app-breadcrumb breadcrumb">
		<li class="breadcrumb-item"><i class="fa fa-user"></i></li>
		<li class="breadcrumb-item"><a href="<?= base_url(); ?>/Diccionario"><?= $data['page_title'] ?></a></li>
	</ul>
	<div class="app-title">

		<div >
			<h1><i class="fa fa-user"></i><?= $data['page_title'] ?></h1>
			
		</div>

	</div>



	<div class="row">
		<div class="col-md-12">
			<div class="tile">
				<div class="tile-body">
					<div class="table-responsive">
					<div class="table-responsive">
						<table class="table table-hover table-bordered " style="width:100%" id="table_modelos">
							<thead>
								<tr>									
								
                                    <th>Modelos</th>
									<th>consultas</th>	
									<th>opciones</th>								
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