<?php

use App\Models\SoftwareDemo;
use App\Models\Billing;
use App\Models\SupportTicket;
use App\Models\SupportMessage;
use App\Models\WhatsAppReminder;
use App\Services\WhatsAppService;
use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Component;

new class extends Component {
    public $activeTab = 'overview';
    public $selectedDemoId = null;
    public $selectedTicketId = null;

    // Support Ticket fields
    public $newTicketSubject = '';
    public $newTicketCategory = 'technical';
    public $newTicketPriority = 'medium';
    public $newTicketMessage = '';
    public $showCreateTicketModal = false;
    public $replyMessage = '';

    // Payment simulation modal
    public $showPaymentModal = false;
    public $paymentBillingId = null;
    public $cardNumber = '4111 2222 3333 4444';
    public $cardName = '';
    public $cardExpiry = '12/28';
    public $cardCvv = '123';
    public $isProcessingPayment = false;

    public function mount()
    {
        if (!Auth::check()) {
            return redirect()->route('client.login');
        }
        $this->cardName = strtoupper(Auth::user()->name);
    }

    // Computed properties
    public function getDemosProperty()
    {
        return SoftwareDemo::where('is_active', true)->get();
    }

    public function getBillingsProperty()
    {
        return Billing::where('user_id', Auth::id())->orderBy('due_date', 'asc')->get();
    }

    public function getTicketsProperty()
    {
        return SupportTicket::where('user_id', Auth::id())->orderBy('updated_at', 'desc')->get();
    }

    public function getSelectedTicketProperty()
    {
        if (!$this->selectedTicketId) return null;
        return SupportTicket::where('user_id', Auth::id())->with('supportMessages.user')->find($this->selectedTicketId);
    }

    public function getSelectedDemoProperty()
    {
        if (!$this->selectedDemoId) return null;
        return SoftwareDemo::find($this->selectedDemoId);
    }

    public function getWhatsappRemindersProperty()
    {
        $billingIds = Billing::where('user_id', Auth::id())->pluck('id')->toArray();
        return WhatsAppReminder::whereIn('billing_id', $billingIds)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function getOverviewStatsProperty()
    {
        $billings = $this->billings;
        $tickets = $this->tickets;
        
        return [
            'unpaid_count' => $billings->whereIn('status', ['pending', 'overdue'])->count(),
            'unpaid_total' => $billings->whereIn('status', ['pending', 'overdue'])->sum('amount'),
            'active_tickets' => $tickets->whereIn('status', ['open', 'in_progress'])->count(),
            'total_demos' => $this->demos->count(),
        ];
    }

    public function setActiveTab($tab)
    {
        $this->activeTab = $tab;
        $this->selectedDemoId = null;
        if ($tab !== 'support') {
            $this->selectedTicketId = null;
        }
    }

    public function selectDemo($id)
    {
        $this->selectedDemoId = $id;
    }

    public function selectTicket($id)
    {
        $this->selectedTicketId = $id;
        $this->replyMessage = '';
    }

    public function openPaymentModal($billingId)
    {
        $billing = Billing::where('user_id', Auth::id())->findOrFail($billingId);
        if ($billing->status === 'paid') {
            $this->showToast('Tagihan ini sudah lunas!', 'info');
            return;
        }
        $this->paymentBillingId = $billingId;
        $this->showPaymentModal = true;
        $this->isProcessingPayment = false;
    }

    public function simulatePayment()
    {
        $this->isProcessingPayment = true;
        
        $billing = Billing::where('user_id', Auth::id())->findOrFail($this->paymentBillingId);
        
        $billing->update([
            'status' => 'paid',
        ]);

        // Send simulated WhatsApp notification using the service
        $whatsappService = new WhatsAppService();
        $whatsappService->sendMessage(
            $billing->whatsapp_number ?? '081234567890',
            "✨ *DBAIK DIGITAL AGENCY - PEMBAYARAN SUKSES* ✨\n\nHalo " . Auth::user()->name . ",\n\nTerima kasih! Pembayaran Anda sebesar *Rp " . number_format($billing->amount, 0, ',', '.') . "* untuk invoice *\"" . $billing->title . "\"* telah kami terima secara instan dan aman.\n\nStatus invoice Anda kini adalah: *LUNAS (PAID)* ✅\n\nDetail Transaksi:\n- Invoice: #" . str_pad($billing->id, 5, '0', STR_PAD_LEFT) . "\n- Layanan: " . $billing->title . "\n- Nominal: Rp " . number_format($billing->amount, 0, ',', '.') . "\n- Metode: Kartu Kredit (Simulated)\n- Tanggal: " . now()->format('d M Y H:i') . " WIB\n\nJika ada pertanyaan mengenai billing Anda, silakan hubungi tim kami melalui support ticket portal klien.\n\nSalam Hangat,\n*Team DBAIK*",
            $billing
        );

        $this->isProcessingPayment = false;
        $this->showPaymentModal = false;
        $this->paymentBillingId = null;
        $this->showToast('Pembayaran berhasil diproses secara aman! Status tagihan diperbarui menjadi LUNAS.', 'success');
    }

    public function createTicket()
    {
        $this->validate([
            'newTicketSubject' => 'required|min:5|max:255',
            'newTicketCategory' => 'required|in:technical,billing,general',
            'newTicketPriority' => 'required|in:low,medium,high',
            'newTicketMessage' => 'required|min:10',
        ], [
            'newTicketSubject.required' => 'Subjek wajib diisi.',
            'newTicketSubject.min' => 'Subjek tiket minimal 5 karakter.',
            'newTicketMessage.required' => 'Deskripsi masalah wajib diisi.',
            'newTicketMessage.min' => 'Pesan minimal terdiri dari 10 karakter.',
        ]);

        $ticket = SupportTicket::create([
            'user_id' => Auth::id(),
            'subject' => $this->newTicketSubject,
            'category' => $this->newTicketCategory,
            'status' => 'open',
            'priority' => $this->newTicketPriority,
        ]);

        SupportMessage::create([
            'support_ticket_id' => $ticket->id,
            'user_id' => Auth::id(),
            'message' => $this->newTicketMessage,
            'is_admin' => false,
        ]);

        $this->reset(['newTicketSubject', 'newTicketCategory', 'newTicketPriority', 'newTicketMessage', 'showCreateTicketModal']);
        $this->selectedTicketId = $ticket->id;
        $this->showToast('Tiket support baru berhasil dibuat!', 'success');
    }

    public function sendReply()
    {
        if (empty(trim($this->replyMessage))) {
            return;
        }

        $ticket = SupportTicket::where('user_id', Auth::id())->findOrFail($this->selectedTicketId);

        SupportMessage::create([
            'support_ticket_id' => $ticket->id,
            'user_id' => Auth::id(),
            'message' => $this->replyMessage,
            'is_admin' => false,
        ]);

        $ticket->update(['status' => 'open']);

        $this->replyMessage = '';
        $this->showToast('Balasan Anda telah terkirim ke administrator.', 'success');
    }

    public function showToast($message, $type = 'success')
    {
        $this->dispatch('toast-notification', message: $message, type: $type);
    }

    public function logout()
    {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();
        return redirect()->route('client.login');
    }
};

?>

<div class="min-h-screen bg-[#030712] relative overflow-hidden pt-8 pb-24 text-slate-100 font-sans" x-data="{ sidebarOpen: false }">
    @section('title', 'Portal Klien — DBAIK Digital Agency')

    <!-- Toast Notification (Alpine.js) -->
    <div x-data="{ show: false, message: '', type: 'success' }"
         x-on:toast-notification.window="message = $event.detail.message; type = $event.detail.type; show = true; setTimeout(() => show = false, 5000)"
         x-show="show"
         x-transition:enter="transition ease-out duration-300 transform"
         x-transition:enter-start="opacity-0 translate-y-2 scale-95"
         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
         x-transition:leave="transition ease-in duration-200 transform"
         x-transition:leave-start="opacity-100 translate-y-0 scale-100"
         x-transition:leave-end="opacity-0 translate-y-2 scale-95"
         class="fixed bottom-10 right-10 z-50 p-5 rounded-2xl shadow-2xl flex items-center gap-3 border"
         :class="{
             'bg-emerald-950/90 border-emerald-500/30 text-emerald-400': type === 'success',
             'bg-rose-950/90 border-rose-500/30 text-rose-400': type === 'error',
             'bg-blue-950/90 border-blue-500/30 text-blue-400': type === 'info'
         }"
         style="display: none;">
        <span x-text="type === 'success' ? '✓' : (type === 'error' ? '⚠️' : 'ℹ️')" class="text-lg font-bold"></span>
        <div class="text-xs font-semibold" x-text="message"></div>
        <button @click="show = false" class="ml-3 text-slate-400 hover:text-white text-xs">&times;</button>
    </div>

    <!-- Glow Backdrop Effects -->
    <div class="absolute top-0 right-0 w-[450px] h-[450px] bg-cyan-500/5 rounded-full blur-[120px] pointer-events-none"></div>
    <div class="absolute bottom-0 left-0 w-[450px] h-[450px] bg-blue-500/5 rounded-full blur-[120px] pointer-events-none"></div>

    <div class="container mx-auto px-6 max-w-7xl relative z-10">
        <!-- Dashboard Top Header Bar -->
        <header class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-10 pb-8 border-b border-white/5">
            <div>
                <div class="flex items-center gap-3">
                    <span class="px-3 py-1 text-[10px] font-extrabold tracking-widest text-cyan-400 bg-cyan-950/30 border border-cyan-500/20 rounded-full uppercase">CLIENT SPACE</span>
                    <span class="text-slate-500 text-xs">Jalur Aman & Enkripsi Aktif</span>
                </div>
                <h1 class="text-3xl font-black text-white tracking-tight mt-2">Dashboard Portal</h1>
                <p class="text-xs text-slate-400 mt-1">Kelola demo aplikasi, billing tagihan, dan tiket support Anda secara tersentralisasi.</p>
            </div>
            
            <div class="flex items-center gap-4 bg-slate-900/50 border border-white/5 px-5 py-3 rounded-2xl">
                <div class="text-right">
                    <div class="text-xs font-black text-white">{{ Auth::user()->name }}</div>
                    <div class="text-[10px] text-slate-400 mt-0.5">{{ Auth::user()->email }}</div>
                </div>
                <div class="h-8 w-px bg-white/10"></div>
                <button wire:click="logout" class="px-4 py-2 border border-white/10 hover:border-red-500/30 bg-white/5 hover:bg-red-950/20 text-slate-300 hover:text-red-400 font-bold text-xs rounded-xl transition-all cursor-pointer">
                    Log out
                </button>
            </div>
        </header>

        <!-- Main Workspace Layout -->
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            
            <!-- Dashboard Navigation Sidebar -->
            <aside class="lg:col-span-1 space-y-3">
                <div class="glass-panel p-3 rounded-2xl grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 lg:grid-cols-1 gap-2 lg:gap-1.5">
                    <button wire:click="setActiveTab('overview')" 
                        class="w-full text-left px-3 sm:px-4 py-2.5 sm:py-3 rounded-xl text-xs font-bold transition-all flex items-center justify-between cursor-pointer {{ $activeTab === 'overview' ? 'bg-cyan-500/10 text-cyan-400 border-l-2 border-cyan-400' : 'text-slate-400 hover:text-slate-200 hover:bg-white/5' }}">
                        <span class="flex items-center gap-2 sm:gap-3">
                            <span class="text-sm sm:text-base">📊</span> Ringkasan
                        </span>
                        <span class="text-[10px] text-slate-500 hidden lg:inline">&rarr;</span>
                    </button>

                    <button wire:click="setActiveTab('demos')" 
                        class="w-full text-left px-3 sm:px-4 py-2.5 sm:py-3 rounded-xl text-xs font-bold transition-all flex items-center justify-between cursor-pointer {{ $activeTab === 'demos' ? 'bg-cyan-500/10 text-cyan-400 border-l-2 border-cyan-400' : 'text-slate-400 hover:text-slate-200 hover:bg-white/5' }}">
                        <span class="flex items-center gap-2 sm:gap-3">
                            <span class="text-sm sm:text-base">💻</span> Demo
                        </span>
                        <span class="px-2 py-0.5 bg-cyan-950 text-cyan-400 border border-cyan-500/30 rounded-full text-[9px] font-black">{{ $this->overviewStats['total_demos'] }}</span>
                    </button>

                    <button wire:click="setActiveTab('billing')" 
                        class="w-full text-left px-3 sm:px-4 py-2.5 sm:py-3 rounded-xl text-xs font-bold transition-all flex items-center justify-between cursor-pointer {{ $activeTab === 'billing' ? 'bg-cyan-500/10 text-cyan-400 border-l-2 border-cyan-400' : 'text-slate-400 hover:text-slate-200 hover:bg-white/5' }}">
                        <span class="flex items-center gap-2 sm:gap-3">
                            <span class="text-sm sm:text-base">💳</span> Billing
                        </span>
                        @if($this->overviewStats['unpaid_count'] > 0)
                            <span class="px-2 py-0.5 bg-rose-950 text-rose-400 border border-rose-500/30 rounded-full text-[9px] font-black">{{ $this->overviewStats['unpaid_count'] }}</span>
                        @else
                            <span class="text-[10px] text-slate-500 hidden lg:inline">&rarr;</span>
                        @endif
                    </button>

                    <button wire:click="setActiveTab('support')" 
                        class="w-full text-left px-3 sm:px-4 py-2.5 sm:py-3 rounded-xl text-xs font-bold transition-all flex items-center justify-between cursor-pointer {{ $activeTab === 'support' ? 'bg-cyan-500/10 text-cyan-400 border-l-2 border-cyan-400' : 'text-slate-400 hover:text-slate-200 hover:bg-white/5' }}">
                        <span class="flex items-center gap-2 sm:gap-3">
                            <span class="text-sm sm:text-base">💬</span> Support
                        </span>
                        @if($this->overviewStats['active_tickets'] > 0)
                            <span class="px-2 py-0.5 bg-amber-950 text-amber-400 border border-amber-500/30 rounded-full text-[9px] font-black">{{ $this->overviewStats['active_tickets'] }}</span>
                        @else
                            <span class="text-[10px] text-slate-500 hidden lg:inline">&rarr;</span>
                        @endif
                    </button>

                    <button wire:click="setActiveTab('whatsapp')" 
                        class="w-full text-left px-3 sm:px-4 py-2.5 sm:py-3 rounded-xl text-xs font-bold transition-all flex items-center justify-between cursor-pointer {{ $activeTab === 'whatsapp' ? 'bg-cyan-500/10 text-cyan-400 border-l-2 border-cyan-400' : 'text-slate-400 hover:text-slate-200 hover:bg-white/5' }}">
                        <span class="flex items-center gap-2 sm:gap-3">
                            <span class="text-sm sm:text-base">📱</span> Sandbox
                        </span>
                        <span class="px-1.5 py-0.5 bg-slate-900 border border-white/15 rounded text-[8px] font-bold text-slate-400 uppercase hidden lg:inline">Dev</span>
                    </button>
                </div>

                <!-- Technical Support Banner -->
                <div class="glass-panel p-6 rounded-2xl relative overflow-hidden hidden lg:block" style="border-color: rgba(6,182,212,0.1)">
                    <div class="absolute -right-6 -bottom-6 w-24 h-24 bg-cyan-500/5 rounded-full blur-xl pointer-events-none"></div>
                    <h4 class="text-xs font-black text-white tracking-wide uppercase">Butuh Konsultasi?</h4>
                    <p class="text-[10px] text-slate-400 mt-2 leading-relaxed">Hubungi Account Manager Anda secara instan atau ajukan tiket support untuk kebutuhan integrasi custom.</p>
                    <a href="https://wa.me/{{ \App\Models\SiteSetting::first()->whatsapp_number ?? '628111513335' }}" target="_blank" class="w-full btn-primary py-2.5 rounded-xl flex items-center justify-center font-extrabold text-[10px] uppercase mt-4 text-center" style="background: linear-gradient(135deg, var(--gold-400), var(--gold-500)); color: black;">
                        WhatsApp Agent &rarr;
                    </a>
                </div>
            </aside>

            <!-- Dashboard Main Interactive Content Workspace -->
            <main class="lg:col-span-3 space-y-6">
                
                <!-- ==================== TAB: OVERVIEW ==================== -->
                @if($activeTab === 'overview')
                    <div class="space-y-6">
                        <!-- Welcome Hero Widget Card -->
                        <div class="glass-panel p-8 rounded-3xl relative overflow-hidden flex flex-col md:flex-row items-center justify-between gap-6" style="border-color: rgba(6, 182, 212, 0.15); background: linear-gradient(135deg, rgba(15, 23, 42, 0.8), rgba(2, 6, 23, 0.9));">
                            <div class="absolute -right-20 -top-20 w-64 h-64 bg-cyan-500/10 rounded-full blur-[80px] pointer-events-none"></div>
                            
                            <div class="space-y-3 max-w-lg text-center md:text-left">
                                <span class="px-2.5 py-0.5 text-[9px] font-black tracking-widest text-cyan-400 bg-cyan-950/40 border border-cyan-500/20 rounded uppercase">ACTIVE CLIENT STATUS</span>
                                <h2 class="text-2xl font-black text-white mt-2">Selamat Datang Kembali, {{ Auth::user()->name }}</h2>
                                <p class="text-xs text-slate-400 leading-relaxed">Semua infrastruktur digital Anda berjalan dengan prima. Melalui dashboard terpadu ini, Anda dapat memantau tagihan recurring bulanan Anda, meluncurkan demo prototype terbaru, dan menghubungi engineer kami secara langsung.</p>
                            </div>

                            <div class="flex flex-col gap-2 w-full md:w-auto">
                                <button wire:click="setActiveTab('demos')" class="px-5 py-3 bg-white hover:bg-slate-200 text-black font-extrabold text-xs tracking-wider rounded-xl transition-all uppercase cursor-pointer text-center">
                                    Buka Demo Aplikasi
                                </button>
                                <button wire:click="setActiveTab('support')" class="px-5 py-3 border border-white/10 hover:bg-white/5 text-slate-300 font-extrabold text-xs tracking-wider rounded-xl transition-all uppercase cursor-pointer text-center">
                                    Ajukan Tiket Baru
                                </button>
                            </div>
                        </div>

                        <!-- Statistics Counter Badges Grid -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <!-- Stat 1: Unpaid Bills -->
                            <div class="glass-panel p-6 rounded-2xl flex items-center justify-between hover:border-rose-500/20 transition-all">
                                <div class="space-y-1">
                                    <div class="text-[10px] font-extrabold text-slate-400 uppercase tracking-wider">Unpaid Billings</div>
                                    <div class="text-2xl font-black text-white">{{ $this->overviewStats['unpaid_count'] }} Tagihan</div>
                                    <div class="text-[10px] text-rose-400 font-medium">Total: Rp {{ number_format($this->overviewStats['unpaid_total'], 0, ',', '.') }}</div>
                                </div>
                                <div class="h-12 w-12 bg-rose-950/20 border border-rose-500/20 rounded-xl flex items-center justify-center text-xl text-rose-400">
                                    💸
                                </div>
                            </div>

                            <!-- Stat 2: Active Tickets -->
                            <div class="glass-panel p-6 rounded-2xl flex items-center justify-between hover:border-amber-500/20 transition-all">
                                <div class="space-y-1">
                                    <div class="text-[10px] font-extrabold text-slate-400 uppercase tracking-wider">Support Desk</div>
                                    <div class="text-2xl font-black text-white">{{ $this->overviewStats['active_tickets'] }} Tiket Aktif</div>
                                    <div class="text-[10px] text-amber-400 font-medium">Butuh Tindak Lanjut</div>
                                </div>
                                <div class="h-12 w-12 bg-amber-950/20 border border-amber-500/20 rounded-xl flex items-center justify-center text-xl text-amber-400">
                                    💬
                                </div>
                            </div>

                            <!-- Stat 3: Software Demos -->
                            <div class="glass-panel p-6 rounded-2xl flex items-center justify-between hover:border-cyan-500/20 transition-all">
                                <div class="space-y-1">
                                    <div class="text-[10px] font-extrabold text-slate-400 uppercase tracking-wider">Demo Catalog</div>
                                    <div class="text-2xl font-black text-white">{{ $this->overviewStats['total_demos'] }} Software</div>
                                    <div class="text-[10px] text-cyan-400 font-medium">Siap Untuk Diuji</div>
                                </div>
                                <div class="h-12 w-12 bg-cyan-950/20 border border-cyan-500/20 rounded-xl flex items-center justify-center text-xl text-cyan-400">
                                    💻
                                </div>
                            </div>
                        </div>

                        <!-- Recent Billings Briefing Ledger -->
                        <div class="glass-panel p-6 rounded-3xl space-y-4">
                            <div class="flex justify-between items-center pb-2 border-b border-white/5">
                                <h3 class="text-sm font-black uppercase tracking-wider text-slate-200">Tagihan Recurring Aktif</h3>
                                <button wire:click="setActiveTab('billing')" class="text-cyan-400 text-xs font-bold hover:underline cursor-pointer">Lihat Semua Ledger &rarr;</button>
                            </div>

                            <div class="divide-y divide-white/5">
                                @forelse($this->billings->take(3) as $billing)
                                    <div class="py-4 flex items-center justify-between gap-4">
                                        <div class="space-y-1">
                                            <div class="text-xs font-black text-white">{{ $billing->title }}</div>
                                            <div class="text-[10px] text-slate-400">
                                                Jatuh Tempo: {{ $billing->due_date->format('d M Y') }} 
                                                <span class="mx-1.5">•</span> 
                                                Siklus: <span class="capitalize text-slate-300 font-bold">{{ $billing->billing_cycle }}</span>
                                            </div>
                                        </div>
                                        
                                        <div class="flex items-center gap-4">
                                            <div class="text-right">
                                                <div class="text-xs font-extrabold text-white">Rp {{ number_format($billing->amount, 0, ',', '.') }}</div>
                                                
                                                <span class="inline-block px-2 py-0.5 text-[8px] font-bold rounded-full mt-1 border
                                                    {{ $billing->status === 'paid' ? 'bg-emerald-950/30 text-emerald-400 border-emerald-500/20' : 
                                                       ($billing->status === 'overdue' ? 'bg-rose-950/30 text-rose-400 border-rose-500/20' : 'bg-cyan-950/30 text-cyan-400 border-cyan-500/20') }}">
                                                    {{ strtoupper($billing->status) }}
                                                </span>
                                            </div>

                                            @if($billing->status !== 'paid')
                                                <button wire:click="openPaymentModal({{ $billing->id }})" class="px-3.5 py-1.5 bg-cyan-400 hover:bg-cyan-300 text-black font-extrabold text-[9px] uppercase tracking-wider rounded-lg transition-all cursor-pointer">
                                                    Bayar
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                @empty
                                    <div class="py-8 text-center text-xs text-slate-500">Tidak ada tagihan aktif terdaftar.</div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                @endif

                <!-- ==================== TAB: SOFTWARE DEMOS ==================== -->
                @if($activeTab === 'demos')
                    <div>
                        @if($selectedDemoId)
                            <!-- High Fidelity Interactive Sandbox & Frame Viewer -->
                            @php $demo = $this->selectedDemo; @endphp
                            <div class="glass-panel rounded-3xl overflow-hidden border border-white/10 shadow-2xl space-y-4">
                                <!-- Top control bar resembling Safari/Chrome browser header -->
                                <div class="bg-slate-900/80 px-6 py-4 flex items-center justify-between border-b border-white/5">
                                    <div class="flex items-center gap-4">
                                        <!-- Browser close/minimize/maximize dots -->
                                        <div class="flex gap-1.5">
                                            <span wire:click="closeDemo" class="h-3 w-3 rounded-full bg-rose-500 cursor-pointer block hover:opacity-80"></span>
                                            <span class="h-3 w-3 rounded-full bg-amber-500 block"></span>
                                            <span class="h-3 w-3 rounded-full bg-emerald-500 block"></span>
                                        </div>
                                        <div class="h-4 w-px bg-white/10"></div>
                                        <span class="text-xs font-black text-white flex items-center gap-2">
                                            <span>{{ $demo->icon }}</span> {{ $demo->name }}
                                        </span>
                                    </div>

                                    <div class="flex items-center gap-3">
                                        <span class="px-3 py-1 bg-white/5 border border-white/10 rounded-xl text-[10px] text-slate-400 font-bold uppercase tracking-wider">SANDBOX ENVIRONMENT</span>
                                        <button wire:click="closeDemo" class="text-xs text-slate-400 hover:text-white cursor-pointer font-bold">&times; Tutup Demo</button>
                                    </div>
                                </div>

                                <div class="p-6 space-y-4">
                                    <div>
                                        <h3 class="text-lg font-black text-white">{{ $demo->name }}</h3>
                                        <p class="text-xs text-slate-400 mt-1 leading-relaxed">{{ $demo->description }}</p>
                                    </div>

                                    <!-- Simulated POS/Analytics or iframe frame -->
                                    <div class="rounded-2xl border border-white/5 bg-[#0b0f19] shadow-inner overflow-hidden relative" style="min-height: 500px;">
                                        @if($demo->mockup_code)
                                            <!-- Dynamic raw mockup code container -->
                                            <div class="p-6 h-full overflow-auto">
                                                {!! $demo->mockup_code !!}
                                            </div>
                                        @elseif($demo->demo_url)
                                            <!-- IFrame sandbox load -->
                                            <iframe src="{{ $demo->demo_url }}" class="w-full h-[550px] border-none" sandbox="allow-scripts allow-same-origin allow-popups"></iframe>
                                        @else
                                            <!-- High-fidelity fallback interface simulator -->
                                            <div class="absolute inset-0 flex flex-col items-center justify-center p-8 text-center space-y-6">
                                                <span class="text-5xl">🤖</span>
                                                <div class="max-w-md space-y-2">
                                                    <h4 class="text-sm font-black text-white uppercase tracking-wider">Aplikasi Sedang Di-deploy</h4>
                                                    <p class="text-xs text-slate-500">Prototype live-demo untuk software digital ini sedang dipersiapkan oleh tim DevOps kami di infrastruktur staging. Hubungi engineer dbaik jika Anda membutuhkan akses source code direct.</p>
                                                </div>
                                                <button wire:click="closeDemo" class="px-5 py-2.5 bg-cyan-400 hover:bg-cyan-300 text-black font-extrabold text-[10px] uppercase rounded-xl transition-all cursor-pointer">
                                                    Kembali ke Katalog
                                                </button>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @else
                            <!-- Software Catalog Grid -->
                            <div class="space-y-6">
                                <div class="flex justify-between items-center">
                                    <div>
                                        <h3 class="text-lg font-black text-white">Katalog Demo Software</h3>
                                        <p class="text-xs text-slate-400 mt-0.5">Jelajahi dan jalankan prototype/demo software yang telah kami buat untuk perusahaan Anda.</p>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    @forelse($this->demos as $demoItem)
                                        <div class="glass-panel p-6 rounded-2xl relative overflow-hidden flex flex-col justify-between group hover:border-cyan-500/30 transition-all duration-300 shadow-lg">
                                            <div class="absolute -right-6 -bottom-6 w-20 h-20 bg-cyan-500/5 rounded-full blur-xl pointer-events-none"></div>
                                            
                                            <div class="space-y-4">
                                                <div class="flex items-center justify-between">
                                                    <div class="h-11 w-11 rounded-xl bg-cyan-950/40 border border-cyan-500/20 flex items-center justify-center text-xl">
                                                        {{ $demoItem->icon }}
                                                    </div>
                                                    <span class="px-2 py-0.5 text-[8px] font-black rounded-full bg-cyan-950/50 text-cyan-400 border border-cyan-500/20 uppercase tracking-widest">PROTOTYPE</span>
                                                </div>
                                                
                                                <div class="space-y-1">
                                                    <h4 class="text-sm font-black text-white group-hover:text-cyan-400 transition-colors">{{ $demoItem->name }}</h4>
                                                    <p class="text-xs text-slate-400 line-clamp-2 leading-relaxed">{{ $demoItem->description }}</p>
                                                </div>
                                            </div>

                                            <div class="mt-6 pt-4 border-t border-white/5 flex items-center justify-between">
                                                <span class="text-[9px] font-extrabold text-slate-500 uppercase">Live Sandbox Aktif</span>
                                                <button wire:click="selectDemo({{ $demoItem->id }})" class="px-4 py-2 bg-white hover:bg-slate-200 text-black font-extrabold text-[10px] uppercase rounded-xl transition-all cursor-pointer">
                                                    Jalankan Demo
                                                </button>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="col-span-full glass-panel p-12 text-center text-xs text-slate-500">Belum ada software demo yang ditautkan ke akun Anda.</div>
                                    @endforelse
                                </div>
                            </div>
                        @endif
                    </div>
                @endif

                <!-- ==================== TAB: BILLING & INVOICES ==================== -->
                @if($activeTab === 'billing')
                    <div class="space-y-6">
                        <div>
                            <h3 class="text-lg font-black text-white">Tagihan & Rekapitulasi Invoice</h3>
                            <p class="text-xs text-slate-400 mt-0.5 font-medium">Berikut adalah daftar lengkap tagihan recurring maintenance plan maupun deployment satu kali Anda.</p>
                        </div>

                        <div class="glass-panel rounded-3xl overflow-hidden shadow-xl hidden md:block">
                            <div class="overflow-x-auto">
                                <table class="w-full text-left border-collapse">
                                    <thead>
                                        <tr class="bg-slate-900/60 border-b border-white/5 text-[10px] font-extrabold text-slate-400 uppercase tracking-wider">
                                            <th class="px-6 py-4">Invoice</th>
                                            <th class="px-6 py-4">Layanan / Deskripsi</th>
                                            <th class="px-6 py-4">Siklus</th>
                                            <th class="px-6 py-4">Jatuh Tempo</th>
                                            <th class="px-6 py-4">Jumlah</th>
                                            <th class="px-6 py-4">Status</th>
                                            <th class="px-6 py-4 text-right">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-white/5 text-xs">
                                        @forelse($this->billings as $bill)
                                            <tr class="hover:bg-white/5 transition-colors">
                                                <td class="px-6 py-5 font-black text-white">#{{ str_pad($bill->id, 5, '0', STR_PAD_LEFT) }}</td>
                                                <td class="px-6 py-5">
                                                    <div class="font-extrabold text-white">{{ $bill->title }}</div>
                                                    <div class="text-[10px] text-slate-400 mt-0.5">WhatsApp Notif: {{ $bill->whatsapp_number ?? '-' }}</div>
                                                </td>
                                                <td class="px-6 py-5 capitalize text-slate-300 font-medium">{{ $bill->billing_cycle }}</td>
                                                <td class="px-6 py-5 text-slate-400">{{ $bill->due_date->format('d M Y') }}</td>
                                                <td class="px-6 py-5 font-black text-white">Rp {{ number_format($bill->amount, 0, ',', '.') }}</td>
                                                <td class="px-6 py-5">
                                                    <span class="inline-block px-2.5 py-0.5 text-[9px] font-bold rounded-full border
                                                        {{ $bill->status === 'paid' ? 'bg-emerald-950/30 text-emerald-400 border-emerald-500/20' : 
                                                           ($bill->status === 'overdue' ? 'bg-rose-950/30 text-rose-400 border-rose-500/20' : 'bg-cyan-950/30 text-cyan-400 border-cyan-500/20') }}">
                                                        {{ strtoupper($bill->status) }}
                                                    </span>
                                                </td>
                                                <td class="px-6 py-5 text-right">
                                                    @if($bill->status !== 'paid')
                                                        <button wire:click="openPaymentModal({{ $bill->id }})" class="px-4 py-2 bg-cyan-400 hover:bg-cyan-300 text-black font-extrabold text-[10px] uppercase rounded-xl transition-all cursor-pointer">
                                                            Simulasi Bayar
                                                        </button>
                                                    @else
                                                        <span class="text-[10px] text-emerald-400 font-bold flex items-center justify-end gap-1.5">
                                                            <span>✓</span> Terbayar
                                                        </span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="px-6 py-12 text-center text-slate-500">Tidak ada tagihan yang terdaftar.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Mobile View for Ledger Bills -->
                        <div class="block md:hidden space-y-4">
                            @forelse($this->billings as $bill)
                                <div class="glass-panel p-5 rounded-2xl border border-white/5 space-y-4">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <span class="text-[10px] font-black text-slate-500">INVOICE #{{ str_pad($bill->id, 5, '0', STR_PAD_LEFT) }}</span>
                                            <h4 class="text-sm font-bold text-white mt-1">{{ $bill->title }}</h4>
                                        </div>
                                        <span class="inline-block px-2.5 py-0.5 text-[9px] font-bold rounded-full border
                                            {{ $bill->status === 'paid' ? 'bg-emerald-950/30 text-emerald-400 border-emerald-500/20' : 
                                               ($bill->status === 'overdue' ? 'bg-rose-950/30 text-rose-400 border-rose-500/20' : 'bg-cyan-950/30 text-cyan-400 border-cyan-500/20') }}">
                                            {{ strtoupper($bill->status) }}
                                        </span>
                                    </div>
                                    
                                    <div class="grid grid-cols-2 gap-4 text-xs pt-2 border-t border-white/5">
                                        <div>
                                            <div class="text-[9px] font-bold text-slate-500 uppercase">Siklus</div>
                                            <div class="text-slate-300 font-medium capitalize mt-0.5">{{ $bill->billing_cycle }}</div>
                                        </div>
                                        <div>
                                            <div class="text-[9px] font-bold text-slate-500 uppercase">Jatuh Tempo</div>
                                            <div class="text-slate-400 mt-0.5">{{ $bill->due_date->format('d M Y') }}</div>
                                        </div>
                                    </div>
                                    
                                    <div class="flex justify-between items-center pt-3 border-t border-white/5">
                                        <div>
                                            <div class="text-[8px] font-bold text-slate-500 uppercase">Jumlah</div>
                                            <div class="text-sm font-black text-white mt-0.5">Rp {{ number_format($bill->amount, 0, ',', '.') }}</div>
                                        </div>
                                        
                                        @if($bill->status !== 'paid')
                                            <button wire:click="openPaymentModal({{ $bill->id }})" class="px-4 py-2 bg-cyan-400 hover:bg-cyan-300 text-black font-extrabold text-[10px] uppercase rounded-xl transition-all cursor-pointer">
                                                Simulasi Bayar
                                            </button>
                                        @else
                                            <span class="text-[10px] text-emerald-400 font-bold flex items-center gap-1.5">
                                                <span>✓</span> Terbayar
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <div class="glass-panel p-8 text-center text-slate-500">Tidak ada tagihan yang terdaftar.</div>
                            @endforelse
                        </div>

                        <!-- Informational Box about WhatsApp Alerts -->
                        <div class="glass-panel p-5 rounded-2xl flex items-start gap-4 border-l-4 border-cyan-400">
                            <span class="text-xl">🔔</span>
                            <div class="space-y-1">
                                <h4 class="text-xs font-black text-white uppercase tracking-wider">Sistem Reminder Otomatis Via WhatsApp Aktif</h4>
                                <p class="text-[10px] text-slate-400 leading-relaxed">Sistem billing kami akan mengirimkan pengingat otomatis ke nomor WhatsApp Anda sebanyak 3 hari sebelum jatuh tempo tagihan recurring Anda. Pastikan nomor kontak yang terdaftar di atas valid dan aktif.</p>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- ==================== TAB: SUPPORT TICKETS ==================== -->
                @if($activeTab === 'support')
                    <div class="space-y-6">
                        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                            <div>
                                <h3 class="text-lg font-black text-white">Pusat Bantuan & Support Ticket</h3>
                                <p class="text-xs text-slate-400 mt-0.5 font-medium">Kirim pertanyaan teknis, kendala bug, atau permohonan fitur baru langsung ke tim developer kami.</p>
                            </div>
                            <button @click="$wire.set('showCreateTicketModal', true)" class="px-5 py-2.5 bg-cyan-400 hover:bg-cyan-300 text-black font-extrabold text-xs uppercase tracking-wider rounded-xl transition-all flex items-center gap-2 cursor-pointer shadow-lg">
                                <span>➕</span> Buat Tiket Baru
                            </button>
                        </div>

                        <!-- Split Ticket Workspace -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <!-- Left Column: Tickets Directory -->
                            <div class="md:col-span-1 glass-panel p-4 rounded-3xl space-y-3 h-[600px] overflow-y-auto">
                                <h4 class="text-xs font-black uppercase text-slate-400 pb-2 border-b border-white/5 tracking-wider">Daftar Tiket Anda</h4>
                                
                                <div class="space-y-2">
                                    @forelse($this->tickets as $t)
                                        <button wire:click="selectTicket({{ $t->id }})" 
                                            class="w-full text-left p-4 rounded-2xl border transition-all flex flex-col justify-between gap-3 cursor-pointer
                                                {{ $selectedTicketId === $t->id ? 'bg-cyan-500/10 border-cyan-400/40' : 'bg-slate-900/30 border-white/5 hover:bg-white/5' }}">
                                            
                                            <div class="space-y-1.5">
                                                <div class="flex items-center justify-between">
                                                    <span class="inline-block px-2 py-0.5 text-[8px] font-black rounded uppercase bg-slate-900 border border-white/10 text-slate-400">{{ $t->category }}</span>
                                                    <span class="text-[9px] font-extrabold capitalize
                                                        {{ $t->priority === 'high' ? 'text-rose-400' : ($t->priority === 'medium' ? 'text-amber-400' : 'text-emerald-400') }}">
                                                        {{ $t->priority }}
                                                    </span>
                                                </div>
                                                <h5 class="text-xs font-black text-white line-clamp-1">{{ $t->subject }}</h5>
                                            </div>

                                            <div class="flex items-center justify-between text-[9px] text-slate-500 border-t border-white/5 pt-2 mt-1">
                                                <span>{{ $t->updated_at->diffForHumans() }}</span>
                                                <span class="font-bold uppercase tracking-wider
                                                    {{ $t->status === 'resolved' || $t->status === 'closed' ? 'text-emerald-400' : 'text-cyan-400' }}">
                                                    {{ $t->status }}
                                                </span>
                                            </div>
                                        </button>
                                    @empty
                                        <div class="text-center py-12 text-xs text-slate-500">Anda belum membuat tiket bantuan.</div>
                                    @endforelse
                                </div>
                            </div>

                            <!-- Right Column: Conversational Thread -->
                            <div class="md:col-span-2 glass-panel rounded-3xl overflow-hidden flex flex-col justify-between h-[600px] border border-white/10 bg-[#0b0f19]/35 relative">
                                @if($this->selectedTicket)
                                    @php $ticketObj = $this->selectedTicket; @endphp
                                    
                                    <!-- Ticket header description -->
                                    <div class="bg-slate-900/80 px-6 py-4 flex items-center justify-between border-b border-white/5">
                                        <div class="space-y-1">
                                            <h4 class="text-xs font-black text-white flex items-center gap-2">
                                                <span class="text-emerald-400">•</span> {{ $ticketObj->subject }}
                                            </h4>
                                            <p class="text-[10px] text-slate-400">
                                                Status: <span class="uppercase font-bold text-cyan-400">{{ $ticketObj->status }}</span> 
                                                <span class="mx-1.5">|</span>
                                                Prioritas: <span class="capitalize font-bold text-amber-400">{{ $ticketObj->priority }}</span>
                                            </p>
                                        </div>

                                        <span class="px-2.5 py-1 text-[9px] font-black rounded-lg bg-emerald-950 text-emerald-400 border border-emerald-500/20 uppercase tracking-widest">CONNECTED SECURELY</span>
                                    </div>

                                    <!-- Conversation Viewport Bubble Stream -->
                                    <div class="flex-grow p-6 overflow-y-auto space-y-4 flex flex-col">
                                        @foreach($ticketObj->supportMessages as $msg)
                                            @if($msg->is_admin)
                                                <!-- Admin/Agent Reply bubble -->
                                                <div class="flex flex-col items-start max-w-[75%] self-start space-y-1">
                                                    <div class="flex items-center gap-2 text-[10px] text-slate-400 font-extrabold pl-1">
                                                        <span>🛠️ Tim Support DBAIK</span>
                                                        <span class="px-1.5 py-0.2 bg-indigo-950 text-indigo-400 border border-indigo-500/20 rounded-full text-[8px] uppercase">Admin</span>
                                                    </div>
                                                    <div class="bg-slate-900 border border-white/10 px-4 py-3 rounded-2xl rounded-tl-sm text-xs leading-relaxed text-slate-100">
                                                        {{ $msg->message }}
                                                    </div>
                                                    <span class="text-[9px] text-slate-500 pl-1">{{ $msg->created_at->format('H:i') }}</span>
                                                </div>
                                            @else
                                                <!-- Customer/Client Message bubble -->
                                                <div class="flex flex-col items-end max-w-[75%] self-end space-y-1">
                                                    <div class="flex items-center gap-2 text-[10px] text-cyan-400 font-extrabold pr-1">
                                                        <span>Anda</span>
                                                    </div>
                                                    <div class="bg-cyan-950/40 border border-cyan-500/30 px-4 py-3 rounded-2xl rounded-tr-sm text-xs leading-relaxed text-slate-100">
                                                        {{ $msg->message }}
                                                    </div>
                                                    <span class="text-[9px] text-slate-500 pr-1">{{ $msg->created_at->format('H:i') }}</span>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>

                                    <!-- Inline Chat Reply Form Box -->
                                    <form wire:submit.prevent="sendReply" class="bg-slate-900/60 p-4 border-t border-white/5 flex gap-3 items-center">
                                        <textarea wire:model.defer="replyMessage" placeholder="Tulis balasan Anda ke engineer dbaik di sini..." required
                                            class="flex-grow bg-slate-950 border border-white/10 rounded-xl px-4 py-3 text-xs text-white focus:outline-none focus:border-cyan-400 transition-all placeholder-slate-500 resize-none h-12"></textarea>
                                        
                                        <button type="submit" class="px-5 py-3.5 bg-cyan-400 hover:bg-cyan-300 text-black font-extrabold text-xs uppercase tracking-wider rounded-xl transition-all cursor-pointer">
                                            Kirim
                                        </button>
                                    </form>
                                @else
                                    <div class="absolute inset-0 flex flex-col items-center justify-center p-8 text-center space-y-4">
                                        <span class="text-4xl">💬</span>
                                        <div class="max-w-md">
                                            <h5 class="text-xs font-black text-white uppercase tracking-wider">Silakan Pilih Tiket</h5>
                                            <p class="text-[10px] text-slate-500 leading-relaxed mt-1">Pilih tiket support aktif dari menu navigasi kiri untuk melihat riwayat korespondensi atau membalas pesan developer dbaik.</p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif

                <!-- ==================== TAB: WHATSAPP SANDBOX ==================== -->
                @if($activeTab === 'whatsapp')
                    <div class="space-y-6">
                        <div>
                            <h3 class="text-lg font-black text-white">WhatsApp Reminder Sandbox & Auditor</h3>
                            <p class="text-xs text-slate-400 mt-0.5">Pantau logs pengiriman simulasi reminder tagihan otomatis maupun manual secara instan.</p>
                        </div>

                        <!-- Developer Terminal Logs Console -->
                        <div class="glass-panel rounded-3xl overflow-hidden shadow-xl border border-white/10 bg-[#060913]">
                            <div class="bg-slate-950 px-6 py-4 flex items-center justify-between border-b border-white/15">
                                <div class="flex items-center gap-2">
                                    <span class="h-3 w-3 rounded-full bg-emerald-500 animate-pulse"></span>
                                    <span class="text-[10px] font-black tracking-widest text-slate-300 uppercase">SANDBOX TERMINAL OUTPUT</span>
                                </div>
                                <span class="text-[9px] text-slate-500 font-mono">PAGER=cat</span>
                            </div>

                            <div class="p-6 font-mono text-xs leading-relaxed space-y-6 max-h-[600px] overflow-y-auto">
                                @forelse($this->whatsappReminders as $r)
                                    <div class="space-y-2 border-b border-white/5 pb-4 last:border-0 last:pb-0">
                                        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-2">
                                            <div class="flex items-center gap-3">
                                                <span class="text-slate-500">{{ $r->created_at->format('Y-m-d H:i:s') }}</span>
                                                <span class="px-2 py-0.5 text-[9px] font-bold rounded uppercase border
                                                    {{ $r->status === 'sent' ? 'bg-emerald-950/40 text-emerald-400 border-emerald-500/20' : 
                                                       ($r->status === 'simulated' ? 'bg-cyan-950/40 text-cyan-400 border-cyan-500/20' : 'bg-rose-950/40 text-rose-400 border-rose-500/20') }}">
                                                    {{ $r->status }}
                                                </span>
                                            </div>
                                            <span class="text-[10px] text-slate-400 font-bold">Penerima: +{{ $r->recipient_number }}</span>
                                        </div>

                                        <div class="bg-black/60 border border-white/5 p-4 rounded-xl text-slate-300 whitespace-pre-line text-[11px]">
                                            {{ $r->message_body }}
                                        </div>

                                        <details class="text-[10px] text-slate-500">
                                            <summary class="cursor-pointer hover:text-slate-300 transition-colors">Tampilkan Meta Response JSON</summary>
                                            <div class="mt-2 bg-[#02050b] border border-white/5 p-3 rounded-lg text-slate-400 overflow-x-auto select-all">
                                                {{ $r->response_meta ?? 'null' }}
                                            </div>
                                        </details>
                                    </div>
                                @empty
                                    <div class="text-center py-12 text-slate-500 font-sans">Belum ada reminder WhatsApp yang terkirim dalam database log sandbox.</div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                @endif

            </main>
        </div>
    </div>

    <!-- ==================== MODAL: CREATE SUPPORT TICKET ==================== -->
    <div x-show="$wire.showCreateTicketModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;" x-transition>
        <!-- Backdrop Blur -->
        <div class="fixed inset-0 bg-black/60 backdrop-blur-sm" @click="$wire.set('showCreateTicketModal', false)"></div>

        <div class="flex items-center justify-center min-h-screen p-6">
            <div class="glass-panel p-8 rounded-3xl max-w-lg w-full relative z-10 space-y-6" style="border-color: rgba(6,182,212,0.2); box-shadow: 0 30px 70px rgba(0,0,0,0.5);">
                <div class="flex justify-between items-center pb-3 border-b border-white/5">
                    <h3 class="text-base font-black text-white uppercase tracking-wider">Buat Tiket Bantuan Baru</h3>
                    <button @click="$wire.set('showCreateTicketModal', false)" class="text-xl text-slate-400 hover:text-white cursor-pointer">&times;</button>
                </div>

                <form wire:submit.prevent="createTicket" class="space-y-4 text-xs">
                    <div class="space-y-1">
                        <label for="newTicketSubject" class="text-[10px] font-bold text-slate-300 uppercase tracking-wide">Subjek Masalah</label>
                        <input type="text" id="newTicketSubject" wire:model.defer="newTicketSubject" required
                            class="w-full bg-slate-900 border border-white/10 rounded-xl px-4 py-3 text-xs text-white focus:outline-none focus:border-cyan-400 placeholder-slate-500"
                            placeholder="e.g. Kendala Integrasi API atau Error Layanan POS">
                        @error('newTicketSubject') <span class="text-red-400 text-[9px]">{{ $message }}</span> @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-1">
                            <label for="newTicketCategory" class="text-[10px] font-bold text-slate-300 uppercase tracking-wide">Kategori</label>
                            <select id="newTicketCategory" wire:model.defer="newTicketCategory"
                                class="w-full bg-slate-900 border border-white/10 rounded-xl px-4 py-3 text-xs text-white focus:outline-none focus:border-cyan-400">
                                <option value="technical">Technical / Bug</option>
                                <option value="billing">Billing / Invoicing</option>
                                <option value="general">Umum / Lainnya</option>
                            </select>
                        </div>

                        <div class="space-y-1">
                            <label for="newTicketPriority" class="text-[10px] font-bold text-slate-300 uppercase tracking-wide">Prioritas</label>
                            <select id="newTicketPriority" wire:model.defer="newTicketPriority"
                                class="w-full bg-slate-900 border border-white/10 rounded-xl px-4 py-3 text-xs text-white focus:outline-none focus:border-cyan-400">
                                <option value="low">Rendah (Low)</option>
                                <option value="medium">Sedang (Medium)</option>
                                <option value="high">Tinggi (High)</option>
                            </select>
                        </div>
                    </div>

                    <div class="space-y-1">
                        <label for="newTicketMessage" class="text-[10px] font-bold text-slate-300 uppercase tracking-wide">Deskripsi Masalah / Pesan</label>
                        <textarea id="newTicketMessage" wire:model.defer="newTicketMessage" required rows="5"
                            class="w-full bg-slate-900 border border-white/10 rounded-xl px-4 py-3 text-xs text-white focus:outline-none focus:border-cyan-400 placeholder-slate-500 resize-none"
                            placeholder="Jelaskan secara detail kendala yang sedang Anda hadapi..."></textarea>
                        @error('newTicketMessage') <span class="text-red-400 text-[9px]">{{ $message }}</span> @enderror
                    </div>

                    <button type="submit" class="w-full btn-primary py-4 rounded-xl flex items-center justify-center font-bold tracking-wider uppercase text-xs mt-6" style="background: linear-gradient(135deg, var(--gold-400), var(--gold-500)); color: black;">
                        Kirim Tiket
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- ==================== MODAL: SECURE SIMULATED PAYMENT ==================== -->
    <div x-show="$wire.showPaymentModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;" x-transition>
        <!-- Backdrop Blur -->
        <div class="fixed inset-0 bg-black/60 backdrop-blur-sm" @click="$wire.set('showPaymentModal', false)"></div>

        <div class="flex items-center justify-center min-h-screen p-6">
            <div class="glass-panel p-8 rounded-3xl max-w-md w-full relative z-10 space-y-6" style="border-color: rgba(6,182,212,0.2); box-shadow: 0 30px 70px rgba(0,0,0,0.5);">
                <div class="flex justify-between items-center pb-3 border-b border-white/5">
                    <h3 class="text-sm font-black text-white uppercase tracking-wider flex items-center gap-2">
                        <span>🔒</span> Secure Gateway Simulator
                    </h3>
                    <button @click="$wire.set('showPaymentModal', false)" class="text-xl text-slate-400 hover:text-white cursor-pointer">&times;</button>
                </div>

                <div class="space-y-4">
                    <!-- Glowing credit card preview graphic -->
                    <div class="glass-panel p-6 rounded-2xl bg-gradient-to-tr from-[#0b0c16] via-[#101c31] to-[#122e4c] border border-cyan-500/20 glow-blue text-white space-y-6 relative overflow-hidden">
                        <div class="absolute -right-6 -bottom-6 w-24 h-24 bg-cyan-500/10 rounded-full blur-xl pointer-events-none"></div>
                        
                        <div class="flex justify-between items-center">
                            <span class="text-lg font-black tracking-widest text-cyan-400">CREDIT CARD</span>
                            <span class="text-sm">VISA</span>
                        </div>
                        
                        <div class="space-y-4">
                            <!-- Card digits -->
                            <div class="text-base font-mono tracking-widest text-center select-none" x-text="$wire.cardNumber"></div>
                            
                            <div class="flex justify-between items-center text-[9px] font-mono uppercase text-slate-400">
                                <div>
                                    <div class="text-[8px] text-slate-500">Card Holder</div>
                                    <div class="text-white font-bold tracking-wider" x-text="$wire.cardName"></div>
                                </div>
                                <div class="text-right">
                                    <div class="text-[8px] text-slate-500">Expires</div>
                                    <div class="text-white font-bold" x-text="$wire.cardExpiry"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Informational Transaction detail -->
                    @if($paymentBillingId)
                        @php $b = Billing::find($paymentBillingId); @endphp
                        @if($b)
                            <div class="bg-slate-900 border border-white/5 p-4 rounded-xl space-y-1.5 text-xs">
                                <div class="flex justify-between">
                                    <span class="text-slate-400 font-medium">Invoice Reference:</span>
                                    <span class="text-white font-black">#{{ str_pad($b->id, 5, '0', STR_PAD_LEFT) }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-slate-400 font-medium">Layanan:</span>
                                    <span class="text-white font-extrabold text-right max-w-[200px] truncate">{{ $b->title }}</span>
                                </div>
                                <div class="flex justify-between border-t border-white/5 pt-2 mt-1.5 text-sm">
                                    <span class="text-slate-300 font-bold">Total Pembayaran:</span>
                                    <span class="text-cyan-400 font-black">Rp {{ number_format($b->amount, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        @endif
                    @endif

                    <!-- Payment processing loaders/action buttons -->
                    @if($isProcessingPayment)
                        <div class="text-center py-6 space-y-3">
                            <div class="h-8 w-8 border-2 border-t-cyan-400 border-r-transparent border-slate-700 animate-spin rounded-full mx-auto"></div>
                            <p class="text-xs text-slate-400">Memproses transaksi secara aman melalui 3D Secure Gateway...</p>
                        </div>
                    @else
                        <div class="space-y-3">
                            <button wire:click="simulatePayment" class="w-full btn-primary py-4 rounded-xl flex items-center justify-center font-bold tracking-wider uppercase text-xs" style="background: linear-gradient(135deg, var(--gold-400), var(--gold-500)); color: black; box-shadow: 0 4px 20px rgba(6,182,212,0.25);">
                                🔒 Konfirmasi & Bayar Instan
                            </button>
                            <button @click="$wire.set('showPaymentModal', false)" class="w-full text-center py-2 text-slate-400 hover:text-white font-bold text-[10px] uppercase tracking-wider cursor-pointer">
                                Batalkan Transaksi
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
