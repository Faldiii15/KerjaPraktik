<?php

namespace App\Http\Controllers;

use App\Models\Alat;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use App\Models\Pemeliharaan;

class DashboardController extends Controller
{
    public function index()
    {
        $jumlahAlat = Alat::count();
        $jumlahPeminjaman = Peminjaman::count();
        $jumlahPengembalian = Pengembalian::count();
        $jumlahPemeliharaan = Pemeliharaan::count();

        $profil = [
            'nama_pt' => 'PT Java Artha Kencana',
            'visi' => [  
                'Bekerja secara profesional dengan memperhatikan mutu hasil pekerjaan dan tepat waktu dalam pengerjaan.',
                'Membangun dan menjaga hubungan kerja, baik internal maupun eskternal.',
                'Menjadi salah satu perusahaan kontruksi terbaik di indonesia dengan penekanan pada pertumbuhan yang 
                    berkelanjutan dan pembangunan kompetensi melalui pengembangan sumber daya manusia, manajemen teknologi, dan tata kelola perusahaan yang baik.',
            ],
            'misi' => [
                'Meningkatkan daya saing perusahaan di industri jasa kontruksi dengan mengembangkan 
                    pelayanan dan teknologi terbaik kepada konsumen dalam memenuhi harapan pemangku kepentingan.',
                'Meningkatkan pelatihan SDM untuk menghasilkan tenaga kerja yang berkualitas dan menciptakan 
                    lingkungan kerja yang kondusif serta menyediakan lapangan kerja yang luas.',
                'Berkompetisi secara professional di dalam mendapatkan pekerjaan dan melaksanakan pekerjaan 
                    berdasarkan ketentuan yang di tetapkan serta menjaga & meningkatkan kualitas hasil pekerjaan.',
            ],
        ];

        return view('dashboard', compact(
            'jumlahAlat',
            'jumlahPeminjaman',
            'jumlahPengembalian',
            'jumlahPemeliharaan',
            'profil'
        ));
    }
}
