<script>
$(".container").before("\
	<div class='sideMenu'>\
		<p><a href='./index.php?r=hotelitem/index'>Objets</a></p>\
		<p><a href='./index.php?r=categorie/index'>Catégories</a></p>\
	</div>\
");
</script>
<?php
/* @var $this CategorieController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Categories',
);

$this->menu=array(
	array('label'=>'Créer une catégorie', 'url'=>array('create')),
	array('label'=>'Gérer les catégories', 'url'=>array('admin')),
);
?>

<h1><img src="./css/logofolder.png" class="imgTitles"/>Catégories</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
