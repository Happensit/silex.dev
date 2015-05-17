<?php
/**
 * Created by PhpStorm.
 * User: liubov
 * Date: 11.05.15
 * Time: 13:32
 */

namespace Entity;

use Symfony\Component\Validator\Constraint as Assert;

class Contacts {

  protected $name;

  /**
   * @Assert|NotBlank()
   * @Assert|Email()
   */
  protected $email;

  protected $subject;

  protected $body;

  public function getName() {
    return $this->name;
  }

  public function setName($name) {
    $this->name = $name;
  }

  public function getEmail() {
    return $this->email;
  }

  public function setEmail($email) {
    $this->email = $email;
  }

  public function getSubject() {
    return $this->subject;
  }

  public function setSubject($subject) {
    $this->subject = $subject;
  }

  public function getBody() {
    return $this->body;
  }

  public function setBody($body) {
    $this->body = $body;
  }
}