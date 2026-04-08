# Laravel AI SDK - Easy README

This README explains the complete Laravel AI SDK in simple language, with practical real-world use cases for every major feature.

Official docs: [Laravel AI SDK](https://laravel.com/docs/ai)

---

## 1) What this SDK gives you

Laravel AI SDK gives you one clean API to work with many AI providers (OpenAI, Anthropic, Gemini, and others) without rewriting your app for each provider.

Main idea:
- You build an **Agent** class.
- You define instructions, tools, memory, and output format.
- You call `prompt()` (or `stream()` / `queue()`) and get a response.

---

## 2) Quick setup

Install:

```bash
composer require laravel/ai
php artisan vendor:publish --provider="Laravel\Ai\AiServiceProvider"
php artisan migrate
```

Add provider keys in `.env`:

```env
OPENAI_API_KEY=
ANTHROPIC_API_KEY=
GEMINI_API_KEY=
COHERE_API_KEY=
ELEVENLABS_API_KEY=
MISTRAL_API_KEY=
JINA_API_KEY=
VOYAGEAI_API_KEY=
XAI_API_KEY=
OLLAMA_API_KEY=
```

Optional custom base URLs (`config/ai.php`):
- Useful for proxies / gateways / private endpoints.
- Supported for OpenAI, Anthropic, Gemini, Groq, Cohere, DeepSeek, xAI, OpenRouter.

---

## 3) Provider support by feature

| Feature | Providers |
| --- | --- |
| Text | OpenAI, Anthropic, Gemini, Azure, Groq, xAI, DeepSeek, Mistral, Ollama |
| Images | OpenAI, Gemini, xAI |
| TTS | OpenAI, ElevenLabs |
| STT | OpenAI, ElevenLabs, Mistral |
| Embeddings | OpenAI, Gemini, Azure, Cohere, Mistral, Jina, VoyageAI |
| Reranking | Cohere, Jina |
| Files | OpenAI, Anthropic, Gemini |

Tip: use `Laravel\Ai\Enums\Lab` instead of hardcoded provider strings.

---

## 4) Core concepts (easy to learn)

### Agents
An agent is your AI worker class (instructions + logic + optional memory + tools).

Real use cases:
- Customer support assistant for your product.
- Sales call analyzer with improvement score.
- Internal coding/document helper for your team.

### Prompting
Use `prompt()` for normal sync calls. You can override provider/model/timeout per request.

Real use cases:
- Route simple user question to cheapest model.
- Force premium model only for difficult prompts.

### Conversation memory
Two ways:
- Implement `Conversational` and return custom `messages()`.
- Use `RemembersConversations` trait for automatic DB storage.

Real use cases:
- Persistent chatbot across sessions.
- User-specific AI history (per account/team).

### Structured output
Implement `HasStructuredOutput` and define JSON schema.

Real use cases:
- Invoice extraction into strict JSON.
- Resume parsing into fixed fields.
- Lead scoring output for CRM automation.

### Attachments
Pass documents/images to agent prompts.

Real use cases:
- Summarize PDF contracts.
- Analyze screenshots for UI feedback.
- Review uploaded reports and return key insights.

### Streaming
Use `stream()` for real-time token-by-token output (SSE). Optional Vercel AI protocol.

Real use cases:
- Chat UI with instant response feel.
- Live “thinking/writing” experience in dashboards.

### Queueing
Use `queue()` for background processing.

Real use cases:
- Long report generation after file upload.
- Batch AI jobs without blocking user requests.

---

## 5) Tools (make your agent do real actions)

### Custom tools
Create tools using `make:tool` and define `description`, `schema`, `handle`.

Real use cases:
- Fetch order status from your database.
- Create support tickets from agent decisions.
- Run business-specific calculations.

### SimilaritySearch tool
Search your own embedded data from inside an agent.

Real use cases:
- "Answer from our knowledge base only".
- Find related policies/docs before answering.

### Provider tools
Provider-native capabilities:
- `WebSearch` (search internet)
- `WebFetch` (read URLs)
- `FileSearch` (search files in vector stores)

Real use cases:
- "What changed in latest framework release?"
- Pull and summarize a known documentation page.
- Search large uploaded manuals and answer with context.

---

## 6) Middleware, reliability, and control

### Agent middleware
Intercept prompts/responses for logging/guardrails.

Real use cases:
- Log all prompts for compliance.
- Block sensitive prompt patterns.
- Add tenant metadata automatically.

### Agent attributes
Set defaults with attributes: provider, model, max tokens, temperature, timeout, etc.

Real use cases:
- Stable defaults for each agent type.
- Use cheap model for simple tasks, smart model for complex tasks.

### Provider options
Return provider-specific options in `providerOptions()`.

Real use cases:
- OpenAI reasoning effort tuning.
- Anthropic thinking budget per task type.

### Failover
Pass provider array to automatically fallback if first provider fails/rate limits.

Real use cases:
- Keep support bot available during outages.
- Smooth traffic during provider incidents.

---

## 7) Media features

### Images
Generate images with `Image::of()`, set ratio/quality, store result.

Real use cases:
- Marketing banner generation.
- Product concept image drafts.

### Audio (TTS)
Generate spoken audio from text with voice options.

Real use cases:
- Voice notifications.
- Accessibility narration for content.

### Transcription (STT)
Convert audio to text, optional diarization (speaker segments).

Real use cases:
- Meeting/call transcript generation.
- Voice note to searchable text.

---

## 8) Embeddings, vector search, reranking (RAG stack)

### Embeddings
Turn text into vectors with `Str::toEmbeddings()` or `Embeddings::for()`.

Real use cases:
- Semantic search.
- Recommendation systems.
- Duplicate/near-duplicate detection.

### Vector querying (PostgreSQL pgvector)
Use vector columns + `whereVectorSimilarTo`.

Real use cases:
- "Find most similar support answers".
- "Find related legal clauses quickly".

Important:
- Native vector querying requires PostgreSQL + pgvector (not plain SQLite).

### Embedding cache
Cache repeated embeddings to reduce cost and latency.

Real use cases:
- Repeated queries over same product catalog.
- Frequent re-analysis of unchanged content.

### Reranking
Reorder results by semantic relevance.

Real use cases:
- Improve search precision after broad retrieval.
- Better top-5 answers in support systems.

---

## 9) Files and vector stores

### Files API
Upload/store/retrieve/delete files with provider (`Document`, `Image`).

Real use cases:
- Store large policy docs once, reference by ID many times.
- Analyze same file repeatedly without re-upload cost.

### Vector stores
Create searchable file collections and attach metadata filters.

Real use cases:
- Department-wise document search (HR, Legal, Engineering).
- Multi-tenant knowledge base with metadata filtering.

---

## 10) Testing and observability

### Testing fakes
Fake `Agent`, `Image`, `Audio`, `Transcription`, `Embeddings`, `Reranking`, `Files`, `Stores`.

Real use cases:
- Deterministic CI tests without real API calls.
- Assert prompts/queued jobs/tool behavior.

### Events
SDK dispatches events like `AgentPrompted`, `ToolInvoked`, `ImageGenerated`, etc.

Real use cases:
- AI usage analytics dashboards.
- Cost and latency monitoring.
- Audit trails for regulated environments.

---

## 11) Suggested learning order

1. Install + configure providers
2. Build one simple agent with `prompt()`
3. Add memory (`RemembersConversations`)
4. Add structured output
5. Add one custom tool
6. Add streaming or queueing
7. Add embeddings + vector search + reranking
8. Add testing fakes and monitoring events

---

## 12) Example routes in this project

You can test many concepts through these routes:

- `/chat` (conversation memory)
- `/ai/structured` (structured output)
- `/ai/tools` (custom/provider tools)
- `/ai/attachments` (document/image input)
- `/ai/stream`, `/ai/stream/sse`, `/ai/stream/vercel` (streaming)
- `/ai/queue` (background jobs)
- `/ai/images`, `/ai/speech`, `/ai/transcribe` (media)
- `/ai/embeddings`, `/ai/similarity` (vector workflows)
- `/ai/files`, `/ai/stores`, `/ai/file-search` (files + stores)
- `/ai/middleware`, `/ai/failover` (production reliability)

---

## 13) Final practical advice

- Start small with one agent and one clear use case.
- Use structured output whenever downstream code depends on fields.
- Add failover and queueing before production launch.
- Add fakes in tests to avoid flaky/expensive test suites.
- Keep provider keys and model choices configurable (`config/ai.php` + `.env`).
