<?php

namespace App\Http\Controllers;

use App\Http\Services\Productt\ProducttService;
use App\Models\BienThe;
use App\Models\Comment;
use App\Models\Mau;
use App\Models\Productt;
use App\Models\Size;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $producttService;
    public function __construct(ProducttService $producttService)
    {
        $this->producttService = $producttService;
    }

    // public function index($id = '', $slug = '')
    // {
    //     $productt = $this->producttService->show($id);
    //     $productsMore = $this->producttService->more($id);
        
    //     $hps = $this->producttService->getscaper($id);
        
    //     $hpsh = $this->producttService->getsharp($id);
        
    //     $hpnagakawa = $this->producttService->getnagakawa($id);
        
    //     $hpcomfee = $this->producttService->getcomfee($id);
        
    //     $hptosiba = $this->producttService->gettosiba($id);
        
    //     $hpcasper = $this->producttService->getcasperqc($id);
        
    //     $hpmitsubishi = $this->producttService->getmitsubishi($id);
        
        
    //     $productsize=$this->producttService->getSize($id);
    //     $productmau=$this->producttService->getMau($id);
    //     $productRelated=$this->producttService->getRelated($id);
    //     // dd($productRelated);
    //     $slview=$productt->view;
    //     $slview+=1;
       
    //     Productt::where('id',$productt->id)->update(['view'=>$slview]);
    //     return view('productts.content', [
    //         'title'=>$productt->name,
    //         'productt'=>$productt,
    //         'productts'=>$productsMore,
    //         'sizes'=>$productsize,
    //         'maus'=>$productmau,
    //         'related'=>$productRelated,
    //         'hps'=>$hps,
    //         'hpsh'=>$hpsh,
    //         'hpnagakawas'=>$hpnagakawa,
    //         'hpcomfees'=>$hpcomfee,
    //         'hptosibas'=>$hptosiba,
    //         'hpcaspers_qc'=>$hpcasper,
    //         'hpmitsubishis'=>$hpmitsubishi,
    //     ]);
    // }
    public function index($slug)
    {
        $productt = $this->producttService->show($slug);
        $productsMore = $this->producttService->more($slug);
        // $productsize = $this->producttService->getSize($slug);

        $hps = $this->producttService->getscaper($slug);
        $hpsh = $this->producttService->getsharp($slug);
        $hpnagakawa = $this->producttService->getnagakawa($slug);
        $hpcomfee = $this->producttService->getcomfee($slug);
        $hptosiba = $this->producttService->gettosiba($slug);
        $hpcasper = $this->producttService->getcasperqc($slug);
        $hpmitsubishi = $this->producttService->getmitsubishi($slug);
        $productRelated = $this->producttService->getRelated($slug);

        // Increase view count
        if ($productt) {
            $productt->increment('view');
        }

        // Determine matching variants
        $variants = [];
        if (in_array($productt->id, [140, 139, 138, 137])) {
            $variants = $hps;
        } elseif (in_array($productt->id, [101, 102, 103])) {
            $variants = $hpsh;
        } elseif (in_array($productt->id, [122, 123, 124])) {
            $variants = $hpnagakawa;
        } elseif (in_array($productt->id, [106, 144, 145])) {
            $variants = $hpcomfee;
        } elseif (in_array($productt->id, [17, 24, 25])) {
            $variants = $hptosiba;
        } elseif (in_array($productt->id, [156, 157])) {
            $variants = $hpcasper;
        } elseif (in_array($productt->id, [135, 136])) {
            $variants = $hpmitsubishi;
        }

        $comments = Comment::where('comment_product', $productt->id)->orderBy('id', 'desc')->get();

        return view('productts.content', [
            'title' => $productt ? $productt->name : 'Product Not Found',
            'productt' => $productt,
            'productts' => $productsMore,
            'variants' => $variants,
            'comments' => $comments,
            // 'productsize' => $productsize,
            'related' => $productRelated,
            'hps' => $hps,
            'hpsh' => $hpsh,
            'hpnagakawas' => $hpnagakawa,
            'hpcomfees' => $hpcomfee,
            'hptosibas' => $hptosiba,
            'hpcaspers_qc' => $hpcasper,
            'hpmitsubishis' => $hpmitsubishi,
        ]);
    }

   
    public function quickviewAPI(Request $request){
        $data = Productt::where('id',$request->data)->get();
        return response()->json($data);
    }

    public function send_comment(Request $request){
        $product_id = $request->product_id;
        $comment_name = $request->comment_name;
        $comment_ct = $request->comment_ct;

        $comment = new Comment();
        
        $comment->comment_ct = $comment_ct;
        $comment->comment_name = $comment_name;
        $comment->comment_product = $product_id;
        $comment->save();
    }

    public function load_comment(Request $request){
        $product_id = $request->product_id;
        $comment = Comment::where('comment_product', $product_id)->get();
        $show='';
        foreach($comment as $comm){
            $show.= '
            <div class="row style_comment" style="background: #FFFFCC; border-radius:10px; 
                margin-bottom: 20px; border:1px;">
            <div class="col-md-2 mb-img">
                <img src = "/template/images/logo02.png" alt="AVATAR" style="width: 100%;"
                class="img img-responsive img-thumbnail">
            </div>
            <div class="col-md-10">
                <p style="font-weight: bold;">'.$comm->comment_name.' ('.$comm->comment_time.')</p>
                <p>'.$comm->comment_ct.'</p>
            </div>
        </div>
            ';
        }
        echo$show;
    }
  
}
