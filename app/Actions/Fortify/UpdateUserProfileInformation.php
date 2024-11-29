<?php
namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;

class UpdateUserProfileInformation implements UpdatesUserProfileInformation
{
    /**
     * Validate and update the given user's profile information.
     *
     * @param  array<string, mixed>  $input
     */
    public function update(User $user, array $input): void
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone' => ['nullable', 'string', 'max:15'], // Validación para teléfono
            'grade' => ['nullable', 'string', 'max:255'], // Validación para grado
            'escalafon' => ['nullable', 'string', 'max:255'], // Validación para escalafón
            'photo' => ['nullable', 'mimes:jpg,jpeg,png', 'max:1024'],
        ])->validateWithBag('updateProfileInformation');

        // Actualizar la foto de perfil si se proporciona
        if (isset($input['photo'])) {
            $user->updateProfilePhoto($input['photo']);
        }

        // Si el correo cambia y el usuario requiere verificación, manejar la lógica de verificación
        if ($input['email'] !== $user->email &&
            $user instanceof MustVerifyEmail) {
            $this->updateVerifiedUser($user, $input);
        } else {
            // Actualizar el usuario con los nuevos datos
            $user->forceFill([
                'name' => $input['name'],
                'email' => $input['email'],
                'phone' => $input['phone'], // Nuevo campo
                'grade' => $input['grade'], // Nuevo campo
                'escalafon' => $input['escalafon'], // Nuevo campo
            ])->save();
        }
    }

    /**
     * Update the given verified user's profile information.
     *
     * @param  array<string, string>  $input
     */
    protected function updateVerifiedUser(User $user, array $input): void
    {
        $user->forceFill([
            'name' => $input['name'],
            'email' => $input['email'],
            'email_verified_at' => null,
            'phone' => $input['phone'], // Asegurar que también se guarden los nuevos campos
            'grade' => $input['grade'],
            'escalafon' => $input['escalafon'],
        ])->save();

        $user->sendEmailVerificationNotification();
    }
}
