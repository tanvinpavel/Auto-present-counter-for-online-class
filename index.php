<?php

$elements = scandir(getcwd().DIRECTORY_SEPARATOR."files");



foreach($elements as $element){
    if($element != '.' && $element != '..'){
        $size = filesize("files".DIRECTORY_SEPARATOR.$element);
        if($size > 0){
            $asst[] = $element;
        }
    }
}

$filePointer = fopen('reference.txt', 'r');

while(!feof($filePointer)){ //file end of file(feof)

	if($filePointer != ''){
		$all_data = fgets($filePointer);

		$pair = explode("#", $all_data);
		
		if($pair[1] != NULL){
			$name[] = $pair[0];
			$roll[] = trim(preg_replace('/\n/',' ', $pair[1]));
		}
	}	
}

function presentChecker($roll, $fileName){
    $file_path = "files".DIRECTORY_SEPARATOR.$fileName;
    $file = fopen($file_path, 'r');
    $size = filesize($file_path);
    
    if($size > 0){
        $data = fread($file, $size);
        $attendance = strpos($data, $roll);
        return $attendance;
    }
}

fclose($filePointer);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Auto present Counter</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
	<div class="main">
    <h1 class="text-center">Auto Present Counter</h1>
	<h3 class="text-center">Subject: Android App Development</h3>
    <h3 class="text-center">Computer Department(7th Semester)</h3>
    <!-- <a href="">Download Report</a> -->
    <div class="container">
        <table>
            <thead>
                <tr>
                    <th>Serial</th>
                    <th>Name</th>
                    <th>Roll</th>
                    <!-- print date in table header -->
                    <?php foreach($asst as $x){ ?>
                        <th style="text-align: center;"><?php echo basename($x,".txt") ?></th>
                    <?php } ?>
                    <th>Present(%)</th>
                </tr>
            </thead>
            
            <tbody>
                <!-- counting every student -->
                <?php for($i=0,$j=1; $i<count($name); $i++,$j++){ ?>
                <tr>
                    <td><?php echo $j ?></td>
                    <td style="min-width: 190px;"><?php echo $name[$i] ?></td>
                    <td><?php echo $roll[$i] ?></td>

                    <!-- student present or not -->
                    <?php foreach($asst as $x){ ?>


                        
                        <td style="min-width: 103px; text-align: center; font-weight: 500;">
                            <?php
                                $pavel = gettype(presentChecker($roll[$i],$x));
                                if($pavel == "integer"){
                                    echo "<span style='color: green;'>P</span>";
                                    static $p = 0;
                                    $student[$roll[$i]] = ++$p;
                                }else{
                                    echo "<span style='color: brown;'>A</span>";
                                }
                            ?>
                        </td>
                    <?php } $p = 0; ?>
                    
                    <td style="text-align: center; font-weight: 700;"><?php 
                        if(isset($student[$roll[$i]])){
                            $present = ($student[$roll[$i]] * 100) / count($asst);
							if(is_double($present)){
								echo number_format($present, 2).'%';
								
							}else{
								echo $present.'%';
							}
                        }else{
                            echo '0%';
                        }
                    ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <footer class="footer-section">
        <p>&copy; Computer Department 52th Batch (1st Shift)</p>
    </footer>
	</div>
</body>
</html>

