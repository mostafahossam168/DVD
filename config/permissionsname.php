<?php
$map = ['create', 'read', 'update', 'delete'];

return [
    'models' => [
        'roles' => $map,
        'admins' => $map,
        'students' => $map,
        'teachers' => $map,
        'settings' => ['read', 'update'],
        'stages' => $map,
        'grades' => $map,
        'subjects' => $map,
        'plans' => $map,
        'lectuers' => $map,
        'materials' => $map,
        'quizes' => $map,
        'questions' => $map,
        'subscriptions' => $map,
        'teacher_subscriptions' => $map,
        'coupons' => $map,
        'lectuers' => $map,
        'contacts' => $map,
        'quiz_results' => ['read'],
        'statistics_home' => ['read'],
        'payment_methods' =>  $map,
    ],
];
