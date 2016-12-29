<?php
/* @var $this TicketsupportController */
/* @var $model Ticketsupport */
$this->breadcrumbs=array(
	'Demandes support'=>array('index'),
	$model->idticketSupport,
);
	$user = Yii::app()->db->createCommand()
    ->select('type')
    ->from('utilisateur')
    ->where('idutilisateur=:id', array(':id'=>Yii::app()->user->id))
    ->queryRow();
    //$user['type']
$this->menu=array(
	array('label'=>'Liste des demandes support', 'url'=>array('index')),
	array('label'=>'Créer une demande', 'url'=>array('create'), 'visible' => !Yii::app()->user->isGuest),
	//array('label'=>'Modifier cette demande',  'visible'=> !Yii::app()->user->isGuest && $user['type'] =='A','url'=>array('update', 'id'=>$model->idticketSupport) ),
	array('label'=>'Supprimer cette demande', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->idticketSupport),'confirm'=>'Confirmer la suppression ?'),  'visible'=> !Yii::app()->user->isGuest && $user['type'] =='A'),
	array('label'=>'Gérer les demandes', 'url'=>array('admin'), 'visible'=> !Yii::app()->user->isGuest && $user['type'] =='T'),
);
$model->initialeDemandeur=$model->getInitialeDemandeur();
$model->initialeTechnicien=$model->getInitialeTechnicien();
if($model->statut!=2 && $model->statut!=3){
	if($model->debDateAttente==null)
		array_push($this->menu,array('label'=>'Mettre la demande en attente', 'url'=>'#', 'linkOptions'=>array('submit'=>array('enattente','id'=>$model->idticketSupport),),  'visible'=> !Yii::app()->user->isGuest && $user['type'] !='U' && $user['type'] !='G'));
	if($model->initialeTechnicien==null){
		array_push($this->menu,array('label'=>'Je traite cette demande', 'url'=>'#', 'linkOptions'=>array('submit'=>array('traiter','id'=>$model->idticketSupport),'confirm'=>'Êtes-vous sûr de prendre en charge la demande ?'),  'visible'=> !Yii::app()->user->isGuest && $user['type'] =='T'));
	}
	else{
		if($model->statut!=3){
			array_push($this->menu,array('label'=>'Je clôture la demande', 'url'=>'#', 'linkOptions'=>array('submit'=>array('cloturer','id'=>$model->idticketSupport),'confirm'=>'Êtes-vous sûr de clôturer la demande ?'), 'visible'=> !Yii::app()->user->isGuest && $user['type'] !='U' && $user['type'] !='G'));	
		}
	}
}
if($model->statut==2){

	array_push($this->menu,array('label'=>'Enlever le statut en attente à la demande', 'url'=>'#', 'linkOptions'=>array('submit'=>array('sortirattente','id'=>$model->idticketSupport),),  'visible'=> !Yii::app()->user->isGuest && $user['type'] !='U' && $user['type'] !='G' ));
}

?>

<h1><img src="./css/logofile.png" class="imgTitles"/>Détails de la demande numéro <?php echo $model->idticketSupport; ?></h1>

<?php
$model->nameitem = Hotelitem::model()->findByPk($model->idhotelitem)->name;
$model->namedepartement = $model->idutilisateurDemande0->utilisateurs0->name;
if(isset($model->dateClotureTicket)){
    $model->dateClotureTicket = strtotime ($model->dateClotureTicket);
    $model->dateClotureTicket = date ('d/m/Y H\h i\m', $model->dateClotureTicket);
}

if(isset($model->datePriseEnCharge)){
    $model->datePriseEnCharge = strtotime ($model->datePriseEnCharge);
    $model->datePriseEnCharge = date ('d/m/Y H\h i\m', $model->datePriseEnCharge);   	
}

if(isset($model->dateDemande)){
    $model->dateDemande = strtotime ($model->dateDemande);
    $model->dateDemande = date ('d/m/Y H\h i\m', $model->dateDemande);
}

if(isset($model->debDateAttente)){
$model->debDateAttente = strtotime ($model->debDateAttente);
$model->debDateAttente = date ('d/m/Y H\h i\m', $model->debDateAttente);
}

if(isset($model->finDateAttente)){
    $model->finDateAttente = strtotime ($model->finDateAttente);
    $model->finDateAttente = date ('d/m/Y H\h i\m', $model->finDateAttente);    		
}
 $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'idticketSupport',
	    array(
	        'name'=>'statut',
	        'value'=>$model->getValueStatut(),
	    ),
		'nameitem',
		'description',
		'lieu',
		'commentaire',
		'dateDemande',
		'datePriseEnCharge',
		'dateClotureTicket',
		'debDateAttente',
		'finDateAttente',
		array(
			'name'=>'idutilisateurDemande',
		    'type'=>'raw',
			'value'=>CHtml::link($model->idutilisateurDemande, './index.php?r=utilisateur/view&id='.$model->idutilisateurDemande),
		),
		'initialeDemandeur',
		'namedepartement',
		array(
			'name'=>'idtechnicien',
		    'type'=>'raw',
			'value'=>CHtml::link($model->idtechnicien, './index.php?r=utilisateur/view&id='.$model->idtechnicien),
		),
		'initialeTechnicien',
	),

)); 
?>