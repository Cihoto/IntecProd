<?php
    // require_once('../bd/bd.php');
    require "../../vendor/autoload.php";
    
    use Dompdf\Dompdf;
    use Dompdf\Options;

    $json = file_get_contents('php://input');
    $data = json_decode($json);

    $empresa_id = $data->empresa_id;
    $fileNameData = $data->fileNameData;
    $table_content = $data->table_content;
    $event_id = $data->event_id;
    $event_data = $data->event_data;

    // echo json_encode(array("name"=> $data->table_content));

    $month = $fileNameData->month;
    $year = $fileNameData->year;
    $day = $fileNameData->day;
    $today = date('d/m/Y');
    
    $fileName = "/Nómina-$event_id$month-$day-$year.pdf";

    $options = new Options();
    // $options->set("chroot",realpath(''));
    $options->setChroot(__DIR__);
    $options->set("isRemoteEnabled",true);
    $options->set("isPhpEnabled",true);

    $dompdf = new Dompdf($options);
    ob_start();
    require(__DIR__.'/nomTemplate.php');
    $html = ob_get_contents();
    ob_get_clean();

    $hfooter = "<footer>
    <div style='display:inline-block;'>
        <div class='wspSection'>
            <img  src='./PDF_svg/whatsApp.svg' alt='WhatsApp Main Logo' style='margin-right: 5px;'>
            <p style='float:inline-start; margin-left:20px; font-size: 10px; font-style: normal; font-weight: 400; letter-spacing: 0.17px;margin-top:2px'>+56982726543</p>
        </div>
        <div class='locationSection'>
            <img  src='./PDF_svg/location.svg' alt='Google Map Location Icon' style='margin-right: 5px;'>
            <p style='float:inline-start; margin-left:20px; font-size: 10px; font-style: normal; font-weight: 400; letter-spacing: 0.17px;margin-top:2px;'>DIR, NUM, COMUNA</p>
        </div>
        <div class='netWorldSection'>
            <img  src='./PDF_svg/webWorldNet.svg' alt='Web World Net Icon' style='margin-right: 5px;'>
            <p style='float:inline-start;margin-left: 20px; font-size: 10px;margin-top:2px;  font-style: normal; font-weight: 400; letter-spacing: 0.17px;'>www.Intec.cl</p>
        </div>
    </div>
    <img class='first-bottom' src='./PDF_svg/bar1.svg' alt='1asdasd'>
    <img class='second-bottom' src='./PDF_svg/bar2.svg' alt='2asdasdasd'>
    <img class='third-bottom' src='./PDF_svg/bar3.svg' alt='3asdqw2e12ed'>
    <img class='fourt-bottom' src='./PDF_svg/bar4.svg' alt='4d1d12'>
    <img class='fifth-bottom' width='100' src='./PDF_svg/bar5.svg' alt='5d12d12'>
    </footer>";
    $html = str_replace('{{ footer }}',$hfooter,$html);
    
    
    if(isset($client_name)){
        
        $html = str_replace("{{ client_name }}", $client_name, $html);
    }else{
        $html = str_replace("{{ client_name }}", "", $html);

    }
    if(isset($nombre_fantasia)){

        $html = str_replace("{{ nombre_fantasia }}", $nombre_fantasia, $html);
        
    }else{
        $html = str_replace("{{ nombre_fantasia }}", "", $html);
        
    }
    $html = str_replace("{{ numquote }}", "", $html);
    $html = str_replace("{{ today }}", $today, $html);

    $html = str_replace("{{ table_content }}", $table_content, $html);

    $html = str_replace("{{ event_name }}", $event_data->eventName, $html);
    $html = str_replace("{{ event_address }}", $event_data->eventAddress, $html);
    $html = str_replace("{{ event_date }}", $event_data->event_dates, $html);
    

    $dompdf->loadHtml($html);
    
    $dompdf->setPaper("A4","portrait");

    // $pdf = $this->pdf->load_view("pdf/comprobanteIngresos", $data, $tamaño, $nombre_archivo);
    
    $dompdf->render();
    
    // $dompdf->stream("$month-$day-$year.pdf");
    
    $output = $dompdf->output();
    $pdfRoot = __DIR__."/documents/buss$empresa_id/nomSheet$fileName";

    $bussDocumentFolder = __DIR__."/documents/buss$empresa_id/nomSheet";

    if(!is_dir($bussDocumentFolder)){
        mkdir($bussDocumentFolder);
    }

    // $pdfAdm = __DIR__."\documents\buss1\quotes";
    file_put_contents($pdfRoot, $output);

    // $data["nombre_archivo"] = "Cotización-$month$month$month-$day-$year.pdf";
    
    echo json_encode(array("name"=> "Nómina-$event_id$month-$day-$year.pdf","path"=>$pdfRoot));
    
   
?>