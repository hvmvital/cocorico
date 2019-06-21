<?php

/*
 * This file is part of the Cocorico package.
 *
 * (c) Cocolabs SAS <contact@cocolabs.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cocorico\CoreBundle\Form\Type\Dashboard;

use Cocorico\CoreBundle\Entity\Listing;
use Cocorico\CoreBundle\Entity\ListingFile;
use Cocorico\CoreBundle\Form\Type\FileType;
use Cocorico\CoreBundle\Form\Type\ListingFileType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ListingEditFilesType extends ListingEditType
{
    /**
     * @var array|string uploaded files
     */
    protected $uploaded;

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'file',
                FileType::class
            )
            ->add(
                'files',
                CollectionType::class,
                array(
                    'allow_delete' => true,
                    'entry_type' => ListingFileType::class,
                    /** @Ignore */
                    'label' => false
                )
            );


        $builder->addEventListener(
            FormEvents::PRE_SUBMIT,
            function (FormEvent $event) {
                $data = $event->getData();
                $data = $data ?: array();
                if (array_key_exists('uploaded', $data["file"])) {
                    // capture uploaded files and store them for onSubmit event
                    $this->uploaded = $data["file"]['uploaded'];
                }
            }
        );


        $builder->addEventListener(
            FormEvents::SUBMIT,
            function (FormEvent $event) {
                /** @var Listing $listing */
                $listing = $event->getData();

                if ($this->uploaded) {
                    $nbFiles = $listing->getFiles()->count();
                    //Add new files
                    $filesUploadedArray = explode(",", trim($this->uploaded, ","));
                    foreach ($filesUploadedArray as $i => $file) {
                        $listingFile = new ListingFile();
                        $listingFile->setListing($listing);
                        $listingFile->setName($file);
                        $listingFile->setPosition($nbFiles + $i + 1);
                        $listing->addFile($listingFile);
                    }

                    $event->setData($listing);
                }
            }
        );


    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'listing_edit_files';
    }
}
