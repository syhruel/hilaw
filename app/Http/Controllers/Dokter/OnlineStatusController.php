<?php  
namespace App\Http\Controllers\Dokter;  

use App\Http\Controllers\Controller; 
use Illuminate\Http\Request;  

class OnlineStatusController extends Controller 
{     
    public function toggle() 
    {     
        $user = auth()->user();      

        $user->update([         
            'is_online' => !$user->is_online     
        ]);      

        auth()->setUser($user->fresh());      

        $status = $user->is_online ? 'online' : 'offline';     
        return redirect()->back()->with('success', "Status berhasil diubah ke {$status}"); 
    }   
}