<?php
$map = ['create', 'read', 'update', 'delete'];

return [
    'models' => [
        'roles' => $map,
        'admins' => $map,
        'students' => $map,
        'parents' => $map,
        'settings' => ['read', 'update'],
        'stages' => $map,
        'grades' => $map,
        'subjects' => $map,
        'lectuers' => $map,
        'materials' => $map,
        'assessments' => $map,
        'question_bank' => $map,
        'subscriptions' => $map,
        'coupons' => $map,
        'contacts' => $map,
        'assessment_results' => ['read'],
        'statistics_home' => ['read'],
        'payment_methods' =>  $map,
        'course_reviews' =>  $map,
    ],
];
