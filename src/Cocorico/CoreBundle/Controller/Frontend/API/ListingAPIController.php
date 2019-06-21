<?php

/*
 * This file is part of the Cocorico package.
 *
 * (c) Cocolabs SAS <contact@cocolabs.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cocorico\CoreBundle\Controller\Frontend\API;

use Cocorico\CoreBundle\CocoricoCoreBundle;
use Cocorico\CoreBundle\Entity\Listing;
use Cocorico\CoreBundle\Form\Type\Frontend\ListingNewType;
use Cocorico\CoreBundle\Model\BaseListing;
use Cocorico\UserBundle\Entity\User;
use Cocorico\CoreBundle\Entity\ListingListingCategory;
use Cocorico\CoreBundle\Entity\ListingTranslation;
use Cocorico\CoreBundle\Entity\ListingLocation;
use Cocorico\GeoBundle\Entity\Coordinate;
use Cocorico\GeoBundle\Form\DataTransformer\GeocodingToCoordinateEntityTransformer;
use Cocorico\CoreBundle\Entity\ListingCategory;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;



/**
 * Listing controller.
 *
 * @Route("api/listing")
 */
class ListingAPIController extends Controller
{


    /**
     *
     * @Route("/{id}", name="id")
     * @Method("GET")
     */
    public function indexAction($id)
    {

        //$encoders = [new XmlEncoder(), new JsonEncoder()];
        // $normalizers = [new ObjectNormalizer()];

        // $serializer = new Serializer($normalizers, $encoders);

        $listing = $this->getDoctrine()
            ->getRepository('CocoricoCoreBundle:Listing')
            ->findOneBy(array('id' => $id));


        $data = $this->serializeListing($listing);


        //$listing = $this->get('serializer')->serialize($listing, 'json');
        //$json = $serializer->serialize($listings,'json');

        $response = new JsonResponse($data, 201);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     *
     * @Route("/newlisting")
     * @Method("POST")
     */
    public function newListingAction(Request $request)
    {

        $user_id = $request->get('user_id');
        $status = $request->get('status');
        $price = $request->get('price');
        $cancellation_policy = $request->get('cancellation_policy');
        $category_id = $request->get('category_id');
        $country_id = $request->get('country_id');
        $listing_zip = $request->get('listing_zip');
        $listing_route = $request->get('listing_route');
        $listing_street_number = $request->get('listing_street_number');
        $lat = $request->get('lat');
        $lng = $request->get('lng');


        $listing_title_en = $request->get('listing_title_en');
        $listing_description_en = $request->get('listing_description_en');
        $listing_rules_en = $request->get('listing_rules_en');
        $listing_slug_en = $request->get('listing_slug_en');
        $listing_locale_en = $request->get('listing_locale_en');

        $listing_title_fr = $request->get('listing_title_fr');
        $listing_description_fr = $request->get('listing_description_fr');
        $listing_rules_fr = $request->get('listing_rules_fr');
        $listing_slug_fr = $request->get('listing_slug_fr');
        $listing_locale_fr = $request->get('listing_locale_fr');









        //Looking for $user by $user_id
        $user = $this->getDoctrine()
            ->getRepository('CocoricoUserBundle:User')
            ->findOneBy(array('id' => $user_id));


        //Setting $listing
        $listing = new Listing();
        $listing->setUser($user);
        //$listing->setLocation($location);
        $listing->setStatus($status);
        $listing->setPrice($price);
        $listing->setCancellationPolicy($cancellation_policy);

        //Looking for $coordinate_id
       // $coordinate = $this->getDoctrine()
       //     ->getRepository('CocoricoGeoBundle:Coordinate')
       //     ->findOneBy(array('id' => $coordinate_id));

        //Looking for $country
        $country = $this->getDoctrine()
            ->getRepository('CocoricoGeoBundle:Country')
            ->findOneBy(array('id' => $country_id));

        //Setting $coordinate
        $listing_coordinate = new Coordinate();
        $listing_coordinate->setCountry($country);
        $listing_coordinate->setLat($lat);
        $listing_coordinate->setLng($lng);
        $listing_coordinate->setZip($listing_zip);
        $listing_coordinate->setRoute($listing_route);
        $listing_coordinate->setStreetNumber($listing_street_number);
        $listing_address = (
            $listing_coordinate->getStreetNumber().' '.
            $listing_coordinate->getRoute().', '.
            $listing_coordinate->getZip().', '.
            $listing_coordinate->getCountry()->getName());
        $listing_coordinate->setAddress($listing_address);




        //Setting listing_location
        $listing_location = new ListingLocation();
        $listing_location->setListing($listing);
        $listing_location->setCoordinate($listing_coordinate);
        $listing_location->setCountry('CA');
        $listing_location->setCity('Montreal');
        $listing_location->setZip('H2L 3W2');
        $listing_location->setRoute('Saint-Andre');
        $listing_location->setStreetNumber('3985B');

        //Setting $listing_location
        $listing->setLocation($listing_location);


        //Looking for $listing_category by $category_id
        $listing_category = $this->getDoctrine()
            ->getRepository('CocoricoCoreBundle:ListingCategory')
            ->findOneBy(array('id' => $category_id));

        //Setting listing_listing_category
        $listing_listing_category = new ListingListingCategory();
        $listing_listing_category->setListing($listing);
        $listing_listing_category->setCategory($listing_category);

        $em = $this->getDoctrine()->getManager();
        $em->persist($listing);
        $em->persist($listing_location);
        $em->persist($listing_listing_category);





        //Setting $listing_translation_en
        $listing_translation_en = new ListingTranslation();
        $listing_translation_en->setTranslatableId($listing->getId());
        $listing_translation_en->setTranslatable($listing);
        $listing_translation_en->setTitle($listing_title_en);
        $listing_translation_en->setDescription($listing_description_en);
        $listing_translation_en->setRules($listing_rules_en);
        $listing_translation_en->setSlug($listing_slug_en);
        $listing_translation_en->setLocale($listing_locale_en);

        //Setting $listing_translation_fr
        $listing_translation_fr = new ListingTranslation();
        $listing_translation_fr->setTranslatableId($listing->getId());
        $listing_translation_fr->setTranslatable($listing);
        $listing_translation_fr->setTitle($listing_title_fr);
        $listing_translation_fr->setDescription($listing_description_fr);
        $listing_translation_fr->setRules($listing_rules_fr);
        $listing_translation_fr->setSlug($listing_slug_fr);
        $listing_translation_fr->setLocale($listing_locale_fr);




        $em->persist($listing_translation_en);
        $em->persist($listing_translation_fr);
        $em->persist($listing_coordinate);
        $em->flush();

        return new Response("Your listing was saved!");
    }


    /**
     *
     * @Route("/")
     * @Method("GET")
     */
    public function listAction()
    {

        $listings = $this->getDoctrine()
            ->getRepository('CocoricoCoreBundle:Listing')
            ->findAll();

        $data = array('listings' => array());

        foreach ($listings as $listing) {
            $data['listings'][] = $this->serializeListing($listing);
        }

        $response = new JsonResponse($data, 200);

        return $response;
    }

    private function serializeListing(Listing $listing)
    {
        return array(
            'id' => $listing->getId(),
            'listing_title' => $listing->getTitle(),
            'user_id' => ($listing->getUser())->getId(),
            'status' => $listing->getStatus(),
            'price' => $listing->getPrice(),
            'cancellation_policy' => $listing->getCancellationPolicy()
        );
    }


}
