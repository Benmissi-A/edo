<?php

namespace App\Component\DataProvider;

use ApiPlatform\Core\DataProvider\CollectionDataProviderInterface;
use App\Component\DTO\NarrativeDTO;
use App\Component\DTO\Strategy\DTOContext;
use App\Component\DTO\Strategy\Narrative\NarrativeDTOGetItem;
use App\Entity\Fiction;
use App\Entity\Narrative;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class FragmentCollectionDataProvider
 * @package App\Component\DataProvider
 */
final class NarrativeCollectionDataProvider implements CollectionDataProviderInterface
{
    /** @var EntityManagerInterface  */
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @param string $resourceClass
     * @param string|null $operationName
     * @return \Generator
     * @throws \Exception
     */
    public function getCollection(string $resourceClass, string $operationName = null): \Generator
    {
        //todo: replace by dynamic fiction
        $fiction = $this->em->getRepository(Fiction::class)->findAll();
        $narratives = $this->em->getRepository(Narrative::class)->findLastNarratives($fiction[0]);

        foreach ($narratives as $narrative) {
            $context= new DTOContext(new NarrativeDTOGetItem(), null, $this->em, $narrative);
            /** @var NarrativeDTO $narrativeDTO */
            yield $context->proceed();
        }
    }
}