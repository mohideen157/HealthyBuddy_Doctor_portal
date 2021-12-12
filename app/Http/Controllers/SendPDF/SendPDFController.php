<?php

namespace App\Http\Controllers\SendPDF;

use Mail;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PDO;
use App;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Settings;
use App\Model\Medcheck\medcheckuser;
use App\Model\Medcheck\medcheckuserstable;
use App\Model\Medcheck\medcheckecgdata;
use App\Model\Medcheck\medcheckweightscale;
use App\Model\Medcheck\medcheckspo2;
use App\Model\Medcheck\medchecktemparature;
use App\Model\Medcheck\medcheckglucosedata;
use App\Model\Insurance\insurancenumber;
use DB;
use ZipArchive;
use DateTime;


//use App\Http\Controllers\Carbon;

//use App\Http\Controllers\PDF;

//use PHPMailer\PHPMailer\PHPMailer;

class SendPDFController extends Controller
{
    public function __construct(){
        $this->connect = new PDO("mysql:host=localhost;dbname=c2pwoocommerce", "root", "P@ssw0rd");   
        //$this->user = $user;  
    }	
    /*public function Download($id)
    {
        $users1 = insurancenumber::where('user_id',$id)->first();
        if ($users1->is_active != 1)
       {
            //alert()->success('Created Successfully', 'Success');
            

      
            $users = insurancenumber::where('user_id',$id)->first();
            $users1 = medcheckuserstable::where('id',$id)->first();
            $insurance = insurancenumber::where('user_id',$id)->first();
            $insurance->is_active = '1';
            $status = $insurance->save();
            DB::commit();
            $pdf = \PDF::loadView('download',compact('users','users1'));

            
            return $pdf->download('test.pdf'); 
              }

    }*/

