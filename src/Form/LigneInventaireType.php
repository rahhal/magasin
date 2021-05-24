<?php

namespace App\Form;

use App\Entity\LigneInventaire;
use App\Entity\Stock;
use App\Entity\Article;
use App\Repository\ArticleRepository;
use App\Repository\StockRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Security;

use Symfony\Component\Form\FormInterface;
use Doctrine\ORM\EntityManagerInterface;



class LigneInventaireType extends AbstractType
{
    private $em;
    private $security;

    /**
     * The Type requires the EntityManager as argument in the constructor. It is autowired
     * in Symfony 3.
     *
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em, Security $security)
    {
        $this->em = $em;
        $this->security = $security;
    }

    /**
     * {@inheritdoc}
     */

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // 2. Remove the dependent select from the original buildForm as this will be
        // dinamically added later and the trigger as well
        $builder->add('qteInv');

        // 3. Add 2 event listeners for the form
        $builder->addEventListener(FormEvents::PRE_SET_DATA, array($this, 'onPreSetData'));
        $builder->addEventListener(FormEvents::PRE_SUBMIT, array($this, 'onPreSubmit'));
    }
/*$builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) use ($user) {
            $form = $event->getForm();
            $form->add('article', EntityType::class, [
                'class' => Article::class,
                'query_builder' => function (ArticleRepository $articleRepository)use ($user) {
                    return $articleRepository->findByCurrentUser($user);
                },
]);
});*/
    protected function addElements(FormInterface $form, Article $article = null) {
         $user = $this->security->getUser();
        // 4. Add the province element
        $form->add('article', EntityType::class, array(
            'required' => true,
            'data' => $article,
            'placeholder' => 'اختر البضاعة...',
            'class' => Article::class,
            'query_builder' => function (ArticleRepository $articleRepository)use ($user) {
            return $articleRepository->findByCurrentUser($user);
        }
        ));

    /*protected function addElements(FormInterface $form, Article $article = null) {
       // $user = $this->security->getUser();
        // 4. Add the province element
        $form->add('article', EntityType::class, array(
            'required' => true,
            'data' => $article,
            'placeholder' => 'اختر البضاعة...',
            'class' => Article::class

        ));*/

        // stocks empty, unless there is a selected Article (Edit View)
        $stocks = array();

        // If there is a Article stored in the ligneInventaire entity, load the stocks of it
        if ($article) {
            // Fetch Stocks of the Article if there's a selected Article
            $repoStock = $this->em->getRepository(Stock::class);

            $stocks = $repoStock->findByArticle($article->getId());
            /*createQueryBuilder("q")
                ->where("q.article = :articleid")
                ->setParameter("articleid", $article->getId())
                ->getQuery()
                ->getResult();*/

        }

        // Add the Stocks field with the properly data
        $form->add('stock', EntityType::class, array(
            'required' => true,
           // 'placeholder' => 'اختر البضاعة اولا...',
            'class' => Stock::class,
            'choices' => $stocks

        ));
    }

    function onPreSubmit(FormEvent $event) {
        $form = $event->getForm();
        $data = $event->getData();

        // Search for selected Article and convert it into an Entity
        $article = $this->em->getRepository(Article::class)->find($data['article']);

        $this->addElements($form, $article);
    }

    function onPreSetData(FormEvent $event) {
        $ligneInventaire = $event->getData();
        $form = $event->getForm();

        // When you create a new ligneInventaire, the Article is always empty
        $article = $ligneInventaire->getArticle() ? $ligneInventaire->getArticle() : null;

        $this->addElements($form, $article);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => LigneInventaire::class,
        ]);
    }
    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return '';
    }
}
