<?php

namespace App\State;

use ApiPlatform\Metadata\CollectionOperationInterface;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\Pagination\Pagination;
use ApiPlatform\State\Pagination\TraversablePaginator;
use ApiPlatform\State\ProviderInterface;
use App\ApiResource\DailyQuest;
use App\ApiResource\QuestTreasure;
use App\Enum\DailyQuestStatusEnum;
use App\Repository\DragonTreasureRepository;

class DailyQuestStateProvider implements ProviderInterface
{
    public function __construct(
        private DragonTreasureRepository $treasureRepository,
        private Pagination $pagination,
    )
    {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        if ($operation instanceof CollectionOperationInterface) {
            $currentPage = $this->pagination->getPage($context);
            $itemsPerPage = $this->pagination->getLimit($operation, $context);
            $offset = $this->pagination->getOffset($operation, $context);
            $totalItems = $this->countTotalQuests();
            dd($currentPage, $itemsPerPage, $offset, $totalItems);

            $quests = $this->createQuests();

            return new TraversablePaginator(
                new \ArrayIterator($quests),
                $currentPage,
                $itemsPerPage,
                $totalItems,
            );
        }

        $quests = $this->createQuests();

        return $quests[$uriVariables['dayString']] ?? null;
    }

    private function createQuests(): array
    {
        $treasures = $this->treasureRepository->findBy([], [], 10);
        $totalQuests = $this->countTotalQuests();

        $quests = [];
        for ($i = 0; $i < $totalQuests; $i++) {
            $quest = new DailyQuest(new \DateTimeImmutable(sprintf('- %d days', $i)));
            $quest->questName = sprintf('Quest %d', $i);
            $quest->description = sprintf('Description %d', $i);
            $quest->difficultyLevel = $i % 10;
            $quest->status = $i % 2 === 0 ? DailyQuestStatusEnum::ACTIVE : DailyQuestStatusEnum::COMPLETED;
            $quest->lastUpdated = new \DateTimeImmutable(sprintf('- %d days', rand(10, 100)));

            $randomTreasure = $treasures[array_rand($treasures)];
            $quest->treasure = new QuestTreasure(
                $randomTreasure->getName(),
                $randomTreasure->getValue(),
                $randomTreasure->getCoolFactor(),
            );

            $quests[$quest->getDayString()] = $quest;
        }

        return $quests;
    }

    private function countTotalQuests(): int
    {
        return 50;
    }
}
