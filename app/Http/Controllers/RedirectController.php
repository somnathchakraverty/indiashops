<?php
namespace indiashopps\Http\Controllers;

use DB;
use indiashopps\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RedirectController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Logs the request for any product, once user clicks on shop now button.
     *
     * @var \Illuminate\Http\Request
     */
    public function log(Request $request)
    {
        echo "<script> (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){ (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o), m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m) })(window,document,'script','//www.google-analytics.com/analytics.js','ga');  ga('create', 'UA-49111709-1', 'indiashopps.com'); ga('send', 'pageview');</script>";
        $save['ip']          = (isset($_SERVER['HTTP_CF_CONNECTING_IP']) ? $_SERVER['HTTP_CF_CONNECTING_IP'] : 0);//Request::getClientIp();
        $save['country']     = (isset($_SERVER['HTTP_CF_IPCOUNTRY']) ? $_SERVER['HTTP_CF_IPCOUNTRY'] : '');
        $save['product_url'] = $request->input('url');
        $save['vendor']      = ($request->input('vendor_id'));
        $save['_id']         = ($request->input('_id'));
        $save['date']        = time();
        $save['referer']     = 1;

        $product = file_get_contents(composer_url('ext_prod_detail.php?_id=' . $save['_id']));
        $product = json_decode($product);

        // echo  '<pre>';print_r($save);exit;
        if (!empty($save['product_url'])) {
            //print_r($save);exit;
            $arr = [
                'ip'       => $save['ip'],
                'country'  => $save['country'],
                '_id'      => $save['_id'],
                'vendor'   => $save['vendor'],
                'date'     => $save['date'],
                'referer'  => '1',
                'category' => $product->return_txt->grp
            ];
            DB::table('gc_log')->insert($arr);

            ?>
            <script lang="text/javascript">
                window.location.href = "<?php echo $save['product_url'];?>";
            </script>
            <?php
        } else {
            redirect(site_url());
        }
    }

    /**
     * Logs the request for any product on APP.
     *
     * @var Vendor_ID
     */
    function log_app($vendor)
    {
        echo "<script> (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){ (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o), m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m) })(window,document,'script','//www.google-analytics.com/analytics.js','ga');  ga('create', 'UA-49111709-1', 'indiashopps.com'); ga('send', 'pageview');</script>";
        $save['ip'] = $this->input->ip_address();
        //	$save['product_url'] 	= $this->input->get("url");
        $save['vendor']         = $vendor;
        $save['date']           = time();
        $save['referer']        = 2;
        $save['distributer_id'] = $this->input->get("distributer_id");
        //print_r($save);exit;
        if (!empty($save['product_url'])) {
            //print_r($save);exit;
            $this->log_model->save($save);
            //redirect($save['product_url']);
            ?>
            <script lang="text/javascript">
                window.location.href = "<?php echo $this->input->get("url");?>";
            </script>
            <?php
        } else {
            redirect(site_url());
        }
    }

    public function loghotdeal1(Request $request)
    {
        //echo "jjjjjj";
        //exit;

        echo "<script> (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){ (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o), m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m) })(window,document,'script','//www.google-analytics.com/analytics.js','ga');  ga('create', 'UA-49111709-1', 'indiashopps.com'); ga('send', 'pageview');</script>";
        $product_url = urldecode($request->input('url'));
        //exit;
        if (!empty($product_url)) {
            //echo product_url;
            //exit;
            ?>
            <script lang="text/javascript">
                window.location.href = "<?php echo $product_url;?>";
            </script>
            <?php
        } else {
            redirect(site_url());
        }
    }

    /**
     * Used to redirect URLs from Indiashopps to other websites.
     *
     * @var \Illuminate\Http\Request
     * @return Response
     */
    public function send(Request $request)
    {
        $url = urldecode($request->get("url"));
        
        if (!empty($url) && filter_var($url, FILTER_VALIDATE_URL) !== false) {
            $data['redirect_url'] = $url;

            return view("v3.static.fcm_redirect", $data);
        } else {
            return redirect("/");
        }
    }
}