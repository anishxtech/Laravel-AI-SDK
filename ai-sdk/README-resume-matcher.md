# Resume + Job Matching Engine (Laravel AI SDK)

A production-style AI module built with Laravel AI SDK that:
- parses resumes and job descriptions,
- creates embeddings (text -> vector),
- computes semantic similarity,
- reranks results,
- explains strengths and skill gaps.

This guide is written so you can understand and build future embedding projects too.

---

## Table of Contents

1. Overview
2. Architecture
3. How text becomes vector
4. Data model (tables and meaning)
5. Main logic walkthrough
6. Embedding concepts (deep dive)
7. Scoring formula
8. Why reranking is added
9. Setup and run
10. Debugging guide
11. How to extend this module
12. Future project ideas

---

## 1) Overview

This module solves a recruiting workflow:

- Input: one resume + multiple job descriptions
- Output:
  - match score per job
  - strengths (overlapping hard skills)
  - missing skills
  - human-readable gap summary

It combines structured extraction with semantic matching.

---

## 2) Architecture

### UI layer
- `app/Livewire/Ai/ResumeMatcherDemo.php`
- `resources/views/livewire/ai/resume-matcher-demo.blade.php`

### Main orchestrator
- `app/Services/ResumeJobMatchingEngine.php`

### Agents
- `app/Ai/Agents/ResumeParserAgent.php`
- `app/Ai/Agents/JobDescriptionParserAgent.php`
- `app/Ai/Agents/MatchGapExplainerAgent.php`

### Persistence
- Migration: `database/migrations/2026_04_08_220500_create_resume_matching_tables.php`
- Models:
  - `app/Models/ResumeProfile.php`
  - `app/Models/JobProfile.php`
  - `app/Models/ResumeJobMatch.php`

---

## 3) How text becomes vector

Important:

> Your app does not manually convert text to vectors.  
> Laravel AI SDK does this by calling the provider embedding API.

In `app/Services/ResumeJobMatchingEngine.php`, inside `run()`:

```php
$vectors = Embeddings::for($embeddingInputs)->generate()->embeddings;
```

What happens:
1. You provide text inputs (`$embeddingInputs`).
2. Laravel AI SDK calls the configured embeddings provider/model.
3. Provider returns embedding arrays (float vectors).
4. SDK returns them in `$response->embeddings`.

Example vector shape:

```txt
[0.0123, -0.4451, 0.2290, ...]
```

Stored in:
- `resume_profiles.embedding`
- `job_profiles.embedding`

---

## 4) Data model (tables and meaning)

### `resume_profiles`
Stores one candidate resume snapshot.

- `user_id`: who imported this profile
- `source_label`: source tag (LinkedIn, referral, etc.)
- `raw_text`: original resume content
- `parsed_json`: extracted structured fields
- `embedding`: semantic vector for matching

### `job_profiles`
Stores one job description snapshot.

- `user_id`: who created/imported this job profile
- `title`: role title
- `raw_text`: original JD content
- `parsed_json`: extracted requirements
- `embedding`: semantic vector

### `resume_job_matches`
Stores one resume-vs-job result.

- `cosine_similarity`: vector similarity score
- `rerank_score`: optional reranking score
- `match_score`: final blended ranking score
- `strengths`: overlap skills list
- `missing_skills`: missing required skills list
- `gap_summary`: short recruiter-friendly explanation

---

## 5) Main logic walkthrough

File: `app/Services/ResumeJobMatchingEngine.php`

### Step 1: Parse resume text
`parseResume()` prompts `ResumeParserAgent` and gets normalized structured JSON.

### Step 2: Parse each job description
`parseJob()` prompts `JobDescriptionParserAgent`.

### Step 3: Build embedding payload text
Methods:
- `embeddingPayloadForResume(...)`
- `embeddingPayloadForJob(...)`

These compose a richer semantic summary from extracted fields + raw text.

### Step 4: Generate embeddings
`Embeddings::for(...)->generate()` returns vectors.

### Step 5: Persist resume and jobs
Vectors + parsed JSON are saved in DB.

### Step 6: Compute cosine similarity
`cosineSimilarity($resumeVec, $jobVec)` computes semantic closeness.

### Step 7: Try reranking
`Reranking::of(...)->rerank(...)` improves ordering when provider supports it.
If it fails, system keeps cosine-only ranking.

