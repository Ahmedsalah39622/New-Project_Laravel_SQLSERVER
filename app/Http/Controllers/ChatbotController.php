<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChatbotController extends Controller
{
    public function getResponse(Request $request)
    {
        $input = strtolower($request->input('message'));

        $responses = [
            'heart' => 'You may need to visit the Cardiology clinic.',
            'chest pain' => 'You should visit the Cardiology clinic.',
            'toothache' => 'Dentistry clinic is the best option for you.',
            'teeth' => 'Visit the Dentistry clinic for a check-up.',
            'headache' => 'Neurology clinic can help you.',
            'nerve' => 'Consider visiting a Neurology specialist.',
            'bone' => 'Orthopedics clinic is recommended.',
            'joint pain' => 'You may benefit from an Orthopedics consultation.',
            'child' => 'Pediatrics clinic is the right choice.',
            'baby' => 'A pediatrician would be best for your baby.',
            'skin' => 'Dermatology clinic will be helpful.',
            'rash' => 'You should check with a Dermatologist.',
        ];

        foreach ($responses as $key => $response) {
            if (strpos($input, $key) !== false) {
                return response()->json(['response' => $response]);
            }
        }

        return response()->json(['response' => 'I am not sure, but a general check-up might be a good start!']);
    }
}
