<?php

/*
 * This file has been created by developers from BitBag.
 *  Feel free to contact us once you face any issues or want to start
 *  another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace spec\BitBag\SyliusVueStorefrontPlugin\Sylius\Transformer\SyliusProduct;

use BitBag\SyliusVueStorefrontPlugin\Document\Product\ProductLinks;
use BitBag\SyliusVueStorefrontPlugin\Sylius\Transformer\SyliusProduct\ProductAssociationsToLinksTransformer;
use Doctrine\Common\Collections\ArrayCollection;
use PhpSpec\ObjectBehavior;
use Sylius\Component\Core\Model\ProductVariant;
use Sylius\Component\Product\Model\ProductAssociationInterface;
use Sylius\Component\Product\Model\ProductAssociationTypeInterface;
use Sylius\Component\Product\Model\ProductInterface;

final class ProductAssociationsToLinksTransformerSpec extends ObjectBehavior
{
    function it_is_initializable(): void
    {
        $this->shouldHaveType(ProductAssociationsToLinksTransformer::class);
    }

    function it_transforms_product_associations_to_links(
        ProductAssociationInterface $syliusProductAssociation,
        ProductInterface $product,
        ProductAssociationTypeInterface $productAssociationType
    ): void {
        $syliusProductAssociation->getOwner()->willReturn($product);
        $syliusProductAssociation->getAssociatedProducts()
            ->willReturn(new ArrayCollection([$product->getWrappedObject()]));

        $syliusProductAssociation->getType()->willReturn($productAssociationType);
        $productAssociationType->getCode()->willReturn('similar_products');

        $product->getCode()->willReturn('code');
        $product->getVariants()->willReturn(new ArrayCollection([new ProductVariant()]));

        $this->transform(new ArrayCollection([$syliusProductAssociation->getWrappedObject()]))
            ->shouldReturnAnInstanceOf(ProductLinks::class);
    }
}
