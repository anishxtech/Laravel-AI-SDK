# Custom tools

## Overview

**Tools** extend what the model can do: call **your** PHP code with structured arguments. Tools implement `Laravel\Ai\Contracts\Tool` with:

- **`description()`** — when the model should use the tool.
- **`schema(JsonSchema $schema)`** — arguments the model must supply.
- **`handle(Request $request)`** — return a string or Stringable result.

## Scaffold

```bash
php artisan make:tool RandomNumberGenerator
```

Place: `app/Ai/Tools/RandomNumberGenerator.php` (path may vary).

## Example (official shape)

```php
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Ai\Contracts\Tool;
use Laravel\Ai\Tools\Request;
use Stringable;

class RandomNumberGenerator implements Tool
{
    public function description(): Stringable|string
    {
        return 'This tool may be used to generate cryptographically secure random numbers.';
    }

    public function handle(Request $request): Stringable|string
    {
        return (string) random_int($request['min'], $request['max']);
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'min' => $schema->integer()->min(0)->required(),
            'max' => $schema->integer()->required(),
        ];
    }
}
```

## Register on an agent

```php
public function tools(): iterable
{
    return [
        new RandomNumberGenerator,
    ];
}
```

## Multi-step tool use

The model may call tools **multiple times**. Raise **`#[MaxSteps]`** on the agent ([22](22-agent-attributes.md)) so there is room for several tool rounds.

## When to use custom tools

- **Your** database, internal APIs, deterministic calculations, feature flags.
- Anything that must **not** be hallucinated.

## Pitfalls

- Tools should be **safe** if called more than once (the model may retry).
- Avoid **destructive** actions without explicit human confirmation in app logic.
- **Side effects** belong in `handle()` — keep descriptions honest.

## See also

- [16-similarity-search](16-similarity-search.md)
- [17-provider-tool-web-search](17-provider-tool-web-search.md)
- [22-agent-attributes](22-agent-attributes.md)
