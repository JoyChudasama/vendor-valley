<?php

namespace App\Controller;

use App\Entity\Vendor;
use App\Form\VendorType;
use App\Repository\VendorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/vendor')]
class VendorController extends AbstractController
{

    #[Route('/{id}/edit', name: 'app_vendor_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Vendor $vendor, VendorRepository $vendorRepository): Response
    {
        $form = $this->createForm(VendorType::class, $vendor, [
            'action' => $this->generateUrl('app_vendor_profile', ['id' => $vendor->getId()])
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $vendorRepository->save($vendor, true);

            return new Response(null, 204);
        }

        return $this->render('vendor/profile_content.html.twig', [
            'vendor' => $vendor,
            'form' => $form,
        ]);
    }

    #[Route('/profile-{id}', name: 'app_vendor_profile', methods: ['GET', 'POST'])]
    public function show(Vendor $vendor): Response
    {
        $form = $this->createForm(VendorType::class, $vendor, [
            'action' => $this->generateUrl('app_vendor_profile', ['id' => $vendor->getId()])
        ]);

        return $this->render('vendor/profile.html.twig', [
            'vendor' => $vendor,
            'form' => $form->createView()
        ]);
    }


    #[Route('/{id}', name: 'app_vendor_delete', methods: ['POST'])]
    public function delete(Request $request, Vendor $vendor, VendorRepository $vendorRepository): Response
    {
        $user = $vendor->getUser();

        if ($this->isCsrfTokenValid('delete' . $vendor->getId(), $request->request->get('_token'))) {
            $user->setBecomeVendor(null);
            $vendorRepository->remove($vendor, true);
        }

        return $this->redirectToRoute('app_user_profile', ['id'=>$user->getId()], Response::HTTP_SEE_OTHER);
    }
}
