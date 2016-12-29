<?php
/* @var $this SalleController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
    'Travail interne'=>array('travailinterne/index'),
	'Salles',
);

$this->menu=array(
    array('label'=>'Calendrier des réservations des salles', 'url'=>array('travailinterne/calendar')),
	array('label'=>'Créer une salle', 'url'=>array('create')),
	array('label'=>'Gérer les salles', 'url'=>array('admin')),
);
?>

<h1><img src="./css/logofile.png" class="imgTitles"/>Liste des salles</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
