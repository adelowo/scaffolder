<?php
/**
 * Spiral Framework.
 *
 * @license   MIT
 * @author    Anton Titov (Wolfy-J)
 */

namespace Spiral\Scaffolder\Declarations;

use Spiral\Reactor\ClassDeclaration;
use Spiral\Reactor\DependedInterface;

/**
 * Common implementation for records and documents.
 */
abstract class EntityDeclaration extends ClassDeclaration implements DependedInterface
{
    /**
     * @var string
     */
    private $parent = '';

    /**
     * @param string $name
     * @param string $parent
     * @param string $comment
     */
    public function __construct(string $name, string $parent, string $comment = '')
    {
        $reflection = new \ReflectionClass($parent);
        $this->parent = $reflection->getName();

        parent::__construct($name, $reflection->getShortName(), [], $comment);
        $this->declareStructure();
    }

    /**
     * Add field into schema.
     *
     * @param string $name
     * @param mixed  $value
     */
    public function addField(string $name, $value)
    {
        $schema = $this->constant('SCHEMA')->getValue();
        $schema[$name] = $value;
        $this->constant('SCHEMA')->setValue($schema);
    }

    /**
     * {@inheritdoc}
     */
    public function getDependencies(): array
    {
        return [$this->parent => null];
    }

    /**
     * Declare entity structure.
     */
    protected function declareStructure()
    {
        $this->constant('SCHEMA')->setValue([]);
    }
}