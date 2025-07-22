<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    // Đảm bảo bạn có dòng này. Đây là phần cung cấp phương thức middleware()
    use AuthorizesRequests, ValidatesRequests;
}
