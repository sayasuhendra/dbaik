<?php

use Livewire\Volt\Component;
use App\Models\MeetingSchedule;

new class extends Component {
    public string $client_name = '';
    public string $client_email = '';
    public string $client_phone = '';
    public string $topic = '';
    public string $meeting_date = '';
    public string $meeting_time = '';
    public string $notes = '';

    public bool $isSuccess = false;

    public function rules()
    {
        return [
            'client_name' => 'required|string|max:255',
            'client_email' => 'required|email|max:255',
            'client_phone' => 'required|string|max:20',
            'topic' => 'required|string|max:255',
            'meeting_date' => 'required|date|after_or_equal:today',
            'meeting_time' => 'required',
            'notes' => 'nullable|string',
        ];
    }

    public function submit()
    {
        $this->validate();

        MeetingSchedule::create([
            'client_name' => $this->client_name,
            'client_email' => $this->client_email,
            'client_phone' => $this->client_phone,
            'topic' => $this->topic,
            'meeting_date' => $this->meeting_date,
            'meeting_time' => $this->meeting_time,
            'notes' => $this->notes,
            'status' => 'pending',
        ]);

        $this->isSuccess = true;
        $this->reset(['client_name', 'client_email', 'client_phone', 'topic', 'meeting_date', 'meeting_time', 'notes']);
    }
}; ?>

<div>
    <section class="relative z-10 py-32 min-h-screen flex items-center justify-center px-4 sm:px-6 lg:px-8">
        <div class="glass-panel max-w-3xl w-full p-6 md:p-12 mx-auto relative overflow-hidden" style="border-radius: 2rem;">
            <!-- Glow Effect -->
            <div class="absolute -top-32 -left-32 w-64 h-64 bg-cyan-500/20 rounded-full blur-[100px] pointer-events-none"></div>
            <div class="absolute -bottom-32 -right-32 w-64 h-64 bg-fuchsia-500/20 rounded-full blur-[100px] pointer-events-none"></div>

            <div class="relative z-10">
                <div class="text-center mb-10">
                    <h2 class="text-3xl md:text-5xl font-black text-white tracking-tight mb-4" style="text-shadow: 0 4px 20px rgba(0,0,0,0.5);">
                        Jadwalkan <span class="text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 to-fuchsia-400">Meeting</span>
                    </h2>
                    <p class="text-slate-400 text-sm md:text-base">Pilih waktu yang tepat untuk mendiskusikan kebutuhan Anda bersama kami.</p>
                </div>

                @if($isSuccess)
                    <div class="p-6 bg-green-500/10 border border-green-500/20 rounded-2xl text-center backdrop-blur-sm">
                        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-green-500/20 text-green-400 mb-4">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                        <h3 class="text-xl font-bold text-white mb-2">Permintaan Terkirim!</h3>
                        <p class="text-green-300/80 text-sm">Tim kami akan segera meninjau jadwal Anda dan mengirimkan tautan meeting.</p>
                        <button wire:click="$set('isSuccess', false)" class="mt-6 px-6 py-2 bg-slate-800 hover:bg-slate-700 text-white rounded-full text-sm font-semibold transition-colors duration-300">
                            Jadwalkan Lainnya
                        </button>
                    </div>
                @else
                    <form wire:submit="submit" class="space-y-6 relative">
                        <!-- Loading Overlay -->
                        <div wire:loading wire:target="submit" class="absolute inset-0 z-50 rounded-2xl flex items-center justify-center backdrop-blur-md bg-[#0B1121]/60">
                            <div class="flex flex-col items-center">
                                <div class="w-10 h-10 border-4 border-cyan-500/30 border-t-cyan-500 rounded-full animate-spin"></div>
                                <span class="text-cyan-400 mt-4 font-bold text-sm uppercase tracking-widest">Memproses...</span>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Name -->
                            <div>
                                <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Nama Lengkap</label>
                                <input type="text" wire:model="client_name" class="w-full bg-[#0B1121]/50 border border-slate-700/50 rounded-xl px-4 py-3 text-white placeholder-slate-600 focus:outline-none focus:border-cyan-500/50 focus:ring-1 focus:ring-cyan-500/50 transition-all duration-300" placeholder="John Doe">
                                @error('client_name') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <!-- Phone -->
                            <div>
                                <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Nomor Telepon / WA</label>
                                <input type="tel" wire:model="client_phone" class="w-full bg-[#0B1121]/50 border border-slate-700/50 rounded-xl px-4 py-3 text-white placeholder-slate-600 focus:outline-none focus:border-cyan-500/50 focus:ring-1 focus:ring-cyan-500/50 transition-all duration-300" placeholder="08123456789">
                                @error('client_phone') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <!-- Email -->
                        <div>
                            <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Email</label>
                            <input type="email" wire:model="client_email" class="w-full bg-[#0B1121]/50 border border-slate-700/50 rounded-xl px-4 py-3 text-white placeholder-slate-600 focus:outline-none focus:border-cyan-500/50 focus:ring-1 focus:ring-cyan-500/50 transition-all duration-300" placeholder="john@example.com">
                            @error('client_email') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <!-- Topic -->
                        <div>
                            <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Topik Meeting</label>
                            <input type="text" wire:model="topic" class="w-full bg-[#0B1121]/50 border border-slate-700/50 rounded-xl px-4 py-3 text-white placeholder-slate-600 focus:outline-none focus:border-cyan-500/50 focus:ring-1 focus:ring-cyan-500/50 transition-all duration-300" placeholder="Konsultasi Pembuatan Website, dll">
                            @error('topic') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Date -->
                            <div>
                                <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Tanggal Meeting</label>
                                <input type="date" wire:model="meeting_date" min="{{ date('Y-m-d') }}" class="w-full bg-[#0B1121]/50 border border-slate-700/50 rounded-xl px-4 py-3 text-white placeholder-slate-600 focus:outline-none focus:border-cyan-500/50 focus:ring-1 focus:ring-cyan-500/50 transition-all duration-300 [color-scheme:dark]">
                                @error('meeting_date') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <!-- Time -->
                            <div>
                                <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Waktu Meeting (WIB)</label>
                                <input type="time" wire:model="meeting_time" class="w-full bg-[#0B1121]/50 border border-slate-700/50 rounded-xl px-4 py-3 text-white placeholder-slate-600 focus:outline-none focus:border-cyan-500/50 focus:ring-1 focus:ring-cyan-500/50 transition-all duration-300 [color-scheme:dark]">
                                @error('meeting_time') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <!-- Notes -->
                        <div>
                            <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Catatan Tambahan (Opsional)</label>
                            <textarea wire:model="notes" rows="3" class="w-full bg-[#0B1121]/50 border border-slate-700/50 rounded-xl px-4 py-3 text-white placeholder-slate-600 focus:outline-none focus:border-cyan-500/50 focus:ring-1 focus:ring-cyan-500/50 transition-all duration-300 resize-none" placeholder="Ada detail khusus yang ingin dibahas?"></textarea>
                            @error('notes') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <button type="submit" class="w-full btn-primary py-4 rounded-xl flex items-center justify-center font-extrabold text-sm uppercase tracking-widest transition-all duration-300 transform hover:-translate-y-1 hover:shadow-lg hover:shadow-cyan-500/25 mt-8">
                            Kirim Permintaan
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </section>
</div>
