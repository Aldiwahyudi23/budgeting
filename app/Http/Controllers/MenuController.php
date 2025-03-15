<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Aktivitas\Expenses;
use App\Models\Aktivitas\Income;
use App\Models\Alokasi\AllocationEx;
use App\Models\Alokasi\AllocationIn;
use App\Models\Assets\Saving;
use App\Models\MasterData\AccountBank;
use App\Models\MasterData\Category;
use App\Models\MasterData\Debit;
use App\Models\MasterData\SubCategory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class MenuController extends Controller
{
    public function setupData()
    {

        return Inertia::render('Menu/SetupData');
    }
}