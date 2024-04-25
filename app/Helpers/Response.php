<?php

namespace App\Helpers;

class Response
{
  public static function getJsonResponse($message, $data, $code, $requestId = '', $errorData = [], $errorList = [])
  {
    $requestId = !empty($requestId) ? $requestId : uniqid();

    $jsonResponseData = [
        'message' => ('messages.' . $message),
        'data' => $data,
        'status' => $code,
        'request_id' => $requestId,
    ];

    if (!empty($errorData)) {
      $jsonResponseData['error_data'] = $errorData;
    }

    if (!empty($errorList)) {
      $jsonResponseData['errors'] = $errorList['errors'];
    }

    if (!headers_sent($file, $line)) {
      header('Content-Type: application/json');
    }

    return json_encode($jsonResponseData);
  }
}
