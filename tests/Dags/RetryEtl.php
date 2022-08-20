<?php
/**
 * Created by PhpStorm.
 * User: chehimi
 * Date: 21/08/22
 * Time: 12:00 م
 */

namespace Proxima\JobQueue\Tests\Dags;

use Proxima\JobQueue\Attributes\Retry;

#[Retry(onFail: true, times: 3)]
class RetryEtl extends Etl
{

}