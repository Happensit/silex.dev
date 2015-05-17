<?php
/**
 * Created by PhpStorm.
 * User: liubov
 * Date: 10.05.15
 * Time: 22:09
 */

namespace Controller;


use Silicone\Controller;
use Silicone\Route;


class Edit extends Controller
{

  /**
   * @Route("/edit")
   */
  public function indexAction()
  {

    return "3333";

  }

  /**
   * @Route("/edit/edit")
   */

  public function editAction()
  {
    return "Db;e ";
  }
}