<script>
$(".container").before("\
	<div class='sideMenu'>\
		<p><a href='./index.php?r=hotelitem/index'>Objets</a></p>\
		<p><a href='./index.php?r=categorie/index'>Catégories</a></p>\
	</div>\
");
</script>
<?php
/* @var $this HotelitemController */
/* @var $dataProvider CActiveDataProvider */
$this->breadcrumbs=array(
	'Gestion des objets',
);

$this->menu=array(
	array('label'=>'Créer un objet', 'url'=>array('create')),
	array('label'=>'Gérer les objets', 'url'=>array('admin')),
);
?>

<h1><img src="./css/logosettings.png" class="imgTitles"/>Objets</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
