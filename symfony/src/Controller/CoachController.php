<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

final class CoachController extends AbstractController
{
    private static array $coaches = [
        [
            'id' => 1,
            'name' => 'Арсеній Рудницький',
            'specialty' => 'Бодібілдинг',
            'focus' => 'Тренування нижньої частини тіла та ніг',
            'experience_years' => 5
        ],
        [
            'id' => 2,
            'name' => 'Дмитро Ковальчук',
            'specialty' => 'Кросфіт',
            'focus' => 'Кардіо витривалість та відновлення м\'язів',
            'experience_years' => 3
        ]
    ];

    #[Route('/api/coaches', name: 'get_all_coaches', methods: ['GET'])]
    public function index(): JsonResponse
    {
        return $this->json([
            'status' => 'success',
            'data' => self::$coaches
        ], 200);
    }

    #[Route('/api/coaches/{id}', name: 'get_one_coach', methods: ['GET'])]
    public function show(int $id): JsonResponse
    {
        foreach (self::$coaches as $coach) {
            if ($coach['id'] === $id) {
                return $this->json(['status' => 'success', 'data' => $coach], 200);
            }
        }

        return $this->json(['status' => 'error', 'message' => 'Тренера не знайдено'], 404);
    }
    #[Route('/api/coaches', name: 'create_coach', methods: ['POST'])]
    public function store(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $newCoach = array_merge(['id' => count(self::$coaches) + 1], $data ?? []);

        return $this->json([
            'status' => 'success',
            'message' => 'Тренера успішно додано!',
            'created_data' => $newCoach
        ], 201);
    }
    #[Route('/api/coaches/{id}', name: 'update_coach', methods: ['PATCH'])]
    public function update(Request $request, int $id): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $found = false;

        foreach (self::$coaches as $coach) {
            if ($coach['id'] === $id) {
                $found = true;
                break;
            }
        }

        if (!$found) {
            return $this->json(['status' => 'error', 'message' => 'Тренера не знайдено'], 404);
        }

        return $this->json([
            'status' => 'success',
            'message' => "Дані тренера з ID {$id} успішно оновлено",
            'updated_fields' => $data
        ], 200);
    }
    #[Route('/api/coaches/{id}', name: 'delete_coach', methods: ['DELETE'])]
    public function destroy(int $id): JsonResponse
    {
        if ($id < 1 || $id > 2) {
            return $this->json(['status' => 'error', 'message' => 'Тренера для видалення не знайдено'], 404);
        }

        return $this->json([
            'status' => 'success',
            'message' => "Тренера з ID {$id} успішно видалено з системи"
        ], 200);
    }
}
