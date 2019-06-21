<?php

/*
 * This file is part of the Cocorico package.
 *
 * (c) Cocolabs SAS <contact@cocolabs.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace Cocorico\CoreBundle\Form\Extension;

use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\PropertyAccess\PropertyAccess;

class FileTypeExtension extends AbstractTypeExtension
{

    public function getExtendedType()
    {
        return 'file';
    }

    /**
     *
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefined(
            array(
                'file_path',
                'imagine_filter',
                'allow_delete',

            )
        );
    }

    /**
     * Pass file url to the view
     *
     * @param \Symfony\Component\Form\FormView      $view
     * @param \Symfony\Component\Form\FormInterface $form
     * @param array                                 $options
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        if (array_key_exists('file_path', $options)) {
            $parentData = $form->getParent()->getData();

            if (null !== $parentData) {
                $accessor = PropertyAccess::createPropertyAccessor();
                $fileUrl = $accessor->getValue($parentData, $options['file_path']);
            } else {
                $fileUrl = null;
            }

            $view->vars['file_url'] = $fileUrl;
        }

        if (array_key_exists('imagine_filter', $options)) {
            $view->vars['imagine_filter'] = $options['imagine_filter'];
        }
    }

}
