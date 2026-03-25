<?php

namespace App\Http\Controllers;

use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

use function Symfony\Component\Clock\now;

class AIController extends Controller
{
    use ResponseTrait;
    public function ask(Request $request)
{
    $symptoms = Auth::user()->symptomes()->latest()->take(5)->get();

    if ($symptoms->isEmpty()) {
        return $this->errorResponse([], 'Aucun symptôme trouvé');
    }

    $symptomsText = "";

    foreach ($symptoms as $s) {
        $symptomsText .= "Name: {$s->name}, Level: {$s->niveau}, Description: {$s->description}\n";
    }

    $prompt = "Symptoms:\n" .
              $symptomsText .
              "Provide general wellness advice. Do not give medical diagnosis. In 20 words and in French.";

    $response = Http::withHeaders([
        'x-goog-api-key' => env('GEMINI_API_KEY'),
        'Content-Type' => 'application/json',
    ])->post('https://generativelanguage.googleapis.com/v1beta/models/gemini-3-flash-preview:generateContent', [
        "contents" => [
            ["parts" => [["text" => $prompt]]]
        ]
    ]);

    $data = $response->json();

    $advice = $data['candidates'][0]['content']['parts'][0]['text'] ?? 'No advice';

    return $this->successResponse([
        'advice' => $advice,
        'generated_at' => now(),
    ], "Conseils générés par l'IA");
}
}
