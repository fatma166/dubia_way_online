<?php
declare(strict_types=1);
namespace App\Modules\Core;

abstract class HTTPResponseCodes
{
    const Sucess = [
        "status" =>true,
        "code" => 200,
        "message" => "Request has been successfully processed."
    ];

    const NotFound = [
        "status" =>false,
        "code" => 404,
        "message" => "Could not locate resource."
    ];

    const InvalidArguments = [
        "status" => false,
        "code" => 404,
        "message" => "Invalid arguments. Server failed to process your request."
    ];

    const BadRequest = [
        "status" => false,
        "code" => 400,
        "message" => "Server failed to process your request."
    ];
    const UnAuth= [

        "status" =>false,
        "code" => 401,
        "message" => "Unauthorized to process your request."
    ];
    const Validation= [
        "status" =>false,
        "code" => 422,
        "message" => "validation error "
    ];
}
