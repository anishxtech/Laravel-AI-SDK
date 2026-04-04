# Structured output

## Overview

For **machine-readable** answers (scores, classification, extraction), implement `Laravel\Ai\Contracts\HasStructuredOutput` and define **`schema(JsonSchema $schema): array`** using Laravel’s JSON schema builder (`Illuminate\Contracts\JsonSchema\JsonSchema`).

The model returns data validated against that schema; you read fields like an **array** on the response object.

## Example

```php
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Ai\Contracts\Agent;
use Laravel\Ai\Contracts\HasStructuredOutput;
use Laravel\Ai\Promptable;

class SalesCoach implements Agent, HasStructuredOutput
{
    use Promptable;

    public function schema(JsonSchema $schema): array
    {
        return [
            'feedback' => $schema->string()->required(),
            'score' => $schema->integer()->min(1)->max(10)->required(),
        ];
    }

    public function instructions(): string
    {
        return 'You are a sales coach...';
    }
}
```

## Accessing the response

```php
$response = (new SalesCoach)->prompt('Analyze this sales transcript...');

return $response['score'];
```

## When to use this

- APIs/UI that need **typed** fields, not free-form prose.
- Downstream PHP code that **validates** business rules after the model returns.

## Anonymous agents

The `agent()` helper accepts a **`schema` closure** as well ([21](21-anonymous-agents.md)).

## Pitfalls

- **Over-constrained** schemas can cause retries or failures — prefer minimal required fields.
- Enforce **business rules** in PHP after parsing; the schema is not a substitute for authorization logic.
- In tests, **`::fake()`** can auto-generate structured data matching the schema ([35](35-testing-fakes.md)).

## See also

- [05-agents-core](05-agents-core.md)
- [21-anonymous-agents](21-anonymous-agents.md)
- [35-testing-fakes](35-testing-fakes.md)
