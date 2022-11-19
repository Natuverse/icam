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
    <?php
        echo $model;
        dep($data);
    ?>
    <input type="hidden" id="idmodelo" value="<?= $data['modelo'] ?>">

	<div class="row">
		<div class="col-md-12">
			<div class="tile">
				<div class="tile-body">
					<div id="graphDivmodelo"></div>
				</div>
			</div>
		</div>
	</div>
<hr>

	<div class="row">
		<div class="col-md-12">
			<div class="tile">
				<div class="tile-body">
					<div id="graphDivminmodelo"></div>
                   
				</div>
			</div>
		</div>
	</div>

	


</main>

<?php footerAdmin($data); ?>