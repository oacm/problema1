<?php

$dir = opendir("entrada/"); //ruta actual
while ($filedir = readdir($dir)){
    if (!is_dir($filedir)){
        if(!strpos($filedir, 'zip')){
            $name=explode('.',$filedir);
            $file = fopen("entrada/".$filedir, "r");
            $countRow=0;
            $lengths=null;
            $instruction1=null;
            $instruction2=null;
            $message=null;
            // get info file
            while (!feof($file)){
                $row = fgets($file);
                switch ($countRow) {
                    case 0:
                        $lengths=explode(" ", $row);
                        break;
                    case 1:
                        $instruction1=$row;
                        break;
                    case 2:
                        $instruction2=$row;
                        break;
                    case 3:
                        $message=$row;
                        break;        
                }
                $countRow++;
            }
            fclose($file);

            //process info
            $arrChar=array();
            for($i=0;$i<=$lengths[2];$i++)
            {
                if ($message[$i+1]){
                    if(($message[$i]<>$message[$i+1]) || (($i+1) == ($lengths[2]-1))){
                        $arrChar[]=$message[$i];
                    }
                }
            }
            $messageClear=implode($arrChar);

            //process output
            $fileout = fopen('salida/salida'.'_'.$name[0].'.txt','w+'); 
            if ((preg_match('([a-zA-Z0-9])',$messageClear)) && (strlen(trim($instruction1))>=2 && strlen(trim($instruction1))<=50) && (strlen(trim($instruction2))>=2 && strlen(trim($instruction2))<=50) && (strlen(trim($messageClear))>=3 && strlen(trim($messageClear))<=5000)) {
                if (strpos($messageClear,trim($instruction1))===false){
                    fwrite($fileout,'NO'.PHP_EOL);
                    fwrite($fileout,'SI');
                }else{
                    fwrite($fileout,'SI'.PHP_EOL);
                    fwrite($fileout,'NO');
                }
            }else{
                fwrite($fileout,'NO'.PHP_EOL);
                fwrite($fileout,'NO');
            }

            fclose($fileout);
        }
    }
}
 
?>