<?php
/* @var $this UtilisateurController */
/* @var $model Utilisateur */

$this->breadcrumbs=array(
	'Utilisateurs'=>array('index'),
	'Numéro '.$model->idutilisateur=>array('view','id'=>$model->idutilisateur),
	'Modifier',
);

$this->menu=array(
	array('label'=>'Liste utilisateurs', 'url'=>array('index')),
	array('label'=>'Créer utilisateurs', 'url'=>array('create')),
	array('label'=>'Modifier utilisateurs', 'url'=>array('view', 'id'=>$model->idutilisateur)),
	array('label'=>'Gérer utilisateurs', 'url'=>array('admin')),
);
?>

<h1>Modifier utilisateur <?php echo $model->initiale; ?></h1>

<?php $this->renderPartial('_update', array('model'=>$model)); ?>