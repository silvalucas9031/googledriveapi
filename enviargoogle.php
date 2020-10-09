<?php

$url = "https://accounts.google.com/o/oauth2/token";

$curl = curl_init($url);
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_POST, true);;
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

$headers = array();
$headers["Content-Type"] = "application/x-www-form-urlencoded";

curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

$data = "client_id=726631050299-37lnvhh5h8m0p7dqvdbttattf0aufbu2.apps.googleusercontent.com&client_secret=BEglL1IsaRPrpo5u4MLjgB-G&refresh_token=1//0dDngmbnekTWMCgYIARAAGA0SNwF-L9IrHb5k74dUNLyWCni9pb3Z_ivf-oY-7GANNu5JFrOfBjpbna_t3-V2LUPnpHlZP9KHhA8&grant_type=refresh_token";

curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

//for debug only!
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

$resp = curl_exec($curl);
$resp1 = json_decode($resp);



$token= $resp1->access_token;

$filety = $_FILES['file']['type'];
$tmpfile = $_FILES['file']['tmp_name'];
$filename = basename($_FILES['file']['name']);

$data = array(
  'uploaded_file' => curl_file_create($tmpfile, $_FILES['image']['type'], $filename),
    'addParents' => "1o10m9ouaowW7BLQYoewMBpVdkiKCiCdZ"
);


$url = "https://www.googleapis.com/upload/drive/v2/files";

$headers = array(
    
        "Authorization: Bearer ".$token,
            
       
    );
        
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, TRUE);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_BINARYTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_POST, true); 
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
$output = curl_exec($ch);

$output1 = json_decode($output);

$id = $output1->id;

$url = "https://www.googleapis.com/drive/v2/files/" . $id . "/parents";

$headers1 = array(
    
        "Authorization: Bearer ".$token,
            'Content-Type: application/json'
       
    );


$data = array(

     'id' => "1o10m9ouaowW7BLQYoewMBpVdkiKCiCdZ"
 
);

$data1 = json_encode($data);
var_dump($data);


$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, true); 
curl_setopt($curl, CURLOPT_POSTFIELDS, $data1);
curl_setopt($curl, CURLOPT_HTTPHEADER, $headers1);
$response = curl_exec($curl);

$url = "https://www.googleapis.com/drive/v2/files/". $id;
$data = array(
    "name" => $filename,
    "mimeType"  => $filety
);
$data1 = json_encode($data);



$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'PATCH');
curl_setopt($curl, CURLOPT_POSTFIELDS, $data1);
curl_setopt($curl, CURLOPT_HTTPHEADER, $headers1);
$response = curl_exec($curl);
var_dump($response);
