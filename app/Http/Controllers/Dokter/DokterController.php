<?php 
namespace App\Http\Controllers\Dokter; 

use App\Http\Controllers\Controller; 
use Illuminate\Http\Request;

class DokterController extends Controller 
{ 
     
    public function index() 
    { 
        $user = auth()->user(); 
        
        $showApprovalNotification = false; 
        if ($user->was_pending && !session('approval_notification_shown')) { 
            $showApprovalNotification = true; 
            
            session(['approval_notification_shown' => true]); 
            
            $user->update(['was_pending' => false]); 
        } 
        
        return view('dokter.dashboard', compact('user', 'showApprovalNotification')); 
    } 

    public function payments() 
    { 
        $dokterId = auth()->id(); 

        $payments = Payment::with(['consultation.user']) 
            ->whereHas('consultation', function ($query) use ($dokterId) { 
                $query->where('dokter_id', $dokterId); 
            }) 
            ->orderBy('created_at', 'desc') 
            ->get(); 

        return view('dokter.payments.index', compact('payments')); 
    } 

}