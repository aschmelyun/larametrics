<?php declare(strict_types=1);

namespace Aschmelyun\Larametrics\Listeners;

use Aschmelyun\Larametrics\Actions\DetermineUniquenessOfVisit;
use Aschmelyun\Larametrics\Actions\FormatRequestObject;
use Aschmelyun\Larametrics\Actions\GetRouteFromRequest;
use Aschmelyun\Larametrics\Actions\GetUserAssociatedWithEvent;
use Illuminate\Foundation\Http\Events\RequestHandled;
use Illuminate\Pipeline\Pipeline;

class RecordRequestHandled
{
    public function handle(RequestHandled $event): void
    {
        // Run an actions pipeline to collect and format request data
        $request = app(Pipeline::class)
            ->send([
                'request' => $event->request,
                'response' => $event->response,
            ])
            ->through([
                GetRouteFromRequest::class,
                GetUserAssociatedWithEvent::class,
                DetermineUniquenessOfVisit::class,
                FormatRequestObject::class,
            ])
            ->thenReturn();

        // Save the request to the database
    }
}