### Step 8: Blend score
`blendScores()` currently uses:

```txt
match_score = 0.7 * cosine + 0.3 * rerank
```

If rerank is missing:

```txt
match_score = cosine
```

### Step 9: Skill overlap and gaps
From `skills_csv`:
- strengths = intersection
- missing = required - available

### Step 10: Human explanation
`buildGapExplanation()` calls `MatchGapExplainerAgent` to explain fit/gaps.

### Step 11: Persist + sort results
Writes `resume_job_matches`, returns jobs sorted by final score.

---

## 6) Embedding concepts (deep dive)

### What is an embedding?
A numeric representation of meaning. Similar meanings are closer in vector space.

### Why embeddings for matching?
Keyword-only matching misses paraphrases. Embeddings capture semantic intent.

### Dimensionality
Depends on provider/model (e.g., 1536 dimensions).

### Distance/similarity options
- cosine similarity (used in this module)
- Euclidean distance
- dot product

### Batch embedding
You can embed multiple texts in one call:

```php
Embeddings::for([$a, $b, $c])->generate();
```

### Caching (Laravel AI docs concept)
To reduce repeated API cost:
- enable global embedding cache in `config/ai.php`
- or call `->cache()` on specific embedding requests

### Vector querying (Laravel AI docs concept)
At larger scale, use PostgreSQL + pgvector for indexed similarity search:
- `whereVectorSimilarTo`
- `orderByVectorDistance`
- `selectVectorDistance`

---

## 7) Scoring formula

### Cosine similarity

Given vectors `a` and `b`:

- `dot = sum(a_i * b_i)`
- `|a| = sqrt(sum(a_i^2))`
- `|b| = sqrt(sum(b_i^2))`
- `cosine = dot / (|a| * |b|)`

The service:
- returns `0` for empty/mismatched vectors
- clamps the result into `[0, 1]`

### Blended final score

- with reranking: `0.7*cosine + 0.3*rerank`
- without reranking: `cosine`

---

## 8) Why reranking is added

Embeddings are strong for broad semantic retrieval.
Reranking improves top-order precision.

Common production pattern:
- embeddings retrieve good candidates,
- reranker improves final ordering.

---

## 9) Setup and run

1. Configure API keys in `.env`:
   - text provider key
   - embeddings provider key
   - optional reranking provider key

2. Run migrations:

```bash
php artisan migrate
```

3. Open:

```txt
/ai/resume-matcher
```

4. Paste resume + multiple jobs separated by:

```txt
---
```

5. Click **Run matching engine**.

---

## 10) Debugging guide

### Parse/syntax errors

```bash
php -l app/Services/ResumeJobMatchingEngine.php
```

### Scores look wrong or all zero
- Check embeddings exist in DB.
- Check vectors have same dimensions.
- Check embedding provider key/model is configured.

### Rerank always null
- Reranking provider may be missing or unsupported.
- System still works with cosine-only scoring.

### Skill gaps look noisy
- Tighten parser prompts/schemas.
- Normalize skill synonyms (e.g., "node" vs "node.js").

---

## 11) How to extend this module

- Add PDF/DOCX resume upload + text extraction
- Add bulk candidate mode (many resumes vs one JD)
- Add mandatory vs optional skill weighting
- Add seniority weighting and domain boosts
- Add export shortlist as CSV
- Add recruiter feedback loop to adjust scoring

---

## 12) Future project ideas (same embedding pattern)

1. **Support Ticket Auto Router**
   - Embed tickets and route by semantic similarity to known issue categories.

2. **Internal Knowledge Search (RAG)**
   - Embed docs/runbooks and retrieve answer context.

3. **Sales Lead Qualification Engine**
   - Match lead notes against ideal customer profile embeddings.

4. **Learning Gap Advisor**
   - Match student skill profile vs target role and suggest learning path.

5. **Policy/Contract Clause Matcher**
   - Compare clauses against approved standard library and flag risk.

6. **Talent Rediscovery**
   - Match archived applicant resumes to newly opened job profiles.

---

## Official reference

- Laravel AI docs: [https://laravel.com/docs/ai](https://laravel.com/docs/ai)

This README is a practical project guide. Keep official docs as source of truth for API behavior and provider support.
