<?php
/* @var $this TravailinterneController */
/* @var $model Travailinterne */

$this->breadcrumbs=array(
	'Travail interne'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Modifier',
);

$this->menu=array(
	array('label'=>'Liste des demandes', 'url'=>array('index')),
	array('label'=>'Créer une demande', 'url'=>array('create')),
	array('label'=>'Détails de cette demande', 'url'=>array('view', 'id'=>$model->id)),
	//array('label'=>'Gérer les demandes', 'url'=>array('admin')),
);
Yii::app()->clientScript->registerScript('triggerOneAllEvents', "
$(document).ready(function() {

	
});"
);
?>

<h1>Modifier une demande <?php echo $model->id; ?></h1>
<?php
	$materiel = strrpos($model->description, 'Matériel spécifique coché : ');
	if($materiel!=false)
		$model->description = substr($model->description, 0, $materiel);
?>
<?php $this->renderPartial('_form', array('model'=>$model)); ?>