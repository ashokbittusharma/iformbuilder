<?php include_once('token.php');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization, X-Request-With');
header('Access-Control-Allow-Credentials: true');

$FormData = json_decode(file_get_contents("php://input"),true);

if(!empty($FormData)){
  
  $postFieldData = '{"fields":[{"element_name":"mail","value":"'.$FormData['email'].'"},{"element_name":"name","value":"'.$FormData['name'].'"}]}';

  //generating a Token for access
  $JWToken = generateJWToken();

  $createRecordApiUrl = "https://app.iformbuilder.com/exzact/api/v60/profiles/504556/pages/3863134/records";

  $ch = curl_init();

    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_URL, $createRecordApiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, false);

    curl_setopt($ch, CURLOPT_POST, TRUE);

    curl_setopt($ch, CURLOPT_POSTFIELDS, $postFieldData);

    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        "Content-Type: application/json",
        "cache-control: no-cache",
        "Authorization: Bearer $JWToken"
    ));

    $response = curl_exec($ch); 
    
    curl_close($ch);

    $sucess = ['message' => "Data stored successfully!"];

    echo json_encode($sucess);
}



