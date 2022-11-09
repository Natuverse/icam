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
						<?php 


					
$datay1 = array(20,15,23,15);
$datay2 = array(12,9,42,8);
$datay3 = array(5,17,32,24);

// Setup the graph
$graph = new Graph(300,250);
$graph->SetScale("textlin");

$theme_class=new UniversalTheme;

$graph->SetTheme($theme_class);
$graph->img->SetAntiAliasing(false);
$graph->title->Set('Filled Y-grid');
$graph->SetBox(false);

$graph->SetMargin(40,20,36,63);

$graph->img->SetAntiAliasing();

$graph->yaxis->HideZeroLabel();
$graph->yaxis->HideLine(false);
$graph->yaxis->HideTicks(false,false);

$graph->xgrid->Show();
$graph->xgrid->SetLineStyle("solid");
$graph->xaxis->SetTickLabels(array('A','B','C','D'));
$graph->xgrid->SetColor('#E3E3E3');

// Create the first line
$p1 = new LinePlot($datay1);
$graph->Add($p1);
$p1->SetColor("#6495ED");
$p1->SetLegend('Line 1');

// Create the second line
$p2 = new LinePlot($datay2);
$graph->Add($p2);
$p2->SetColor("#B22222");
$p2->SetLegend('Line 2');

// Create the third line
$p3 = new LinePlot($datay3);
$graph->Add($p3);
$p3->SetColor("#FF1493");
$p3->SetLegend('Line 3');

$graph->legend->SetFrameWeight(1);

// Output line
$graph->Stroke();

//end of php code
?>




							
					</div>
				</div>
			</div>
		</div>
	</div>


	<div class="row">
		<div class="col-md-12">
			<div class="tile">
				<div class="tile-body">
					<div class="table-responsive">
					<div class="table-responsive">
						<table class="table table-hover table-bordered " style="width:100%" id="table_consultas">
							<thead>
								<tr>									
									<th>fecha</th>
                                    <th>mensajes</th>
									<th>Bot</th>								
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