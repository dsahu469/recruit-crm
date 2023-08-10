<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Info(
 *     title="Your API",
 *     version="1.0",
 *     description="Your API description",
 *     termsOfService="http://yourterms.com",
 *     @OA\Contact(
 *         email="contact@yourapi.com"
 *     ),
 *     @OA\License(
 *         name="Your API License",
 *         url="http://yourapilicense.com"
 *     )
 * )
 */

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}
