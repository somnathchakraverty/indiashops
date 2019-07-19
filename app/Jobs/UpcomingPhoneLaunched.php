<?php

namespace indiashopps\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Cache;
use indiashopps\Category;
use indiashopps\Models\UpcomingSubscriber;
use indiashopps\Support\SolrClient\Facade\Solr;
use SendGrid\Mail\Content;
use SendGrid\Mail\From;
use SendGrid\Mail\Mail;
use SendGrid\Mail\Personalization;
use SendGrid\Mail\SendAt;
use SendGrid\Mail\To;

class UpcomingPhoneLaunched implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $product_id;

    /**
     * Create a new job instance.
     *
     * @param $product_id
     */
    public function __construct($product_id)
    {
        $this->product_id = $product_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $sub_query = UpcomingSubscriber::whereProductId($this->product_id)
                                       ->whereNotified(UpcomingSubscriber::USER_NOT_NOTIFIED);

        if ($sub_query->count() > 0) {

            $solr    = Solr::getInstance();
            $product = $solr->wherePid($this->product_id)->getProduct(true);
            $product = $product->product_detail;

            if (isset($product->description)) {
                unset($product->description);
                unset($product->desc_json);
            }

            $this->sendTransactionalEmail($product, $sub_query->get());
        }
    }

    /**
     * @param $product
     * @param $subscribers
     * @return bool
     * @throws \Exception
     */
    protected function sendTransactionalEmail($product, $subscribers)
    {
        if (env('SENDGRID_API_KEY', false) === false) {
            throw new \Exception("Send Grid API Key Missing..!!");
        }

        $from = new From(env('MAIL_USERNAME'), 'Indiashopps');

        $mail = new Mail($from, null);
        $mail->setSubject($product->name . " Launch Notification");

        foreach ($subscribers as $subscriber) {
            $to              = new To($subscriber->email, "User");
            $personalization = $this->addPersonalization($product);
            $personalization->addTo($to);
            $mail->addPersonalization($personalization);

            $subscriber->notified = UpcomingSubscriber::USER_NOTIFIED;
            $subscriber->save();
        }
        $mail->setTemplateId('09b23176-34c7-408b-a465-ee2d60db272f');

        $sendGrid = new \SendGrid(env('SENDGRID_API_KEY'));
        $sendGrid->client->mail()->send()->post($mail);
    }

    /**
     * @param $product
     * @return Personalization
     */
    private function addPersonalization($product)
    {
        $personalization = new Personalization();
        $personalization->addDynamicTemplateData(':product_price!', (string)number_format($product->saleprice));
        $personalization->addDynamicTemplateData(':product_name!', (string)($product->name));

        if (isset($product->mini_spec)) {
            $specs     = array_filter(explode(";", $product->mini_spec));
            $spec_html = '';
            $count     = count($specs);

            foreach ($specs as $key => $spec) {
                if (($key + 1) % 2 == 1) {
                    $spec_html .= '<tr>';
                }

                $spec_html .= '<td align="left" valign="middle">' . $spec . '</td>';

                if (($key + 1) % 2 == 0) {
                    $spec_html .= '</tr>';
                    if (($key + 1) != $count) {
                        $spec_html .= '<tr>';
                    }
                }
            }

            if (isset($key) && ($key + 1) % 2 == 1) {
                $spec_html .= '</tr>';
            }

            $personalization->addDynamicTemplateData(':mini_specs!', $spec_html);
        }

        $product_image = getImageNew($product->image_url, 'M');

        if (stripos($product_image, "http") == false && stripos($product_image, "indiashopps") != false) {
            $product_image = "https:" . $product_image;
        }

        if (isset($product->release_date)) {
            $release_date = (string)$product->release_date;
        } else {
            $release_date = "Recently";
        }

        $personalization->addDynamicTemplateData(':launch_date!', $release_date);
        $personalization->addDynamicTemplateData(':product_image!', $product_image);
        $personalization->addDynamicTemplateData(':product_url!', product_url($product));
        $personalization->addDynamicTemplateData(':product_vendor!', config('vendor.name.' . $product->lp_vendor));

        try {
            if (Cache::has('listing_page_upcoming_mobiles')) {
                $result   = json_decode(Cache::get('listing_page_upcoming_mobiles'));
                $upcoming = collect($result->return_txt->hits->hits)->take(4);
            } else {
                $solr     = Solr::getInstance();
                $result   = $solr->whereAvailability('Coming Soon')
                                 ->whereCategoryId(Category::MOBILE)
                                 ->take(4)
                                 ->getSearch(true);
                $upcoming = collect($result->return_txt->hits->hits);
            }
            $upcoming_html = '';

            if ($upcoming->count() > 0) {

                foreach ($upcoming as $product) {
                    if (isset($product->_source)) {
                        $product = $product->_source;
                    }

                    $upcoming_html .= "<a href='" . product_url($product) . "'>$product->name</a>";
                }
            }

            $personalization->addDynamicTemplateData(':upcoming_mobiles!', $upcoming_html);
        }
        catch (\Exception $e) {
            \Log::error($e->getMessage() . "::" . $e->getTraceAsString());
        }

        return $personalization;
    }
}