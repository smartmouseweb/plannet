<?php

namespace App\Controller;

use App\Entity\ApiResponse;
use App\Entity\Prize;
use App\Entity\PrizeToUser;
use App\Entity\Setting;
use App\Entity\TranslationType;
use App\Entity\TranslationLocale;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PrizeController extends AbstractController
{
    private $apiResponse;

    #[Route('/prize-check', name: 'prize_check', methods: ['GET'])]
    public function checkPrize(Request $request, EntityManagerInterface $em): Response
    {
        $this->apiResponse = new ApiResponse();

        $apiToken = $request->query->get('apiToken');

        $user = $em->getRepository(User::class)->findByToken($apiToken);
       
        if (!isset($user)) 
        {
            $this->apiResponse->setUserNotFoundResponse();
        }
        else
        {
            $prizeToUser = $em->getRepository(PrizeToUser::class)->checkUserPrizeToday($user->getId());

            if (isset($prizeToUser))
            {
                $translationTypes = $em->getRepository(TranslationType::class)->findAll('name');
                $translationLocale = $em->getRepository(TranslationLocale::class)->findOneBy(['name' => $request->query->get('lang') ?? 'en_us']);

                $this->apiResponse->setResponse('Success', 200, 'You already got a prize today!', $prizeToUser->packForApi($translationTypes, $translationLocale, $em));
            }
            else
            {
                $this->apiResponse->setResponse('Success', 201, 'You didn\'t get a prize today!');
            }            
        }

        return $this->json($this->apiResponse->output());
    }

    #[Route('/prize-get', name: 'prize_get', methods: ['GET'])]
    public function getPrize(Request $request, EntityManagerInterface $em): Response
    {
        $this->apiResponse = new ApiResponse();

        $apiToken = $request->query->get('apiToken');

        $user = $em->getRepository(User::class)->findByToken($apiToken);
       
        if (!isset($user)) 
        {
            $this->apiResponse->setUserNotFoundResponse();
        }
        else
        {
            $prizeToUser = $em->getRepository(PrizeToUser::class)->checkUserPrizeToday($user->getId());

            if (isset($prizeToUser))
            {
                $this->apiResponse->setResponse('Error', 190, 'You already got a prize today! No further action');
            }
            else
            {
                $settings = $em->getRepository(Setting::class)->findAll('name');
                
                $now = new \DateTime();
                $secFromMidnight = $now->getTimestamp() - strtotime(date('Y-m-d'));

                if ($now->format('Y-m-d') >= $settings['promotion_start_date']->getValue() && $now->format('Y-m-d') < date('Y-m-d', strtotime($settings['promotion_start_date']->getValue(). ' + '.(int)$settings['promotion_days']->getValue().' days')) &&
                    (int)$settings['promotion_from_hour']->getValue()*3600 < $secFromMidnight && (int)$settings['promotion_to_hour']->getValue()*3600 >= $secFromMidnight
                    )
                {
                    $totalPrizeCount = $em->getRepository(Prize::class)->count();
                    $todayPrizeToUserCount = $em->getRepository(PrizeToUser::class)->count(['dateAdded' => $now]);
                    $maxPrizes = ceil($totalPrizeCount / (int)$settings['promotion_days']->getValue());

                    if ($todayPrizeToUserCount < $maxPrizes)
                    {
                        $prize = $em->getRepository(Prize::class)->findOneFree();

                        if (isset($prize))
                        {
                            $prizeToUser = new PrizeToUser();
                            $prizeToUser->setUser($user);
                            $prizeToUser->setPrize($prize);
                            $prizeToUser->setDateAdded($now);
                            $em->persist($prizeToUser);
                            $em->flush();

                            $translationTypes = $em->getRepository(TranslationType::class)->findAll('name');
                            $translationLocale = $em->getRepository(TranslationLocale::class)->findOneBy(['name' => $request->query->get('lang') ?? 'en_us']);

                            $this->apiResponse->setResponse('Success', 200, 'You got a prize!', $prizeToUser->packForApi($translationTypes, $translationLocale, $em));
                        }
                        else
                        {
                            $this->apiResponse->setResponse('Error', 193, 'Can\'t fetch prize');
                        }
                    }
                    else
                    {
                        $this->apiResponse->setResponse('Error', 192, 'No more prizes today ('.$todayPrizeToUserCount.' / '.$maxPrizes.')');
                    }
                }
                else
                {
                    $this->apiResponse->setResponse('', 191, 'The campaign is closed!');
                }
            }
        }

        return $this->json($this->apiResponse->output());
    }

}
