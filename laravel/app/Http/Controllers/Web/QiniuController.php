<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Web\OSSController;

use Qiniu\Auth;
use Qiniu\Storage\BucketManager;

class QiniuController extends OSSController
{
    //
    protected $_auth;
    protected $_bucketManager;

    /**
     * QiniuController constructor.
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->_accessKey = env('QINIU_ACCESS_KEY');
        $this->_secretKey = env('QINIU_SECRET_KEY');

        // 初始化签权对象
        $this->_auth = new Auth($this->_accessKey, $this->_secretKey);

        if(!$this->_auth){
            abort(403, 'Unauthorized action.');
        }


    }

    public function test(){
//        dump($this->_auth);
        return;
    }

    protected function initBucketManager(){
        //初始化BucketManager
        $this->_bucketManager = new BucketManager($this->_auth);

    }

    public function getBucketList(){
        $this->initBucketManager();
        dump($this->_bucketManager);

        

    }


}
