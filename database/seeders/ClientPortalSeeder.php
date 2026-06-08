<?php

namespace Database\Seeders;

use App\Models\Billing;
use App\Models\SoftwareDemo;
use App\Models\SupportMessage;
use App\Models\SupportTicket;
use App\Models\User;
use Illuminate\Database\Seeder;

class ClientPortalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Ensure we have an admin user updated/created
        $admin = User::where('email', 'sayasuhendra@gmail.com')->first();
        if ($admin) {
            $admin->update([
                'is_admin' => true,
            ]);
        } else {
            $admin = User::create([
                'name' => 'Suhendra',
                'email' => 'sayasuhendra@gmail.com',
                'password' => bcrypt('password'),
                'is_admin' => true,
            ]);
        }

        // Create a separate test client user if needed
        $client = User::where('email', 'client@dbaik.com')->first();
        if (! $client) {
            $client = User::create([
                'name' => 'Budi Santoso',
                'email' => 'client@dbaik.com',
                'password' => bcrypt('password'),
                'is_admin' => false,
            ]);
        }

        // 2. Seed Software Demos
        SoftwareDemo::truncate();

        // Demo 1: POS E-Commerce Gateway
        SoftwareDemo::create([
            'name' => 'E-Commerce POS Gateway',
            'slug' => 'ecommerce-pos-gateway',
            'description' => 'Sebuah console point of sale premium dengan multi-outlet, sinkronisasi inventaris cloud, dan payment gateway QRIS terintegrasi otomatis.',
            'icon' => '🏪',
            'is_active' => true,
            'mockup_code' => $this->getPosMockupHtml(),
        ]);

        // Demo 2: AI Data Analytics Console
        SoftwareDemo::create([
            'name' => 'AI Data Analytics Console',
            'slug' => 'ai-data-analytics-console',
            'description' => 'Dashboard visualisasi big data dengan analisis prediksi berbasis machine learning untuk meramalkan tren penjualan bulanan.',
            'icon' => '📊',
            'is_active' => true,
            'mockup_code' => $this->getAnalyticsMockupHtml(),
        ]);

        // Demo 3: Customer Service CRM Bot
        SoftwareDemo::create([
            'name' => 'Customer Service CRM Bot',
            'slug' => 'crm-support-bot',
            'description' => 'Integrasi omni-channel customer service CRM terpadu dengan kecerdasan buatan untuk merespon chat pelanggan secara realtime.',
            'icon' => '🤖',
            'is_active' => true,
            'mockup_code' => $this->getCrmMockupHtml(),
        ]);

        // 3. Seed Billings
        Billing::truncate();

        // Seed for Admin (Suhendra) for testing
        Billing::create([
            'user_id' => $admin->id,
            'title' => 'Layanan Cloud Hosting & Maintenance Plan (Mei 2026)',
            'amount' => 750000,
            'billing_cycle' => 'monthly',
            'status' => 'pending',
            'due_date' => now()->addDays(3)->format('Y-m-d'),
            'recurring_billing' => true,
            'whatsapp_number' => '628111513335',
        ]);

        Billing::create([
            'user_id' => $admin->id,
            'title' => 'Desain Premium & Landing Page Development',
            'amount' => 4500000,
            'billing_cycle' => 'one-time',
            'status' => 'paid',
            'due_date' => now()->subDays(15)->format('Y-m-d'),
            'recurring_billing' => false,
            'whatsapp_number' => '628111513335',
        ]);

        Billing::create([
            'user_id' => $admin->id,
            'title' => 'Integrasi API Payment Gateway & Keamanan SSL',
            'amount' => 1200000,
            'billing_cycle' => 'yearly',
            'status' => 'overdue',
            'due_date' => now()->subDays(5)->format('Y-m-d'),
            'recurring_billing' => true,
            'whatsapp_number' => '628111513335',
        ]);

        // Seed for Budisantoso (Client)
        Billing::create([
            'user_id' => $client->id,
            'title' => 'Layanan Cloud Hosting & Maintenance Plan (Mei 2026)',
            'amount' => 750000,
            'billing_cycle' => 'monthly',
            'status' => 'pending',
            'due_date' => now()->addDays(2)->format('Y-m-d'),
            'recurring_billing' => true,
            'whatsapp_number' => '081122334455',
        ]);

        // 4. Seed Support Tickets
        SupportTicket::truncate();
        SupportMessage::truncate();

        // Ticket 1 (for Admin / Suhendra)
        $ticket1 = SupportTicket::create([
            'user_id' => $admin->id,
            'subject' => 'Integrasi QRIS Payment Gateway pada POS E-commerce',
            'category' => 'technical',
            'status' => 'in_progress',
            'priority' => 'high',
        ]);

        SupportMessage::create([
            'support_ticket_id' => $ticket1->id,
            'user_id' => $admin->id,
            'message' => 'Halo Tim DBAIK, kami ingin bertanya bagaimana cara mengaktifkan modul QRIS dinamis di demo POS E-commerce yang sudah dideploy? Terima kasih.',
            'is_admin' => false,
        ]);

        SupportMessage::create([
            'support_ticket_id' => $ticket1->id,
            'user_id' => $admin->id, // Seeded reply as Admin
            'message' => 'Halo Pak Suhendra, untuk mengaktifkan QRIS dinamis, Anda perlu melengkapi dokumen administrasi merchant di menu Settings. Tim kami akan membantu sinkronisasi API Key dalam 1x24 jam setelah dokumen disetujui.',
            'is_admin' => true,
        ]);

        // Ticket 2 (for Client Budisantoso)
        $ticket2 = SupportTicket::create([
            'user_id' => $client->id,
            'subject' => 'Kendala Loading Lambat pada Detail Produk',
            'category' => 'technical',
            'status' => 'open',
            'priority' => 'medium',
        ]);

        SupportMessage::create([
            'support_ticket_id' => $ticket2->id,
            'user_id' => $client->id,
            'message' => 'Selamat siang, saya mengalami kendala pada halaman galeri produk. Saat diklik detail, loading spinner berputar sangat lama (sekitar 7 detik). Mohon bantuannya.',
            'is_admin' => false,
        ]);
    }

    /**
     * POS Mockup HTML
     */
    private function getPosMockupHtml(): string
    {
        return <<<'HTML'
<div class="space-y-6 text-slate-100 font-sans p-2">
    <!-- Header -->
    <div class="flex justify-between items-center border-b border-white/10 pb-4">
        <div>
            <h4 class="text-base font-black tracking-wide text-cyan-400">🏪 DBAIK POS CONSOLE</h4>
            <p class="text-[10px] text-slate-400">Outlet Utama: Kebayoran Baru, Jakarta</p>
        </div>
        <div class="flex items-center gap-2">
            <span class="h-2 w-2 rounded-full bg-emerald-500 animate-pulse"></span>
            <span class="text-[9px] font-bold text-emerald-400 uppercase">ONLINE & SYNCED</span>
        </div>
    </div>

    <!-- POS Body -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <!-- Products Column (Left) -->
        <div class="md:col-span-2 space-y-4">
            <div class="flex gap-2">
                <input type="text" placeholder="Cari barcode atau nama produk..." class="w-full bg-slate-900/60 border border-white/10 rounded-xl px-3 py-2 text-xs focus:outline-none focus:border-cyan-400">
                <button class="bg-cyan-500/10 border border-cyan-400/20 text-cyan-400 px-3 py-2 rounded-xl text-xs font-bold hover:bg-cyan-500/20 transition-all">Filter</button>
            </div>
            
            <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                <div class="bg-slate-900/40 border border-white/5 p-3 rounded-xl hover:border-cyan-400/20 transition-all flex flex-col justify-between h-32">
                    <span class="text-lg">🥤</span>
                    <div>
                        <div class="text-[10px] font-black">Boba Milk Tea XL</div>
                        <div class="text-[10px] text-cyan-400 font-bold mt-1">Rp 28.000</div>
                    </div>
                </div>
                <div class="bg-slate-900/40 border border-white/5 p-3 rounded-xl hover:border-cyan-400/20 transition-all flex flex-col justify-between h-32">
                    <span class="text-lg">🍟</span>
                    <div>
                        <div class="text-[10px] font-black">French Fries Large</div>
                        <div class="text-[10px] text-cyan-400 font-bold mt-1">Rp 22.000</div>
                    </div>
                </div>
                <div class="bg-slate-900/40 border border-white/5 p-3 rounded-xl hover:border-cyan-400/20 transition-all flex flex-col justify-between h-32">
                    <span class="text-lg">🍔</span>
                    <div>
                        <div class="text-[10px] font-black">Double Beef Cheese</div>
                        <div class="text-[10px] text-cyan-400 font-bold mt-1">Rp 45.000</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Checkout Card (Right) -->
        <div class="bg-slate-900/60 border border-white/10 p-4 rounded-2xl flex flex-col justify-between h-[300px]">
            <div class="space-y-3">
                <div class="text-xs font-black uppercase text-slate-400 tracking-wider">Ringkasan Pesanan</div>
                <div class="divide-y divide-white/5">
                    <div class="py-2 flex justify-between text-xs">
                        <span class="text-slate-400">1x Boba Milk Tea XL</span>
                        <span class="font-extrabold text-white">Rp 28.000</span>
                    </div>
                    <div class="py-2 flex justify-between text-xs">
                        <span class="text-slate-400">1x Double Beef Cheese</span>
                        <span class="font-extrabold text-white">Rp 45.000</span>
                    </div>
                </div>
            </div>

            <div class="space-y-3 border-t border-white/10 pt-3">
                <div class="flex justify-between items-center">
                    <span class="text-xs font-black text-slate-300">TOTAL</span>
                    <span class="text-sm font-black text-cyan-400">Rp 73.000</span>
                </div>
                <button onclick="alert('Ini adalah simulasi interaktif demo. Pembayaran terintegrasi QRIS.')" class="w-full bg-cyan-400 hover:bg-cyan-300 text-black font-extrabold text-xs py-2.5 rounded-xl uppercase tracking-wider transition-all">
                    Bayar Instan QRIS
                </button>
            </div>
        </div>
    </div>
</div>
HTML;
    }

    /**
     * Analytics Mockup HTML
     */
    private function getAnalyticsMockupHtml(): string
    {
        return <<<'HTML'
<div class="space-y-6 text-slate-100 font-sans p-2">
    <!-- Header -->
    <div class="flex justify-between items-center border-b border-white/10 pb-4">
        <div>
            <h4 class="text-base font-black tracking-wide text-indigo-400">📊 AI PREDICTIVE INSIGHTS</h4>
            <p class="text-[10px] text-slate-400">Data Model V3.1.5 • Updated 5 mins ago</p>
        </div>
        <span class="px-2 py-0.5 bg-indigo-950 text-indigo-400 border border-indigo-500/20 text-[9px] font-black rounded uppercase">AI ENGINE STABLE</span>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="bg-slate-900/40 border border-white/5 p-4 rounded-xl">
            <div class="text-[9px] font-extrabold text-slate-500 uppercase">Perkiraan Omzet Bulan Depan</div>
            <div class="text-xl font-black text-white mt-1">Rp 128.450.000</div>
            <div class="text-[9px] text-emerald-400 font-bold mt-1">▲ +12.4% vs Bulan Ini</div>
        </div>
        <div class="bg-slate-900/40 border border-white/5 p-4 rounded-xl">
            <div class="text-[9px] font-extrabold text-slate-500 uppercase">Customer Retention Rate</div>
            <div class="text-xl font-black text-white mt-1">87.3%</div>
            <div class="text-[9px] text-emerald-400 font-bold mt-1">▲ +2.1% Peningkatan loyalitas</div>
        </div>
        <div class="bg-slate-900/40 border border-white/5 p-4 rounded-xl">
            <div class="text-[9px] font-extrabold text-slate-500 uppercase">Rekomendasi Stok Produk</div>
            <div class="text-xl font-black text-white mt-1">Bobal XL & Burger</div>
            <div class="text-[9px] text-indigo-400 font-bold mt-1">Prediksi demand tinggi weekend ini</div>
        </div>
    </div>

    <!-- Chart Simulation Layout -->
    <div class="bg-slate-900/60 border border-white/10 p-4 rounded-2xl">
        <div class="flex justify-between items-center mb-3">
            <span class="text-xs font-black text-slate-300 uppercase tracking-wider">Trend Penjualan & Proyeksi AI (Mingguan)</span>
            <span class="text-[10px] text-slate-500">Garis Putus-Putus = Prediksi AI</span>
        </div>
        
        <!-- Beautiful SVG Chart Mockup -->
        <div class="relative h-44 w-full bg-slate-950/40 border border-white/5 rounded-xl flex items-end p-2 gap-4">
            <!-- Grid Lines -->
            <div class="absolute inset-0 flex flex-col justify-between p-4 pointer-events-none opacity-20">
                <div class="border-b border-white"></div>
                <div class="border-b border-white"></div>
                <div class="border-b border-white"></div>
            </div>
            
            <!-- Bars representing chart data -->
            <div class="flex-1 flex flex-col justify-end items-center h-full z-10">
                <div class="w-full bg-indigo-500/30 border border-indigo-400/50 rounded-t h-[30%]"></div>
                <span class="text-[8px] text-slate-500 mt-1 font-bold">Minggu 1</span>
            </div>
            <div class="flex-1 flex flex-col justify-end items-center h-full z-10">
                <div class="w-full bg-indigo-500/40 border border-indigo-400/60 rounded-t h-[45%]"></div>
                <span class="text-[8px] text-slate-500 mt-1 font-bold">Minggu 2</span>
            </div>
            <div class="flex-1 flex flex-col justify-end items-center h-full z-10">
                <div class="w-full bg-indigo-500/65 border border-indigo-400/80 rounded-t h-[60%]"></div>
                <span class="text-[8px] text-slate-500 mt-1 font-bold">Minggu 3</span>
            </div>
            <div class="flex-1 flex flex-col justify-end items-center h-full z-10">
                <div class="w-full bg-cyan-500/50 border border-cyan-400/80 border-dashed rounded-t h-[80%]"></div>
                <span class="text-[8px] text-cyan-400 mt-1 font-black">AI Proj</span>
            </div>
        </div>
    </div>
</div>
HTML;
    }

    /**
     * CRM Mockup HTML
     */
    private function getCrmMockupHtml(): string
    {
        return <<<'HTML'
<div class="space-y-6 text-slate-100 font-sans p-2">
    <!-- Header -->
    <div class="flex justify-between items-center border-b border-white/10 pb-4">
        <div>
            <h4 class="text-base font-black tracking-wide text-teal-400">🤖 OMNI-CHANNEL CRM BOT</h4>
            <p class="text-[10px] text-slate-400">Bot Status: ACTIVE • WhatsApp & Telegram Online</p>
        </div>
        <span class="px-2 py-0.5 bg-teal-950 text-teal-400 border border-teal-500/20 text-[9px] font-black rounded uppercase">AI AGENT ONLINE</span>
    </div>

    <!-- Live CRM Bot Conversation Thread -->
    <div class="bg-slate-900/60 border border-white/10 p-4 rounded-2xl space-y-4">
        <div class="text-xs font-black uppercase text-slate-400 tracking-wider">Simulasi Obrolan Real-Time</div>
        
        <div class="space-y-3 max-h-48 overflow-y-auto pr-1">
            <div class="flex items-start gap-2.5">
                <div class="h-6 w-6 rounded-full bg-slate-800 border border-white/10 flex items-center justify-center text-[10px]">👤</div>
                <div class="bg-slate-800/80 text-xs px-3 py-2 rounded-2xl rounded-tl-none max-w-[80%] text-slate-200">
                    "Halo, apakah bobal milk tea ready sore ini? Saya mau pesan 5 cup."
                    <div class="text-[8px] text-slate-500 mt-1 text-right">14:20 WIB</div>
                </div>
            </div>
            
            <div class="flex items-start gap-2.5 justify-end">
                <div class="bg-teal-950/80 border border-teal-500/20 text-xs px-3 py-2 rounded-2xl rounded-tr-none max-w-[80%] text-teal-200">
                    "Halo! Bobal Milk Tea XL selalu ready dan siap disajikan. Kami bisa langsung siapkan pesanan Anda untuk pick-up sore ini pukul 16:00. Apakah Anda ingin langsung melakukan checkout?"
                    <div class="text-[8px] text-teal-400/60 mt-1 text-right">14:20 WIB • Auto Replied by AI Bot</div>
                </div>
                <div class="h-6 w-6 rounded-full bg-teal-950 border border-teal-500/30 flex items-center justify-center text-[10px]">🤖</div>
            </div>
        </div>

        <div class="flex gap-2 border-t border-white/5 pt-3">
            <input type="text" placeholder="Ketik pesan balasan manual sebagai Customer Service Agent..." class="w-full bg-slate-950/60 border border-white/10 rounded-xl px-3 py-2 text-xs focus:outline-none focus:border-teal-400">
            <button onclick="alert('CS Response dispatch simulated.')" class="bg-teal-400 hover:bg-teal-300 text-black px-4 py-2 rounded-xl text-xs font-extrabold uppercase">Kirim</button>
        </div>
    </div>
</div>
HTML;
    }
}
