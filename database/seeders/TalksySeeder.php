<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\Certificate;
use App\Models\Material;
use App\Models\Module;
use App\Models\Question;
use App\Models\Quiz;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Artisan;

class TalksySeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        User::truncate();
        Module::truncate();
        Material::truncate();
        Quiz::truncate();
        Question::truncate();
        DB::table('material_completions')->truncate();
        DB::table('quiz_attempts')->truncate();
        Certificate::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        if (!file_exists(public_path('storage'))) {
            Artisan::call('storage:link');
        }

        // === USER ===
        $admin = User::create([
            'name' => 'Admin Talks.id',
            'email' => 'admin@talksy.id',
            'password' => Hash::make('password'),
            'role' => UserRole::ADMIN,
            'email_verified_at' => now()
        ]);

        $studentSuper = User::create([
            'name' => 'Siswa Super',
            'email' => 'super@talksy.id',
            'password' => Hash::make('password'),
            'role' => UserRole::STUDENT,
            'email_verified_at' => now()
        ]);

        $studentRajin = User::create([
            'name' => 'Siswa Rajin',
            'email' => 'rajin@talksy.id',
            'password' => Hash::make('password'),
            'role' => UserRole::STUDENT,
            'email_verified_at' => now()
        ]);

        $studentBerjuang = User::create([
            'name' => 'Siswa Pejuang',
            'email' => 'berjuang@talksy.id',
            'password' => Hash::make('password'),
            'role' => UserRole::STUDENT,
            'email_verified_at' => now()
        ]);

        $studentBaru = User::create([
            'name' => 'Siswa Baru',
            'email' => 'baru@talksy.id',
            'password' => Hash::make('password'),
            'role' => UserRole::STUDENT,
            'email_verified_at' => now()
        ]);

        $allMaterials = collect();
        $allQuizzes = collect();

        // === MODULE + MATERIAL + QUIZ ===
        DB::transaction(function () use (&$allMaterials, &$allQuizzes) {
            $modulesData = $this->getModulesData();

            foreach ($modulesData as $moduleDatum) {
                $module = Module::create($moduleDatum['module']);

                $materials = collect();
                foreach ($moduleDatum['materials'] as $materialDatum) {
                    $materialDatum['module_id'] = $module->id;
                    $materials->push(Material::create($materialDatum));
                }

                $quiz = Quiz::create([
                    'module_id' => $module->id,
                    'title' => $moduleDatum['quiz']['title'],
                    'passing_score' => 70
                ]);

                foreach ($moduleDatum['quiz']['questions'] as $questionDatum) {
                    $questionDatum['quiz_id'] = $quiz->id;
                    Question::create($questionDatum);
                }

                $allMaterials = $allMaterials->merge($materials);
                $allQuizzes->push($quiz);
            }
        });

        // === PROGRES SISWA ===
        $studentSuper->completions()->attach($allMaterials->pluck('id'));
        foreach ($allQuizzes as $quiz) {
            $studentSuper->quizAttempts()->create([
                'quiz_id' => $quiz->id,
                'score' => 95,
                'is_passed' => true
            ]);
        }
        Certificate::create([
            'user_id' => $studentSuper->id,
            'certificate_code' => 'TSY-LULUS-2025-' . Str::random(8)
        ]);

        // === Siswa Rajin ===
        $rajinModulesCount = (int) ceil($allQuizzes->count() * 0.6);
        $rajinMaterials = $allMaterials->whereIn('module_id', range(1, $rajinModulesCount));
        $studentRajin->completions()->attach($rajinMaterials->pluck('id'));

        $rajinQuizzes = $allQuizzes->whereIn('module_id', range(1, $rajinModulesCount));
        foreach ($rajinQuizzes as $quiz) {
            $studentRajin->quizAttempts()->create([
                'quiz_id' => $quiz->id,
                'score' => 85,
                'is_passed' => true
            ]);
        }

        // === Siswa Berjuang ===
        $berjuangMaterials = $allMaterials->whereIn('module_id', [1, 2]);
        $studentBerjuang->completions()->attach($berjuangMaterials->pluck('id'));

        if ($allQuizzes->has(0)) {
            $studentBerjuang->quizAttempts()->create([
                'quiz_id' => $allQuizzes[0]->id,
                'score' => 90,
                'is_passed' => true
            ]);
        }

        if ($allQuizzes->has(1)) {
            $studentBerjuang->quizAttempts()->create([
                'quiz_id' => $allQuizzes[1]->id,
                'score' => 50,
                'is_passed' => false
            ]);

            $studentBerjuang->quizAttempts()->create([
                'quiz_id' => $allQuizzes[1]->id,
                'score' => 60,
                'is_passed' => false,
                'created_at' => now()->addMinute()
            ]);
        }
    }

    private function getModulesData(): array
    {
        $data = [
            [
                'module' => [
                    'order_index' => 1,
                    'title' => 'The Foundation & The Niyyah',
                    'description' => 'Membangun fondasi dan niat yang lurus dalam menuntut ilmu bahasa Inggris.'
                ],
                'materials' => [
                    [
                        'title' => "Why Learn English as a Muslim?",
                        'type' => 'text',
                        'content_body' => "<h1>Pentingnya Bahasa Inggris bagi Muslim</h1><p>Belajar bahasa Inggris bukan hanya untuk dunia, tetapi juga untuk menyebarkan nilai-nilai Islam ke panggung global (dakwah)...</p>"
                    ],
                    [
                        'title' => "Adab & Niat dalam Belajar",
                        'type' => 'text',
                        'content_body' => "<h2>Memperbaiki Niat (Niyyah)</h2><p>Rasulullah ﷺ bersabda, \"Innamal a'maalu binniyyaat...\"</p>"
                    ],
                    [
                        'title' => "Common Greetings & Salutations",
                        'type' => 'text',
                        'content_body' => "<p>Hello, Hi, Good Morning, Good Afternoon, Good Evening. Dan jangan lupakan, \"Assalamualaikum\".</p>"
                    ],
                    [
                        'title' => "Introducing Yourself Politely",
                        'type' => 'text',
                        'content_body' => "<p>Contoh: \"My name is...\", \"I come from...\", \"I work as a...\".</p>"
                    ],
                    [
                        'title' => "Video: Basic Pronunciation (The Alphabet)",
                        'type' => 'video',
                        'content_url' => 'https://www.youtube.com/watch?v=hqx29_pSUDE'
                    ],
                    [
                        'title' => "Asking Simple Questions",
                        'type' => 'text',
                        'content_body' => "<p>What is your name? Where are you from? How are you?</p>"
                    ],
                    [
                        'title' => "Small Talk: Talking About Weather",
                        'type' => 'text',
                        'content_body' => "<p>\"The weather is nice today, isn't it?\"</p>"
                    ],
                    [
                        'title' => "PDF: Daily Du'a for Learning",
                        'type' => 'pdf',
                        'content_url' => 'pdfs/dummy.pdf'
                    ],
                ],
                'quiz' => [
                    'title' => 'Kuis Fondasi',
                    'questions' => [
                        [
                            'question_text' => 'How do you say "Apa kabar?" in English?',
                            'options' => ['How are you?', 'What is your name?', 'Where do you live?'],
                            'correct_option_index' => 0
                        ],
                        [
                            'question_text' => 'A proper response to "Thank you" is...',
                            'options' => ['Okay', "You're welcome", 'Goodbye'],
                            'correct_option_index' => 1
                        ],
                    ]
                ]
            ],
            [
                'module' => [
                    'order_index' => 2,
                    'title' => 'Grammar Building Blocks',
                    'description' => 'Memahami komponen dasar tata bahasa seperti Noun, Verb, dan Adjective.'
                ],
                'materials' => [
                    [
                        'title' => "What is a Noun (Isim)?",
                        'type' => 'text',
                        'content_body' => "<h1>Kata Benda (Nouns)</h1><p>A noun is a word that names a person, place, thing, or idea. Contoh: book, teacher, Mecca, patience (sabr).</p>"
                    ],
                    [
                        'title' => "Action Words: Verbs (Fi'il)",
                        'type' => 'text',
                        'content_body' => "<h1>Kata Kerja (Verbs)</h1><p>A verb is a word that expresses action or a state of being. Contoh: read (iqra), write, pray (salah), is, are.</p>"
                    ],
                    [
                        'title' => "Video: Noun vs Verb",
                        'type' => 'video',
                        'content_url' => 'https://www.youtube.com/watch?v=9_934h_G44g'
                    ],
                ],
                'quiz' => [
                    'title' => 'Kuis Grammar Dasar',
                    'questions' => [
                        [
                            'question_text' => 'Which one is a noun?',
                            'options' => ['run', 'beautiful', 'book'],
                            'correct_option_index' => 2
                        ],
                        [
                            'question_text' => 'Which one is a verb?',
                            'options' => ['student', 'study', 'smart'],
                            'correct_option_index' => 1
                        ],
                    ]
                ]
            ],
        ];

        // === AUTO-GENERATE MODULE 3-10 ===
        for ($i = 3; $i <= 10; $i++) {
            $materials = [];
            for ($j = 1; $j <= 8; $j++) {
                $materials[] = [
                    'title' => "Text Material $j for Module $i",
                    'type' => 'text',
                    'content_body' => "<p>Content for material $j</p>"
                ];
            }

            $materials[] = [
                'title' => "Module $i Video",
                'type' => 'video',
                'content_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ'
            ];

            $materials[] = [
                'title' => "Module $i PDF",
                'type' => 'pdf',
                'content_url' => 'pdfs/dummy.pdf'
            ];

            $questions = [];
            for ($k = 1; $k <= 10; $k++) {
                $questions[] = [
                    'question_text' => "Question $k for Module $i?",
                    'options' => ['Option A', 'Option B', 'Option C'],
                    'correct_option_index' => rand(0, 2)
                ];
            }

            $data[] = [
                'module' => [
                    'order_index' => $i,
                    'title' => "Module $i: Intermediate Topic",
                    'description' => "Description for intermediate module $i."
                ],
                'materials' => $materials,
                'quiz' => [
                    'title' => "Kuis Modul $i",
                    'questions' => $questions
                ]
            ];
        }

        return $data;
    }
}
