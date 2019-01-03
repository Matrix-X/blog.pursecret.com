<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OSSController extends Controller
{
    //

    protected $_accessKey = '';
    protected $_secretKey = '';

    /**
     * OSSController constructor.
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {

    }

}
