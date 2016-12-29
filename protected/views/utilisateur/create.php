<?php
/* @var $this UtilisateurController */
/* @var $model Utilisateur */

$this->breadcrumbs=array(
	'Utilisateurs'=>array('index'),
	'Créer',
);

$this->menu=array(
	array('label'=>'Liste utilisateurs', 'url'=>array('index')),
	array('label'=>'Gérer utilisateurs', 'url'=>array('admin')),
);
?>

<h1><img src="./css/logouser.png" class="imgTitles"/>Créer un utilisateur</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>