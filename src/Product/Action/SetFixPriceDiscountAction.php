<?php
declare(strict_types=1);

namespace Src\Product\Action;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Src\Product\Domain\Command\SetFixPriceDiscount;
use Src\Product\Domain\Handler\SetDiscountHandler;

final class SetFixPriceDiscountAction
{
    /**
     * @var SetDiscountHandler
     */
    private $handler;

    public function __construct(SetDiscountHandler $handler)
    {
        $this->handler = $handler;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $sku = $request->getAttribute("sku", "");
        $body = $request->getParsedBody();
        $amount = isset($body["amount"]) ? (int) $body["amount"] : null;
        $currency = isset($body["currency_code"]) ? $body["currency_code"] : "";

        $this->handler->handle($sku, new SetFixPriceDiscount($amount, $currency));

        return $response->withStatus(204);
    }
}
