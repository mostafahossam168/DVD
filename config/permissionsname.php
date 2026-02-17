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
        'statistics_home' => ['read'],
    ],
];
