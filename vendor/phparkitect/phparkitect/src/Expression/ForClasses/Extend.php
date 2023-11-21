<?php

declare(strict_types=1);

namespace Arkitect\Expression\ForClasses;

use Arkitect\Analyzer\ClassDescription;
use Arkitect\Expression\Description;
use Arkitect\Expression\Expression;
use Arkitect\Rules\Violation;
use Arkitect\Rules\ViolationMessage;
use Arkitect\Rules\Violations;

class Extend implements Expression
{
    /** @var string */
    private $className;

    public function __construct(string $className)
    {
        $this->className = $className;
    }

    public function describe(ClassDescription $theClass, string $because): Description
    {
        return new Description("should extend {$this->className}", $because);
    }

    public function evaluate(ClassDescription $theClass, Violations $violations, string $because): void
    {
        $extends = $theClass->getExtends();

        if (null !== $extends && $extends->matches($this->className)) {
            return;
        }

        $violation = Violation::create(
            $theClass->getFQCN(),
            ViolationMessage::selfExplanatory($this->describe($theClass, $because))
        );

        $violations->add($violation);
    }
}
