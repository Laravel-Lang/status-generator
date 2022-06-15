<?php

declare(strict_types=1);

namespace LaravelLang\StatusGenerator\Services;

use DragonCode\Contracts\Support\Arrayable;
use DragonCode\Support\Facades\Helpers\Arr;
use LaravelLang\StatusGenerator\Objects\Count as CountDto;

class Counter implements Arrayable
{
    protected array $all = [];

    protected array $missing = [];

    protected array $complete = [];

    public function incrementAll(string $locale): void
    {
        $this->increment($this->all, $locale);

        $this->calculateComplete($locale);
    }

    public function incrementMissing(string $locale): void
    {
        $this->increment($this->missing, $locale);

        $this->calculateComplete($locale);
    }

    public function count(): int
    {
        return count($this->all);
    }

    /**
     * @return array<CountDto>
     */
    public function toArray(): array
    {
        return Arr::of($this->all)
            ->ksort()
            ->map(fn (int $all, string $locale) => $this->item(
                $locale,
                $all,
                $this->missing[$locale]  ?? 0,
                $this->complete[$locale] ?? 0
            ))->toArray();
    }

    protected function increment(array &$values, string $locale): void
    {
        $values[$locale] = Arr::get($values, $locale, 0) + 1;
    }

    protected function calculateComplete(string $locale): void
    {
        $all     = Arr::get($this->all, $locale, 0);
        $missing = Arr::get($this->missing, $locale, 0);

        $this->complete[$locale] = round(($all - $missing) / $all * 100, 2);
    }

    protected function item(string $locale, int $all, int $missing, float $complete): CountDto
    {
        return CountDto::fromArray(compact('locale', 'all', 'missing', 'complete'));
    }
}
