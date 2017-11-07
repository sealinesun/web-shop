<?php
declare(strict_types=1);

namespace Src\Product\Domain\Command;

use Money\Currency;
use Money\Money;
use Src\Product\Domain\Rule\CurrencyFormatRule;
use Src\Product\Domain\Rule\DescriptionFormatRule;
use Src\Product\Domain\Rule\TitleFormatRule;

final class NewProduct
{
    /**
     * @var string
     */
    private $sku;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $description;

    /**
     * @var int
     */
    private $priceAmount;

    /**
     * @var string
     */
    private $priceCurrencyCode;

    public function __construct(
        string $sku,
        string $title,
        string $description,
        int $priceAmount,
        string $priceCurrencyCode
    ) {
        $this->sku = $sku;
        $this->title = $title;
        $this->description = $description;
        $this->priceAmount = $priceAmount;
        $this->priceCurrencyCode = $priceCurrencyCode;

        $this->validate();
    }

    private function validate(): void
    {
        (new TitleFormatRule())->validate($this->title);
        (new DescriptionFormatRule())->validate($this->description);
        (new CurrencyFormatRule())->validate($this->priceCurrencyCode);
    }

    public function getSku(): string
    {
        return $this->sku;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getPrice(): Money
    {
        return new Money($this->priceAmount, new Currency($this->priceCurrencyCode));
    }
}
