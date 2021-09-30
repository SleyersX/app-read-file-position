<?php
    header('Content-Type: application/text; charset=utf-8');

    include 'vendor/readFile.php';
    $readFile = new readFile();

    $dirUpload = "./";
    $fileRead = $_FILES['fileRead'];
    $fileTemplate = $_FILES['fileTemplate'];
    $lengthTemplate = $_POST['lengthTemplate'] ?? 1;
    $delimiter= $_POST['delimiter'] ?? ",";
    $offset = $_POST['offset'] ?? 0;

    if(move_uploaded_file($fileRead["tmp_name"], "$dirUpload/".$fileRead["name"]) && move_uploaded_file($fileTemplate["tmp_name"], "$dirUpload/".$fileTemplate["name"]) && !empty($lengthTemplate)){

        $data = $readFile->parse_csv_file($fileTemplate["name"],$delimiter);

        $readFile->write_ini_file($data, './templates.ini', true);

        define("template", parse_ini_file('templates.ini', true));
        $fileName = $fileRead["name"];

        $response = array();
        $resp = array();
        $data= array();

        if(file_exists($fileName) && is_readable($fileName) && filesize($fileName) > 0){

            $file_handle = fopen($fileName, "r");
            while(!feof($file_handle)){
                $start=0;
                $end=0;
                $line = fgets($file_handle, 4096);
                $pos=substr($line,$offset,$lengthTemplate);
                if(strlen($pos) === 0){
                    break;
                }
                if(isset(template["$pos"])){
                    foreach(template["$pos"] as $key => $value){
                        $start=($end+1);
                        $end=(($start-1)+$value);
                        $x=substr($line,($start-1),$value);
                        printf("%s=\"%s\"\n", $key, $x);
                    }
                }else{
                    http_response_code(400);
                    printf("Template[%s], não foi encontrado em template.ini .\n", $pos);
                }
                //$response[$pos][]=$resp;
                printf("\n%s\n",str_pad("",150,"-"));
            }

            fclose($file_handle);
        }
    }
    else {
        http_response_code(400);
        echo "Ocorreu um erro durante upload do arquivos.\n";
    }
