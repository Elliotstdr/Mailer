<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class MailController extends AbstractController
{
  public function __construct()
  {
  }

  #[Route('/sendemail', name: 'send_email', methods: ["POST"])]
  public function sendmail(Request $request, MailerInterface $mailer): Response
  {
    $requestData = json_decode($request->getContent(), true);
    // Récupérer les données du formulaire depuis la requête
    $title = $requestData['title'];
    $name = $requestData['name'];
    $message = $requestData['message'];

    // Envoyer l'e-mail
    $email = (new Email())
      ->from('no-reply@elliotstdr.fr')
      ->to($_ENV['EMAIL'])
      ->subject('Nouveau message de contact')
      ->html("$name <br> Titre : $title <br> Message : $message");

    $mailer->send($email);

    // Répondre avec une réponse JSON pour confirmer l'envoi de l'e-mail
    return $this->json(['message' => 'E-mail envoyé avec succès']);
  }
}
