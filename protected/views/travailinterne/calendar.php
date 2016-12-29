<div class="noprint">
<?php

$this->breadcrumbs=array(
    'Travail interne'=>array('index'),
    'Calendrier',
);
    $user = Yii::app()->db->createCommand()
    ->select('type')
    ->from('utilisateur')
    ->where('idutilisateur=:id', array(':id'=>Yii::app()->user->id))
    ->queryRow();
    //$user['type']
$this->menu=array(
    array('label'=>'Liste des demandes', 'url'=>array('index'), 'visible'=> !Yii::app()->user->isGuest && $user['type'] !='S' && $user['type'] !='U'),
    array('label'=>'Créer une demande', 'url'=>array('create'),'visible'=> !Yii::app()->user->isGuest && $user['type'] !='S' && $user['type'] !='U'),
    array('label'=>'Gérer les demandes', 'url'=>array('admin'), 'visible'=> !Yii::app()->user->isGuest && $user['type'] =='T' || $user['type'] =='A'),
    array('label'=>'Gestion des lignes telephoniques', 'url'=>array('ligne/index'), 'visible'=> !Yii::app()->user->isGuest && $user['type'] =='T' || $user['type'] =='A'),
    array('label'=>'Gestion des salles', 'url'=>array('salle/index'), 'visible'=> !Yii::app()->user->isGuest && $user['type'] =='T' || $user['type'] =='A'),
);
?>

<!--<div class="view center">
<div class="form">-->
    <?php /* $form=$this->beginWidget('CActiveForm', array(
        'id'=>'calendarEmber-form',
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // There is a call to performAjaxValidation() commented in generated controller code.
        // See class documentation of CActiveForm for details on this.
        'enableAjaxValidation'=>false,
        'htmlOptions' => array(
            'enctype' => 'multipart/form-data',
        ),
    )); */ ?>
    <!--<b><?php
        //echo CHtml::encode("Afficher uniquement la semaine (pour n'imprimer qu'une semaine) : "); ?></b>
    <div class="row">-->
    <?php 
        /*
        //ARRAY OF WEEKS
        $weeks=array();

        //WE GET THE FIRST MONDAY OF MONTH
        date_default_timezone_set('Europe/Paris');
        //$date = new DateTime(date('Y-m-00', time()));
        $date = new DateTime(date('Y-m-00', time()));
        $firstMond = $date->modify('first monday')->format('d');
        $daysInMonth = cal_days_in_month(0, date("m"), date("Y"));
        $j=0;
        for($i=$firstMond;1+7*($i-1)<$daysInMonth;$i++){
            $lun = 1+7*($i-1);
            $dim = $i*7;
            if($dim>$daysInMonth)
                $dim = $dim-$daysInMonth;
            if($lun<10)
                $lun='0'.$lun;
            if($dim<10)
                $dim='0'.$dim; 
            $week = array("week_".$j+1 =>"du Lundi ". $lun ." au Dimanche ".$dim);
            $weeks[$lun.'-'.$dim]=$week["week_".$j+1];
            $j++;
        }

        //var_dump($models);
        $opts = CHtml::listData($weeks,'weekNumber','details');
        $select ='';
        if(isset($_POST['week'])&&$_POST['week']!='')
            $select = $_POST['week'];
        echo CHtml::dropDownList('week',$select,$weeks,array('empty'=>'(Choisissez une semaine)')); 
        ?>  

    </div>
    <?php echo CHtml::submitButton('Valider'); ?>
    <?php $this->endWidget(); */?>
<!--</div>-->


<?php
if(isset($_POST['week'])&&$_POST['week']!='')
    $week=$_POST['week'];
else
    $week='-1';


?>
<!--</div>-->
<h1><img src="./css/logocalendar.png" class="imgTitles"/>Calendrier des réservations des salles</h1>

<div id="calendar-container">
<?php

 $this->widget('ext.fullcalendar.EFullCalendarHeart', array(
    //'themeCssFile'=>'cupertino/jquery-ui.min.css',
    'id'=>'calendar',
    'options'=>array(
        'header'=>array(
            'left'=>'prev,next,today',
            'center'=>'title',
            'right'=>'month,agendaWeek,agendaDay',
        ),
        'events'=>$this->createUrl('travailinterne/calendarevents&week='.$week), // URL to get event
        'eventClick'=>'js:function(calEvent, jsEvent, view) {
            window.location.href = "'.Yii::app()->createUrl("travailinterne/view&id=").'"+calEvent.id;

        }',

    )));
?>
</div>
</div>
<?php $this->renderPartial('_weeklyCalendar', array('model'=>$this)); ?>
