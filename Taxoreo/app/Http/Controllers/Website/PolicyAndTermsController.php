<?php
namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use Redirect;
use DB;
use Validator;

class PolicyAndTermsController extends Controller
{

    public function privacy_policy()
    {
        return view('Website.PrivacyPolicy');
    }

    public function refund_policy()
    {
        return view('Website.RefundPolicy');
    }

    public function return_policy()
    {
        return view('Website.ReturnPolicy');
    }

    public function terms_and_conditions()
    {
        return view('Website.TermsAndConditions');
    }
}
