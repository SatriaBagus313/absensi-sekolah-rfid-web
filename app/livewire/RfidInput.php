<?php
namespace App\Livewire;

use Livewire\Component;
use App\Models\ScanBuffer;

class RfidInput extends Component
{
    public $uid;

    public function checkScan()
    {
        $scan = ScanBuffer::first();
        if ($scan) {
            $this->uid = $scan->uid;
            // Opsional: Hapus setelah diambil agar tidak terisi terus menerus
            // $scan->delete(); 
        }
    }

    public function render()
    {
        return view('livewire.rfid-input');
    }
}