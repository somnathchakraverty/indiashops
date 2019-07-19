<?php
namespace indiashopps\Http\Controllers;

use DB;
use helper;
use indiashopps\Http\Controllers\Controller;
use Illuminate\Http\Request;
use indiashopps\Models\Occasion;

class OccasionsController extends Controller
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
		foreach( Occasion::all() as $occasion )
		{
			$occasions[$occasion->type][] = $occasion;
		}

		$data['tinker'][] = 'Successful mothers are not the ones that have never struggled. They are the ones that never give up, despite the struggles.  – Sharon Jaynes';
		$data['tinker'][] = 'My mother, is the bone of my spine, keeping me straight and true. She is my blood, making sure it runs rich and strong. She is the beating of my heart. I cannot imagine a life without here. – Kristin Hannah';
		$data['tinker'][] = 'A mother is she who can take the place of all others but whose place no one else can take. – Anna, Siolhan & Jack';
		$data['tinker'][] = 'All that I am or ever hope to be, I owe to my angel mother. – Abraham Lincoln';
		$data['tinker'][] = 'There will be so many times you feel like you’ve failed, but in the eyes, heart and mind of your child you are Super Mom. – Stephanie Precourt';
		$data['tinker'][] = 'There is no perfect way to be a good mother. Each situation is unique. Each mother has different challengers, different skills and abilities and certainly different children. What matters is that a mother loves her children deeply.  – Elder M. Russel Ballard';
		$data['tinker'][] = 'God could not be everywhere, and therefore he made mothers. -Rudyard Kipling';
		$data['tinker'][] = 'My mother is a walking miracle. -Leonardo DiCaprio';
		$data['tinker'][] = 'Being a full-time mother is one of the highest salaried jobs… since the payment is pure love.  -Mildred B. Vermont';
		$data['tinker'][] = 'A mother’s arms are made of tenderness and children sleep soundly in them. - yVictor Hugo';
		$data['tinker'][] = 'For when a child is born the mother also is born again. - Gilbert Parker';
		$data['tinker'][] = 'The sweetest sounds to mortals given are heard in Mother, Home, and Heaven - William Goldsmith Brown';
		$data["slider_size"] = 5;
		$data['quotes'] = [];
		$data['quotes'][0] = "“Some mothers are kissing mothers and some are scolding mothers, but it is love just the same, and most mothers kiss and scold together.” ― Pearl S. Buck";
		$data['quotes'][1] = "“Being a full-time mother is one of the highest salaried jobs in my field, since the payment is pure love.” ― Mildred B. Vermont";
		$data['quotes'][2] = "“The heart of a mother is a deep abyss at the bottom of which you will always find forgiveness.” ― Honoré de Balzac";

		$data["slider_size"] = 5;
		$data["title"] = "Mother's Day 2017 - Gifts for Mom - Mothers Day Gifts - Indiashopps.com";
		$data["h1"] = "Mother's Day";
		$data["meta_description"] = "Find mothers day gifts and buy gifts for mom at Indiashopps. Shop best gifts for mom including mothers day flowers, personalized gifts and more. show mom how much you love her straight from the heart. happy mother's day!";
		$data["keywords"] = "mother's day 2017, mother's day in india, gifts for mom, mothers day gifts, gift for mother, best gifts for mom, best gift for mother, gift ideas for mom, mother's day gift ideas, mothers day gift, unique gifts for mom, gift ideas for mother, personalized gifts for mom, online gifts for mother, mother's day special gifts";
		$data["text"] = "<p>The day dedicated to the most important person of your life is just around the corner and you just can’t afford to miss it. Mother’s Day in India is celebrated on every second Sunday of the month of May. The upcoming Mother’s Day 2017 is on 14th May and we have already started our preparations to make the most of this day. The efforts shouldn’t be any less because you are going to honour the most auspicious relationship in this world.</p>
								<p>Mother is just not a word; it’s the purest emotion in the world, which can be only felt by a mother and her child. Mothers are such special people in our lives that no volume of words can ever be enough to appreciate the importance of her. It is only because of her what we are today and now it’s time to say little thanks to her for all those things. To celebrate all the wonderful moms out there in the whole world IndiaShopps brings to you a wide range of online gifts for mother.</p>
								<p>When it comes to gifts for mom, you have to pretty thoughtful while purchasing gifts. To meet the various demands we have best gifts for mom. The different types of gifts we have include personalized gifts for mom too. You can be specific about your requirements while purchasing these gifts like personalized cakes, personalized cushion covers, personalized coffee mugs etc.</p>
								<p>We have beautiful mother’s day flowers, which are sure to make your mom’s morning the brightest one. Let her day start with these beautiful flowers by her side when she wakes up and follow it with scrumptious mother’s day special cake and mother’s day special gifts which include mothers day gifts hampers, special mother’s day jewellery, mother’s day greeting cards etc.</p>
								<p>Other unique gifts for mom comprise mother’s day accessories, chocolates, diaries, mugs, sarees, suits, handbags, footwear, mother’s day trophy etc.</p>
								<p>Buy mother’s day special gifts online with us and let your mom know that she deserves the best of the world. We let you compare the prices of each and every product from various e-commerce platforms like Amazon, Flipkart, Snapdeal, Jabong, Ferns n Petals, Archies etc.</p>";
		$data['day'] = $day;
		$data = array_merge($occasions, $data);

		return view("v2.occasions.mothers_day", $data);
	}

}
