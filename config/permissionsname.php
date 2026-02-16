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
        // 'courses' => $map,
        // 'lessons' => $map,
        // 'coupones' => $map,
        // 'quizes' => $map,
        // 'questions' => $map,
        // 'enrollments' => ['read', 'update'],
        // 'reviews' => ['read', 'update'],
        // 'actives' => ['read', 'delete'],
        // 'contacts' => ['read', 'delete'],
        'statistics_home' => ['read'],
    ],
];
