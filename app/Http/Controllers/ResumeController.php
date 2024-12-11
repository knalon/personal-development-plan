<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http; // To make HTTP requests
use Smalot\PdfParser\Parser;

class ResumeController extends Controller
{
    public function showForm()
    {
        return view('upload-resume');
    }

    public function showText()
    {
        $resumeText = session('resumeText', 'No text found');
        if (is_array($resumeText)) {
            $resumeText = implode("\n", $resumeText); // Convert array to string
        }
        return view('resume-text', compact('resumeText'));
    }

    public function uploadResume(Request $request)
    {
        $request->validate([
            'resume' => 'required|mimes:pdf|max:2048',
            'ai_choice' => 'required|string|in:textcortex,gemini',
        ]);

        // Store the uploaded file
        $pdfFile = $request->file('resume');
        $path = $pdfFile->getPathname();

        // Parse the PDF to extract text
        $parser = new Parser();
        $pdf = $parser->parseFile($path);
        $text = $pdf->getText();

        // Prepare the context for the API call
        $context = "Generate a Detailed Personal Development Plan using the following resume : " . $text;

        // Handle AI choice
        $aiChoice = $request->input('ai_choice');

        // Initialize variables to store the responses
        $generatedText = '';

        if ($aiChoice === 'textcortex') {
            $response = $this->callTextCortex($context);
            $generatedText = $response; // TextCortex returns a string
        } elseif ($aiChoice === 'gemini') {
            $response = $this->callGemini($context);
            $generatedText = $response; // Gemini returns an array
        }
        // dd($geminiOutput);
        // Redirect to a view to display the PDP and action plan
        return redirect()->route('resume.text')
            ->with('resumeText', $generatedText);
    }
   

    // Redirect to a view to

    private function callTextCortex($context)
    {
        // Make the API call to TextCortex
        $response = Http::withToken('gAAAAABnGdENKXAxSqpGBJkXw3CZqdnTpmAEJ6dLt4yM68psZFYNGdmpO1bFbIEL4vzDwzUMGSi07dIc-zOuJyW36nhGm8W4cSK1OXmdjFusjOlQoZ6rMZrsAtKm-1esljiIWKGI5i8i') // Replace with TextCortex API Key
            ->post('https://api.textcortex.com/v1/texts/blogs', [
                'context' => $context,
                'formality' => 'default',
                'keywords' => ['Personal development plan'],
                'max_tokens' => 2048,
                'model' => 'claude-3-haiku',
                'n' => 1,
                'source_lang' => 'en',
                'target_lang' => 'en',
                'temperature' => null,
                'title' => 'Personal Development Plan'
            ]);

        // Handle the API response and return the generated text
        $responseData = $response->json();
        return $responseData['data']['outputs'][0]['text'] ?? 'Error: No text generated.';
    }

    private function callGemini($context)
    {
        // Make the API call to Gemini
        $response = Http::post('https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key=AIzaSyCbtNEMVdPOaUs0lxb46dVHMzk8cFASCdQ', [ // Replace with your actual API Key
            'contents' => [
                [
                    'parts' => [
                        ['text' => $context]
                    ]
                ]
            ]
        ]);

        // Handle the API response
        $responseData = $response->json();
        // dd($response);
        if (isset($responseData['candidates'][0]['content']['parts'])) {
            $geminiTextParts = $responseData['candidates'][0]['content']['parts'][0]['text'];
            // Clean up the text to remove unwanted symbols (*, #, etc.)
            $cleanedTextParts = preg_replace('/[\*\#]/', '', $geminiTextParts); // Remove unwanted symbols
            return $cleanedTextParts;
        }

        return ['Error: No text generated.'];
    }

    // private function callGemini($context)
    // {
    //     // Make the API call to Gemini
    //     $response = Http::post('https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key=AIzaSyCbtNEMVdPOaUs0lxb46dVHMzk8cFASCdQ', [ // Replace with your actual API Key
    //         'contents' => [
    //             [
    //                 'parts' => [
    //                     ['text' => $context]
    //                 ]
    //             ]
    //         ]
    //     ]);

    //     // Handle the API response and return the generated text
    //     $responseData = $response->json();
    //     if (isset($responseData['candidates'][0]['content']['parts'][0]['text'])) {
    //         return $responseData['candidates'][0]['content']['parts'][0]['text'];
    //     }

    //     return 'Error: No text generated.';
    // }
}