<?php

namespace App\Service;

use App\Entity\Product;
use App\Entity\ProductImage;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\String\Slugger\SluggerInterface;

class ProductImageHelper extends AbstractController
{
    private const PRODUCT_UPLOADS_DIRECTORY = 'uploads/product_images';
    private const SUPPORTED_IMAGE_EXTENSIONS = ['jpeg', 'jpg', 'png', 'gif'];

    public function __construct(private SluggerInterface $slugger)
    {
    }

    public function setImages(array $uploadedProductImages, Product $product)
    {
        if (!$uploadedProductImages) return;

        foreach ($uploadedProductImages as $img) {
            try {
                $extension = explode('.', $img->getClientOriginalName())[1];

                if (!in_array($extension, self::SUPPORTED_IMAGE_EXTENSIONS)) throw new Exception("Only images with .jpg, .png, and .gif extensions are allowed. Please upload again.", 400);

                $originalFilename = pathinfo($img->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $this->slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '-' . $product->getId() . $product->getVendor()->getId() . '.' . $img->guessExtension();

                $img->move(self::PRODUCT_UPLOADS_DIRECTORY, $newFilename);

                $productIamage  = new ProductImage();
                $productIamage->setEncodedImageName($newFilename);
                $productIamage->setProduct($product);

                $product->addProductImage($productIamage);
            } catch (FileException $e) {
                throw new Exception('Something went wrong. Could not upload images.', 400);
            }
        }
    }
}
