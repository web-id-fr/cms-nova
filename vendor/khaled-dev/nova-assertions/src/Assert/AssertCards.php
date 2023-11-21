<?php

namespace NovaTesting\Assert;

use closure;
use NovaTesting\NovaResponse;
use Illuminate\Testing\Assert as PHPUnit;

trait AssertCards
{
    public $novaCardResponse;

    public function assertCardCount($amount)
    {
        $this->setNovaCardResponse();

        $this->novaCardResponse->assertJsonCount($amount);

        return $this;
    }

    public function assertCards(closure $callable)
    {
        $original = $this->novaCardResponse->original;

        $cards = collect(json_decode(json_encode($original, true)));

        PHPUnit::assertTrue($callable($cards));

        return $this;
    }

    public function assertCardsInclude($class)
    {
        $this->setNovaCardResponse();

        $this->novaCardResponse->assertJsonFragment([
            'component' => $this->extractComponentName($class)
        ]);

        return $this;
    }

    public function assertCardsExclude($class)
    {
        $this->setNovaCardResponse();

        $this->novaCardResponse->assertJsonMissing([
            'component' => $this->extractComponentName($class)
        ]);

        return $this;
    }

    /**
     * @param string|\Laravel\Nova\Card $class
     * @return string
     */
    protected function extractComponentName($class)
    {
        if (is_object($class)) {
            return $class->component();
        }

        return class_exists($class) ? app($class)->component() : $class;
    }

    public function setNovaCardResponse()
    {
        if ($this->novaCardResponse) {
            return;
        }

        extract($this->novaParameters);

        $endpoint = "$endpoint/cards";

        if (isset($resourceId)) {
            $endpoint = "$endpoint?resourceId=$resourceId";
        }

        abort_if(strpos($endpoint, 'creation-fields'), 500, 'No cards on forms');
        abort_if(strpos($endpoint, 'update-fields'), 500, 'No cards on forms');

        $this->novaCardResponse = new NovaResponse(
            $this->parent->getJson($endpoint),
            $this->novaParameters,
            $this->parent
        );
    }
}
