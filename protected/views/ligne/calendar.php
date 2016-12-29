<?php
$this->breadcrumbs=array(
    'Travail interne'=>array('travailinterne/index'),
	'Lignes'=>array('index'),
    'Calendrier',
);

    $user = Yii::app()->db->createCommand()
    ->select('type')
    ->from('utilisateur')
    ->where('idutilisateur=:id', array(':id'=>Yii::app()->user->id))
    ->queryRow();
    //$user['type']

$this->menu=array(
    array('label'=>'Liste des lignes', 'url'=>array('index'), 'visible'=> !Yii::app()->user->isGuest && $user['type'] !='S' && $user['type'] !='U'),
	array('label'=>'Créer une ligne', 'url'=>array('create'), 'visible'=> !Yii::app()->user->isGuest && $user['type'] !='S' && $user['type'] !='U'),
	array('label'=>'Gérer les lignes', 'url'=>array('admin'), 'visible'=> !Yii::app()->user->isGuest && $user['type'] !='S' && $user['type'] !='U'),
);
?>
<h1><img src="./css/logocalendar.png" class="imgTitles"/>Calendrier d'utilisation des lignes</h1>

<?php  $this->widget('ext.fullcalendar.EFullCalendarHeart', array(
    //'themeCssFile'=>'cupertino/jquery-ui.min.css',
    'options'=>array(
        'header'=>array(
            'left'=>'prev,next,today',
            'center'=>'title',
            'right'=>'month,agendaWeek,agendaDay',
        ),
        'events'=>$this->createUrl('ligne/calendarevents'), // URL to get event
        'eventClick'=>'js:function(calEvent, jsEvent, view) {
            window.location.href = "'.Yii::app()->createUrl("travailinterne/view&id=").'"+calEvent.id;

        }',

    ))); ?>