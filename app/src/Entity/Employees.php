<?php
namespace Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @ORM\Table(name="Employees")
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks()
 */
class Employees {
  /**
   * @ORM\Id
   * @ORM\Column(type="integer")
   * @ORM\GeneratedValue
   */
  protected $id;

  /**
   * @ORM\Column
   * @Assert\NotBlank()
   * @Assert\Length(min = "3", max = "20")
   */
  protected $name;

  /**
   * @ORM\Column
   * @Assert\NotBlank()
   * @Assert\Length(min = "3")
   */
  protected $description;

  /**
   * @ORM\Column(type="string", length=255, nullable=true)
   */
  public $path;


  public $file;

  public function getId() {
    return $this->id;
  }

  public function getName() {
    return $this->name;
  }

  public function setName($name) {
    $this->name = $name;
  }

  public function getDescription() {
    return $this->description;
  }

  public function setDescription($description) {
    $this->description = $description;
  }

  public function getPath()
  {
    return $this->path;
  }

  public function setPath($path)
  {
      $this->path = $path;
  }

  public function getUploadRootDir() {
    return __DIR__ . '/../../../public/uploads/employees/';
  }

  public function getAbsolutePath() {
    return NULL === $this->path ? NULL : $this->getUploadRootDir() . $this->path;
  }

  /**
   * @ORM\PrePersist()
   * @ORM\PreUpdate()
   */
  public function preUpload() {

    $this->tempFile = $this->getAbsolutePath();
    $this->oldFile = $this->getPath();

    if(null !== $this->file)
    {
      $this->path = '111.jpg';//$this->file;
    }

  }

  /**
   * @ORM\PostPersist()
   * @ORM\PostUpdate()
   */
  public function upload()
  {
    if (NULL !== $this->file) {

      if (!is_dir($this->getUploadRootDir())) {
        mkdir($this->getUploadRootDir());
      }

      $this->file->move($this->getUploadRootDir(), $this->file);
      unset($this->file);

//      if(NULL !== $this->oldFile) {
//        unlink($this->tempFile);
//      }
    }
  }

  /**
   * @ORM\PreRemove()
   */
  public function preRemoveUpload()
  {
    $this->tempFile = $this->getAbsolutePath();
  }

  /**
   * @ORM\PostRemove()
   */
  public function removeUpload()
  {
    if(file_exists($this->tempFile))
    {
      unlink($this->tempFile);
    }
  }

}
