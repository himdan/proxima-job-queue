<?php
/**
 * Created by PhpStorm.
 * User: chehimi
 * Date: 18/08/22
 * Time: 10:13 م
 */

call_user_func(function (){
     require __DIR__ . "/../vendor/autoload.php";
    (new \Symfony\Component\Filesystem\Filesystem())->remove(\Proxima\JobQueue\Tests\Functional\Kernel::getCacheLocation());
});