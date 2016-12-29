<script>
$(".container").before("\
	<div class='sideMenu'>\
		<p><a href='./index.php?r=ticketsupport/index'>Demande de support</a></p>\
		<p><a href='./index.php?r=travailinterne/index'>Demande de travail interne</a></p>\
	</div>\
");
</script>
<?php
/* @var $this TicketsupportController */
/* @var $dataProvider CActiveDataProvider */
$this->breadcrumbs=array(
	'Demandes au support',
);

	$user = Yii::app()->db->createCommand()
    ->select('type')
    ->from('utilisateur')
    ->where('idutilisateur=:id', array(':id'=>Yii::app()->user->id))
    ->queryRow();
    //$user['type']

$this->menu=array(
	array('label'=>'Créer une demande support', 'url'=>array('create') ,'visible'=> !Yii::app()->user->isGuest),
	array('label'=>'Gérer les demandes support', 'url'=>array('admin') , 'visible'=> !Yii::app()->user->isGuest && $user['type'] =='T' || $user['type'] =='A'),
	
);
?>

<h1><img src="./css/logofile.png" class="imgTitles"/>Liste des demandes au support</h1>
<h2>Différents statuts :</h2>
<ul class="operations">
	<li><img src="./css/logofile_rose.png" class="imgTitles"/><b>Créé</b>, la demande n'a pas encore été affectée à un membre du service technique</li>
	<li><img src="./css/logofile_jaune.png" class="imgTitles"/><b>Pris en charge</b>, la demande est en cours de traitement</li>
	<li><img src="./css/logofile_vert.png" class="imgTitles"/><b>Clôturé</b>, la demande a été traitée</li>
	<li><img src="./css/logofile_bleu.png" class="imgTitles"/><b>En attente</b>, la demande ne peut pas être traitée pour le moment (exemple de raison : des objets doivent être commandés)</li>		
</ul>
<div class="form">
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

	if(isset($_POST['listTemps'])){
		$temps=$_POST['listTemps'];
	}else{
		$temps='semaine';
	}
	echo CHtml::dropDownList('listTemps', $temps, 
	              array('semaine' => 'Cette semaine', 'mois'=> 'Ce mois','annee' => 'Cette année'));
	echo CHtml::dropDownList('listFiltre', $select, 
	              array('mesdemandes' => 'Mes demandes', 'tout' => 'Toutes les demandes de mon département'));?>
	<?php echo CHtml::submitButton('Valider'); ?>
    <?php $this->endWidget(); ?>
</div>
<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>

