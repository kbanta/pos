<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Color;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Size;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(['role:user']);
    }
    public function index()
    {
        return view('user.userhome');
    }
}
