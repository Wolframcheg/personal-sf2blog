<?php
namespace AppBundle\Form;

use AppBundle\Entity\Tag;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

class TagFieldListener implements EventSubscriberInterface
{

    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public static function getSubscribedEvents()
    {
        return array(
            FormEvents::PRE_SET_DATA => 'onPreSetData',
            FormEvents::POST_SUBMIT => 'onPostSubmit',
        );
    }

    public function onPreSetData(FormEvent $event)
    {
        $form = $event->getForm();
        $post = $event->getData();

        $tags = $post->getTags()->toArray();
        $value = '';

        foreach ($tags as $key => $tag) {
            if (!$key) {
                $value = $tag->getName();
                continue;
            }
            $value .= ',' . $tag->getName();
        }

        $form->add('tags', TextType::class, [
            'required' => false,
            'mapped' => false,
            'data' => $value
        ]);

        $form->add('allTags', EntityType::class, [
            'required' => false,
            'mapped' => false,
            'class' => 'AppBundle\Entity\Tag',
            'choice_label' => 'name',
            'expanded' => true,
            'multiple' => true,
            'data' => $post->getTags(),
            'attr' => [
                'class' => 'form-inline'
            ]
        ]);
    }

    public function onPostSubmit(FormEvent $event)
    {
        $form = $event->getForm();
        $post = $event->getData();

        $strTags = $form->get('tags')->getData();
        $collection = new ArrayCollection();

        if ($arrayTags = explode(',', $strTags)) {
            $allTags = $this->em->getRepository('AppBundle:Tag')->getKeyPairs();

            foreach ($arrayTags as $tagName) {
                $tag = isset($allTags[$tagName]) ? $this->em->getReference('AppBundle:Tag', $allTags[$tagName]) : new Tag($tagName);
                $collection->add($tag);
            }
        }
        $post->setTags($collection);
    }
}