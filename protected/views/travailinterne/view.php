<?php
/* @var $this TravailinterneController */
/* @var $model Travailinterne */

$this->breadcrumbs=array(
	'Travail interne'=>array('index'),
	$model->id,
);
	$user = Yii::app()->db->createCommand()
    ->select('type')
    ->from('utilisateur')
    ->where('idutilisateur=:id', array(':id'=>Yii::app()->user->id))
    ->queryRow();
    //$user['type']
$this->menu=array(
    array('label'=>'Calendrier', 'url'=>array('calendar'), 'visible'=> !Yii::app()->user->isGuest && $user['type'] !='U'),
	array('label'=>'Liste des demandes', 'url'=>array('index')),
	array('label'=>'Créer une demande', 'url'=>array('create')),
	array('label'=>'Modifier cette demande', 'url'=>array('update', 'id'=>$model->id), 'visible'=> !Yii::app()->user->isGuest && $user['type'] =='C'),
	array('label'=>'Supprimer cette demande', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'La suppression va envoyer un mail d\'annulation au service technique, confirmer la suppression ?'), 'visible'=> !Yii::app()->user->isGuest && $user['type'] !='U'),
	array('label'=>'Gérer les demandes', 'url'=>array('admin'), 'visible'=> !Yii::app()->user->isGuest && $user['type'] =='T' || $user['type'] =='A'),
);
?>

<h1><img src="./css/logofile.png" class="imgTitles"/>Détails de la demande numéro <?php echo $model->id; ?></h1>

<?php 
if(!isset($model->idligne0->name)){
	$nameLigne='Pas de ligne demandée';
}
else{
	$nameLigne=$model->idligne0->name;	
}
//FORMATING DATES TO FRENCH FORMAT --------------------------------------
if(isset($model->dateDebut)){
    $model->dateDebut = strtotime ($model->dateDebut);
    $model->dateDebut = date ('d/m/Y H\h i\m', $model->dateDebut);
}

if(isset($model->dateFin)){
    $model->dateFin = strtotime ($model->dateFin);
    $model->dateFin = date ('d/m/Y H\h i\m', $model->dateFin);
}

if(isset($model->dateDemande)){
    $model->dateDemande = strtotime ($model->dateDemande);
    $model->dateDemande = date ('d/m/Y H\h i\m', $model->dateDemande);
}
if(isset($model->dateModif)){
    $model->dateModif = strtotime ($model->dateModif);
    $model->dateModif = date ('d/m/Y H\h i\m', $model->dateModif);
}
//------------------------------------------------------------------------
	if(is_null($model->docsource)|| !isset($model->docsource) || $model->docsource==''){
		$docsource='Aucun fichier n\'a été ajouté';
	}
	else{
		$docsource=CHtml::link('Télécharger le fichier',array('travailinterne/download',
                                     'id'=>$model->id,
                                     ));
	}
	$this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		array(
			'name'=>'idutilisateurDemande',
		    'type'=>'raw',
			'value'=>CHtml::link($model->idutilisateurDemande, './index.php?r=utilisateur/view&id='.$model->idutilisateurDemande),
		),
		array(
		    'name'=>'Demandeur (initiales)',
		    'value'=>$model->idutilisateurDemande0->initiale,
		),
		array(
			'name'=>'idutilisateurModif',
		    'type'=>'raw',
			'value'=>CHtml::link($model->idutilisateurModif, './index.php?r=utilisateur/view&id='.$model->idutilisateurModif),
		),
		'nomClient',
		'dateDemande',
		'dateDebut',
		'dateFin',
		'dateModif',
		array(
		    'name'=>'Salle',
		    'value'=>$model->idsalle0->name,
		),
		array(
		    'name'=>'Ligne',
			'type'=>'raw',
            'value'=>'<b style="color:green">'.CHtml::encode($nameLigne).'</b>',
		),
		array(
			'name'=>'docsource',
			'type'=>'raw',
			'value'=>$docsource,
		),

	),
)); ?>
<br/>
<h6>Description de la demande</h6>
<div class="textDisplay">
<?php 
echo $model->description; 
?>
</div><br/>

