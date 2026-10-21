<?php

declare(strict_types=1);

namespace App\Admin\Site;

use App\Admin\AbstractAdmin;
use App\Admin\Traits\ConfigureAdminFullTrait;
use App\Entity\Page\PageRelatedArticle;
use App\Repository\Page\ArticleRepository;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelType;
use Symfony\Component\Form\ChoiceList\Loader\CallbackChoiceLoader;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Contracts\Service\Attribute\Required;

/**
 * @method PageRelatedArticle|null getSubject()
 */
class SitePageRelatedArticleInlineAdmin extends AbstractAdmin
{
    use ConfigureAdminFullTrait;

    private ArticleRepository $articleRepository;

    #[Required]
    public function setArticleRepository(
        ArticleRepository $articleRepository,
    ): void {
        $this->articleRepository = $articleRepository;
    }

    protected function configureDefaultSortValues(array &$sortValues): void
    {
        $sortValues = [
            '_sort_order' => 'ASC',
            '_sort_by'    => 'createdAt',
        ];
    }

    protected function configureFormFields(FormMapper $form): void
    {
        $this->configureFormFieldPosition(form: $form, options: ['attr' => ['style' => 'width: 100px']]);

        $articleChoiceLoader = new CallbackChoiceLoader(
            fn () => $this->articleRepository->getChoiceListBySiteId($this->getSubject()?->getPage()?->getSite()?->getId())
        );

        $form->add(
            'article',
            ModelType::class,
            [
                'label'         => 'PAGE_RELATED_ARTICLE_ENTITY.LABEL.ARTICLE',
                'help'          => 'PAGE_RELATED_ARTICLE_ENTITY.HELP.ARTICLE',
                'placeholder'   => 'PAGE_RELATED_ARTICLE_ENTITY.PLACEHOLDER.ARTICLE',
                'btn_add'       => false,
                'required'      => true,
                'constraints'   => [new NotBlank()],
                'choice_loader' => $articleChoiceLoader,
            ],
            [
                'admin_code' => 'admin.site.page.related_article.inline',
            ],
        );

        $this->configureFormFieldChoice(
            form: $form,
            name: 'active',
            choices: self::$choicesYesNo,
            label: 'FIELD.ACTIVE',
            options: ['attr' => ['style' => 'width: 100px']]
        );
    }
}
