<?php
/* @var $this TicketsupportController */
/* @var $model Ticketsupport */

$this->breadcrumbs=array(
	'Demandes au support'=>array('index'),
	'Créer',
);

$this->menu=array(
	array('label'=>'Liste des demandes', 'url'=>array('index')),
);
?>
<?php
Yii::app()->clientScript->registerScript('imgs', "

	$('#categorieId').change(function(){
		$('#img').children().attr('src', '');		
	});
"
,CClientScript::POS_END);

?>

<h1><img src="./css/logoquestion.png" class="imgTitles"/>Faire une demande au support</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
