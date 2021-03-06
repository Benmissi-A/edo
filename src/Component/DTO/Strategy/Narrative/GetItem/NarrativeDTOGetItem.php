<?php

declare(strict_types=1);

namespace App\Component\DTO\Strategy\Narrative\GetItem;

use App\Component\DTO\Strategy\DTOStrategyConfig;
use App\Component\DTO\Strategy\DTOStrategyInterface;
use App\Component\Transformer\NarrativeDTOTransformer;
use App\Entity\Narrative;

/**
 * Class NarrativeDTOGetItem
 * @package App\Component\DTO\Strategy\Narrative
 */
class NarrativeDTOGetItem implements DTOStrategyInterface
{
    public function proceed(DTOStrategyConfig $strategyConfig)
    {
        /** @var Narrative $narrative */
        $narrative = $strategyConfig->getEntity();

        //convert narrative into Narrative DTO
        return NarrativeDTOTransformer::fromEntity(
            NarrativeDTOGetItemHelper::createTransformerConfig(
                $strategyConfig->getEm(),
                $narrative
            ));
    }
}