<?php

use App\Ai\Agents\StreamShowcaseAgent;
use App\Livewire\Ai\AttachmentsDemo;
use App\Livewire\Ai\EmbeddingsDemo;
use App\Livewire\Ai\ExamplesIndex;
use App\Livewire\Ai\FailoverDemo;
use App\Livewire\Ai\FilesDemo;
use App\Livewire\Ai\FileSearchDemo;
use App\Livewire\Ai\ImageDemo;
use App\Livewire\Ai\MiddlewareDemo;
use App\Livewire\Ai\QueueDemo;
use App\Livewire\Ai\QuickAskDemo;
use App\Livewire\Ai\SimilarityDemo;
use App\Livewire\Ai\SpeechDemo;
use App\Livewire\Ai\StoresDemo;
use App\Livewire\Ai\StreamDemo;
use App\Livewire\Ai\StructuredOutputDemo;
use App\Livewire\Ai\ToolsDemo;
use App\Livewire\Ai\TranscribeDemo;
use App\Livewire\Chatbot;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/chat', Chatbot::class)->name('chat');

    Route::get('/ai', ExamplesIndex::class)->name('ai.index');
    Route::get('/ai/structured', StructuredOutputDemo::class)->name('ai.structured');
    Route::get('/ai/tools', ToolsDemo::class)->name('ai.tools');
    Route::get('/ai/quick', QuickAskDemo::class)->name('ai.quick');
    Route::get('/ai/attachments', AttachmentsDemo::class)->name('ai.attachments');
    Route::get('/ai/stream', StreamDemo::class)->name('ai.stream');
    Route::get('/ai/queue', QueueDemo::class)->name('ai.queue');
    Route::get('/ai/images', ImageDemo::class)->name('ai.images');
    Route::get('/ai/speech', SpeechDemo::class)->name('ai.speech');
    Route::get('/ai/transcribe', TranscribeDemo::class)->name('ai.transcribe');
    Route::get('/ai/embeddings', EmbeddingsDemo::class)->name('ai.embeddings');
    Route::get('/ai/files', FilesDemo::class)->name('ai.files');
    Route::get('/ai/stores', StoresDemo::class)->name('ai.stores');
    Route::get('/ai/file-search', FileSearchDemo::class)->name('ai.file-search');
    Route::get('/ai/similarity', SimilarityDemo::class)->name('ai.similarity');
    Route::get('/ai/middleware', MiddlewareDemo::class)->name('ai.middleware');
    Route::get('/ai/failover', FailoverDemo::class)->name('ai.failover');

    Route::get('/ai/stream/sse', function () {
        $q = (string) request('q', 'Say hello in one sentence.');

        return (new StreamShowcaseAgent)->stream($q);
    })->name('ai.stream.sse');

    Route::get('/ai/stream/vercel', function () {
        $q = (string) request('q', 'Say hello in one sentence.');

        return (new StreamShowcaseAgent)->stream($q)->usingVercelDataProtocol();
    })->name('ai.stream.vercel');
});

require __DIR__.'/settings.php';
