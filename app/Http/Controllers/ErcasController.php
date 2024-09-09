<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ErcasController extends Controller
{
    
public $base_url = "https://sagecloud.ng/api";


public function ercasLogin(){
 $email = "dropifypay@gmail.com";
 $password = "Prinbhobhoangel24###";


$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => "$this->base_url/v2/merchant/authorization",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>'{
	"email":"dropifypay@gmail.com",
	"password":"Prinbhobhoangel24###"
}',
  CURLOPT_HTTPHEADER => array(
    'Accept: application/json',
    'Content-Type: application/json'
  ),
));

$response = curl_exec($curl);
curl_close($curl);
$result = json_decode($response,true);
dd($result);
$status = $result["success"];
if($status == true){
  $token = $result["data"]["token"]["access_token"];
  return response()->json([
    "status" => true,
    "token" => $token
  ]);
}else{
  return response()->json([
    "status" => false,
    "message" => "transfer could not be initiated"
  ]);
}

    }



    public function getBanks(){


$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "$this->base_url/v2/transfer/get-transfer-data",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
  CURLOPT_HTTPHEADER => array(
    'Accept: application/json',
    'Content-Type: application/json',
    'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiI1IiwianRpIjoiMWViMTEyYjBkY2NiOWZmMjM2ZjRlMzZkYWI4Zjc0OTA1YjYyNGUzMTA4YTg0NTg4M2EzZWY1Mjg1MmMzZWRhYTdkODc0NTliNjNhYWE3NmMiLCJpYXQiOjE3MjIwNzAxMDAuMTgzMjEsIm5iZiI6MTcyMjA3MDEwMC4xODMyMTMsImV4cCI6MTcyMjE1NjUwMC4xNjc5OTcsInN1YiI6IjYwOSIsInNjb3BlcyI6WyIqIl19.RXNwV3iVm7TqXNWl5tvkYyoZHJs1A2Oz0-QIEUVo397yOYNdr30yQ78DzIoi0XCpoYmRq7EUpXn1GoGEVTugHN5ARGTkUZNrnGvCuXuLZF2EpnyJevjeGy14MzUt7RWdiBXdoeT42NXQ6e51Y4GCLNJKnVxP1kpKWsiusuEvBpPoZafMfYBX7EGU1sBuhcyG3bB7nr7CPU5xRrNQTy6fYJ9gOO3C2dCFcA3VKy3-I_zRQBwZ0qwC_4BqpPaWSdXWmEAOWVaHULOp4w7Kq8cl5Y623BXp93QxXOzkdvfhUJfzklpMh7kl79eAX-dYpwp22xFCCrw6G-j-O4314TC-QzQDtCINgizvYH5lXq8klMbMamtD7S23F1jTtjKeQGXIu63w74N8YCdNAICuZqxDd6yFThqeXtLyf8K4C7tq0Yy-VPIgnWXK_xonGMTo6znbNrr5VbaGOua52e4Wl7bQiGg5Y_KzYYhX3QRz26uCKSS01-jzLUOmDV240ujiVeAb8kyw7hiwZosGO5yc9yEmr8YyJJDcP0VieudB4o6xQp64t7IFqnkNOPVqWCU3sLot0DMmdKUPKLC2LVEyhC_IEZkMP2-hRZAJ1Hj-0pgvwGrDyEUGZM6Uk6KdYWUmffr029-Y1wY8B_LRPc3mw9HgU3wJVqL4YR9PcsZNeIb00fY'
  ),
));

$response = curl_exec($curl);

curl_close($curl);
dd($response);

    }










}
