<?php

use Livewire\Volt\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

new class extends Component {
    public $name = '';
    public $email = '';
    public $password = '';
    public $password_confirmation = '';
    public $errorMessage = '';

    public function mount()
    {
        if (auth()->check()) {
            return redirect()->route('client.portal');
        }
    }

    public function register()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|min:8|confirmed',
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email ini sudah terdaftar.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal terdiri dari 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        try {
            $user = User::create([
                'name' => $this->name,
                'email' => $this->email,
                'password' => Hash::make($this->password),
                'is_admin' => false,
            ]);

            Auth::login($user);

            session()->regenerate();

            return redirect()->route('client.portal');
        } catch (\Exception $e) {
            $this->errorMessage = 'Terjadi kesalahan saat pendaftaran: ' . $e->getMessage();
        }
    }
};

?>

<div class="relative z-10 py-16 md:py-20 min-h-[85vh] flex items-center justify-center">
    <!-- Glow Background Accents -->
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 h-[350px] w-[350px] rounded-full bg-cyan-500/10 blur-[100px] pointer-events-none"></div>
    <div class="absolute top-1/3 left-1/3 h-[250px] w-[250px] rounded-full bg-blue-500/10 blur-[90px] pointer-events-none"></div>

    <div class="container mx-auto px-6 max-w-md w-full relative">
        @section('title', 'Daftar Portal Klien — DBAIK Digital Agency')

        <div class="glass-panel p-8 rounded-3xl shadow-2xl relative overflow-hidden" style="border-color: rgba(6, 182, 212, 0.15); box-shadow: 0 20px 50px rgba(0,0,0,0.4), 0 0 30px rgba(6, 182, 212, 0.05);">
            <!-- Title -->
            <div class="text-center mb-8">
                <span class="text-[10px] font-bold tracking-widest text-cyan-400 uppercase">JOIN CLIENT HUB</span>
                <h2 class="text-3xl font-black text-white mt-2">Daftar Akun</h2>
                <p class="text-xs text-slate-400 mt-2">Buat akun untuk mengelola support ticket, tagihan, dan melihat demo aplikasi Anda.</p>
            </div>

            <!-- Error Notification -->
            @if($errorMessage)
                <div class="mb-6 p-4 rounded-xl border border-red-500/20 bg-red-950/20 text-red-400 text-xs flex items-center gap-2">
                    <span>⚠️</span>
                    <span>{{ $errorMessage }}</span>
                </div>
            @endif

            <form wire:submit.prevent="register" class="space-y-4">
                <!-- Name Field -->
                <div class="space-y-1">
                    <label for="name" class="text-xs font-bold text-slate-300 tracking-wide uppercase">Nama Lengkap</label>
                    <input type="text" id="name" wire:model.defer="name" required
                        class="w-full bg-slate-900/50 border border-white/10 rounded-2xl px-5 py-3 text-sm text-white focus:outline-none focus:border-cyan-400 focus:ring-1 focus:ring-cyan-400 transition-all placeholder-slate-500"
                        placeholder="John Doe">
                    @error('name') <span class="text-red-400 text-[10px]">{{ $message }}</span> @enderror
                </div>

                <!-- Email Field -->
                <div class="space-y-1">
                    <label for="email" class="text-xs font-bold text-slate-300 tracking-wide uppercase">Email Address</label>
                    <input type="email" id="email" wire:model.defer="email" required
                        class="w-full bg-slate-900/50 border border-white/10 rounded-2xl px-5 py-3 text-sm text-white focus:outline-none focus:border-cyan-400 focus:ring-1 focus:ring-cyan-400 transition-all placeholder-slate-500"
                        placeholder="nama@email.com">
                    @error('email') <span class="text-red-400 text-[10px]">{{ $message }}</span> @enderror
                </div>

                <!-- Password Field -->
                <div class="space-y-1" x-data="{ show: false }">
                    <label for="password" class="text-xs font-bold text-slate-300 tracking-wide uppercase">Password</label>
                    <div class="relative">
                        <input :type="show ? 'text' : 'password'" id="password" wire:model.defer="password" required
                            class="w-full bg-slate-900/50 border border-white/10 rounded-2xl px-5 py-3 pr-12 text-sm text-white focus:outline-none focus:border-cyan-400 focus:ring-1 focus:ring-cyan-400 transition-all placeholder-slate-500"
                            placeholder="••••••••">
                        <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 flex items-center pr-4 text-slate-400 hover:text-cyan-400 transition-colors">
                            <svg x-show="!show" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <svg x-show="show" style="display: none;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                            </svg>
                        </button>
                    </div>
                    @error('password') <span class="text-red-400 text-[10px]">{{ $message }}</span> @enderror
                </div>

                <!-- Password Confirmation Field -->
                <div class="space-y-1" x-data="{ show: false }">
                    <label for="password_confirmation" class="text-xs font-bold text-slate-300 tracking-wide uppercase">Konfirmasi Password</label>
                    <div class="relative">
                        <input :type="show ? 'text' : 'password'" id="password_confirmation" wire:model.defer="password_confirmation" required
                            class="w-full bg-slate-900/50 border border-white/10 rounded-2xl px-5 py-3 pr-12 text-sm text-white focus:outline-none focus:border-cyan-400 focus:ring-1 focus:ring-cyan-400 transition-all placeholder-slate-500"
                            placeholder="••••••••">
                        <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 flex items-center pr-4 text-slate-400 hover:text-cyan-400 transition-colors">
                            <svg x-show="!show" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <svg x-show="show" style="display: none;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full btn-primary py-4 rounded-2xl flex items-center justify-center font-bold tracking-wider uppercase text-xs mt-6" style="background: linear-gradient(135deg, var(--gold-400), var(--gold-500)); color: black; box-shadow: 0 6px 20px rgba(6, 182, 212, 0.2);">
                    <span>Daftar Akun</span>
                </button>
            </form>

            <div class="mt-6 pt-6 border-t border-white/5 text-center">
                <p class="text-xs text-slate-400">Sudah memiliki akun? <a href="{{ route('client.login') }}" class="text-cyan-400 font-bold hover:underline">Log in Sekarang</a></p>
            </div>
        </div>
    </div>
</div>
