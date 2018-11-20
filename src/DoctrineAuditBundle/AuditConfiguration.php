<?php

namespace DH\DoctrineAuditBundle;

use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

class AuditConfiguration
{
    /**
     * @var TokenStorage
     */
    protected $securityTokenStorage;
    /**
     * @var RequestStack
     */
    protected $requestStack;
    /**
     * @var array
     */
    private $ignoredColumns = [];
    /**
     * @var array
     */
    private $entities = [];

    public function __construct(array $config, TokenStorage $securityTokenStorage, RequestStack $requestStack)
    {
        $this->securityTokenStorage = $securityTokenStorage;
        $this->requestStack = $requestStack;
        $this->ignoredColumns = $config['ignored_columns'];

        if (isset($config['entities']) && !empty($config['entities'])) {
            // use entity names as array keys for easier lookup
            foreach ($config['entities'] as $auditedEntity => $entityOptions) {
                $this->entities[$auditedEntity] = $entityOptions;
            }
        }
    }

    /**
     * Returns true if $entity is audited.
     *
     * @param $entity
     *
     * @return bool
     */
    public function isAudited($entity): bool
    {
        if (!empty($this->entities)) {
            foreach (array_keys($this->entities) as $auditedEntity) {
                if (\is_object($entity) && $entity instanceof $auditedEntity) {
                    return true;
                }
                if (\is_string($entity) && $entity === $auditedEntity) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Returns true if $field is audited.
     *
     * @param $entity
     * @param $field
     *
     * @return bool
     */
    public function isAuditedField($entity, $field): bool
    {
        if (!\in_array($field, $this->ignoredColumns, true) && $this->isAudited($entity)) {
            $class = \is_object($entity) ? \Doctrine\Common\Util\ClassUtils::getRealClass(
                \get_class($entity)
            ) : $entity;
            $entityOptions = $this->entities[$class];

            return !isset($entityOptions['ignored_columns']) || !\in_array(
                    $field,
                    $entityOptions['ignored_columns'],
                    true
                );
        }

        return false;
    }

    /**
     * Get the value of excludedColumns.
     *
     * @return array
     */
    public function getIgnoredColumns(): array
    {
        return $this->ignoredColumns;
    }

    /**
     * Get the value of entities.
     *
     * @return array
     */
    public function getEntities(): array
    {
        return $this->entities;
    }

    /**
     * Get the value of securityTokenStorage.
     *
     * @return TokenStorage
     */
    public function getSecurityTokenStorage(): TokenStorage
    {
        return $this->securityTokenStorage;
    }

    /**
     * Get the value of requestStack.
     *
     * @return RequestStack
     */
    public function getRequestStack(): RequestStack
    {
        return $this->requestStack;
    }
}
