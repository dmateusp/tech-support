<?php
/* @var $this TravailinterneController */
/* @var $model Travailinterne */

$this->breadcrumbs=array(
	'Travail interne'=>array('index'),
	'Créer une demande',
);
	$user = Yii::app()->db->createCommand()
    ->select('type')
    ->from('utilisateur')
    ->where('idutilisateur=:id', array(':id'=>Yii::app()->user->id))
    ->queryRow();
    //$user['type']
$this->menu=array(
	array('label'=>'Liste des demandes', 'url'=>array('index')),
	array('label'=>'Gérer les demandes', 'url'=>array('admin'), 'visible'=> !Yii::app()->user->isGuest && $user['type'] =='T' || $user['type'] =='A'),
);
?>

<h1><img src="./css/logoquestion.png" class="imgTitles"/>Créer une demande de travail interne</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>