<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
trait Timestamp {
    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        $this->prePersist();
        return $this->created_at;
    }

    public function prePersist(){
        $this->created_at = new \DateTime();
    }
}
