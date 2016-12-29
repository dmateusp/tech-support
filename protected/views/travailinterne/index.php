<script>
$(".container").before("\
    <div class='sideMenu'>\
        <p><a href='./index.php?r=ticketsupport/index'>Demande de support</a></p>\
        <p><a href='./index.php?r=travailinterne/index'>Demande de travail interne</a></p>\
    </div>\
");
</script>
<?php
/* @var $this TravailinterneController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Travail interne',
);
	$user = Yii::app()->db->createCommand()
    ->select('type')
    ->from('utilisateur')
    ->where('idutilisateur=:id', array(':id'=>Yii::app()->user->id))
    ->queryRow();
    //$user['type']
$this->menu=array(
    array('label'=>'Calendrier des réservations des salles', 'url'=>array('calendar'), 'visible'=> !Yii::app()->user->isGuest && $user['type'] !='U'),
	array('label'=>'Créer une demande', 'url'=>array('create')),
	array('label'=>'Gérer les demandes', 'url'=>array('admin'), 'visible'=> !Yii::app()->user->isGuest && $user['type'] =='T' || $user['type'] =='A'),
	array('label'=>'Gestion des lignes telephoniques', 'url'=>array('ligne/index'), 'visible'=> !Yii::app()->user->isGuest && $user['type'] =='T' || $user['type'] =='A'),
	array('label'=>'Gestion des salles', 'url'=>array('salle/index'), 'visible'=> !Yii::app()->user->isGuest && $user['type'] =='T' || $user['type'] =='A'),
);
?>

<h1><img src="./css/logofile.png" class="imgTitles"/>Travail interne - Liste</h1>
    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'stats-form',
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // There is a call to performAjaxValidation() commented in generated controller code.
        // See class documentation of CActiveForm for details on this.
        'enableAjaxValidation'=>false,
        'htmlOptions' => array(
            'enctype' => 'multipart/form-data',
        ),
    )); ?>
<?php
	if(isset($_POST['listFiltre'])){
		$select=$_POST['listFiltre'];
	}else{
		$select='mesdemandes';
	}

	echo CHtml::dropDownList('listFiltre', $select, 
	              array('mesdemandes' => 'Mes demandes', 'tout' => 'Toutes les demandes de mon département'));?>
	<?php echo CHtml::submitButton('Valider'); ?>
    <?php $this->endWidget(); ?>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); 

?>
