<?php
namespace App\Filament\Pages;

use App\Models\Organization;
use Filament\Pages\Auth\Register;
use Filament\Forms\Form;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\TextInput;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Facades\Blade;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log; // Import logging

class registration extends Register
{
    public $name;
    public $email;
    public $password;
    protected ?string $maxWidth = '2xl';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Wizard::make([
                    Wizard\Step::make('Kontak')
                        ->schema([
                            TextInput::make('name')
                                ->label('Nama')
                                ->required()
                                ->reactive(), // Pastikan input bersifat reactive
                            TextInput::make('email')
                                ->label('Email')
                                ->required(),
                        ]),
                    Wizard\Step::make('Password')
                        ->schema([
                            TextInput::make('password')
                                ->label('Password')
                                ->required()
                                ->password(),
                            TextInput::make('password_confirmation')
                                ->label('Konfirmasi Password')
                                ->required()
                                ->password(),
                        ]),
                ])->submitAction(new HtmlString(Blade::render(<<<BLADE
                    <x-filament::button
                        type="submit"
                        size="sm"
                    >
                        Register
                    </x-filament::button>
                BLADE))),
            ]);
        }

        protected function getFormActions(): array
        {
            return [];
        }
    
        public function dehydrate(): void
        {
            $formState = $this->form->getState();
    
            // Tambahkan log untuk debug
            Log::info('Form State: ', $formState);
    
            $this->name = $formState['name'] ?? null;
            $this->email = $formState['email'] ?? null;
            $this->password = $formState['password'] ?? null;
    
            // Log setelah menetapkan nilai
            Log::info('Dehydrate - Name: ' . $this->name);
            Log::info('Dehydrate - Email: ' . $this->email);
            Log::info('Dehydrate - Password: ' . ($this->password ? 'Yes' : 'No'));
        }
    
        public function register(): ?\Filament\Http\Responses\Auth\Contracts\RegistrationResponse
        {
            // Tambahkan logging untuk debug
            Log::info('Register method called.');
            Log::info('Name: ' . $this->name);
            Log::info('Email: ' . $this->email);
            Log::info('Password is set: ' . ($this->password ? 'Yes' : 'No'));
    
            try {
                DB::transaction(function () {
                    $organization = Organization::create([
                        'name' => 'Nama Organisasi Default',
                    ]);
    
                    // Pastikan nilai name tidak kosong
                    if (is_null($this->name) || is_null($this->email) || is_null($this->password)) {
                        throw new \Exception('Field name, email, atau password kosong!');
                    }
    
                    $user = User::create([
                        'name' => $this->name,
                        'email' => $this->email,
                        'password' => bcrypt($this->password),
                        'organization_id' => $organization->id,
                    ]);
    
                    auth()->login($user);
                });
    
                return redirect()->route('filament.pages.dashboard');
            } catch (\Exception $e) {
                Log::error('Registration error: ' . $e->getMessage());
                throw $e; // Tambahkan penanganan exception jika perlu
            }
        }
    }