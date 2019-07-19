<?php
namespace indiashopps\Http\Controllers;

use DB;
use helper;
use indiashopps\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ValentineController extends Controller
{

	/**
	 * Shoes listing Under given Min & Max Price
	 */
	public function index()
	{
		return view("v1.valentine.index");
	}

	public function day($day = "rose")
	{

		$data["day"]      = $day;
		$products_for_him = DB::table('gc_valentine_products_stage')
							  ->where('gender', 'M')
							  ->where('ref_id', '<>', '0')
							  ->where('day', "like", config('valentine.name.' . $day))
							  ->lists('ref_id');

		$products_for_him         = file_get_contents(composer_url('query_ids.php?ids=' . json_encode($products_for_him)));
		$data['products_for_him'] = json_decode($products_for_him)->hits->hits;

		$products_for_her         = DB::table('gc_valentine_products_stage')
									  ->where('ref_id', '<>', '0')
									  ->where('gender', 'F')
									  ->where('day', "like", config('valentine.name.' . $day))
									  ->lists('ref_id');

		$products_for_her         = file_get_contents(composer_url('query_ids.php?ids=' . json_encode($products_for_her)));
		$data['products_for_her'] = json_decode($products_for_her)->hits->hits;


		$top_gifted_products         = DB::table('gc_valentine_products_stage')->orderBy("id")->lists('ref_id');
		$top_gifted_products         = file_get_contents(composer_url('query_ids.php?ids=' . json_encode($top_gifted_products)));
		$data['top_gifted_products'] = json_decode($top_gifted_products)->hits->hits;

		$top_popular_gifts         = DB::table('gc_valentine_products_stage')->orderBy("id", "desc")->lists('ref_id');
		$top_popular_gifts         = file_get_contents(composer_url('query_ids.php?ids=' . json_encode($top_popular_gifts)));
		$data['top_popular_gifts'] = json_decode($top_popular_gifts)->hits->hits;

		$latest_prod         = DB::table('gc_valentine_products_stage')->orderBy("id", "desc")->lists('ref_id');
		$latest_prod         = file_get_contents(composer_url('query_ids.php?ids=' . json_encode($latest_prod)));
		$data['latest_prod'] = json_decode($latest_prod)->hits->hits;


		$top_popular_cake         = DB::table('gc_valentine_products')
									  ->where("type", "like", "cake")
									  ->orderBy("id")
									  ->lists('pid');
		$top_popular_cake         = file_get_contents(composer_url('query_ids.php?ids=' . json_encode($top_popular_cake)));
		$data['top_popular_cake'] = json_decode($top_popular_cake)->hits->hits;

		$top_teddy_flower         = DB::table('gc_valentine_products')
									  ->where("type", "like", "teddy_flower")
									  ->orderBy("id")
									  ->lists('pid');
		$top_teddy_flower         = file_get_contents(composer_url('query_ids.php?ids=' . json_encode($top_teddy_flower)));
		$data['top_teddy_flower'] = json_decode($top_teddy_flower)->hits->hits;

		$data['quotes'] = [];
		switch ($day) {
			case "rose":
				$data['quotes'][0] = "“Some people grumble that roses have thorns; I am grateful that thorns have roses.” ― Alphonse Karr, A Tour Round My Garden";
				$data['quotes'][1] = "“I'd rather have roses on my table than diamonds on my neck.” ― Emma Goldman";
				$data['quotes'][2] = "“Even if love is full of thorns, I'd still embrace it for I know that in between those thorns, there is a rose that's worth all the pain.” ― Unknown";
				$data['quotes'][3] = "“Just remember, during the winter, far beneath the bitter snow, that there's a seed that with the sun's love in the spring becomes a rose.” ― Bette Midler";

				$data["slider_size"]      = 5;
				$data["title"]            = "Rose Day Gifts Online India | Indiashopps";
				$data["h1"]               = "Rose Day Gifts Online – Buy, Compare & Save";
				$data["meta_description"] = "Buy or Send Romantic Rose Day Gifts surprise to your Boyfriend or Girlfriend online in India. You can also compare price to get the best deal only at Indiashopps.";
				$data["keywords"]         = "Rose day gifts online, Rose day gifts ideas online, Rose day gifts for him, Rose day gifts for her, Rose day gifts online India, Rose day gifts for boyfriend, Rose day gifts for girlfriend";
				$data["text"]             = "<p>Rose Day 2017 is going to happen on 7th February as usual and as it is a first day of the Valentine’s week, it is always a buzz among youngsters. Flowers are the best things to show your love towards someone. And roses are something, which takes your breath away and it is even more special when you get it from someone special. Your partners must be waiting for you to surprise them with a bunch of gorgeous roses of their favourite colour. </p>
    <p>Now know what significance does each colour rose hold. Red roses are meant for pure and unbreakable bond of love. White roses define purity, serenity and virtuousness. Orange roses signify emotions of energy and passion towards someone. Pink roses are so beautiful and just as their soothing colour they define feelings of joy, gratitude and softness. Green roses signify harmony, luck and composure. </p>
    <p>The stunning bunch of these splendid roses will undoubtedly make your someone special’s day and will make the best Rose day for you. The number of roses you give also defines your feeling for the other person. Like if you offer a single rose to someone that defines your thankful feelings doe that person and also it makes an impression that they play a big role in your life.</p>
    <p>If somebody presents you a bunch of red roses, that implies that he or she is seeking a special corner in your heart. If you have some romantic feelings for someone and you are hesitant to speak out those in words, a bunch of roses can do it for you. The wonderful roses are thought to be an embodiment of sentiment and will show your feelings of adoration,profound love, peace, warmth, gratefulness deeply.</p>
    <p>Long distance relationships in our generation are very common and it normally happens that couples don’t get that privilege to celebrate each and every day of Valentine’s Day together.  But with our online delivery of roses you can simply order the best bouquet or any number of flowers for your partner and get it delivered at his/her place. </p>
    <p>This expression shows them that you really do care about your relationship and do small romantic things to keep that romance ever fresh.  Buy Rose Day flowers online with IndiaShopps and spend wisely without paying unnecessary expenditure. Also look romantic & best Rose day gift ideas online for him/her. We have hassle-free delivery system and flexible payment methods so that we end up lending an excellent customer service to you. </p>
    <p>Buy the best colour and fresh roses with us to make your rose day a memorable one for you and your partner. We have rose day cards as well with overwhelming rose day messages written on them. So we are all se to make your rose day a very special one. </p> ";

				$data["list_him"][0]  = "list-of-flowers/valentines-flowers";
				$data["list_him"][1]  = "list-of-flowers/flowers-online";
				$data["list_him"][2]  = "list-of-flowers/bouquet-of-roses";
				$data["list_him"][3]  = "list-of-flowers/flower-bouquet";
				$data["list_him"][4]  = "list-of-flowers/bouquet-of-flowers";
				$data["list_him"][5]  = "list-of-flowers/send-flowers-online";
				$data["list_him"][6]  = "list-of-flowers/online-flowers";
				$data["list_him"][7]  = "list-of-flowers/cheap-flowers";
				$data["list_him"][8]  = "list-of-flowers/flowers";
				$data["list_him"][9]  = "list-of-photo-frames/photo-frame";
				$data["list_him"][10] = "list-of-chocolate/chocolate";
				$data["list_him"][11] = "list-of-dry-fruits/fruits-basket";
				$data["list_him"][12] = "list-of-gift-card/valentines-gifts-for-him";
				$data["list_him"][13] = "list-of-chocolate/cadbury";
				$data["list_him"][14] = "list-of-chocolate/chocolate-cake";

				$data["list_her"][0]  = "list-of-flowers/valentines-flowers";
				$data["list_her"][1]  = "list-of-flowers/flowers-online";
				$data["list_her"][2]  = "list-of-flowers/bouquet-of-roses";
				$data["list_her"][3]  = "list-of-flowers/flower-bouquet";
				$data["list_her"][4]  = "list-of-flowers/bouquet-of-flowers";
				$data["list_her"][5]  = "list-of-flowers/send-flowers-online";
				$data["list_her"][6]  = "list-of-flowers/online-flowers";
				$data["list_her"][7]  = "list-of-flowers/cheap-flowers";
				$data["list_her"][8]  = "list-of-flowers/flowers";
				$data["list_her"][9]  = "list-of-photo-frames/wood-frame";
				$data["list_her"][10] = "list-of-chocolate/best-chocolate";
				$data["list_her"][11] = "list-of-dry-fruits/fruits-basket";
				$data["list_her"][12] = "list-of-gift-card/love-valentine-cards";
				$data["list_her"][13] = "list-of-chocolate/cadbury";
				$data["list_her"][14] = "list-of-chocolate/chocolate-desserts";


				break;

			case "kiss":
				$data['quotes'][0]        = "“Love's sweetest language is a kiss.” ― Robert Herrick";
				$data['quotes'][1]        = "A kiss makes the heart young again and wipes out the years. Rupert Brooke";
				$data['quotes'][2]        = "We are all mortal until the first kiss and the second glass of wine. Eduardo Galeano";
				$data['quotes'][3]        = "A kiss is a lovely trick designed by nature to stop speech when words become superfluous. Ingrid Bergman";
				$data["slider_size"]      = 8;
				$data["title"]            = "Kiss Day Gifts Online India | Indiashopps";
				$data["h1"]               = "Kiss Day Gifts Online – Buy, Compare & Save";
				$data["meta_description"] = "Indiashopps.com offers exclusive range of kiss day gifts online in India. Order Now! and make valentine kiss day very pleasant for your partner.";
				$data["keywords"]         = "Keywords: Kiss day gifts online, Kiss day gifts ideas online, Kiss day gifts for him, Kiss day gifts for her, Kiss day gifts online India, Kiss day gifts for boyfriend, Kiss day gifts for girlfriend";
				$data["text"]             = "<p>Kiss is the sweetest expression of love. A kiss defines the purity and intensity of your love. Kisses let you exchange the deepest feelings with each other. Kisses are something, which everyone loves to have and when you shower kisses on someone you yourself feel amazing. On this kiss day gift your loved one with the best of kiss day gifts.</p><p>
We at Indiashopps, have launched an extravagant collection of kiss day gifts like dresses, watches, sandals, kiss day mugs, photo frames, flowers, chocolates and even fashion accessories. Flowers are the best, which can complement with your kisses and will end making your day special.</p><p>
Celebrate your true love in the grandest way on this kiss day. Gift a stunning piece of jewellery or a dress or a décor piece to make your partner feel the luckiest one on this day.</p><p>
It is definitely the best occasion to bring back that warmness and intensity in your love, which you have lost amidst your routine life. </p><p>
Indiashopps presents best Valentine Kiss Day Gifts Idea Online for Him/Her and has the most striking collection for you in the most reasonable budget so that you don’t end up making hole in your pocket. Browse through our outstanding collection of kiss day gifts and make your day an unforgettable one. We have hassle free delivery system and flexible payment methods like debit card, credit card, COD.</p>";
				$data["list_him"][0]      = "list-of-flowers/valentines-flowers";
				$data["list_him"][1]      = "list-of-flowers/flowers-online";
				$data["list_him"][2]      = "list-of-flowers/bouquet-of-roses";
				$data["list_him"][3]      = "list-of-flowers/flower-bouquet";
				$data["list_him"][4]      = "list-of-flowers/bouquet-of-flowers";
				$data["list_him"][5]      = "list-of-flowers/send-flowers-online";
				$data["list_him"][6]      = "list-of-flowers/online-flowers";
				$data["list_him"][7]      = "list-of-flowers/cheap-flowers";
				$data["list_him"][8]      = "list-of-flowers/flowers";
				$data["list_him"][9]      = "list-of-photo-frames/photo-frame";
				$data["list_him"][10]     = "list-of-chocolate/chocolate";
				$data["list_him"][11]     = "list-of-dry-fruits/fruits-basket";
				$data["list_him"][12]     = "list-of-gift-card/valentines-gifts-for-him";
				$data["list_him"][13]     = "list-of-chocolate/cadbury";
				$data["list_him"][14]     = "list-of-chocolate/chocolate-cake";

				$data["list_her"][0]  = "list-of-flowers/valentines-flowers";
				$data["list_her"][1]  = "list-of-flowers/flowers-online";
				$data["list_her"][2]  = "list-of-flowers/bouquet-of-roses";
				$data["list_her"][3]  = "list-of-flowers/flower-bouquet";
				$data["list_her"][4]  = "list-of-flowers/bouquet-of-flowers";
				$data["list_her"][5]  = "list-of-flowers/send-flowers-online";
				$data["list_her"][6]  = "list-of-flowers/online-flowers";
				$data["list_her"][7]  = "list-of-flowers/cheap-flowers";
				$data["list_her"][8]  = "list-of-flowers/flowers";
				$data["list_her"][9]  = "list-of-photo-frames/wood-frame";
				$data["list_her"][10] = "list-of-chocolate/best-chocolate";
				$data["list_her"][11] = "list-of-dry-fruits/fruits-basket";
				$data["list_her"][12] = "list-of-gift-card/love-valentine-cards";
				$data["list_her"][13] = "list-of-chocolate/cadbury";
				$data["list_her"][14] = "list-of-chocolate/chocolate-desserts";
				break;

			case "hug":
				$data['quotes'][0]        = "A Hug is a great gift- One size fits all, and its easy to exchange.";
				$data['quotes'][1]        = "Hugs were invented to let people know you love them without saying anything.";
				$data['quotes'][2]        = "One day someone is going to hug you so tight that all of your broken pieces will stick together.";
				$data['quotes'][3]        = "Just remember, you can’t put your arms around a memory, so hug someone you love, today.";
				$data["slider_size"]      = 5;
				$data["title"]            = "Hug Day Gifts Online India | Indiashopps";
				$data["h1"]               = "Hug Day Gifts Online – Buy, Compare & Save";
				$data["meta_description"] = "This valentine hug day, order wide range of unique trendy hug day gifts online in India for someone special. Buy, Send or Compare only at Indiashopps.com ";
				$data["keywords"]         = "Hug day gifts online, Hug day gifts ideas online, Hug day gifts for him, Hug day gifts for her, Hug day gifts online India, Hug day gifts for boyfriend, Hug day gifts for girlfriend";
				$data["text"]             = "<p>Hug Day falls on the seventh day of Valentine’s Week i.e. 13th of Feb. It is one of the most special days because hug is a special expression of love, affection and care. Hug Day is a popular among youngsters and on this day people exchange friendly hugs with each other so as to make themselves feel good. A hug has a lot of benefits and that has been proved scientifically. </p><p>
A hug is such a powerful physical activity that it boosts your emotional levels. Hug relieves you from stress. Hug is commonly used to greet each other or say bye to someone who is leaving for a different place far from yours. Hugs are meant to catalyse our happiness levels.  A study shows that hugging releases the level of oxytocin in our body, a hormone which is the cause of happiness and love for us.</p><p>
Who doesn’t like to get a warm hug from their dear ones, so on this hug day make your partner feel on the top of the world by cuddling them with a wholehearted hug. Hold your hands together and escape a hug and witness your relationship flourishing. </p><p>
Indiashopps has amazing Valentine Hug Day Gift Ideas Online for Him/Her at affordable prices. We are there to shower you with awesome gifts of hug day like roses, hug day pillows, t-shirts, mugs etc. Get flexible payment methods and hassle free delivery system.</p>";
				$data["list_him"][0]      = "list-of-flowers/valentines-flowers";
				$data["list_him"][1]      = "list-of-flowers/flowers-online";
				$data["list_him"][2]      = "list-of-flowers/bouquet-of-roses";
				$data["list_him"][3]      = "list-of-flowers/flower-bouquet";
				$data["list_him"][4]      = "list-of-flowers/bouquet-of-flowers";
				$data["list_him"][5]      = "list-of-flowers/send-flowers-online";
				$data["list_him"][6]      = "list-of-flowers/online-flowers";
				$data["list_him"][7]      = "list-of-flowers/cheap-flowers";
				$data["list_him"][8]      = "list-of-flowers/flowers";
				$data["list_him"][9]      = "list-of-photo-frames/photo-frame";
				$data["list_him"][10]     = "list-of-chocolate/chocolate";
				$data["list_him"][11]     = "list-of-dry-fruits/fruits-basket";
				$data["list_him"][12]     = "list-of-gift-card/valentines-gifts-for-him";
				$data["list_him"][13]     = "list-of-chocolate/cadbury";
				$data["list_him"][14]     = "list-of-chocolate/chocolate-cake";

				$data["list_her"][0]  = "list-of-flowers/valentines-flowers";
				$data["list_her"][1]  = "list-of-flowers/flowers-online";
				$data["list_her"][2]  = "list-of-flowers/bouquet-of-roses";
				$data["list_her"][3]  = "list-of-flowers/flower-bouquet";
				$data["list_her"][4]  = "list-of-flowers/bouquet-of-flowers";
				$data["list_her"][5]  = "list-of-flowers/send-flowers-online";
				$data["list_her"][6]  = "list-of-flowers/online-flowers";
				$data["list_her"][7]  = "list-of-flowers/cheap-flowers";
				$data["list_her"][8]  = "list-of-flowers/flowers";
				$data["list_her"][9]  = "list-of-photo-frames/wood-frame";
				$data["list_her"][10] = "list-of-chocolate/best-chocolate";
				$data["list_her"][11] = "list-of-dry-fruits/fruits-basket";
				$data["list_her"][12] = "list-of-gift-card/love-valentine-cards";
				$data["list_her"][13] = "list-of-chocolate/cadbury";
				$data["list_her"][14] = "list-of-chocolate/chocolate-desserts";
				break;

			case "teddy":
				$data['quotes'][0]        = "A bedroom without a teddy bear is like a face without a smile.";
				$data['quotes'][1]        = "When everything else has let you down, there's teddy bear!";
				$data['quotes'][2]        = "Anyone who has looked a teddy bear in the face will recognize the friendly twinkle in his knowing look.-Harold Nadolny";
				$data['quotes'][3]        = "Teddy bears don't need hearts as they are already stuffed with love.";
				$data["slider_size"]      = 4;
				$data["title"]            = "Teddy Day Gifts Online India | Indiashopps";
				$data["h1"]               = "Teddy Day Gifts Online – Buy, Compare & Save";
				$data["meta_description"] = "Send valentine teddy day gifts to your love ones. Our beautiful teddy gifts collections surely reveal your deep-heart emotions on this valentine week.";
				$data["keywords"]         = "Teddy day gifts online, Teddy day gifts ideas online, Teddy day gifts for her, Teddy day gifts online India, Teddy day gifts for girlfriend";
				$data["text"]             = "<p>Teddy Bears are not only the best friends of children, but are much loved among adults too. Teddy bear signifies cuteness, purity and love. Teddy bears hold such a special place in everyone’s heart. They offer support, kinship, love, fraternity, and acknowledgment. Gifting a teddy bear to your loved one signifies how pure and innocent your relationship is with them also you do care about them a lot. Gifting teddy bear to your friends and closed ones will offer an additional factor of commitment to further strengthen the bond.</p><p>
You will be amazed to know that the history of Teddy Bear. Actually Teddy bear got its name from President Theodore Roosevelt, who treated a bear humbly on one of his hunting trips. Teddy bears are one of those things that everybody likes and loves to possesses, but people think that after a certain age they can’t gift it. They are super comfortable to sleep with and are immensely adorable to hug. </p><p>
Teddy bears are an epitome of warmth, love, care and of course cuteness. Though gifting a teddy bear is an age old tradition, but it still continues to be the best gift ever. It shows your innocent feelings towards your closed one. </p><p>
When your partner is or anyone who is not in the place with you, you can just hug a teddy bear gifted by him and feel the same cuddliness as you do with them. So isn’t it super loving and charming.</p><p>
On such a special occasion of teddy day, IndiaShopps has come up with remarkably stunning and fluffy teddies for you to gift your special one. These are just the perfect gift you can gift to anyone you want and see how their affection and care towards you amplifies. Teddy day gifts- Buy or send Valentine teddy bear online in India with IndiaShopps because we have hassle free delivery and flexible payment methods including COD.</p>";
				$data["list_him"][0]      = "list-of-flowers/valentines-flowers";
				$data["list_him"][1]      = "list-of-flowers/flowers-online";
				$data["list_him"][2]      = "list-of-flowers/bouquet-of-roses";
				$data["list_him"][3]      = "list-of-flowers/flower-bouquet";
				$data["list_him"][4]      = "list-of-flowers/bouquet-of-flowers";
				$data["list_him"][5]      = "list-of-flowers/send-flowers-online";
				$data["list_him"][6]      = "list-of-flowers/online-flowers";
				$data["list_him"][7]      = "list-of-flowers/cheap-flowers";
				$data["list_him"][8]      = "list-of-flowers/flowers";
				$data["list_him"][9]      = "list-of-photo-frames/photo-frame";
				$data["list_him"][10]     = "list-of-chocolate/chocolate";
				$data["list_him"][11]     = "list-of-dry-fruits/fruits-basket";
				$data["list_him"][12]     = "list-of-gift-card/valentines-gifts-for-him";
				$data["list_him"][13]     = "list-of-chocolate/cadbury";
				$data["list_him"][14]     = "list-of-chocolate/chocolate-cake";

				$data["list_her"][0]  = "list-of-flowers/valentines-flowers";
				$data["list_her"][1]  = "list-of-flowers/flowers-online";
				$data["list_her"][2]  = "list-of-flowers/bouquet-of-roses";
				$data["list_her"][3]  = "list-of-flowers/flower-bouquet";
				$data["list_her"][4]  = "list-of-flowers/bouquet-of-flowers";
				$data["list_her"][5]  = "list-of-flowers/send-flowers-online";
				$data["list_her"][6]  = "list-of-flowers/online-flowers";
				$data["list_her"][7]  = "list-of-flowers/cheap-flowers";
				$data["list_her"][8]  = "list-of-flowers/flowers";
				$data["list_her"][9]  = "list-of-photo-frames/wood-frame";
				$data["list_her"][10] = "list-of-chocolate/best-chocolate";
				$data["list_her"][11] = "list-of-dry-fruits/fruits-basket";
				$data["list_her"][12] = "list-of-gift-card/love-valentine-cards";
				$data["list_her"][13] = "list-of-chocolate/cadbury";
				$data["list_her"][14] = "list-of-chocolate/chocolate-desserts";
				break;

			case "promise":
				$data['quotes'][0]        = "Love is a promise, love is a souvenir, once given never forgotten, never let it disappear.";
				$data['quotes'][1]        = "A promise is a cloud, fulfillment is rain.";
				$data['quotes'][2]        = "Don't promise the moon or the stars, justpromise that you will always stay under them with your beloved.";
				$data['quotes'][3]        = "Promises are only as strong as the person who gives them …";
				$data["slider_size"]      = 3;
				$data["title"]            = "Propose Day Gifts Online India | Indiashoppss";
				$data["h1"]               = "Propose Day Gifts Online -– Buy, Compare & Savee";
				$data["meta_description"] = "Buy or send promise day gifts online to your love ones at lowest price with deal & coupon and enjoy make a 'Be together' valentine week.";
				$data["keywords"]         = "Propose day gifts online, Proposeday gifts ideas online, Propose day gifts for him, Propose day gifts for her, Propose day gifts online India, Propose day gifts for boyfriend, Propose day gifts for girlfriend";
				$data["text"]             = "<p>“Promises are meant to be kept” an old proverb, which is every bit true. Promises are definitely meant to be kept. Love comes along with promises and can only bloom, if the made promises are fulfilled. It is obvious when a person makes some promises; we expect something out of them and when the expectations aren’t fulfilled, its human nature to get disappointed. It is important to understand what your partner or any other person expects from you in a relationship, so that you can make the same promises and also live up to them. </p><p>
It’s not about always making big promises, but even small promises if fulfilled honestly can make your relationship beautiful. Communication is very much important in a relationship and if your promise to make a healthy and regular communication in a relationship, your partner will always appreciate it. </p><p>
Promise them that you will always understand them and let them be themselves. A promise to support your partner in every situation is a big promise and is expected by everyone, make sure you don not fall in the wrong place once you make this promise. </p><p>
So on this Promise Day, which is on 11 Feb, make some sincere promises to your loved one but in a different fashion that they will love. We are here to add some goodies to your promises with our special collection of promise day gifts and we are sure they will complement your promises in the best manner possible. It is the occasion to make them super happy and love you even more. Strengthen your relationships with solemn promises.</p><p>
Have a look at Valentine Promise Day Gifts Ideas Online in India with Indiashopps and enjoy your day. We ensure hassle free delivery system and flexible payment methods such as debit cards, credit cards and also COD.</p>";
				$data["list_him"][0]      = "list-of-flowers/valentines-flowers";
				$data["list_him"][1]      = "list-of-flowers/flowers-online";
				$data["list_him"][2]      = "list-of-flowers/bouquet-of-roses";
				$data["list_him"][3]      = "list-of-flowers/flower-bouquet";
				$data["list_him"][4]      = "list-of-flowers/bouquet-of-flowers";
				$data["list_him"][5]      = "list-of-flowers/send-flowers-online";
				$data["list_him"][6]      = "list-of-flowers/online-flowers";
				$data["list_him"][7]      = "list-of-flowers/cheap-flowers";
				$data["list_him"][8]      = "list-of-flowers/flowers";
				$data["list_him"][9]      = "list-of-photo-frames/photo-frame";
				$data["list_him"][10]     = "list-of-chocolate/chocolate";
				$data["list_him"][11]     = "list-of-dry-fruits/fruits-basket";
				$data["list_him"][12]     = "list-of-gift-card/valentines-gifts-for-him";
				$data["list_him"][13]     = "list-of-chocolate/cadbury";
				$data["list_him"][14]     = "list-of-chocolate/chocolate-cake";

				$data["list_her"][0]  = "list-of-flowers/valentines-flowers";
				$data["list_her"][1]  = "list-of-flowers/flowers-online";
				$data["list_her"][2]  = "list-of-flowers/bouquet-of-roses";
				$data["list_her"][3]  = "list-of-flowers/flower-bouquet";
				$data["list_her"][4]  = "list-of-flowers/bouquet-of-flowers";
				$data["list_her"][5]  = "list-of-flowers/send-flowers-online";
				$data["list_her"][6]  = "list-of-flowers/online-flowers";
				$data["list_her"][7]  = "list-of-flowers/cheap-flowers";
				$data["list_her"][8]  = "list-of-flowers/flowers";
				$data["list_her"][9]  = "list-of-photo-frames/wood-frame";
				$data["list_her"][10] = "list-of-chocolate/best-chocolate";
				$data["list_her"][11] = "list-of-dry-fruits/fruits-basket";
				$data["list_her"][12] = "list-of-gift-card/love-valentine-cards";
				$data["list_her"][13] = "list-of-chocolate/cadbury";
				$data["list_her"][14] = "list-of-chocolate/chocolate-desserts";
				break;

			case "valentines":
				$data['quotes'][0]        = "Falling in love is when she falls asleep in your arms and wakes up in your dreams.";
				$data['quotes'][1]        = "Love is our true destiny. We do not find the meaning of life by ourselves alone - we find it with another. Thomas Merton";
				$data['quotes'][2]        = "Love is a symbol of eternity. It wipes out all sense of time, destroying all memory of a beginning and all fear of an end.";
				$data['quotes'][3]        = "Love unlocks doors and opens windows that weren't even there before. ~Mignon McLaughlin";
				$data["slider_size"]      = 7;
				$data["title"]            = "Valentine Day Gifts Online India | Indiashopps";
				$data["h1"]               = "Valentine Day Gifts Online – Buy, Compare & Save";
				$data["meta_description"] = "Browse huge collection of Valentine's Day gifts online in India for him/her at lowest price and enjoy exciting deals and offers only at Indiashopps.";
				$data["keywords"]         = "Valentine day gifts online, Valentine day gifts ideas online, Valentine day gifts for him, Valentine day gifts for her, Valentine day gifts online India, Valentine day gifts for boyfriend, Valentine day gifts for girlfriend";
				$data["text"]             = "<p>So the most awaited day of the year for lovers is here, the Valentine’s Day. Valentine’s Day is  an opportunity for lovers to show their feelings to each other. But do you really think Valentine’s Day is just restricted to couples? No it’s not, Valentine’s Day gives you an exceptional occasion to shower your love on anyone you love dearly, be it your parents, children, friend, husband, colleague, teacher or anyone. Valentine’s Day is the perfect time to let your dear ones know, how much you mean to them. Valentine’s day is celebrated in several countries throughout the world, including Mexico, France, England, Australia, and of course The United States.</p><p>
Love is a fuel to run any engine of a relationship and Valentine’s Day is the one which makes this fuel even more special. Valentine’s Day is Just round the corner and there is already a lot of buzz regarding the same on the internet.</p><p>
The most demanding things on Valentine’s Day are gifts. Because gifts are something, which convey the emotions you can’t speak in words. When your beloved is so special to you, the gift given to them should also be very special. Remember your Valentine’s Day gift is going to tell your heart’s story on behalf of you.</p><p>
It’s time to spice up the love between you two, because it’s a month of romance. People forget their past grudges and join together to celebrate this special day, which will come only after a year. So, if you miss the opportunity now, you will have to wait till next year to tell your special feelings to the special one for you. </p><p>
On this Occasion IndiaShopps has loaded itself with splendid collection of Valentine’s Day gifts, which we bet will be no less than a treasure for you. Shop the best Valentine’s Day gifts for him/her or for anyone with us and celebrate it with great pomp and show. It’s not the time to restrict yourself or your feelings. Let them flow like a wine!</p><p>
You are free to choose any payment method with us be it debit card, credit card or COD etc. We assure you of the fastest delivery. Also, don’t forget to compare the prices. </p>";
				$data["list_him"][0]      = "list-of-flowers/valentines-flowers";
				$data["list_him"][1]      = "list-of-flowers/flowers-online";
				$data["list_him"][2]      = "list-of-flowers/bouquet-of-roses";
				$data["list_him"][3]      = "list-of-flowers/flower-bouquet";
				$data["list_him"][4]      = "list-of-flowers/bouquet-of-flowers";
				$data["list_him"][5]      = "list-of-flowers/send-flowers-online";
				$data["list_him"][6]      = "list-of-flowers/online-flowers";
				$data["list_him"][7]      = "list-of-flowers/cheap-flowers";
				$data["list_him"][8]      = "list-of-flowers/flowers";
				$data["list_him"][9]      = "list-of-photo-frames/photo-frame";
				$data["list_him"][10]     = "list-of-chocolate/chocolate";
				$data["list_him"][11]     = "list-of-dry-fruits/fruits-basket";
				$data["list_him"][12]     = "list-of-gift-card/valentines-gifts-for-him";
				$data["list_him"][13]     = "list-of-chocolate/cadbury";
				$data["list_him"][14]     = "list-of-chocolate/chocolate-cake";

				$data["list_her"][0]  = "list-of-flowers/valentines-flowers";
				$data["list_her"][1]  = "list-of-flowers/flowers-online";
				$data["list_her"][2]  = "list-of-flowers/bouquet-of-roses";
				$data["list_her"][3]  = "list-of-flowers/flower-bouquet";
				$data["list_her"][4]  = "list-of-flowers/bouquet-of-flowers";
				$data["list_her"][5]  = "list-of-flowers/send-flowers-online";
				$data["list_her"][6]  = "list-of-flowers/online-flowers";
				$data["list_her"][7]  = "list-of-flowers/cheap-flowers";
				$data["list_her"][8]  = "list-of-flowers/flowers";
				$data["list_her"][9]  = "list-of-photo-frames/wood-frame";
				$data["list_her"][10] = "list-of-photo-frames/personalised-photo-frames";
				$data["list_her"][11] = "list-of-dry-fruits/fruits-basket";
				$data["list_her"][12] = "list-of-gift-card/love-valentine-cards";
				$data["list_her"][13] = "list-of-chocolate/cadbury";
				$data["list_her"][14] = "list-of-gift-card/cute-valentine-cards";
				break;

			case "chocolate":
				$data['quotes'][0]        = "“Chocolate says “I’m sorry” so much better than words.” – Rachel Vincent";
				$data['quotes'][1]        = "“Your hand and your mouth agreed many years ago that, as far as chocolate is concerned, there is no need to involve your brain.” – Dave Barry";
				$data['quotes'][2]        = "Chocolate symbolizes, as does no other food, luxury, comfort, sensuality, gratification, and love.” – Karl Petzke";
				$data['quotes'][3]        = "“Secret of happiness: eating chocolate as one makes love. Making love as one eat chocolate.” – Guto Graca";
				$data["slider_size"]      = 5;
				$data["title"]            = "Chocolate Day Gifts Online India | Indiashopps";
				$data["h1"]               = "Chocolate Day Gifts Online – Buy, Compare & Save";
				$data["meta_description"] = "Buy or Send best collection of chocolates & other beautiful gifts online on this Valentine’s Chocolate day for your love ones with a personal touch only at Indiashopps.com.";
				$data["keywords"]         = "Chocolate day gifts online, Chocolate day gifts ideas online, Chocolate gifts for him, Chocolate day gifts for her, Chocolate day gifts online India";
				$data["text"]             = "<p>Each and every day of Valentine’s week is special but the third day of Valentine’s week; Chocolate Day is the sweetest of all. Chocolate Day is commended by each one who wishes to express his adoration, feelings to their darling person. This year Chocolate Day falls on Thursday 9th February 2017, to express sweet gesture and happiness among each other.</p><p>
Chocolate Day stands out among all the days of the Valentine Week because it brings a favourite flavour of affection and compassion in every one’s life. On this day people buy different types chocolates and chocolate hampers for their loved ones to make them feel happy. People share chocolate day sms, chocolate day messages, chocolate cards, chocolate day greetings with each other and celebrate this special day.</p><p>
Chocolate Day lends us with an excellent opportunity to gift scrumptious chocolates to our closed ones and it really delivers a sweet impact on our relationships. Chocolates can be given to express your profound love and emotional attachment towards their dear ones. You can also send chocolate day cards, flowers and teddy bears along with chocolates to make their day a precious one.</p><p>
Chocolate Day is celebrated with massive enthusiasm and love among every generation especially young girls and boys. If there is someone, who is upset with for any reason chocolate day is the best occasion to make their mood happy because there is hardly anyone who can’t be delighted with a box of mouth-watering chocolates. Indulge yourself and even your darling person in the pool of chocolates on this day and see how it sweetens your relationship. </p><p>
Here at IndiaShopps we are all set to take you through our delicious collection of chocolates. Buy or send valentines chocolate day gifts for him/her and also different types of chocolates. We have hassle free delivery and flexible payment methods including COD.</p>";
				$data["list_him"][0]      = "list-of-flowers/valentines-flowers";
				$data["list_him"][1]      = "list-of-flowers/flowers-online";
				$data["list_him"][2]      = "list-of-flowers/bouquet-of-roses";
				$data["list_him"][3]      = "list-of-flowers/flower-bouquet";
				$data["list_him"][4]      = "list-of-flowers/bouquet-of-flowers";
				$data["list_him"][5]      = "list-of-flowers/send-flowers-online";
				$data["list_him"][6]      = "list-of-flowers/online-flowers";
				$data["list_him"][7]      = "list-of-flowers/cheap-flowers";
				$data["list_him"][8]      = "list-of-flowers/flowers";
				$data["list_him"][9]      = "list-of-photo-frames/photo-frame";
				$data["list_him"][10]     = "list-of-chocolate/chocolate";
				$data["list_him"][11]     = "list-of-dry-fruits/fruits-basket";
				$data["list_him"][12]     = "list-of-gift-card/valentines-gifts-for-him";
				$data["list_him"][13]     = "list-of-chocolate/cadbury";
				$data["list_him"][14]     = "list-of-chocolate/chocolate-cake";

				$data["list_her"][0]  = "list-of-flowers/valentines-flowers";
				$data["list_her"][1]  = "list-of-flowers/flowers-online";
				$data["list_her"][2]  = "list-of-flowers/bouquet-of-roses";
				$data["list_her"][3]  = "list-of-flowers/flower-bouquet";
				$data["list_her"][4]  = "list-of-flowers/bouquet-of-flowers";
				$data["list_her"][5]  = "list-of-flowers/send-flowers-online";
				$data["list_her"][6]  = "list-of-flowers/online-flowers";
				$data["list_her"][7]  = "list-of-flowers/cheap-flowers";
				$data["list_her"][8]  = "list-of-flowers/flowers";
				$data["list_her"][9]  = "list-of-photo-frames/wood-frame";
				$data["list_her"][10] = "list-of-chocolate/best-chocolate";
				$data["list_her"][11] = "list-of-dry-fruits/fruits-basket";
				$data["list_her"][12] = "list-of-gift-card/love-valentine-cards";
				$data["list_her"][13] = "list-of-chocolate/cadbury";
				$data["list_her"][14] = "list-of-chocolate/chocolate-desserts";
				break;

			case "propose":
				$data['quotes'][0]        = "Love is passionate, love is blind, there is no better day to express it, other than Propose Day.";
				$data['quotes'][1]        = "Love is to express and not to impress people. Happy Propose Day!";
				$data['quotes'][2]        = "Love is not Something you find Love is Something thats find you. Find the one for you on this propose day.";
				$data["slider_size"]      = 6;
				$data["title"]            = "Propose Day Gifts Online India | Indiashopps";
				$data["h1"]               = "Propose Day Gifts Online - Buy, Compare & Save";
				$data["meta_description"] = "Indiashopps.com provides wide range of beautiful propose day gifts for him or her on the occasion of Valentine’s Day. Lowest Price Guaranteed!";
				$data["keywords"]         = "Propose day gifts online, Proposeday gifts ideas online, Propose day gifts for him, Propose day gifts for her, Propose day gifts online India, Propose day gifts for boyfriend, Propose day gifts for girlfriend";
				$data["text"]             = "<p>Love is floating all around us in the air, in our surroundings as propose day is round the corner and all the hearts filled with feelings and love someone are preparing themselves to express their feelings to their special ones in the best manner possible. To show your affection and hidden feelings, you should plan something special for them. It’s a day when you get an excellent chance to express your feelings of adoration and fondness in the dreamiest way.</p><p>
Confessing your love for the man or girl of your dreams is the one of the hardest jobs in the world. But Propose Day lends you with an awesome opportunity to reach you’re the person of your dreams and confess your love boldly in front of them. One should not be afraid of the rejection, it is always better to pour out your feelings so that you don’t regret it later. One should not linger behind to portray their feelings for someone. </p><p>
Proposing someone on prose day will make your proposal and love for them even more special. Propose Day is the second day of Valentine’s week and is much popular and loved among youngsters.  </p><p>
Make your dream person feel that he/she is the luckiest one on this planet because you love them by planning a different kind of proposal. Especially, girls love if they are proposed in a unique manner, so don’t lag behind in making them feel special. </p><p>
Plan your proposal along the shorelines or take them to the place they love and tell them in the most benevolent way that what you feel for them. And we are here to help you with it. </p><p>
To make your propose Day special here we have brought to you an awesome collection of propose day gifts such as flowers, cakes, teddy bears, rings, necklaces and many more things. Buy or send Propose Day gifts for him/her in India. Everything is available at such alluring prices that it will completely take care of your pocket. </p><p>
With our adorable gifts approach your crush with confidence, we are sure they will be greatly impressed.</p>";
				$data["list_him"][0]      = "list-of-flowers/valentines-flowers";
				$data["list_him"][1]      = "list-of-flowers/flowers-online";
				$data["list_him"][2]      = "list-of-flowers/bouquet-of-roses";
				$data["list_him"][3]      = "list-of-flowers/flower-bouquet";
				$data["list_him"][4]      = "list-of-flowers/bouquet-of-flowers";
				$data["list_him"][5]      = "list-of-flowers/send-flowers-online";
				$data["list_him"][6]      = "list-of-flowers/online-flowers";
				$data["list_him"][7]      = "list-of-flowers/cheap-flowers";
				$data["list_him"][8]      = "list-of-flowers/flowers";
				$data["list_him"][9]      = "list-of-photo-frames/photo-frame";
				$data["list_him"][10]     = "list-of-chocolate/chocolate";
				$data["list_him"][11]     = "list-of-dry-fruits/fruits-basket";
				$data["list_him"][12]     = "list-of-gift-card/valentines-gifts-for-him";
				$data["list_him"][13]     = "list-of-chocolate/cadbury";
				$data["list_him"][14]     = "list-of-chocolate/chocolate-cake";

				$data["list_her"][0]  = "list-of-flowers/valentines-flowers";
				$data["list_her"][1]  = "list-of-flowers/flowers-online";
				$data["list_her"][2]  = "list-of-flowers/bouquet-of-roses";
				$data["list_her"][3]  = "list-of-flowers/flower-bouquet";
				$data["list_her"][4]  = "list-of-flowers/bouquet-of-flowers";
				$data["list_her"][5]  = "list-of-flowers/send-flowers-online";
				$data["list_her"][6]  = "list-of-flowers/online-flowers";
				$data["list_her"][7]  = "list-of-flowers/cheap-flowers";
				$data["list_her"][8]  = "list-of-flowers/flowers";
				$data["list_her"][9]  = "list-of-photo-frames/wood-frame";
				$data["list_her"][10] = "list-of-chocolate/best-chocolate";
				$data["list_her"][11] = "list-of-dry-fruits/fruits-basket";
				$data["list_her"][12] = "list-of-gift-card/love-valentine-cards";
				$data["list_her"][13] = "list-of-chocolate/cadbury";
				$data["list_her"][14] = "list-of-chocolate/chocolate-desserts";
				break;


		}

		// echo "<pre>";print_r($data);exit;
		return view("v1.valentine.day_products", $data);
	}

}
