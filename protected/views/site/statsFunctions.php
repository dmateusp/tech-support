<?php 

function getOnlyWantedItems($count,$data_array,$data,$objetshotel){
	foreach($data as $key=>$value)
	{



		//$count
	    if(isset($objetshotel) && $objetshotel!=''){

	        if(in_array($value['idhotelitem'],$objetshotel)){
	            foreach($count as $key=>$val){

	                if($value['idhotelitem']==$val['idhotelitem'])
	                    if(!in_array($value["name"],$data_array))
	                        array_push($data_array,array($value["name"],intval($val["count(*)"])));

	            }
	            
	        }
	    }

	}
	return $data_array;
}
function getAverageResolveDuration($startDate,$endDate){

    $durationResolveTicket = Yii::app()->db->createCommand()
        ->select("DATEDIFF(dateClotureTicket,datePriseEnCharge) as datediff, DATEDIFF(finDateAttente,debDateAttente) as datediffAttente")
        ->from('ticketsupport t')
        ->where('dateDemande BETWEEN :startDate AND :endDate', array(':startDate'=> $startDate,
                                                        ':endDate'=> $endDate))
        ->queryAll();

    $durationCount = Yii::app()->db->createCommand()
        ->select("count(*) as total")
        ->from('ticketsupport t')
        ->where('dateDemande BETWEEN :startDate AND :endDate', array(':startDate'=> $startDate,
                                                        ':endDate'=> $endDate))
        ->andWhere('dateClotureTicket IS NOT NULL')

        ->queryRow();
    $total=0;
    foreach($durationResolveTicket as $key=>$value){
    	if($value['datediff']!=null)
    		$total=$total+$value['datediff'];
        if($value['datediffAttente']!=null)
            $total=$total-$value['datediffAttente'];
    }

    if($durationCount['total']!=0)
    	$moyenne=$total/$durationCount['total'];
    else
    	$moyenne=0;
    return $moyenne;
}

?>