    public function SendPDFemailWoo(Request $request)
    {
        $orderid = $request->get("order_id");
        $total_qty = $this->connect->query("select product_qty from wp_wc_order_product_lookup where order_id=$orderid");
        $qty = $total_qty->fetch();
             
        //echo 'total_qty='.$qty[0];
        //$users = insurancenumber::where('insur_code','adityabirla')->first();
    for($i=1;$i<=$qty[0];$i++)
     {
        $users = insurancenumber::where('insur_code','adityabirla')
        ->where('is_active','0')
        ->first();
        
    if ($users)
    {
          
     $item_qty = $qty[0];  
     $name="'insuredperson_name$i'";
     $sex="'insuredperson_sex$i'";
     $dob="'insuredperson_dob$i'";
     $relationship="'insuredperson_relationship$i'";

     $insuredpersonname = $this->connect->query("SELECT meta_value FROM wp_postmeta where post_id=$orderid and meta_key=$name");
     $insuredname = $insuredpersonname->fetch();

     $insuredpersonsex = $this->connect->query("SELECT meta_value FROM wp_postmeta where post_id=$orderid and meta_key=$sex");
     $insuredsex = $insuredpersonsex->fetch();

     $insuredpersondob = $this->connect->query("SELECT meta_value FROM wp_postmeta where post_id=$orderid and meta_key=$dob");
     $insureddob = $insuredpersondob->fetch();

     $billingaddress = $this->connect->query("SELECT meta_value FROM wp_postmeta where post_id=$orderid and meta_key='_billing_address_1'");
     $billingaddress1 = $billingaddress->fetch();
     
     $billingcity = $this->connect->query("SELECT meta_value FROM wp_postmeta where post_id=$orderid and meta_key='_billing_city'");
     $billingcity1 = $billingcity->fetch();
     
     $billingstate = $this->connect->query("SELECT meta_value FROM wp_postmeta where post_id=$orderid and meta_key='_billing_state'");
     $billingstate1 = $billingstate->fetch();
     
     $billingpostcode = $this->connect->query("SELECT meta_value FROM wp_postmeta where post_id=$orderid and meta_key='_billing_postcode'");
     $billingpostcode1 = $billingpostcode->fetch();
     
     $billingcountry = $this->connect->query("SELECT meta_value FROM wp_postmeta where post_id=$orderid and meta_key='_billing_country'");
     $billingcountry1 = $billingcountry->fetch();
     
     $billingemail = $this->connect->query("SELECT meta_value FROM wp_postmeta where post_id=$orderid and meta_key='_billing_email'");
     $billingemail1 = $billingemail->fetch();
     
     $billingphone = $this->connect->query("SELECT meta_value FROM wp_postmeta where post_id=$orderid and meta_key='_billing_phone'");
     $billingphone1 = $billingphone->fetch();
     
     $insuredpersonrelationship = $this->connect->query("SELECT meta_value FROM wp_postmeta where post_id=$orderid and meta_key=$relationship");
     $insuredpersonrelationship1 = $insuredpersonrelationship->fetch();

     $insuredpersonnominee = $this->connect->query("SELECT meta_value FROM wp_postmeta where post_id=$orderid and meta_key='insuredperson_nominee'");
     $insuredpersonnominee1 = $insuredpersonnominee->fetch();

     $product_net = $this->connect->query("select product_net_revenue from wp_wc_order_product_lookup where order_id=$orderid");
     $product_net_revenue = $product_net->fetch();
     
     //$itm_qty = $this->connect->query("select product_qty from wp_wc_order_product_lookup where order_id=$orderid");
     //$item_qty = $itm_qty->fetch();

     $tax = $this->connect->query("select tax_amount from wp_wc_order_product_lookup where order_id=$orderid");
     $tax_amount = $tax->fetch();
     $tax_amount1 = $tax_amount[0]/$item_qty;
     $CGST = '';
     $SGST = '';
     $IGST = '';
     if($billingstate1[0] == 'DL'){        
        $CGST = $tax_amount1/2;
        $SGST = $tax_amount1/2;
     }
     else{
        $IGST = $tax_amount1;
     }
     $product_gross = $this->connect->query("select product_gross_revenue from wp_wc_order_product_lookup where order_id=$orderid");
     $product_gross_revenue = $product_gross->fetch();
     
     $dt = new DateTime();
     $dt1 = $dt->format('d-m-Y');
     $dt2= date('d-m-Y', strtotime($dt1. ' + 365 days'));
            
    
    $file_ext = md5(rand()) . '.pdf';
    $this->file_name = "C:/C2P/Downloads/".$file_ext;         
    
    $data = array('email' => $request->get("customer_email"), 'client_name' => $request->get("first_name"), 'billing_address' => $request->get("billing_address"), 'subject' => 'Aditya Birla Teleconsulting Policy Cover');
    $pdf = \PDF::loadView('emails.adithyatelepolicypdftemp',compact('insuredname','insuredsex','insureddob','billingaddress1','billingcity1','billingstate1','billingpostcode1','billingcountry1','billingemail1','billingphone1','insuredpersonrelationship1','insuredpersonnominee1','users','product_net_revenue','tax_amount','product_gross_revenue','dt1','dt2','item_qty','CGST','SGST','IGST'));
        
    //$pdf = \PDF::loadView('emails.adithyatelepolicypdftemp', $data);
        //file_put_contents(storage_path().$this->file_name, $pdf);
        //return $pdf->download('adithyatelepolicypdf.pdf');
    $pdf->save($this->file_name);
    // Send Email
    Mail::send('emails.adithyatelepolicypdf', $data, function($message)use($data,$pdf) {
        $message->to($data["email"])
        ->subject($data["subject"])
        ->attach($this->file_name);
        });
        //->attachData($pdf->output(), "TELECONSULTATION_POLICYCOVER.PDF");  
        //->attach($this->file_name);  
      
     //$insurance = insurancenumber::whereapplication_no($users->application_no);
     $users->is_active = '1';
     $users->misc1 = $orderid;
     $status = $users->save();
     DB::commit();
     
    } //IF end
   }//For Loop End    
    

}   
	
}



	
