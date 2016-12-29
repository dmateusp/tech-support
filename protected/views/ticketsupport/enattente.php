<?php
	$this->breadcrumbs=array(
		'Demandes support'=>array('index'),
		'Demande numéro '.$model->idticketSupport=>array('view&id='.$model->idticketSupport),
		'Mettre la demande en attente',
	);
	$this->menu=array(
		array('label'=>'Liste des demandes support', 'url'=>array('index')),
		array('label'=>'Créer une demande', 'url'=>array('create')),
	);
?>
<h1><img src="./css/logoattente.png" class="imgTitles"/>Mettre en attente</h1>
<?php $this->renderPartial('_attenteForm', array('model'=>$model)); ?>