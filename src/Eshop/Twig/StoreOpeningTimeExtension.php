<?php

declare(strict_types=1);

namespace App\Eshop\Twig;

use DateTimeImmutable;
use Doctrine\Common\Collections\Collection;
use Impexta\Store\Domain\Entity\StoreOpeningHoursInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

final class StoreOpeningTimeExtension extends AbstractExtension
{
    /** @return array<int,TwigFilter> */
    public function getFilters(): array
    {
        return [
            new TwigFilter('store_opening', [$this, 'getStoreOpeningHours']),
        ];
    }

    /**
     * @param Collection<int, StoreOpeningHoursInterface> $openingHoursCollection
     * @return array<int, array<string, int|DateTimeImmutable|bool|null>>
     */
    public function getStoreOpeningHours(Collection $openingHoursCollection): array
    {
        /** @var array<StoreOpeningHoursInterface> $openingHours */
        $openingHours = $openingHoursCollection->toArray();
        /* @phpstan-ignore-next-line */
        usort($openingHours, ['self', 'sortOpeningHours']);

        $data = [];
        $sequenceStartIndex = 0;

        foreach ($openingHours as $key => $openingHour) {
            $nextKey = $key + 1;

            // If there is no next day, save current sequence and end it
            if ($nextKey === count($openingHours)) {
                $data[] = [
                    'startDay' => $openingHours[$sequenceStartIndex]->getDay(),
                    'endDay' => $openingHour->getDay(),
                    'openingAt' => $openingHour->getOpensAt(),
                    'closeAt' => $openingHour->getClosesAt(),
                    'isOpen' => $openingHour->isOpen(),
                ];

                break;
            }

            // If next day is not the same, reset pointer and store the current sequence
            $sequenceBroke = false;

            if ($openingHour->isOpen() != $openingHours[$nextKey]->isOpen()) {
                $sequenceBroke = true;
            }

            if (
                $openingHour->getOpensAt() != $openingHours[$nextKey]->getOpensAt() ||
                $openingHour->getClosesAt() != $openingHours[$nextKey]->getClosesAt()
            ) {
                $sequenceBroke = true;
            }

            if (!$sequenceBroke) {
                continue;
            }

            $data[] = [
                'startDay' => $openingHours[$sequenceStartIndex]->getDay(),
                'endDay' => $openingHour->getDay(),
                'openingAt' => $openingHour->getOpensAt(),
                'closeAt' => $openingHour->getClosesAt(),
                'isOpen' => $openingHour->isOpen(),
            ];

            $sequenceStartIndex = $nextKey;
        }

        return $data;
    }

    /**
     * Sorts array of OpeningHours objects by day of the week
     * It respects, that Sunday is 0 and Saturday is 6
     *
     * Result order is: 1, 2, 3, 4, 5, 6, 0
     *
     * @SuppressWarnings("PHPMD.UnusedPrivateMethod")
     */
    private static function sortOpeningHours(
        StoreOpeningHoursInterface $inputDayA,
        StoreOpeningHoursInterface $inputDayB
    ): int {
        if ($inputDayA->getDay() === 0) {
            return 1;
        }

        if ($inputDayB->getDay() === 0) {
            return -1;
        }

        // Sort all other days
        return $inputDayA->getDay() < $inputDayB->getDay() ? -1 : 1;
    }
}
