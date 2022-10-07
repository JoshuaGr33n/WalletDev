<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Nexmo\Laravel\Facades\Nexmo;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except(['logout', 'dashboard']);
        $this->middleware('auth')->only(['logout', 'dashboard']);
    }

    public function register(Request $request)
    {
        $input = $request->validate([
            'country_code' => ['required', 'numeric', 'regex:/(\+|00)(297|93|244|1264|358|355|376|971|54|374|1684|1268|61|43|994|257|32|229|226|880|359|973|1242|387|590|375|501|1441|591|55|1246|673|975|267|236|1|61|41|56|86|225|237|243|242|682|57|269|238|506|53|5999|61|1345|357|420|49|253|1767|45|1809|1829|1849|213|593|20|291|212|34|372|251|358|679|500|33|298|691|241|44|995|44|233|350|224|590|220|245|240|30|1473|299|502|594|1671|592|852|504|385|509|36|62|44|91|246|353|98|964|354|972|39|1876|44|962|81|76|77|254|996|855|686|1869|82|383|965|856|961|231|218|1758|423|94|266|370|352|371|853|590|212|377|373|261|960|52|692|389|223|356|95|382|976|1670|258|222|1664|596|230|265|60|262|264|687|227|672|234|505|683|31|47|977|674|64|968|92|507|64|51|63|680|675|48|1787|1939|850|351|595|970|689|974|262|40|7|250|966|249|221|65|500|4779|677|232|503|378|252|508|381|211|239|597|421|386|46|268|1721|248|963|1649|235|228|66|992|690|993|670|676|1868|216|90|688|886|255|256|380|598|1|998|3906698|379|1784|58|1284|1340|84|678|681|685|967|27|260|263)(9[976]\d|8[987530]\d|6[987]\d|5[90]\d|42\d|3[875]\d|2[98654321]\d|9[8543210]|8[6421]|6[6543210]|5[87654321]|4[987654310]|3[9643210]|2[70]|7|1)\d{4,20}$/'],
            'phone_number' => ['required', 'numeric', 'unique:users', 'regex:/^\+(?:[0-9] ?){6,14}[0-9]$/'],
        ],
        [
            'country_code.required'=> 'Country Code is required',
            'phone_number.required'=> 'Phone Number is required',
            'country_code.required'=> 'Invalid Country Code',
            'phone_number.regex'=> 'Invalid Phone Number',
        ]);

        $token = Str::random(30);

        $user = new User;
        $user->country_code = $input['country_code'];
        $user->phone_number = $input['phone_number'];
        $user->phone_verified = '0';
        $user->token = $token;
        $user->save();

        $num = $request->input('phone_number');
        $otp = mt_rand(100000,999999);

        Nexmo::message()->send([
            'to' => '91'. $num,
            'from' => '9876543210',
            'text' => 'Your OTP for Verification is '. $otp
        ]);

        // Mail::to($input['email'])->send(new RegisterMail($token));

        return redirect()->back()->with('success', 'Verification mail sent, please check your inbox.');
    }
 
    public function verify(Request $request)
    {
        $input = $request->validate([
            'token' => 'required|string',
        ]);

        $user = User::where('token', $input['token'])
            ->where('email_verified', '0')
            ->first();

        if ($user != null) {
            User::where('token', $input['token'])
                ->update([
                    'email_verified' => '1',
                    'token' => ''
                ]);

            Auth::login($user);
                        
            return redirect()->route('dashboard')->with('success', 'You are successfully registered.');
        }

        return redirect()->back()->with('error', 'Verification link is not valid.');
    }

    public function login(Request $request)
    {
        // $input = $request->validate([
        //     'token' => 'required|string',
        // ]);

        $token = 'YqSzNwD1teGRw0I76UK1CqpJUoeaVr';

        $user = User::where('token', $token)->where('phone_verified', '1')->first();

        if ($user != null) {
            User::where('token', $token)->where('phone_verified', '1')->update(['token' => '']);

            Auth::login($user);
            
            return redirect()->route('home')->with('success', 'You are successfully logged in.');
        }

        return redirect()->back()->with('error', 'Login link is not valid.');
    }
}
