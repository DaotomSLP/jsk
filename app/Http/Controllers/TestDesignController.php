<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\FloorPlanSlideImages;
use App\Models\FutureWorkImages;
use App\Models\FutureWorks;
use App\Models\HomeSlideImages;
use App\Models\Orders;
use App\Models\PastWorkImages;
use App\Models\PastWorks;
use App\Models\PlanPackages;
use App\Models\Plans;
use App\Models\Floors;
use App\Models\LampCategories;
use App\Models\PlanSlideImages;
use App\Models\PresentWorkImages;
use App\Models\PresentWorks;
use App\Models\Rooms;
use App\Models\TopSellingSlideImages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use App\Models\Lamps;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class TestDesignController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    function __construct()
    {
    }

    public function index(Request $request)
    {
        $categories = Categories::all();
        $homeSlideImages = HomeSlideImages::all();
        $topSellingSlideImages = TopSellingSlideImages::all();
        $recommendeds = Plans::join('categories', 'plans.category', 'categories.id')
            ->join('recommendeds', 'plans.id', 'recommendeds.plan_id')->get();

        $category_plans = array();
        foreach ($categories as $category) {
            $category_plan = array();
            $category_plan['cate_name'] = App::getLocale() == 'la' ? $category->cate_name : (App::getLocale() == 'en' ? $category->cate_en_name : $category->cate_cn_name);

            $category_plan['id'] = $category->id;
            $category_plan['plans'] = Plans::select('plans.*')
                ->join('categories', 'plans.category', 'categories.id')
                ->where('category', $category->id)
                ->orderBy('plans.id', 'desc')
                ->limit(3)
                ->get();
            array_push($category_plans, $category_plan);
        }

        $planSlideImages = PlanSlideImages::join('plans', 'planSlideImages.plan_id', 'plans.id')
            ->get();

        return view('testdesign.home', compact('categories', 'recommendeds', 'planSlideImages', 'category_plans', 'homeSlideImages', 'topSellingSlideImages'));
    }

    public function search(Request $request)
    {
        $plansQuery = Plans::select('plans.*', 'categories.cate_name')
            ->join('categories', 'plans.category', 'categories.id')
            ->orderBy('plans.id', 'desc');

        if ($request->floor != '') {
            $plansQuery->where('floor', $request->floor);
        }

        if ($request->bedroom != '') {
            $plansQuery->where('bedroom', $request->bedroom);
        }

        if ($request->bath != '') {
            $plansQuery->where('bath', $request->bath);
        }

        $all_plans = $plansQuery->count();

        if ($request->page) {
            $plansQuery->offset(($request->page - 1) * 15);
        }

        $plans = $plansQuery->limit(15)
            ->get();

        $pagination = [
            'offsets' => ceil($all_plans / 15),
            'offset' => $request->page ? $request->page : 1,
            'all' => $all_plans
        ];

        $categories = Categories::all();

        return view('testdesign.search', compact('plans', 'categories', 'pagination'));
    }

    public function plansByCategory($id, Request $request)
    {
        $plansQuery = Plans::select('plans.*', 'categories.cate_name')
            ->join('categories', 'plans.category', 'categories.id')
            ->where('categories.id', $id)
            ->orderBy('plans.id', 'desc');

        $all_plans = $plansQuery->count();

        if ($request->page) {
            $plansQuery->offset(($request->page - 1) * 15);
        }

        $plans = $plansQuery->limit(15)
            ->get();

        $pagination = [
            'offsets' => ceil($all_plans / 15),
            'offset' => $request->page ? $request->page : 1,
            'all' => $all_plans
        ];

        $categories = Categories::all();

        $category_id = $id;

        $category = Categories::where('id', $id)->first();

        return view('testdesign.plansByCategory', compact('plans', 'category', 'categories', 'pagination', 'category_id'));
    }

    public function detail($id)
    {
        $categories = Categories::all();

        $plan = Plans::where('id', $id)->first();
        $rooms = Rooms::select('floors.floor_name', 'rooms.*')
            ->join('floors', 'rooms.floor_id', 'floors.id')
            ->join('plans', 'floors.plan_id', 'plans.id')
            ->where('plans.id', $id)
            ->get();

        $floors = Floors::select('floors.*')
            ->join('plans', 'floors.plan_id', 'plans.id')
            ->where('plans.id', $id)
            ->get();

        $floor_with_rooms = array();

        foreach ($floors as $key => $floor) {
            $array_rooms = array();
            foreach ($rooms as $key => $room) {
                if ($room->floor_id == $floor->id) {
                    array_push($array_rooms, $room);
                }
            }
            $array_floor = $floor;
            $array_floor["rooms"] = $array_rooms;
            array_push($floor_with_rooms, $array_floor);
        }

        $recommendeds = Plans::join('categories', 'plans.category', 'categories.id')
            ->inRandomOrder()
            ->limit(3)
            ->get();

        $planSlideImages = PlanSlideImages::join('plans', 'planSlideImages.plan_id', 'plans.id')
            ->where('plans.id', $id)
            ->get();

        $planPackages = PlanPackages::select('planPackages.*')
            ->join('plans', 'planPackages.plan_id', 'plans.id')
            ->where('plans.id', $id)
            ->get();

        $floorPlanSlideImages = FloorPlanSlideImages::join('plans', 'floorPlanSlideImages.plan_id', 'plans.id')
            ->where('plans.id', $id)
            ->get();

        return view('testdesign.detail', compact('plan', 'floor_with_rooms', 'recommendeds', 'planSlideImages', 'floorPlanSlideImages', 'categories', 'planPackages'));
    }

    public function showPastWorks(Request $request)
    {
        $pastWorksQuery = PastWorks::select('pastWorks.*')
            ->orderBy('pastWorks.id', 'desc');

        $allPastWorks = $pastWorksQuery->count();

        if ($request->page) {
            $pastWorksQuery->offset(($request->page - 1) * 15);
        }

        $pastWorks = $pastWorksQuery->limit(15)
            ->get();

        $pagination = [
            'offsets' => ceil($allPastWorks / 15),
            'offset' => $request->page ? $request->page : 1,
            'all' => $allPastWorks
        ];

        $categories = Categories::all();

        return view('testdesign.pastWorks', compact('pastWorks', 'categories', 'pagination'));
    }

    public function pastWorkDetail($id)
    {
        $categories = Categories::all();
        $pastWork = PastWorks::where('id', $id)->first();

        $pastWorkImages = PastWorkImages::join('pastWorks', 'pastWorkImages.pastwork_id', 'pastWorks.id')
            ->where('pastWorks.id', $id)
            ->get();

        return view('testdesign.pastWorkDetail', compact('pastWork', 'categories', 'pastWorkImages'));
    }

    public function showPresentWorks(Request $request)
    {
        $presentWorksQuery = PresentWorks::select('presentWorks.*')
            ->orderBy('presentWorks.id', 'desc');

        $allPresentWorks = $presentWorksQuery->count();

        if ($request->page) {
            $presentWorksQuery->offset(($request->page - 1) * 15);
        }

        $presentWorks = $presentWorksQuery->limit(15)
            ->get();

        $pagination = [
            'offsets' => ceil($allPresentWorks / 15),
            'offset' => $request->page ? $request->page : 1,
            'all' => $allPresentWorks
        ];

        $categories = Categories::all();

        return view('testdesign.presentWorks', compact('presentWorks', 'categories', 'pagination'));
    }

    public function presentWorkDetail($id)
    {
        $categories = Categories::all();
        $presentWork = PresentWorks::where('id', $id)->first();

        $presentWorkImages = PresentWorkImages::join('presentWorks', 'presentWorkImages.presentWork_id', 'presentWorks.id')
            ->where('presentWorks.id', $id)
            ->get();

        return view('testdesign.presentWorkDetail', compact('presentWork', 'categories', 'presentWorkImages'));
    }

    public function showFutureWorks(Request $request)
    {
        $futureWorksQuery = FutureWorks::select('futureWorks.*')
            ->orderBy('futureWorks.id', 'desc');

        $allFutureWorks = $futureWorksQuery->count();

        if ($request->page) {
            $futureWorksQuery->offset(($request->page - 1) * 15);
        }

        $futureWorks = $futureWorksQuery->limit(15)
            ->get();

        $pagination = [
            'offsets' => ceil($allFutureWorks / 15),
            'offset' => $request->page ? $request->page : 1,
            'all' => $allFutureWorks
        ];

        $categories = Categories::all();

        return view('testdesign.futureWorks', compact('futureWorks', 'categories', 'pagination'));
    }

    public function futureWorkDetail($id)
    {
        $categories = Categories::all();
        $futureWork = FutureWorks::where('id', $id)->first();

        $futureWorkImages = FutureWorkImages::join('futureWorks', 'futureWorkImages.futureWork_id', 'futureWorks.id')
            ->where('futureWorks.id', $id)
            ->get();

        return view('testdesign.futureWorkDetail', compact('futureWork', 'categories', 'futureWorkImages'));
    }

    public function access_denied()
    {
        return view('accessDenied');
    }

    public function lamps(Request $request)
    {
        $lampsQuery = Lamps::select('lamps.*', 'lamp_categories.name as cate_name', 'lamp_categories.en_name as cate_en_name', 'lamp_categories.cn_name as cate_cn_name', 'lamp_categories.th_name as cate_th_name')
            ->join('lamp_categories', 'lamps.category_id', 'lamp_categories.id')
            ->orderBy('lamps.id', 'desc');

        if ($request->category_id != '') {
            $lampsQuery->where('category_id', $request->category_id);
        }

        $all_lamps = $lampsQuery->count();

        if ($request->page) {
            $lampsQuery->offset(($request->page - 1) * 15);
        }

        $lamps = $lampsQuery->limit(15)
            ->get();

        $pagination = [
            'offsets' => ceil($all_lamps / 15),
            'offset' => $request->page ? $request->page : 1,
            'all' => $all_lamps
        ];

        $categories = Categories::all();

        $lamp_categories = LampCategories::all();

        return view('testdesign.lamps', compact('lamps', 'categories', 'lamp_categories', 'pagination'));
    }

    private function generateOrderUniqueCode($length = 6)
    {
        $code = Str::random($length);

        // Check if the generated code already exists in the database
        while (Orders::where('order_no', '#' . $code)->exists()) {
            $code = Str::random($length);
        }

        return $code;
    }

    public function orders(Request $request)
    {
        if ($request->status) {
            $ordersQuery = orders::select('orders.order_no', 'orders.created_at', 'plans.plan_name', 'plans.plan_en_name', 'plans.plan_cn_name', 'plans.thumbnail', 'plans.id AS plan_id', 'categories.cate_name', 'categories.cate_en_name', 'categories.cate_cn_name', 'planPackages.name', 'planPackages.en_name', 'planPackages.cn_name', 'planPackages.price')
                ->join('plans', 'orders.plan_id', 'plans.id')
                ->join('categories', 'plans.category', 'categories.id')
                ->join('planPackages', 'orders.plan_package_id', 'planPackages.id')
                ->where('orders.user_id', Auth::user()->id)
                ->where('orders.status', $request->status);

            $allOrder = $ordersQuery->count();

            if ($request->page) {
                $ordersQuery->offset(($request->page - 1) * 15);
            }

            $orders = $ordersQuery->limit(15)
                ->get();

            $pagination = [
                'offsets' => ceil($allOrder / 15),
                'offset' => $request->page ? $request->page : 1,
                'all' => $allOrder
            ];

            $status = $request->status;
            $categories = Categories::all();

            return view('testdesign.orders', compact('orders', 'status', 'categories', 'pagination'));
        } else {
            return redirect('/orders?status=success');
        }
    }

    public function order(Request $request)
    {
        $order = new Orders;
        $order->order_no = '#' . $this->generateOrderUniqueCode();
        $order->plan_id = $request->plan_id;
        $order->plan_package_id = $request->plan_package_id;
        $order->user_id = Auth::user()->id;

        if ($order->save()) {
            return redirect('/')->with(['error' => 'insert_success']);
        } else {
            return redirect('/')->with(['error' => 'not_insert']);
        }
    }
}
