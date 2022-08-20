<?php
/**
 * Created by PhpStorm.
 * User: chehimi
 * Date: 21/08/22
 * Time: 10:51 ص
 */

namespace Proxima\JobQueue\Tests\Dags;
use Proxima\JobQueue\Attributes\Scheduled;

#[Scheduled(for:"@daily", catchup:true)]
class ScheduledEtl extends Etl
{

}