<?php		


	// function rotate_2d_array($array)
	// {
	//     $result = array();
	//     foreach (array_values($array) as $key => $sub_array)
	//     {
	//         foreach (array_values($sub_array) as $sub_key => $value)
	//         {
	//             if (empty($result[$sub_key]))
	//             {
	//                 $result[$sub_key] = array($value);
	//             }
	//             else
	//             {
	//                 array_unshift($result[$sub_key], $value);
	//             }
	//         }
	//     }
	//     return $result;
	// }
	//$res = fgetcsv(fopen('disabilitydata.csv','r'),0);
	$dataFile = fopen('diabetesdata.csv','r');
	//$dataFile = fopen('dat.csv','r');
	$res = [];

	$names = fgetcsv($dataFile,0,","," ","\n");
	//$names = array_slice($names, 1);
	//$x = 0;
	
	while($row = fgetcsv($dataFile,0,","," ","\n") ){
		// if($x>0){
		// 	settype($row[1],'integer');
		// 	settype($row[2],'integer');

		// }
		//$row= array_slice($row,1);
		$temp = [];
		for($i = 0; $i< sizeof($names);$i++){
			$temp[$names[$i]] = $row[$i];
			//$a = $row[0]/10;
			//settype($a,'integer');
			//if($a==0) $a='';
			//$grp = $a.'1-'.($a+1).'0';
			
		}

		$temp['group'] = $temp['age'];
		if($temp['group'] == -1){
			$temp['group'] = "NA";
		}

		
		//$row['group'] = $row['age'];

		
		//array_push($res, array_slice($row,1));
		//array_push($res, $row);
		array_push($res,$temp);
		//$x++;
	}

	//$res = rotate_2d_array($res);
	
	$results['names'] = $names;

	//for($x = 1;$x < sizeof($res);$x++) settype($res[$x][1],'integer');

	// for($x = 1;$x < sizeof($res)-1;$x++){
	// 	for($y = 2;$y < sizeof($res);$y++){

	// 		$a = $res[$x][1];
	// 		//settype($a,'integer');

	// 		$b = $res[$y][1];
	// 		//settype($b,'integer');

	// 		if($a>$b){
	// 			$row = $res[$x];
	// 			$res[$x] = $res[$y];
	// 			$res[$y] = $row;
	// 		}
	// 	}
	// }

	$results['data'] = $res;

	echo json_encode($results);


?>