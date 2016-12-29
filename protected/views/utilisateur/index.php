<script>
$(".container").before("\
	<div class='sideMenu'>\
		<p><a href='./index.php?r=utilisateur/index'>Utilisateurs</a></p>\
		<p><a href='./index.php?r=departement/index'>Départements</a></p>\
	</div>\
");
</script>
<?php
/* @var $this UtilisateurController */
/* @var $dataProvider CActiveDataProvider */
$this->breadcrumbs=array(
	'Utilisateurs',
);

$this->menu=array(
	array('label'=>'Créer utilisateurs', 'url'=>array('create')),
	array('label'=>'Gérer utilisateurs', 'url'=>array('admin')),
);
?>

<h1><img src="./css/logouser.png" class="imgTitles"/>Utilisateurs</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
