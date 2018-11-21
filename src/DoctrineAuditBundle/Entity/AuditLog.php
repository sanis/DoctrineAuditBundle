<?php

namespace DH\DoctrineAuditBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class AuditLog
 *
 * @package DH\DoctrineAuditBundle\Entity
 */
abstract class AuditLog
{
    /**
     * @var int
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="bigint", unique=true)
     */
    protected $id;
    /**
     * @var string
     * @ORM\Column(type="string", length=10, nullable=false)
     */
    protected $type;
    /**
     * @var string
     * @ORM\Column(type="json_array")
     */
    protected $diffs;
    /**
     * @var object
     */
    protected $blame;
    /**
     * @var string
     * @ORM\Column(type="string", length=100)
     */
    protected $blameUser;
    /**
     * @var string
     * @ORM\Column(type="string", length=45)
     */
    protected $ip;
    /**
     * @var \DateTime
     * @ORM\Column(type="datetime", nullable=false)
     */
    protected $createdAt;
    /**
     * @var object
     */
    protected $object;

    abstract public function getEntity(): string;

    /**
     * @return object
     */
    public function getBlame(): object
    {
        return $this->blame;
    }

    /**
     * @param object $blame
     *
     * @return AuditLog
     */
    public function setBlame(object $blame): AuditLog
    {
        $this->blame = $blame;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getObject()
    {
        return $this->object;
    }

    /**
     * @param mixed $object
     *
     * @return UserAuditLog
     */
    public function setObject($object)
    {
        $this->object = $object;

        return $this;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     *
     * @return AuditLog
     */
    public function setId(int $id): AuditLog
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     *
     * @return AuditLog
     */
    public function setType(string $type): AuditLog
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return string
     */
    public function getDiffs()
    {
        return $this->diffs;
    }

    /**
     * @param string $diffs
     *
     * @return AuditLog
     */
    public function setDiffs(string $diffs): AuditLog
    {
        $this->diffs = $diffs;

        return $this;
    }

    /**
     * @return string
     */
    public function getBlameUser(): string
    {
        return $this->blameUser;
    }

    /**
     * @param string $blameUser
     *
     * @return AuditLog
     */
    public function setBlameUser(string $blameUser): AuditLog
    {
        $this->blameUser = $blameUser;

        return $this;
    }

    /**
     * @return string
     */
    public function getIp(): string
    {
        return $this->ip;
    }

    /**
     * @param string $ip
     *
     * @return AuditLog
     */
    public function setIp(string $ip): AuditLog
    {
        $this->ip = $ip;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     *
     * @return AuditLog
     */
    public function setCreatedAt(\DateTime $createdAt): AuditLog
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
