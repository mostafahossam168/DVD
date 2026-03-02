<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PageContentController extends Controller
{
    /**
     * Available static pages configuration.
     *
     * key => [setting_key, title]
     */
    protected array $pages = [
        'about' => [
            'setting_key' => 'page_about',
            'title' => 'عن المنصة',
        ],
        'vision' => [
            'setting_key' => 'page_vision',
            'title' => 'رؤيتنا',
        ],
        'team' => [
            'setting_key' => 'page_team',
            'title' => 'فريق العمل',
        ],
        'faq' => [
            'setting_key' => 'page_faq',
            'title' => 'الأسئلة الشائعة',
        ],
        'privacy' => [
            'setting_key' => 'page_privacy',
            'title' => 'سياسة الخصوصية',
        ],
        'terms' => [
            'setting_key' => 'page_terms',
            'title' => 'الشروط والأحكام',
        ],
        'usage' => [
            'setting_key' => 'page_usage',
            'title' => 'سياسة الاستخدام',
        ],
    ];

    protected function resolvePage(string $slug): array
    {
        if (! array_key_exists($slug, $this->pages)) {
            abort(404);
        }

        return array_merge($this->pages[$slug], ['slug' => $slug]);
    }

    public function edit(string $page)
    {
        $pageConfig = $this->resolvePage($page);

        $content = setting($pageConfig['setting_key']);

        return view('dashboard.pages.edit-static-page', [
            'page' => $pageConfig,
            'content' => $content,
        ]);
    }

    public function update(Request $request, string $page)
    {
        $pageConfig = $this->resolvePage($page);

        $data = $request->validate([
            'content' => ['nullable', 'string'],
        ]);

        setting([
            $pageConfig['setting_key'] => $data['content'] ?? '',
        ])->save();

        return redirect()
            ->back()
            ->with('success', 'تم حفظ محتوى الصفحة بنجاح');
    }
}

