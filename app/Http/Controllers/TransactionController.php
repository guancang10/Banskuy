<?php

namespace App\Http\Controllers;

use App\Models\Documentation;
use App\Models\DocumentationPhoto;
use App\Models\DonationTransaction;
use App\Models\Foundation;
use App\Models\Level;
use App\Models\LevelGrade;
use App\Models\Post;
use App\Models\User;
use App\Models\UserLevel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class TransactionController extends Controller
{
    public function MakeTransaction($id)
    {
        $id = Crypt::decrypt($id);
        $user = User::where('UserID', $id)->with('UserLevel.LevelGrade')->with('Photo')->first();
        $StatusRedirect = 0;
        return view('Transaction.createtransaction', compact('user', 'StatusRedirect'));
    }

    public function DonationHistory()
    {
        return view('DonationHistory.donationhistory');
    }

    public function GetFoundationSearch(Request $request)
    {
        // if($request->donationType) $post = Ppst::where()
        if ($request->text == 'all')
            $foundation = Foundation::get();
        else
            $foundation = Foundation::where('FoundationName', 'like', '%' . $request->text . '%')->get();

        $foundationid = array();
        foreach ($foundation as $value) {
            $foundationid[] = ['key' => $value->FoundationID, 'value' => Crypt::encrypt($value->FoundationID)];
        };
        $response = array('payload' => $foundation, 'foundationID' => $foundationid);
        return response()->json($response);
    }

    public function GetFoundationByID(Request $request)
    {
        $id = Crypt::decrypt($request->UserID);

        $foundation = Foundation::where('FoundationID', $id)->with('Address.Province')->with('Address.City')->first();

        $response = ['payload' => $foundation, 'foundationid' => Crypt::encrypt($foundation->FoundationID)];
        return response()->json($response);
    }

    public function RequestTransaction(Request $request)
    {
        $donationtransaction = new DonationTransaction();
        $donationtransaction->UserID = Crypt::decrypt($request->UserID);
        $donationtransaction->FoundationID = Crypt::decrypt($request->FoundationID);
        $donationtransaction->DonationTypeDetailID = $request->Unit;
        $donationtransaction->ApprovalStatusID     = '1';
        $donationtransaction->DonationDescriptionName = $request->DonationDescription;
        $donationtransaction->TransactionDate = date('Y-m-d');
        $donationtransaction->Quantity = $request->Quantity;
        $donationtransaction->created_at = date('Y-m-d H:i:s');
        $donationtransaction->PostID = $request->SelectPost;
        $donationtransaction->save();
        $request->session()->flash('toastsuccess', 'Request submitted');
        return redirect()->action('App\Http\Controllers\TransactionController@DonationHistory');
    }

    public function GetDonationHistory(Request $request)
    {
        $id = Crypt::decrypt($request->UserID);
        $donationhistory = DonationTransaction::where('UserID', $id)->with('DonationTypeDetail.DonationType')->with('ApprovalStatus')->with('Foundation')->orderBy('TransactionDate', 'DESC')->orderBy('created_at','DESC')->get();
        // echo ($donationhistory);
        $donationhistory = $donationhistory->filter(function ($x) use ($request) {
            if ($request->keyword) $x = (str_contains($x->DonationDescriptionName, $request->keyword) || str_contains($x->DonationTypeDetail->DonationType->DonationTypeName, $request->keyword) || str_contains($x->Foundation->FoundationName, $request->keyword)) ? $x : [];
            // echo ($x);
            // // echo ($x->ApprovalStatus);
            // return;
            if ($x && $request->donationStatus) $x = ($x->ApprovalStatus->ApprovalStatusID == $request->donationStatus) ? $x : [];

            if ($x && $request->donationType) $x = ($x->DonationTypeDetail->DonationType->DonationTypeID == $request->donationType) ? $x : [];

            if ($x && ($request->dateStart && $request->dateEnd)) {
                $dateFrom = date('Y-m-d', strtotime($request->dateStart));
                $dateTo = date('Y-m-d', strtotime($request->dateEnd));
                $transactionDate = date('Y-m-d', strtotime($x->TransactionDate));
                if (($transactionDate >= $dateFrom) && ($transactionDate <= $dateTo)) {
                    $x = $x;
                } else {
                    $x = [];
                }
            }

            return $x;
        });
        // echo ($donationhistory);
        // return;
        $response = ['payload' => $donationhistory];
        return response()->json($response);
    }

    public function GetDonationHistoryDetail(Request $request)
    {
        $donation = DonationTransaction::where("DonationTransactionID", $request->TransactionID)->with('DonationTypeDetail.DonationType')->with('ApprovalStatus')->with('foundation')->with('User')->first();
        $response = ['payload' => $donation];
        return response()->json($response);
    }

    //===============================  PEMBATAS UNTUK DONATION APPROVAL  ==================================//

    public function DonationApproval()
    {
        return view('Transaction.transactionapproval');
    }

    public function GetDonationApproval(Request $request)
    {
        $foundationid = Crypt::decrypt($request->FoundationID);
        $donationapproval = DonationTransaction::where('FoundationID', $foundationid)->where('ApprovalStatusID','!=','6')->with('DonationTypeDetail.DonationType')->with('ApprovalStatus')->with('User')->with('Post')->orderBy('TransactionDate', 'DESC')->orderBy('created_at', 'DESC')->get();
        // echo ($donationhistory);
        $donationapproval = $donationapproval->filter(function ($x) use ($request) {
            if ($request->keyword) $x = (str_contains($x->DonationDescriptionName, $request->keyword) || str_contains($x->DonationTypeDetail->DonationType->DonationTypeName, $request->keyword)) ? $x : [];
            // echo ($x);
            // // echo ($x->ApprovalStatus);
            // return;
            if ($x && $request->donationStatus) $x = ($x->ApprovalStatus->ApprovalStatusID == $request->donationStatus) ? $x : [];

            if ($x && $request->donationType) $x = ($x->DonationTypeDetail->DonationType->DonationTypeID == $request->donationType) ? $x : [];

            if ($x && ($request->dateStart && $request->dateEnd)) {
                $dateFrom = date('Y-m-d', strtotime($request->dateStart));
                $dateTo = date('Y-m-d', strtotime($request->dateEnd));
                $transactionDate = date('Y-m-d', strtotime($x->TransactionDate));
                if (($transactionDate >= $dateFrom) && ($transactionDate <= $dateTo)) {
                    $x = $x;
                } else {
                    $x = [];
                }
            }

            return $x;
        });
        // echo ($donationhistory);
        // return;
        $response = ['payload' => $donationapproval];
        return response()->json($response);
    }

    public function GetDonationApprovalDetail(Request $request)
    {
        $donation = DonationTransaction::where("DonationTransactionID", $request->TransactionID)->with('DonationTypeDetail.DonationType')->with('ApprovalStatus')->with('User')->with('Post')->first();
        $response = ['payload' => $donation];
        return response()->json($response);
    }

    public function AcceptRejectDonationTransaction(Request $request)
    {
        $donation = DonationTransaction::where("DonationTransactionID", $request->TransactionID)->with('DonationTypeDetail.DonationType')->first();


        $donation->ApprovalStatusID = $request->donationStatus;


        $donation->save();
        if ($donation->ApprovalStatusID == 5) {
            $UserLevel = UserLevel::where([['UserID', $donation->UserID], ['IsCurrentLevel', 1]])->first();
            $Level = Level::where('LevelID', $UserLevel->LevelID)->first();
            // dd($Level);
            $LevelGrade = LevelGrade::all();
            $NextLevel = $LevelGrade->where('LevelGradeID', $UserLevel->LevelGradeID + 1)->first();
            switch ($donation->DonationTypeDetail->DonationType->DonationTypeID) {
                case 1:
                    if ($Level->Exp + 750 >= $NextLevel->LevelExp) {
                        $Level->Exp = $Level->Exp + 750;
                        $LastLevelExp = $Level->Exp;
                        $Level->save();
                        $userlevel = new UserLevel;
                        $userlevel->UserID = $UserLevel->UserID;
                        $userlevel->LevelGradeID = $NextLevel->LevelGradeID;
                        $userlevel->IsCurrentLevel = 1;
                        $userlevel->ReceivedDate = Carbon::now()->toDateTimeString();
                        $userlevel->created_at = date('Y-m-d H:i:s');
                        $userlevel->save();

                        $userlevellastid = $userlevel->LevelID;

                        $level = new Level();
                        $level->LevelID = $userlevellastid;
                        $level->Exp = $LastLevelExp + 750;
                        $level->ReceivedDate = Carbon::now()->toDateTimeString();
                        $level->created_at = date('Y-m-d H:i:s');
                        $level->save();
                        $UserLevel->IsCurrentLevel = 0;
                        $UserLevel->save();
                    } else {
                        $Level->Exp = $Level->Exp + 750;
                        // dd($Level);
                        $Level->save();
                    }
                    break;
                case 2:
                    if ($Level->Exp + 1000 >= $NextLevel->LevelExp) {
                        $Level->Exp = $Level->Exp + 1000;
                        $LastLevelExp = $Level->Exp;
                        $Level->save();
                        $userlevel = new UserLevel;
                        $userlevel->UserID = $UserLevel->UserID;
                        $userlevel->LevelGradeID = $NextLevel->LevelGradeID;
                        $userlevel->IsCurrentLevel = 1;
                        $userlevel->ReceivedDate = Carbon::now()->toDateTimeString();
                        $userlevel->created_at = date('Y-m-d H:i:s');
                        $userlevel->save();

                        $userlevellastid = $userlevel->LevelID;

                        $level = new Level();
                        $level->LevelID = $userlevellastid;
                        $level->Exp = $LastLevelExp + 1000;
                        $level->ReceivedDate = Carbon::now()->toDateTimeString();
                        $level->created_at = date('Y-m-d H:i:s');
                        $level->save();
                        $UserLevel->IsCurrentLevel = 0;
                        $UserLevel->save();
                    } else {
                        $Level->Exp = $Level->Exp + 1000;
                        $Level->save();
                    }
                    break;
                case 3:
                    if ($Level->Exp + 500 >= $NextLevel->LevelExp) {
                        $Level->Exp = $Level->Exp + 500;
                        $LastLevelExp = $Level->Exp;
                        $Level->save();
                        $userlevel = new UserLevel;
                        $userlevel->UserID = $UserLevel->UserID;
                        $userlevel->LevelGradeID = $NextLevel->LevelGradeID;
                        $userlevel->IsCurrentLevel = 1;
                        $userlevel->ReceivedDate = Carbon::now()->toDateTimeString();
                        $userlevel->created_at = date('Y-m-d H:i:s');
                        $userlevel->save();

                        $userlevellastid = $userlevel->LevelID;

                        $level = new Level();
                        $level->LevelID = $userlevellastid;
                        $level->Exp = $LastLevelExp + 500;
                        $level->ReceivedDate = Carbon::now()->toDateTimeString();
                        $level->created_at = date('Y-m-d H:i:s');
                        $level->save();
                        $UserLevel->IsCurrentLevel = 0;
                        $UserLevel->save();
                    } else {
                        $Level->Exp = $Level->Exp + 500;
                        $Level->save();
                    }
                    break;
            }
        }
        $response = ['payload' => 'sukses'];
        return response()->json($response);
    }

    public function UploadDocumentation(Request $request)
    {
        $hashed = Hash::make($request->transactionID);
        $hashed = str_replace('\\', ';', $hashed);
        $hashed = str_replace('/', ';', $hashed);
        $filename = $hashed . '.' . $request->file('DocumentationPhoto')->getClientOriginalExtension();
        // $ftp = ftp_connect(env('FTP_SERVER'));
        // $login_result = ftp_login($ftp, env('FTP_USERNAME'), env('FTP_PASSWORD'));

        $donation = DonationTransaction::where('DonationTransactionID', $request->transactionID)->first();
        $post = Post::where('PostID', $donation->PostID)->first();

        $documentation = new Documentation();
        $documentation->DocumentationDate = date('Y-m-d H:i:s');
        //$documentation->DonationTypeID = ; // MASIH ENTAHLAH GIMANA GET NYA DI TRANSACTION GAADA SOALNYA
        $documentation->updated_at = date('Y-m-d H:i:s');
        $documentation->save();

        if($post){
            if($post->Quantity > $donation->Quantity){
                $post->Quantity = $post->Quantity - $donation->Quantity;
                
            }else{
                $post->Quantity = 0;
                $post->StatusPostId = 2;
            }
            $post->save();
        }
        $donation->DocumentationID = $documentation->DocumentationID;
        $donation->save();

        $documentationphoto = new DocumentationPhoto();
        Storage::disk('ftp')->put('DocumentationPicture/' . $filename, fopen($request->file('DocumentationPhoto'), 'r+'));
        $documentationphoto->DocumentationID = $documentation->DocumentationID;
        $documentationphoto->PhotoName = $filename;
        $documentationphoto->save();

        $request->session()->flash('toastsuccess', 'Dokumentasi updated successfully');
        return redirect()->back();
    }

    //25 Nov 2021 - add fikri for redirecting from post
    public function MakeTransactionWithPost($id)
    {
        $PostID = Crypt::decrypt($id);
        $user = User::where('UserID', FacadesAuth::id())->with('UserLevel.LevelGrade')->with('Photo')->first();
        $Post = Post::where('PostID', $PostID)->first();
        $Foundation = Foundation::where('FoundationID', $Post->ID)->first();
        $StatusRedirect = 1;
        
        return view('Transaction.createtransaction', compact('user', 'Foundation', 'Post', 'StatusRedirect'));
    }

    public function DeleteTransaction(Request $request){
        $donation = DonationTransaction::where("DonationTransactionID", $request->popupTransactionID)->first();
        $donation->ApprovalStatusID = '6';
        $donation->save();
        $request->session()->flash('toastsuccess', 'Transaksi Berhasil Dibatalkan');
        return redirect()->back();
    }
}
