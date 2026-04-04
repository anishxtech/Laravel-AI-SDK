<?php

namespace App\Ai\Tools;

use Illuminate\Contracts\JsonSchema\JsonSchema;
use Illuminate\Foundation\Application;
use Laravel\Ai\Contracts\Tool;
use Laravel\Ai\Tools\Request;
use Stringable;

class LaravelVersion implements Tool
{
    public function __construct(protected Application $app) {}

    public function description(): Stringable|string
    {
        return 'Returns the Laravel framework version of this application.';
    }

    public function handle(Request $request): Stringable|string
    {
        return $this->app->version();
    }

    public function schema(JsonSchema $schema): array
    {
        return [];
    }
}
