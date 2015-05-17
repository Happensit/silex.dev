<?php
/**
 * Created by PhpStorm.
 * User: liubov
 * Date: 10.05.15
 * Time: 22:02
 */

namespace Controller;


use Silicone\Controller;
use Silicone\Route;


class Test extends Controller
{

  /**
   * @Route("/test", defaults={"test" = "test1"})
   * @Route("/test/{test}")
   */
  public function indexAction($test){

    return $test;
  }
}