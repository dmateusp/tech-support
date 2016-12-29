<script>
$(".container").before("\
	<div class='sideMenu'>\
		<p><a href='./index.php?r=utilisateur/index'>Utilisateurs</a></p>\
		<p><a href='./index.php?r=departement/index'>Départements</a></p>\
	</div>\
");
</script>
<?php
/* @var $this DepartementController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Départements',
);

$this->menu=array(
	array('label'=>'Créer un département', 'url'=>array('create')),
	array('label'=>'Gérer les déparements', 'url'=>array('admin')),
);
?>

<h1><img src="./css/logofolder.png" class="imgTitles"/>Départements</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
