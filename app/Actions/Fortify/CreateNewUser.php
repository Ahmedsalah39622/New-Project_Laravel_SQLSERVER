<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;
use App\Models\Patient;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        // Define the validation rules
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ];

        // Validate the input
        $validator = Validator::make($input, $rules);

        // Check if validation fails
        if ($validator->fails()) {
            // Throw a validation exception with the errors
            throw new \Illuminate\Validation\ValidationException($validator);
        }

        // Create the Patient record
        Patient::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'age' => $input['age'] ?? null,
            'birthdate' => $input['birthdate'] ?? null,
            'gender' => $input['gender'] ?? null,
            'blood_type' => $input['blood_type'] ?? null,
            'phone' => $input['phone'],
            'insurance_provider' => $input['insurance_provider'] ?? null,
        ]);

        // Create and return the User record
        return User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
        ]);
    }
}
