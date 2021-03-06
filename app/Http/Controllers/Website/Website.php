<?php

namespace App\Http\Controllers\Website;

use App\Http\Models\billing_details;
use App\Http\Models\Cart;
use App\Http\Models\categories;
use App\Http\Models\Comments;
use App\Http\Models\contact_us;
use App\Http\Models\orders;
use App\Http\Models\products;
use App\Http\Models\settings_website;
use App\Http\Models\sub_categories;
use App\Http\Models\user_login;
use App\Traits\General_Traits;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use http\Env\Url;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Pagination\Paginator;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class Website extends BaseController
{
    use General_Traits;

    public function viewlogin()
    {
        return view('Website.UserLogin');
    }

    public function customLogin(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
        $credentials = $request->only('email', 'password');
        if (auth('user')->attempt($credentials)) {
            return redirect('/')
                ->with('success', 'Signed in');
        }
        return redirect("userLogin")->with('error', 'Login details are not valid');
    }

    public function logout(Request $request)
    {
        auth('user')->logout();
        return redirect('/userLogin');
    }

    public function customRegistration(Request $request)
    {
        $rules = [
            'username' => 'required',
            'email' => 'required|email|unique:user_login',
            'password' => 'required|confirmed'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
        user_login::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);
        return redirect("userLogin")->withSuccess('You have signed-in');
    }

    public function viewregister()
    {
        return view('Website.RegisterUser');
    }

    #############################################################################################
    public function Index()
    {
        $NewestProducts = products::join('categories', 'categories.id', '=', 'products.category_id')->
        join('sub-category', 'sub-category.id', '=', 'products.sub_category_id')->
        join('product_images', 'product_images.id', '=', 'products.product_imagesID')->
        orderBy('products.created_at', 'desc')->take(8)->
        get(['products.id', 'products.old_price', 'products.discount', 'categories.category', 'sub-category.sub_category_name', 'products.title', 'products.price',
            'products.short_description', 'product_images.path']);
        $PopularCategories = products::join('categories', 'categories.id', '=', 'products.category_id')->
        select(['products.category_id', 'categories.category', 'categories.category_image'])->distinct()->get();
        $Count_cart = Cart::join('user_login', 'user_login.id', '=', 'cart.user_id')->
        join('products', 'products.id', '=', 'cart.product_id')->
        join('product_images', 'product_images.id', '=', 'products.product_imagesID')->
        where('user_login.id', '=', auth('user')->id())->count();
        $popular_products = Comments::
        join('products', 'products.id', '=', 'comments.product_id')->
        join('categories', 'categories.id', '=', 'products.category_id')->
        join('sub-category', 'sub-category.id', '=', 'products.sub_category_id')->
        join('product_images', 'product_images.id', '=', 'products.product_imagesID')->
        where('comments.rating', '>=', 2)->
        groupBy('comments.product_id')->get();

        $settings= settings_website::all();



        return view('Website.index', compact(['NewestProducts','settings', 'popular_products', 'PopularCategories', 'Count_cart']));
    }

    public function Shop_View(Request $request)
    {

        if ($request->get('sort') == "price_asc") {

            $NewestProducts = products::join('categories', 'categories.id', '=', 'products.category_id')->
            join('sub-category', 'sub-category.id', '=', 'products.sub_category_id')->
            join('product_images', 'product_images.id', '=', 'products.product_imagesID')->
            orderBy('products.price', 'asc')->
            paginate(15);

            $Count_cart = Cart::join('user_login', 'user_login.id', '=', 'cart.user_id')->
            join('products', 'products.id', '=', 'cart.product_id')->
            join('product_images', 'product_images.id', '=', 'products.product_imagesID')->
            where('user_login.id', '=', auth('user')->id())->count();

            $count = products::all()->count();

            $popular_products = Comments::
            join('products', 'products.id', '=', 'comments.product_id')->
            join('categories', 'categories.id', '=', 'products.category_id')->
            join('sub-category', 'sub-category.id', '=', 'products.sub_category_id')->
            join('product_images', 'product_images.id', '=', 'products.product_imagesID')->
            where('comments.rating', '>=', 2)->
            groupBy('comments.product_id')->get();

            $settings= settings_website::all();

            $categories = categories::select('id', 'category')->get();
            foreach ($categories as $singlecat) {
                $sub[$singlecat->category] = sub_categories::where('category_id', $singlecat->id)->get();
            }
            return view('Website.Shop', compact(['NewestProducts','categories','settings', 'popular_products', 'count', 'Count_cart']));

        } elseif ($request->get('sort') == "price_desc") {

            $NewestProducts = products::join('categories', 'categories.id', '=', 'products.category_id')->
            join('sub-category', 'sub-category.id', '=', 'products.sub_category_id')->
            join('product_images', 'product_images.id', '=', 'products.product_imagesID')->
            orderBy('products.price', 'desc')->
            paginate(15);
            $count = products::all()->count();
            $Count_cart = Cart::join('user_login', 'user_login.id', '=', 'cart.user_id')->
            join('products', 'products.id', '=', 'cart.product_id')->
            join('product_images', 'product_images.id', '=', 'products.product_imagesID')->
            where('user_login.id', '=', auth('user')->id())->count();

            $popular_products = Comments::
            join('products', 'products.id', '=', 'comments.product_id')->
            join('categories', 'categories.id', '=', 'products.category_id')->
            join('sub-category', 'sub-category.id', '=', 'products.sub_category_id')->
            join('product_images', 'product_images.id', '=', 'products.product_imagesID')->
            where('comments.rating', '>=', 2)->
            groupBy('comments.product_id')->get();
            $settings= settings_website::all();

            $categories = categories::select('id', 'category')->get();
            foreach ($categories as $singlecat) {
                $sub[$singlecat->category] = sub_categories::where('category_id', $singlecat->id)->get();
            }

            return view('Website.Shop', compact(['NewestProducts','categories','settings', 'popular_products', 'count', 'Count_cart']));

        } elseif ($request->get('sort') == "product_oldest") {

            $NewestProducts = products::join('categories', 'categories.id', '=', 'products.category_id')->
            join('sub-category', 'sub-category.id', '=', 'products.sub_category_id')->
            join('product_images', 'product_images.id', '=', 'products.product_imagesID')->
            orderBy('products.created_at', 'asc')->
            paginate(15);
            $count = products::all()->count();
            $Count_cart = Cart::join('user_login', 'user_login.id', '=', 'cart.user_id')->
            join('products', 'products.id', '=', 'cart.product_id')->
            join('product_images', 'product_images.id', '=', 'products.product_imagesID')->
            where('user_login.id', '=', auth('user')->id())->count();

            $popular_products = Comments::
            join('products', 'products.id', '=', 'comments.product_id')->
            join('categories', 'categories.id', '=', 'products.category_id')->
            join('sub-category', 'sub-category.id', '=', 'products.sub_category_id')->
            join('product_images', 'product_images.id', '=', 'products.product_imagesID')->
            where('comments.rating', '>=', 2)->
            groupBy('comments.product_id')->get();
            $settings= settings_website::all();

            $categories = categories::select('id', 'category')->get();
            foreach ($categories as $singlecat) {
                $sub[$singlecat->category] = sub_categories::where('category_id', $singlecat->id)->get();
            }

            return view('Website.Shop', compact(['NewestProducts','categories','settings', 'popular_products', 'count', 'Count_cart']));
        } elseif ($request->get('sort') == "product_newest") {

            $NewestProducts = products::join('categories', 'categories.id', '=', 'products.category_id')->
            join('sub-category', 'sub-category.id', '=', 'products.sub_category_id')->
            join('product_images', 'product_images.id', '=', 'products.product_imagesID')->
            orderBy('products.created_at', 'desc')->
            paginate(15);
            $count = products::all()->count();
            $Count_cart = Cart::join('user_login', 'user_login.id', '=', 'cart.user_id')->
            join('products', 'products.id', '=', 'cart.product_id')->
            join('product_images', 'product_images.id', '=', 'products.product_imagesID')->
            where('user_login.id', '=', auth('user')->id())->count();

            $popular_products = Comments::
            join('products', 'products.id', '=', 'comments.product_id')->
            join('categories', 'categories.id', '=', 'products.category_id')->
            join('sub-category', 'sub-category.id', '=', 'products.sub_category_id')->
            join('product_images', 'product_images.id', '=', 'products.product_imagesID')->
            where('comments.rating', '>=', 2)->
            groupBy('comments.product_id')->get();

            $settings= settings_website::all();

            $categories = categories::select('id', 'category')->get();
            foreach ($categories as $singlecat) {
                $sub[$singlecat->category] = sub_categories::where('category_id', $singlecat->id)->get();
            }

            return view('Website.Shop', compact(['settings','categories','NewestProducts', 'popular_products', 'count', 'Count_cart']));
        } elseif ($request->get('sort') == "lowest_rating") {

            $NewestProducts = Comments::
            join('products', 'products.id', '=', 'comments.product_id')->
            join('categories', 'categories.id', '=', 'products.category_id')->
            join('sub-category', 'sub-category.id', '=', 'products.sub_category_id')->
            join('product_images', 'product_images.id', '=', 'products.product_imagesID')->
            where('comments.rating', '<=', 2)->groupBy('comments.product_id')->paginate(15);
            $count = products::all()->count();
            $Count_cart = Cart::join('user_login', 'user_login.id', '=', 'cart.user_id')->
            join('products', 'products.id', '=', 'cart.product_id')->
            join('product_images', 'product_images.id', '=', 'products.product_imagesID')->
            where('user_login.id', '=', auth('user')->id())->count();

            $popular_products = Comments::
            join('products', 'products.id', '=', 'comments.product_id')->
            join('categories', 'categories.id', '=', 'products.category_id')->
            join('sub-category', 'sub-category.id', '=', 'products.sub_category_id')->
            join('product_images', 'product_images.id', '=', 'products.product_imagesID')->
            where('comments.rating', '>=', 2)->
            groupBy('comments.product_id')->get();
            $settings= settings_website::all();

            $categories = categories::select('id', 'category')->get();
            foreach ($categories as $singlecat) {
                $sub[$singlecat->category] = sub_categories::where('category_id', $singlecat->id)->get();
            }

            return view('Website.Shop', compact(['settings','categories','NewestProducts', 'popular_products', 'count', 'Count_cart']));
        } elseif ($request->get('sort') == "highest_rating") {

            $NewestProducts = Comments::
            join('products', 'products.id', '=', 'comments.product_id')->
            join('categories', 'categories.id', '=', 'products.category_id')->
            join('sub-category', 'sub-category.id', '=', 'products.sub_category_id')->
            join('product_images', 'product_images.id', '=', 'products.product_imagesID')->
            where('comments.rating', '>=', 2)->groupBy('comments.product_id')->paginate(15);
            $Count_cart = Cart::join('user_login', 'user_login.id', '=', 'cart.user_id')->
            join('products', 'products.id', '=', 'cart.product_id')->
            join('product_images', 'product_images.id', '=', 'products.product_imagesID')->
            where('user_login.id', '=', auth('user')->id())->count();
            $count = products::all()->count();

            $popular_products = Comments::
            join('products', 'products.id', '=', 'comments.product_id')->
            join('categories', 'categories.id', '=', 'products.category_id')->
            join('sub-category', 'sub-category.id', '=', 'products.sub_category_id')->
            join('product_images', 'product_images.id', '=', 'products.product_imagesID')->
            where('comments.rating', '>=', 2)->
            groupBy('comments.product_id')->get();
            $settings= settings_website::all();

            $categories = categories::select('id', 'category')->get();
            foreach ($categories as $singlecat) {
                $sub[$singlecat->category] = sub_categories::where('category_id', $singlecat->id)->get();
            }
            return view('Website.Shop', compact(['settings','categories','NewestProducts', 'popular_products', 'count', 'Count_cart']));
        } else {
            $NewestProducts = products::join('categories', 'categories.id', '=', 'products.category_id')->
            join('sub-category', 'sub-category.id', '=', 'products.sub_category_id')->
            join('product_images', 'product_images.id', '=', 'products.product_imagesID')->
            orderBy('products.created_at', 'desc')->
            paginate(15);
            $count = products::all()->count();
            $categories = categories::all();
            $Count_cart = Cart::join('user_login', 'user_login.id', '=', 'cart.user_id')->
            join('products', 'products.id', '=', 'cart.product_id')->
            join('product_images', 'product_images.id', '=', 'products.product_imagesID')->
            where('user_login.id', '=', auth('user')->id())->count();
            $popular_products = Comments::
            join('products', 'products.id', '=', 'comments.product_id')->
            join('categories', 'categories.id', '=', 'products.category_id')->
            join('sub-category', 'sub-category.id', '=', 'products.sub_category_id')->
            join('product_images', 'product_images.id', '=', 'products.product_imagesID')->
            where('comments.rating', '>=', 2)->
            groupBy('comments.product_id')->get();

            $settings= settings_website::all();

            $categories = categories::select('id', 'category')->get();
            foreach ($categories as $singlecat) {
                $sub[$singlecat->category] = sub_categories::where('category_id', $singlecat->id)->get();
            }
            return view('Website.Shop', compact(['settings','NewestProducts', 'Count_cart', 'count', 'popular_products', 'categories', 'sub']));
        }
    }

    public function SingleCategory_View(Request $request, $category)
    {

        if ($request->get('sort') == "price_asc") {

            $NewestProducts = products::join('categories', 'categories.id', '=', 'products.category_id')->
            join('sub-category', 'sub-category.id', '=', 'products.sub_category_id')->
            join('product_images', 'product_images.id', '=', 'products.product_imagesID')->
            orderBy('products.price', 'asc')->where('categories.category', $category)->
            paginate(15);
            $count = products::all()->count();
            $Count_cart = Cart::join('user_login', 'user_login.id', '=', 'cart.user_id')->
            join('products', 'products.id', '=', 'cart.product_id')->
            join('product_images', 'product_images.id', '=', 'products.product_imagesID')->
            where('user_login.id', '=', auth('user')->id())->count();
            $settings= settings_website::all();
            $categories = categories::select('id', 'category')->get();
            foreach ($categories as $singlecat) {
                $sub[$singlecat->category] = sub_categories::where('category_id', $singlecat->id)->get();
            }

            return view('Website.SingleCategory', compact(['settings','categories','NewestProducts', 'count', 'Count_cart']));

        } elseif ($request->get('sort') == "price_desc") {

            $NewestProducts = products::join('categories', 'categories.id', '=', 'products.category_id')->
            join('sub-category', 'sub-category.id', '=', 'products.sub_category_id')->
            join('product_images', 'product_images.id', '=', 'products.product_imagesID')->
            orderBy('products.price', 'desc')->where('categories.category', $category)->
            paginate(15);
            $count = products::all()->count();
            $Count_cart = Cart::join('user_login', 'user_login.id', '=', 'cart.user_id')->
            join('products', 'products.id', '=', 'cart.product_id')->
            join('product_images', 'product_images.id', '=', 'products.product_imagesID')->
            where('user_login.id', '=', auth('user')->id())->count();
            $settings= settings_website::all();
            $categories = categories::select('id', 'category')->get();
            foreach ($categories as $singlecat) {
                $sub[$singlecat->category] = sub_categories::where('category_id', $singlecat->id)->get();
            }

            return view('Website.SingleCategory', compact(['settings','categories','NewestProducts', 'count', 'Count_cart']));
        } elseif ($request->get('sort') == "product_oldest") {

            $NewestProducts = products::join('categories', 'categories.id', '=', 'products.category_id')->
            join('sub-category', 'sub-category.id', '=', 'products.sub_category_id')->
            join('product_images', 'product_images.id', '=', 'products.product_imagesID')->
            orderBy('products.created_at', 'asc')->where('categories.category', $category)->
            paginate(15);
            $count = products::all()->count();
            $Count_cart = Cart::join('user_login', 'user_login.id', '=', 'cart.user_id')->
            join('products', 'products.id', '=', 'cart.product_id')->
            join('product_images', 'product_images.id', '=', 'products.product_imagesID')->
            where('user_login.id', '=', auth('user')->id())->count();
            $settings= settings_website::all();
            $categories = categories::select('id', 'category')->get();
            foreach ($categories as $singlecat) {
                $sub[$singlecat->category] = sub_categories::where('category_id', $singlecat->id)->get();
            }

            return view('Website.SingleCategory', compact(['settings','categories','NewestProducts', 'count', 'Count_cart']));
        } elseif ($request->get('sort') == "product_newest") {

            $NewestProducts = products::join('categories', 'categories.id', '=', 'products.category_id')->
            join('sub-category', 'sub-category.id', '=', 'products.sub_category_id')->
            join('product_images', 'product_images.id', '=', 'products.product_imagesID')->
            orderBy('products.created_at', 'desc')->where('categories.category', $category)->
            paginate(15);
            $count = products::all()->count();
            $Count_cart = Cart::join('user_login', 'user_login.id', '=', 'cart.user_id')->
            join('products', 'products.id', '=', 'cart.product_id')->
            join('product_images', 'product_images.id', '=', 'products.product_imagesID')->
            where('user_login.id', '=', auth('user')->id())->count();
            $settings= settings_website::all();
            $categories = categories::select('id', 'category')->get();
            foreach ($categories as $singlecat) {
                $sub[$singlecat->category] = sub_categories::where('category_id', $singlecat->id)->get();
            }

            return view('Website.SingleCategory', compact(['settings','categories','NewestProducts', 'count', 'Count_cart']));
        } elseif ($request->get('sort') == "lowest_rating") {

            $NewestProducts = Comments::
            join('products', 'products.id', '=', 'comments.product_id')->
            join('categories', 'categories.id', '=', 'products.category_id')->
            join('sub-category', 'sub-category.id', '=', 'products.sub_category_id')->
            join('product_images', 'product_images.id', '=', 'products.product_imagesID')->
            where('comments.rating', '<=', 2)->
            where('categories.category', $category)->
            groupBy('comments.product_id')->paginate(15);
            $count = products::all()->count();
            $Count_cart = Cart::join('user_login', 'user_login.id', '=', 'cart.user_id')->
            join('products', 'products.id', '=', 'cart.product_id')->
            join('product_images', 'product_images.id', '=', 'products.product_imagesID')->
            where('user_login.id', '=', auth('user')->id())->count();
            $settings= settings_website::all();
            $categories = categories::select('id', 'category')->get();
            foreach ($categories as $singlecat) {
                $sub[$singlecat->category] = sub_categories::where('category_id', $singlecat->id)->get();
            }

            return view('Website.SingleCategory', compact(['settings','categories','NewestProducts', 'count', 'Count_cart']));
        } elseif ($request->get('sort') == "highest_rating") {

            $NewestProducts = Comments::
            join('products', 'products.id', '=', 'comments.product_id')->
            join('categories', 'categories.id', '=', 'products.category_id')->
            join('sub-category', 'sub-category.id', '=', 'products.sub_category_id')->
            join('product_images', 'product_images.id', '=', 'products.product_imagesID')->
            where('comments.rating', '>=', 2)->
            where('categories.category', $category)->
            groupBy('comments.product_id')->paginate(15);
            $count = products::all()->count();
            $Count_cart = Cart::join('user_login', 'user_login.id', '=', 'cart.user_id')->
            join('products', 'products.id', '=', 'cart.product_id')->
            join('product_images', 'product_images.id', '=', 'products.product_imagesID')->
            where('user_login.id', '=', auth('user')->id())->count();
            $settings= settings_website::all();
            $categories = categories::select('id', 'category')->get();
            foreach ($categories as $singlecat) {
                $sub[$singlecat->category] = sub_categories::where('category_id', $singlecat->id)->get();
            }

            return view('Website.SingleCategory', compact(['settings','categories','NewestProducts', 'count', 'Count_cart']));
        } else {
            $count = products::join('categories', 'categories.id', '=', 'products.category_id')->
            join('sub-category', 'sub-category.id', '=', 'products.sub_category_id')->
            join('product_images', 'product_images.id', '=', 'products.product_imagesID')->
            where('categories.category', $category)->count();

            $categories = categories::all();
            $NewestProducts = products::join('categories', 'categories.id', '=', 'products.category_id')->
            join('sub-category', 'sub-category.id', '=', 'products.sub_category_id')->
            join('product_images', 'product_images.id', '=', 'products.product_imagesID')->
            where('categories.category', $category)->orderBy('products.created_at', 'desc')->
            paginate(15);
            $Count_cart = Cart::join('user_login', 'user_login.id', '=', 'cart.user_id')->
            join('products', 'products.id', '=', 'cart.product_id')->
            join('product_images', 'product_images.id', '=', 'products.product_imagesID')->
            where('user_login.id', '=', auth('user')->id())->count();
            $settings= settings_website::all();
            $categories = categories::select('id', 'category')->get();
            foreach ($categories as $singlecat) {
                $sub[$singlecat->category] = sub_categories::where('category_id', $singlecat->id)->get();
            }

            return view('Website.SingleCategory', compact(['settings','categories','NewestProducts', 'count', 'categories', 'Count_cart']));
        }
    }

    public function Single_SubCategory_View(Request $request, $sub_category_name)
    {

        if ($request->get('sort') == "price_asc") {

            $NewestProducts = products::join('categories', 'categories.id', '=', 'products.category_id')->
            join('sub-category', 'sub-category.id', '=', 'products.sub_category_id')->
            join('product_images', 'product_images.id', '=', 'products.product_imagesID')->
            orderBy('products.price', 'asc')->where('sub-category.sub_category_name', $sub_category_name)->
            paginate(15);
            $count = products::all()->count();
            $Count_cart = Cart::join('user_login', 'user_login.id', '=', 'cart.user_id')->
            join('products', 'products.id', '=', 'cart.product_id')->
            join('product_images', 'product_images.id', '=', 'products.product_imagesID')->
            where('user_login.id', '=', auth('user')->id())->count();
            $settings= settings_website::all();
            $categories = categories::select('id', 'category')->get();
            foreach ($categories as $singlecat) {
                $sub[$singlecat->category] = sub_categories::where('category_id', $singlecat->id)->get();
            }

            return view('Website.SingleCategory', compact(['settings','categories','NewestProducts', 'count', 'Count_cart']));

        } elseif ($request->get('sort') == "price_desc") {

            $NewestProducts = products::join('categories', 'categories.id', '=', 'products.category_id')->
            join('sub-category', 'sub-category.id', '=', 'products.sub_category_id')->
            join('product_images', 'product_images.id', '=', 'products.product_imagesID')->
            orderBy('products.price', 'desc')->where('sub-category.sub_category_name', $sub_category_name)->
            paginate(15);
            $count = products::all()->count();
            $Count_cart = Cart::join('user_login', 'user_login.id', '=', 'cart.user_id')->
            join('products', 'products.id', '=', 'cart.product_id')->
            join('product_images', 'product_images.id', '=', 'products.product_imagesID')->
            where('user_login.id', '=', auth('user')->id())->count();
            $settings= settings_website::all();
            $categories = categories::select('id', 'category')->get();
            foreach ($categories as $singlecat) {
                $sub[$singlecat->category] = sub_categories::where('category_id', $singlecat->id)->get();
            }
            return view('Website.SingleCategory', compact(['categories','settings','NewestProducts', 'count', 'Count_cart']));
        } elseif ($request->get('sort') == "product_oldest") {

            $NewestProducts = products::join('categories', 'categories.id', '=', 'products.category_id')->
            join('sub-category', 'sub-category.id', '=', 'products.sub_category_id')->
            join('product_images', 'product_images.id', '=', 'products.product_imagesID')->
            orderBy('products.created_at', 'asc')->
            where('sub-category.sub_category_name', $sub_category_name)->
            paginate(15);
            $count = products::all()->count();
            $Count_cart = Cart::join('user_login', 'user_login.id', '=', 'cart.user_id')->
            join('products', 'products.id', '=', 'cart.product_id')->
            join('product_images', 'product_images.id', '=', 'products.product_imagesID')->
            where('user_login.id', '=', auth('user')->id())->count();
            $settings= settings_website::all();
            $categories = categories::select('id', 'category')->get();
            foreach ($categories as $singlecat) {
                $sub[$singlecat->category] = sub_categories::where('category_id', $singlecat->id)->get();
            }
            return view('Website.SingleCategory', compact(['categories','settings','NewestProducts', 'count', 'Count_cart']));
        } elseif ($request->get('sort') == "product_newest") {

            $NewestProducts = products::join('categories', 'categories.id', '=', 'products.category_id')->
            join('sub-category', 'sub-category.id', '=', 'products.sub_category_id')->
            join('product_images', 'product_images.id', '=', 'products.product_imagesID')->
            orderBy('products.created_at', 'desc')->
            where('sub-category.sub_category_name', $sub_category_name)->
            paginate(15);
            $count = products::all()->count();
            $Count_cart = Cart::join('user_login', 'user_login.id', '=', 'cart.user_id')->
            join('products', 'products.id', '=', 'cart.product_id')->
            join('product_images', 'product_images.id', '=', 'products.product_imagesID')->
            where('user_login.id', '=', auth('user')->id())->count();
            $settings= settings_website::all();
            $categories = categories::select('id', 'category')->get();
            foreach ($categories as $singlecat) {
                $sub[$singlecat->category] = sub_categories::where('category_id', $singlecat->id)->get();
            }
            return view('Website.SingleCategory', compact(['categories','settings','NewestProducts', 'count', 'Count_cart']));
        } elseif ($request->get('sort') == "lowest_rating") {

            $NewestProducts = Comments::
            join('products', 'products.id', '=', 'comments.product_id')->
            join('categories', 'categories.id', '=', 'products.category_id')->
            join('sub-category', 'sub-category.id', '=', 'products.sub_category_id')->
            join('product_images', 'product_images.id', '=', 'products.product_imagesID')->
            where('comments.rating', '<=', 2)->
            where('sub-category.sub_category_name', $sub_category_name)->
            groupBy('comments.product_id')->paginate(15);
            $count = products::all()->count();
            $Count_cart = Cart::join('user_login', 'user_login.id', '=', 'cart.user_id')->
            join('products', 'products.id', '=', 'cart.product_id')->
            join('product_images', 'product_images.id', '=', 'products.product_imagesID')->
            where('user_login.id', '=', auth('user')->id())->count();
            $settings= settings_website::all();
            $categories = categories::select('id', 'category')->get();
            foreach ($categories as $singlecat) {
                $sub[$singlecat->category] = sub_categories::where('category_id', $singlecat->id)->get();
            }

            return view('Website.SingleCategory', compact(['categories','settings','NewestProducts', 'count', 'Count_cart']));
        } elseif ($request->get('sort') == "highest_rating") {

            $NewestProducts = Comments::
            join('products', 'products.id', '=', 'comments.product_id')->
            join('categories', 'categories.id', '=', 'products.category_id')->
            join('sub-category', 'sub-category.id', '=', 'products.sub_category_id')->
            join('product_images', 'product_images.id', '=', 'products.product_imagesID')->
            where('comments.rating', '>=', 2)->groupBy('comments.product_id')->
            where('sub-category.sub_category_name', $sub_category_name)->
            paginate(15);
            $count = products::all()->count();
            $Count_cart = Cart::join('user_login', 'user_login.id', '=', 'cart.user_id')->
            join('products', 'products.id', '=', 'cart.product_id')->
            join('product_images', 'product_images.id', '=', 'products.product_imagesID')->
            where('user_login.id', '=', auth('user')->id())->count();
            $settings= settings_website::all();
            $categories = categories::select('id', 'category')->get();
            foreach ($categories as $singlecat) {
                $sub[$singlecat->category] = sub_categories::where('category_id', $singlecat->id)->get();
            }

            return view('Website.SingleCategory', compact(['categories','settings','NewestProducts', 'count', 'Count_cart']));
        } else {
            $count = products::join('categories', 'categories.id', '=', 'products.category_id')->
            join('sub-category', 'sub-category.id', '=', 'products.sub_category_id')->
            join('product_images', 'product_images.id', '=', 'products.product_imagesID')->
            where('sub-category.sub_category_name', $sub_category_name)->count();
            $categories = categories::all();
            $NewestProducts = products::join('categories', 'categories.id', '=', 'products.category_id')->
            join('sub-category', 'sub-category.id', '=', 'products.sub_category_id')->
            join('product_images', 'product_images.id', '=', 'products.product_imagesID')->
            where('sub-category.sub_category_name', $sub_category_name)->orderBy('products.created_at', 'desc')->
            paginate(15);
            $Count_cart = Cart::join('user_login', 'user_login.id', '=', 'cart.user_id')->
            join('products', 'products.id', '=', 'cart.product_id')->
            join('product_images', 'product_images.id', '=', 'products.product_imagesID')->
            where('user_login.id', '=', auth('user')->id())->count();
            $settings= settings_website::all();
            $categories = categories::select('id', 'category')->get();
            foreach ($categories as $singlecat) {
                $sub[$singlecat->category] = sub_categories::where('category_id', $singlecat->id)->get();
            }

            return view('Website.SingleSubCategory', compact(['categories','settings','NewestProducts', 'count', 'categories', 'Count_cart']));
        }
    }

    public function Single_Product($id, $product_name)
    {
        $NewestProducts = products::join('categories', 'categories.id', '=', 'products.category_id')->
        join('sub-category', 'sub-category.id', '=', 'products.sub_category_id')->
        join('product_images', 'product_images.id', '=', 'products.product_imagesID')->
        where('products.title', $product_name)->get();
        $comments = Comments::join('user_login', 'user_login.id', '=', 'comments.user_id')->
        where('comments.product_id', $id)->get();
        $RelatedProducts = products::join('categories', 'categories.id', '=', 'products.category_id')->
        join('sub-category', 'sub-category.id', '=', 'products.sub_category_id')->
        join('product_images', 'product_images.id', '=', 'products.product_imagesID')->
        orderBy('products.price', 'asc')->
        get();
        $Count_cart = Cart::join('user_login', 'user_login.id', '=', 'cart.user_id')->
        join('products', 'products.id', '=', 'cart.product_id')->
        join('product_images', 'product_images.id', '=', 'products.product_imagesID')->
        where('user_login.id', '=', auth('user')->id())->count();
        $comments_count = Comments::join('user_login', 'user_login.id', '=', 'comments.user_id')->
        where('comments.product_id', $id)->count();
        $settings= settings_website::all();
        return view('Website.SingleProduct', compact(['settings','NewestProducts','comments_count','comments', 'RelatedProducts', 'Count_cart']));
    }

    public function postcomments(Request $request)
    {
        try {
            $token = auth('user')->id();
            if ($token) {
                $rules = [
                    'comment' => 'required',
                    "user_id" => "required",
                    "product_id" => "required"
                ];
                $validator = Validator::make($request->all(), $rules);
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator);
                }
                Comments::create([
                    'comment' => $request->comment,
                    'rating' => $request->rating,
                    'user_id' => $request->user_id,
                    'product_id' => $request->product_id
                ]);
                return back()->with('error', "The comment has been added");

            } else {
                return back()->with('error', 'Please Login');
            }
        } catch (\Exception $ex) {
            return back()->with('error', $ex->getMessage());
        }

    }

    public function CartIndex()
    {
        $Products_Cart = Cart::join('user_login', 'user_login.id', '=', 'cart.user_id')->
        join('products', 'products.id', '=', 'cart.product_id')->
        join('product_images', 'product_images.id', '=', 'products.product_imagesID')->
        get(['cart.id', 'cart.product_id', 'cart.quantity', 'cart.Sub_total', 'products.title',
            'products.price', 'product_images.path']);
        $Count_cart = Cart::join('user_login', 'user_login.id', '=', 'cart.user_id')->
        join('products', 'products.id', '=', 'cart.product_id')->
        join('product_images', 'product_images.id', '=', 'products.product_imagesID')->
        where('user_login.id', '=', auth('user')->id())->count();
        $total_price = Cart::join('user_login', 'user_login.id', '=', 'cart.user_id')->
        select('cart.Sub_total')->where('user_login.id', '=', auth('user')->id())->sum('cart.Sub_total');
        $settings= settings_website::all();
        return view('Website.Cart', compact(['settings','Products_Cart', 'Count_cart', 'total_price']));
    }

    public function AddItemToCard($product_id, $user_id = null, $total = null, $quantity = 1)
    {

        try {
            $token = auth('user')->id();
            $check_productID= Cart::join('user_login','user_login.id','=','cart.user_id')->
                join('products', 'products.id', '=', 'cart.product_id')->
                where('user_login.id','=',auth('user')->id())->where('cart.product_id','=',$product_id)->exists();

            if ($token!=null) {
                if($check_productID==1){
                    return back()->with('error', 'This product is already exists in the your cart');
                } else {
                    Cart::create([
                        'product_id' => $product_id,
                        'user_id' => $user_id,
                        'quantity' => $quantity,
                        'Sub_total' => $total
                    ]);
                    return back()->with('success', "Added");
                }
            } else {
                return back()->with('error', 'Please Login');
            }
        } catch (\Exception $ex) {
            return back()->with('error', $ex->getMessage());
        }

    }

    public function TruncateCart()
    {
        Cart::truncate()->where('user_login.id', '=', auth('user')->id());
        return back()->with('success', 'Now, The cart is empty');
    }

    public function deleteitemcart($id)
    {
        Cart::destroy($id);
        return back()->with('success', "The item has been deleted");
    }

    ###############################################################
    public function checkout_view()
    {
        $Count_cart = Cart::join('user_login', 'user_login.id', '=', 'cart.user_id')->
        join('products', 'products.id', '=', 'cart.product_id')->
        join('product_images', 'product_images.id', '=', 'products.product_imagesID')->
        where('user_login.id', '=', auth('user')->id())->count();
        $Products_Cart = Cart::join('user_login', 'user_login.id', '=', 'cart.user_id')->
        join('products', 'products.id', '=', 'cart.product_id')->
        join('product_images', 'product_images.id', '=', 'products.product_imagesID')->
        get(['cart.id', 'cart.product_id', 'cart.quantity', 'cart.Sub_total', 'products.title',
            'products.price', 'product_images.path']);
        $billing_details = billing_details::join('user_login', 'user_login.id', '=', 'billing_details.user_id')->
        where('billing_details.user_id', '=', auth('user')->id())->get();

        $count_checkout = billing_details::join('user_login', 'user_login.id', '=', 'billing_details.user_id')->
        where('billing_details.user_id', '=', auth('user')->id())->count();

        $settings= settings_website::all();

        $total_price = Cart::join('user_login', 'user_login.id', '=', 'cart.user_id')->
        select('cart.Sub_total')->where('user_login.id', '=', auth('user')->id())->sum('cart.Sub_total');
        if (auth('user')->id()) {
            if ($Count_cart == 0) {
                return redirect('/Cart')->with('error', 'Please add one item at least to go to the checkout');
            } else {

                return view('Website.CheckOut', compact(['settings','Count_cart', 'total_price', 'count_checkout', 'Products_Cart', 'billing_details']));
            }
        } else {
            return redirect('/Cart')->with('error', 'Please login to your account');
        }
    }

    public function update_billing_details(Request $request)
    {
        try {
            $find_id = billing_details::join('user_login', 'user_login.id', '=', 'billing_details.user_id')->
            where('billing_details.user_id', '=', auth('user')->id())->exists();
            if ($find_id == 1) {
                $update_billing_details = billing_details::join('user_login', 'user_login.id', '=', 'billing_details.user_id')->
                where('billing_details.user_id', '=', auth('user')->id())->first(['billing_details.id']);
                $update_billing_details->full_name = $request->full_name;
                $update_billing_details->phone1 = $request->phone1;
                $update_billing_details->phone2 = $request->phone2;
                $update_billing_details->country = $request->country;
                $update_billing_details->city = $request->city;
                $update_billing_details->zip_code = $request->zip_code;
                $update_billing_details->full_address = $request->full_address;
                $update_billing_details->notes = $request->notes;
                $update_billing_details->payment_method = $request->payment_method;
                $update_billing_details->save();
                //handle the order

                $order = Cart::join('billing_details', 'billing_details.user_id', '=', 'cart.user_id')->distinct()->
                get(['billing_details.id']);
                $total_invoice = Cart::join('user_login', 'user_login.id', '=', 'cart.user_id')->
                select('cart.Sub_total')->where('user_login.id', '=', auth('user')->id())->sum('cart.Sub_total');
                $Count_cart = Cart::join('user_login', 'user_login.id', '=', 'cart.user_id')->
                join('products', 'products.id', '=', 'cart.product_id')->
                join('product_images', 'product_images.id', '=', 'products.product_imagesID')->
                where('user_login.id', '=', auth('user')->id())->count();
                foreach ($order as $orders) {
                    orders::create([
                        'user_id' => auth('user')->id(),
                        'total_invoice' => $total_invoice,
                        'billing_details_ID' => $orders->id,
                        'items' => $Count_cart,
                        'status' => 0
                    ]);
                }
                Cart::truncate()->where('user_login.id', '=', auth('user')->id());

                return redirect('/Cart')->with('success', "Your order has been Sent");

            } else {
                $rules = [
                    'user_id' => 'required',
                    'full_name' => 'required',
                    'phone1' => 'required',
                    'city' => 'required',
                    'country' => 'required',
                    'zip_code' => 'required',
                    'full_address' => 'required',
                    'payment_method' => 'required',
                ];
                $validator = Validator::make($request->all(), $rules);
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator);
                } else {
                    if ($request->payment_method == 'cash') {
                        $cash = $request->payment_method = 'cash';
                        billing_details::create([
                            'user_id' => $request->user_id,
                            'full_name' => $request->full_name,
                            'phone1' => $request->phone1,
                            'phone2' => $request->phone2,
                            'country' => $request->country,
                            'city' => $request->city,
                            'zip_code' => $request->zip_code,
                            'full_address' => $request->full_address,
                            'notes' => $request->notes,
                            'payment_method' => $cash,
                        ]);
                        //handle the order

                        $order = Cart::join('billing_details', 'billing_details.user_id', '=', 'cart.user_id')->distinct()->
                        get(['billing_details.id']);
                        $total_invoice = Cart::join('user_login', 'user_login.id', '=', 'cart.user_id')->
                        select('cart.Sub_total')->where('user_login.id', '=', auth('user')->id())->sum('cart.Sub_total');
                        $Count_cart = Cart::join('user_login', 'user_login.id', '=', 'cart.user_id')->
                        join('products', 'products.id', '=', 'cart.product_id')->
                        join('product_images', 'product_images.id', '=', 'products.product_imagesID')->
                        where('user_login.id', '=', auth('user')->id())->count();
                        foreach ($order as $orders) {
                            orders::create([
                                'user_id' => auth('user')->id(),
                                'total_invoice' => $total_invoice,
                                'billing_details_ID' => $orders->id,
                                'items' => $Count_cart,
                                'status' => 0
                            ]);
                        }
                        Cart::truncate()->where('user_login.id', '=', auth('user')->id());

                        return redirect('/Cart')->with('success', "Your order has been Sent");

                    } else {
                        $paypal = $request->payment_method = 'paypal';
                        billing_details::create([
                            'user_id' => $request->user_id,
                            'full_name' => $request->full_name,
                            'phone1' => $request->phone1,
                            'phone2' => $request->phone2,
                            'country' => $request->country,
                            'city' => $request->city,
                            'zip_code' => $request->zip_code,
                            'full_address' => $request->full_address,
                            'notes' => $request->notes,
                            'payment_method' => $paypal,
                        ]);
                        ///handle the order
                        ///
                        $order = Cart::join('billing_details', 'billing_details.user_id', '=', 'cart.user_id')->distinct()->
                        get(['billing_details.id']);
                        $total_invoice = Cart::join('user_login', 'user_login.id', '=', 'cart.user_id')->
                        select('cart.Sub_total')->where('user_login.id', '=', auth('user')->id())->sum('cart.Sub_total');
                        $Count_cart = Cart::join('user_login', 'user_login.id', '=', 'cart.user_id')->
                        join('products', 'products.id', '=', 'cart.product_id')->
                        join('product_images', 'product_images.id', '=', 'products.product_imagesID')->
                        where('user_login.id', '=', auth('user')->id())->count();
                        foreach ($order as $orders) {
                            orders::create([
                                'user_id' => auth('user')->id(),
                                'total_invoice' => $total_invoice,
                                'billing_details_ID' => $orders->id,
                                'items' => $Count_cart,
                                'status' => 0
                            ]);
                        }
                        Cart::truncate()->where('user_login.id', '=', auth('user')->id());

                        return redirect('/Cart')->with('success', "Your order has been Sent");
                    }
                }
            }
        } catch (\Exception $ex) {
            return back()->with('error', $ex->getMessage());
        }


    }

    public function view_account()
    {
        $Count_cart = Cart::join('user_login', 'user_login.id', '=', 'cart.user_id')->
        join('products', 'products.id', '=', 'cart.product_id')->
        join('product_images', 'product_images.id', '=', 'products.product_imagesID')->
        where('user_login.id', '=', auth('user')->id())->count();

        $settings= settings_website::all();

        $orders = orders::join('user_login', 'user_login.id', '=', 'orders.user_id')->where('orders.user_id', '=', auth('user')->id())
            ->get(['orders.created_at', 'orders.id', 'orders.status', 'orders.total_invoice', 'orders.items']);

        $account_info = billing_details::join('user_login', 'user_login.id', '=', 'billing_details.user_id')->
        where('billing_details.user_id', '=', auth('user')->id())->get();


        return view('Website.Profile', compact('settings','Count_cart', 'orders', 'account_info'));
    }

    public function update_info(Request $request)
    {
        $update_info = billing_details::join('user_login', 'user_login.id', '=', 'billing_details.user_id')->
        where('billing_details.user_id', '=', auth('user')->id())->first(['billing_details.id']);
        $update_info->full_name = $request->full_name;
        $update_info->phone1 = $request->phone1;
        $update_info->phone2 = $request->phone2;
        $update_info->country = $request->country;
        $update_info->city = $request->city;
        $update_info->zip_code = $request->zip_code;
        $update_info->full_address = $request->full_address;
        $update_info->save();
        return back()->with('success', 'The account info has been updated');
    }

    public function GetPopularProducts()
    {
        $NewestProducts = Comments::
        join('products', 'products.id', '=', 'comments.product_id')->
        join('categories', 'categories.id', '=', 'products.category_id')->
        join('sub-category', 'sub-category.id', '=', 'products.sub_category_id')->
        join('product_images', 'product_images.id', '=', 'products.product_imagesID')->
        where('comments.rating', '>=', 2)->
        groupBy('comments.product_id')->
        get(['products.id', 'categories.category', 'sub-category.sub_category_name', 'products.title', 'products.price',
            'products.short_description', 'product_images.path', 'comments.rating']);
        return $this->returnData("done", $NewestProducts);
    }

