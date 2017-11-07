<?php
declare(strict_types=1);

namespace Src\Product\Action;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Src\Product\Domain\Command\SetPercentPriceDiscount;
use Src\Product\Domain\Handler\SetDiscountHandler;

final class SetPercentDiscountAction
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
        $percent = isset($body["percent"]) ? (int) $body["percent"] : null;

        $this->handler->handle($sku, new SetPercentPriceDiscount($percent));

        return $response->withStatus(204);
    }
}
