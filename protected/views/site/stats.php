<?php
/* @var $this SiteController */
?>
<div class="noprint">
<?php
    $this->pageTitle=Yii::app()->name . ' - Stats';
    $this->breadcrumbs=array(
    	'Stats',
    );
    ?>
    <h1><img src="./css/logostats.png" class="imgTitles"/> Stats</h1>

<!--FORM TO SELECT DATA-->
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
	<div class="row">  
    Choix des objets :
 <?php 
    if(isset($_POST['Hotelitem']['checkBoxObj']))
        $objetshotel=$_POST['Hotelitem']['checkBoxObj'];

    $this->widget('ext.EchMultiSelect.EchMultiSelect', array(
                    'model' => Hotelitem::model(),
                    'dropDownAttribute' => 'checkBoxObj',
                    'data' => CHtml::listData( Hotelitem::model()->findAll( array( 'order' => 'idhotelitem' ) ), 'idhotelitem', 'name' ),
                    'options' => array('buttonWidth' => 80, 'ajaxRefresh' =>false,'filter'=>true),
                    'dropDownHtmlOptions'=> array(
                    'id'=>'checkBoxObj',
                                            ),
                    )
                );
 
/*
	$opts = CHtml::listData(Hotelitem::model()->findAll(),'idhotelitem','name');

	?>
	<table align="center" class="typeObj">
	<th><h3><?php echo CHtml::label('Type d\'objet','dropDownObj');?></h3> </th>
	<tr>
	<?php
    $htmloptscheckbox = array(
        'id' => 'checkBoxObj',
        'template'=>'<td>{label}{input}</td>',
        'selected'=>'true',
        );
    if(!isset($objetshotel))
        $objetshotel=array();
	echo CHtml::checkBoxList('checkBoxObj',$objetshotel,$opts,$htmloptscheckbox);    
 */?><tr>
 	</tr>
 	 </table>
	</div>

	<div class="row" >
    Période : <input type="text" placeholder="JJ/MM" name="startDate" value="<?php if(isset($_POST['startDate'])) echo $_POST['startDate'];?>"/>

    -
    <input type="text" placeholder="JJ/MM" name="endDate" value="<?php if(isset($_POST['endDate'])) echo $_POST['endDate'];?>"/>
    </div>

    <div class="row">
    Année : <input type="text" placeholder="AAAA" name="annee" value="<?php if(isset($_POST['annee'])) echo $_POST['annee'];?>"/>
    </div>
	<div class="row buttons">
		<?php echo CHtml::submitButton('Valider'); ?>
	</div>

    <?php $this->endWidget(); ?>
</div>
</div>
<!--FORM TO SELECT DATA #END-->

<!--GRAPH DISPLAYS-->
<?php if (isset($research)){ ?>

        <?php include_once 'statsFunctions.php'; ?>

    <div class="row"> 
        <div class="span6" >  
            <?php
            if(isset($objetshotel) && $objetshotel!=''){
                $data = Hotelitem::model()->findAll();
                $data_array=array();
                //$value["name"]
                if(!isset($startDate) || $startDate=='')
                    $startDate = '0000-00-00';
                if(!isset($endDate) || $endDate=='')
                    $endDate = '9999-12-31';
                array_push($data_array,array('Objets', 'Nombre de demandes'));
                    $count = Yii::app()->db->createCommand()
                        ->select('count(*),idhotelitem')
                        ->from('ticketsupport')
                        ->where('dateDemande BETWEEN :startDate AND :endDate', array(':startDate'=> $startDate,
                                                                        ':endDate'=> $endDate))
                        ->group('idhotelitem')
                        ->queryAll();

                $data_array=getOnlyWantedItems($count,$data_array,$data,$objetshotel);

            }   

        if(isset($objetshotel) && $objetshotel!=''){
            echo "<h3>Période :</h3>";
            if(isset($_POST['startDate'])&& $_POST['startDate']!='')
                echo $_POST['startDate'].'/'.$_POST['annee'].' - ';
            if(isset($_POST['endDate'])&& $_POST['endDate']!='')
                echo $_POST['endDate'].'/'.$_POST['annee'];


            echo "<p><h3>Moyenne de temps pris pour résoude une demande :</h3></p>";
            echo getAverageResolveDuration($startDate,$endDate)*24;
            echo " heures par demande.";
    	//very useful google chart
            $this->widget('ext.Hzl.google.HzlVisualizationChart', array('visualization' => 'PieChart',
                'data' => $data_array,
                
                'options' => array('title' => 'Répartition des demandes')));
     
        }
            ?>
     
        </div>
    </div>
     
     
     
    <div class="row"> 
        <div class="span6" >  
    <?php
        if(isset($objetshotel) && $objetshotel!=''){
            $countByMonth = Yii::app()->db->createCommand()
                ->select('count(*),t.idhotelitem,name,MONTH(dateDemande)')
                ->from('ticketsupport t')
                ->join('hotelitem h', 'h.idhotelitem=t.idhotelitem')
                ->where('dateDemande BETWEEN :startDate AND :endDate', array(':startDate'=> $startDate,
                                                                ':endDate'=> $endDate))
                ->group('idhotelitem,MONTH(dateDemande)')
                ->queryAll();
            $data_by_interval = array(
                        
                );
            $part_data_names = array('Mois');
            $part_data_months = array();
            foreach($countByMonth as $key=>$value)
            {
                foreach($value as $k=>$v){
                    

                    if(in_array($value['idhotelitem'],$objetshotel)){
                        if($k=='name')
                            if(!in_array($v, $part_data_names))
                                array_push($part_data_names,$v);

                        if($k=='MONTH(dateDemande)'){
                            if(!isset($part_data_months[$v]))
                                $part_data_months[$v]=array(date('F', mktime(0, 0, 0, $v, 10)));
                            $part_data_months[$v][array_search($value['name'],$part_data_names)]=intval($value['count(*)']);
                            
                        }
                        //array_push($data_by_interval[$k],$v);
                    }

                }


            }
            array_push($data_by_interval,$part_data_names);
            $maxsize=0;
            foreach($part_data_months as $key=>$value){
                if($maxsize<max(array_keys($value)))
                    $maxsize=max(array_keys($value));
            }
            ksort($part_data_months);
            foreach($part_data_months as $key=>$value){
                for($i=0;$i<$maxsize+1;$i++){
                    if(!isset($value[$i])){

                        $value[$i]=0;
                    }
                }
                ksort($value);
                //sort($value);
                array_push($data_by_interval, $value);
            }
            $this->widget('ext.Hzl.google.HzlVisualizationChart', array('visualization' => 'ColumnChart',
                        'data' => $data_by_interval,
                        'options' => array(
                            'title' => 'Demandes par mois',
                            'titleTextStyle' => array('color' => '#FF0000'),
                            'vAxis' => array(
                                'title' => 'Demandes',
                            ),
                            'hAxis' => array('title' => 'Mois'),
                            'curveType' => 'function', //smooth curve or not
                            
                    )));
        }
}     
    ?>
    	</div>
    </div>

<!--GRAPH DISPLAYS #END-->