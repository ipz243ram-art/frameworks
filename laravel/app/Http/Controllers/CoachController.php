<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CoachController extends Controller
{
    private static $coaches = [
        [
            'id' => 1,
            'name' => 'Андрій Рудницький',
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
    public function index()
    {
        return response()->json([
            'status' => 'success',
            'data' => self::$coaches
        ], 200);
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'specialty' => 'required|string',
            'focus' => 'required|string',
            'experience_years' => 'required|integer'
        ]);
        $newCoach = array_merge(['id' => count(self::$coaches) + 1], $validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Тренера успішно додано!',
            'created_data' => $newCoach
        ], 21);
    }
    public function update(Request $request, $id)
    {
        $coachId = (int)$id;
        $found = false;

        foreach (self::$coaches as $coach) {
            if ($coach['id'] === $coachId) {
                $found = true;
                break;
            }
        }

        if (!$found) {
            return response()->json([
                'status' => 'error',
                'message' => 'Тренера з таким ID не знайдено'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => "Дані тренера з ID {$id} успішно оновлено",
            'updated_fields' => $request->all()
        ], 200);
    }
    public function destroy($id)
    {
        $coachId = (int)$id;
        if ($coachId > 2 || $coachId < 1) {
            return response()->json([
                'status' => 'error',
                'message' => 'Тренера для видалення не знайдено'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => "Тренера з ID {$id} успішно видалено з системи"
        ], 200);
    }
}