#########################################
    public function about_view()
    {
        $Count_cart = Cart::join('user_login', 'user_login.id', '=', 'cart.user_id')->
        join('products', 'products.id', '=', 'cart.product_id')->
        join('product_images', 'product_images.id', '=', 'products.product_imagesID')->
        where('user_login.id', '=', auth('user')->id())->count();
        $settings= settings_website::all();
        return view('Website.About_Us', compact(['settings','Count_cart']));
    }

    public function contact_view()
    {
        $Count_cart = Cart::join('user_login', 'user_login.id', '=', 'cart.user_id')->
        join('products', 'products.id', '=', 'cart.product_id')->
        join('product_images', 'product_images.id', '=', 'products.product_imagesID')->
        where('user_login.id', '=', auth('user')->id())->count();
        $settings= settings_website::all();
        return view('Website.Contact_Us', compact(['settings','Count_cart']));
    }

    public function send_mail(Request $request)
    {
        try {
            $rules = [
                'first_name' => 'required',
                "email" => "required",
                "phone" => "required",
                "subject" => "required",
                "message" => "required",
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator);
            }
            contact_us::create([
                'first_name' => $request->first_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'subject' => $request->subject,
                'message' => $request->message,

            ]);
            return back()->with('success', "The mail has been sent");

        } catch (\Exception $ex) {
            return back()->with('error', $ex->getMessage());
        }
    }
    ####################

    public function search_result(Request $request)
    {

        if ($request->get('sort') == "price_asc") {

            $NewestProducts= products::join('categories','categories.id','=','products.category_id')->
            join('sub-category','sub-category.id','=','products.sub_category_id')->
            join('product_images','product_images.id','=','products.product_imagesID')->
            where('products.title','LIKE','%'.$request->search.'%')->orderBy('products.price', 'asc')->
            paginate(15);
            $Count_cart = Cart::join('user_login', 'user_login.id', '=', 'cart.user_id')->
            join('products', 'products.id', '=', 'cart.product_id')->
            join('product_images', 'product_images.id', '=', 'products.product_imagesID')->
            where('user_login.id', '=', auth('user')->id())->count();

            $count =products::join('categories','categories.id','=','products.category_id')->
            join('sub-category','sub-category.id','=','products.sub_category_id')->
            join('product_images','product_images.id','=','products.product_imagesID')->
            where('products.title','LIKE','%'.$request->search.'%')->count();

            $popular_products = Comments::
            join('products', 'products.id', '=', 'comments.product_id')->
            join('categories', 'categories.id', '=', 'products.category_id')->
            join('sub-category', 'sub-category.id', '=', 'products.sub_category_id')->
            join('product_images', 'product_images.id', '=', 'products.product_imagesID')->
            where('comments.rating', '>=', 2)->
            groupBy('comments.product_id')->get();

            $settings= settings_website::all();

            $categories = categories::select('id', 'category')->get();
            foreach ($categories as $singlecat) {
                $sub[$singlecat->category] = sub_categories::where('category_id', $singlecat->id)->get();
            }
            return view('Website.Search_result', compact(['NewestProducts','categories','settings', 'popular_products', 'count', 'Count_cart']));

        } elseif ($request->get('sort') == "price_desc") {

            $NewestProducts= products::join('categories','categories.id','=','products.category_id')->
            join('sub-category','sub-category.id','=','products.sub_category_id')->
            join('product_images','product_images.id','=','products.product_imagesID')->
            where('products.title','LIKE','%'.$request->search.'%')->
            orderBy('products.price', 'desc')->
            paginate(15);

            $count =products::join('categories','categories.id','=','products.category_id')->
            join('sub-category','sub-category.id','=','products.sub_category_id')->
            join('product_images','product_images.id','=','products.product_imagesID')->
            where('products.title','LIKE','%'.$request->search.'%')->count();

            $Count_cart = Cart::join('user_login', 'user_login.id', '=', 'cart.user_id')->
            join('products', 'products.id', '=', 'cart.product_id')->
            join('product_images', 'product_images.id', '=', 'products.product_imagesID')->
            where('user_login.id', '=', auth('user')->id())->count();

            $popular_products = Comments::
            join('products', 'products.id', '=', 'comments.product_id')->
            join('categories', 'categories.id', '=', 'products.category_id')->
            join('sub-category', 'sub-category.id', '=', 'products.sub_category_id')->
            join('product_images', 'product_images.id', '=', 'products.product_imagesID')->
            where('comments.rating', '>=', 2)->
            groupBy('comments.product_id')->get();
            $settings= settings_website::all();

            $categories = categories::select('id', 'category')->get();
            foreach ($categories as $singlecat) {
                $sub[$singlecat->category] = sub_categories::where('category_id', $singlecat->id)->get();
            }

            return view('Website.Search_result', compact(['NewestProducts','categories','settings', 'popular_products', 'count', 'Count_cart']));

        } elseif ($request->get('sort') == "product_oldest") {

            $NewestProducts= products::join('categories','categories.id','=','products.category_id')->
            join('sub-category','sub-category.id','=','products.sub_category_id')->
            join('product_images','product_images.id','=','products.product_imagesID')->
            where('products.title','LIKE','%'.$request->search.'%')->
            orderBy('products.created_at', 'asc')->
            paginate(15);
            $count =products::join('categories','categories.id','=','products.category_id')->
            join('sub-category','sub-category.id','=','products.sub_category_id')->
            join('product_images','product_images.id','=','products.product_imagesID')->
            where('products.title','LIKE','%'.$request->search.'%')->count();

            $Count_cart = Cart::join('user_login', 'user_login.id', '=', 'cart.user_id')->
            join('products', 'products.id', '=', 'cart.product_id')->
            join('product_images', 'product_images.id', '=', 'products.product_imagesID')->
            where('user_login.id', '=', auth('user')->id())->count();

            $popular_products = Comments::
            join('products', 'products.id', '=', 'comments.product_id')->
            join('categories', 'categories.id', '=', 'products.category_id')->
            join('sub-category', 'sub-category.id', '=', 'products.sub_category_id')->
            join('product_images', 'product_images.id', '=', 'products.product_imagesID')->
            where('comments.rating', '>=', 2)->
            groupBy('comments.product_id')->get();
            $settings= settings_website::all();

            $categories = categories::select('id', 'category')->get();
            foreach ($categories as $singlecat) {
                $sub[$singlecat->category] = sub_categories::where('category_id', $singlecat->id)->get();
            }

            return view('Website.Search_result', compact(['NewestProducts','categories','settings', 'popular_products', 'count', 'Count_cart']));
        } elseif ($request->get('sort') == "product_newest") {

            $NewestProducts= products::join('categories','categories.id','=','products.category_id')->
            join('sub-category','sub-category.id','=','products.sub_category_id')->
            join('product_images','product_images.id','=','products.product_imagesID')->
            where('products.title','LIKE','%'.$request->search.'%')->
            orderBy('products.created_at', 'desc')->
            paginate(15);

            $count =products::join('categories','categories.id','=','products.category_id')->
            join('sub-category','sub-category.id','=','products.sub_category_id')->
            join('product_images','product_images.id','=','products.product_imagesID')->
            where('products.title','LIKE','%'.$request->search.'%')->count();

            $Count_cart = Cart::join('user_login', 'user_login.id', '=', 'cart.user_id')->
            join('products', 'products.id', '=', 'cart.product_id')->
            join('product_images', 'product_images.id', '=', 'products.product_imagesID')->
            where('user_login.id', '=', auth('user')->id())->count();

            $popular_products = Comments::
            join('products', 'products.id', '=', 'comments.product_id')->
            join('categories', 'categories.id', '=', 'products.category_id')->
            join('sub-category', 'sub-category.id', '=', 'products.sub_category_id')->
            join('product_images', 'product_images.id', '=', 'products.product_imagesID')->
            where('comments.rating', '>=', 2)->
            groupBy('comments.product_id')->get();

            $settings= settings_website::all();

            $categories = categories::select('id', 'category')->get();
            foreach ($categories as $singlecat) {
                $sub[$singlecat->category] = sub_categories::where('category_id', $singlecat->id)->get();
            }

            return view('Website.Search_result', compact(['settings','categories','NewestProducts', 'popular_products', 'count', 'Count_cart']));
        } elseif ($request->get('sort') == "lowest_rating") {

            $NewestProducts = Comments::
            join('products', 'products.id', '=', 'comments.product_id')->
            join('categories', 'categories.id', '=', 'products.category_id')->
            join('sub-category', 'sub-category.id', '=', 'products.sub_category_id')->
            join('product_images', 'product_images.id', '=', 'products.product_imagesID')->
            where('comments.rating', '<=', 2)->where('products.title','LIKE','%'.$request->search.'%')->groupBy('comments.product_id')->paginate(15);
            $count =products::join('categories','categories.id','=','products.category_id')->
            join('sub-category','sub-category.id','=','products.sub_category_id')->
            join('product_images','product_images.id','=','products.product_imagesID')->
            where('products.title','LIKE','%'.$request->search.'%')->count();

            $Count_cart = Cart::join('user_login', 'user_login.id', '=', 'cart.user_id')->
            join('products', 'products.id', '=', 'cart.product_id')->
            join('product_images', 'product_images.id', '=', 'products.product_imagesID')->
            where('user_login.id', '=', auth('user')->id())->count();

            $popular_products = Comments::
            join('products', 'products.id', '=', 'comments.product_id')->
            join('categories', 'categories.id', '=', 'products.category_id')->
            join('sub-category', 'sub-category.id', '=', 'products.sub_category_id')->
            join('product_images', 'product_images.id', '=', 'products.product_imagesID')->
            where('comments.rating', '>=', 2)->
            groupBy('comments.product_id')->get();
            $settings= settings_website::all();

            $categories = categories::select('id', 'category')->get();
            foreach ($categories as $singlecat) {
                $sub[$singlecat->category] = sub_categories::where('category_id', $singlecat->id)->get();
            }

            return view('Website.Search_result', compact(['settings','categories','NewestProducts', 'popular_products', 'count', 'Count_cart']));
        } elseif ($request->get('sort') == "highest_rating") {

            $NewestProducts = Comments::
            join('products', 'products.id', '=', 'comments.product_id')->
            join('categories', 'categories.id', '=', 'products.category_id')->
            join('sub-category', 'sub-category.id', '=', 'products.sub_category_id')->
            join('product_images', 'product_images.id', '=', 'products.product_imagesID')->
            where('comments.rating', '>=', 2)->where('products.title','LIKE','%'.$request->search.'%')->groupBy('comments.product_id')->paginate(15);
            $Count_cart = Cart::join('user_login', 'user_login.id', '=', 'cart.user_id')->
            join('products', 'products.id', '=', 'cart.product_id')->
            join('product_images', 'product_images.id', '=', 'products.product_imagesID')->
            where('user_login.id', '=', auth('user')->id())->count();
            $count =products::join('categories','categories.id','=','products.category_id')->
            join('sub-category','sub-category.id','=','products.sub_category_id')->
            join('product_images','product_images.id','=','products.product_imagesID')->
            where('products.title','LIKE','%'.$request->search.'%')->count();

            $popular_products = Comments::
            join('products', 'products.id', '=', 'comments.product_id')->
            join('categories', 'categories.id', '=', 'products.category_id')->
            join('sub-category', 'sub-category.id', '=', 'products.sub_category_id')->
            join('product_images', 'product_images.id', '=', 'products.product_imagesID')->
            where('comments.rating', '>=', 2)->
            groupBy('comments.product_id')->get();
            $settings= settings_website::all();

            $categories = categories::select('id', 'category')->get();
            foreach ($categories as $singlecat) {
                $sub[$singlecat->category] = sub_categories::where('category_id', $singlecat->id)->get();
            }
            return view('Website.Search_result', compact(['settings','categories','NewestProducts', 'popular_products', 'count', 'Count_cart']));
        } else {
            $NewestProducts= products::join('categories','categories.id','=','products.category_id')->
            join('sub-category','sub-category.id','=','products.sub_category_id')->
            join('product_images','product_images.id','=','products.product_imagesID')->
            where('products.title','LIKE','%'.$request->search.'%')->
            orderBy('products.created_at', 'desc')->
            paginate(15);
            $count =products::join('categories','categories.id','=','products.category_id')->
            join('sub-category','sub-category.id','=','products.sub_category_id')->
            join('product_images','product_images.id','=','products.product_imagesID')->
            where('products.title','LIKE','%'.$request->search.'%')->count();

            $categories = categories::all();
            $Count_cart = Cart::join('user_login', 'user_login.id', '=', 'cart.user_id')->
            join('products', 'products.id', '=', 'cart.product_id')->
            join('product_images', 'product_images.id', '=', 'products.product_imagesID')->
            where('user_login.id', '=', auth('user')->id())->count();
            $popular_products = Comments::
            join('products', 'products.id', '=', 'comments.product_id')->
            join('categories', 'categories.id', '=', 'products.category_id')->
            join('sub-category', 'sub-category.id', '=', 'products.sub_category_id')->
            join('product_images', 'product_images.id', '=', 'products.product_imagesID')->
            where('comments.rating', '>=', 2)->
            groupBy('comments.product_id')->get();

            $settings= settings_website::all();

            $categories = categories::select('id', 'category')->get();
            foreach ($categories as $singlecat) {
                $sub[$singlecat->category] = sub_categories::where('category_id', $singlecat->id)->get();
            }
            return view('Website.Search_result', compact(['settings','NewestProducts', 'Count_cart', 'count', 'popular_products', 'categories', 'sub']));
        }
    }

    public function update_account(Request $request){
       $update_account= user_login::find(auth('user')->id());
       $update_account->username= $request->username;
       $update_account->email=$request->email;
       $update_account->password= Hash::make($request->password);
       $update_account->save();
       return back()->with('success','The info of your account has been updated');
    }
    public function generate_pdf(){
        $orders = orders::join('user_login', 'user_login.id', '=', 'orders.user_id')->where('orders.user_id', '=', auth('user')->id())
            ->get(['orders.created_at', 'orders.id', 'orders.status', 'orders.total_invoice', 'orders.items']);
        $pdf = PDF::loadView('Website.generate_pdf', compact('orders'));
        return $pdf->download('invoices.pdf');
    }
}
