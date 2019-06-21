<?php

/*
 * This file is part of the Cocorico package.
 *
 * (c) Cocolabs SAS <contact@cocolabs.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cocorico\CoreBundle\Controller\Frontend;


use Cocorico\CoreBundle\Entity\TaxRate;
use Cocorico\CoreBundle\Form\Type\Frontend\ListingNewType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\BrowserKit\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class TaxRateController extends Controller
{
    /**
     * @Route("/taxrate/new")
     */
    public function newAction()
    {
        $taxRate = new TaxRate("QN","Quebec", 0.55, 0.599, 0.35);

        $em = $this->getDoctrine()->getManager();
        $em->persist($taxRate);
        $em->flush();
        return new Response('<html><body>TaxRate created!</body></html>');

    }

    /**
     * @Route("/taxrates")
     */
    public function listAction()
    {
        $em = $this->getDoctrine()->getManager();
        $taxrates = $em->getRepository('CocoricoCoreBundle:TaxRate')->findAll();

        return $this->render('CocoricoCoreBundle:Frontend/TaxRates:list.html.twig', [
            'taxrates' => $taxrates
        ]);
    }




}
